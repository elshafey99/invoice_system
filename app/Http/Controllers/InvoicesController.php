<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Models\invoicesDetails;
use App\Models\invoicesAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'Unpaid',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoicesDetails::create([
            'id_invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'Status' => 'Unpaid',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoicesAttachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();
            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        session()->flash('Add', 'The invoice has been added successfully.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);
        session()->flash('edit', 'The invoice has been modified successfully.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoicesAttachment::where('invoice_id', $id)->first();
        $id_page = $request->id_page;

        if (!$id_page == 2) {

            if (!empty($Details->invoice_number)) {
                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }
            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');
        } else {
            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('invoices/view-archive');
        }
    }

    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function statusUpdate(Request $request, $id)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->status === 'paid') {
            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);

            invoicesDetails::create([
                'id_invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'Status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'Status' => $request->Status,
                'payment_date' => $request->payment_date,
            ]);
            invoicesDetails::create([
                'id_invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'Status' => $request->Status,
                'value_status' => 3,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }

    public function invoicePaid()
    {
        $invoices = Invoices::where('value_status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function invoiceUnPaid()
    {
        $invoices = Invoices::where('value_status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }

    public function invoicePartial()
    {
        $invoices = Invoices::where('value_status', 3)->get();
        return view('invoices.invoices_Partial', compact('invoices'));
    }
    public function invoicePrint($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoice', compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
}
