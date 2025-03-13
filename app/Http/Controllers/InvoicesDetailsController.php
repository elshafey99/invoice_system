<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;
use App\Models\invoicesDetails;
use App\Models\invoicesAttachment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where("id", $id)->first();
        $details = invoicesDetails::where('id_invoice', $id)->get();
        $attachments = invoicesAttachment::where('invoice_id', $id)->get();
        return view('invoices.details_invoice', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = invoicesAttachment::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'The attachment has been successfully deleted.');
        return back();
    }

    public function openFile($invoice_number, $file_name)
    {
        // $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        // return response()->file($files);

        $path = $invoice_number . '/' . $file_name;
        // Generate the full path
        $fullPath = Storage::disk('public_uploads')->path($path);
        return response()->file($fullPath);
    }

    public function getFile($invoice_number, $file_name)
    {
        $path = $invoice_number . '/' . $file_name;
        // Generate the full path
        $fullPath = Storage::disk('public_uploads')->path($path);
        return response()->download($fullPath);
    }
}