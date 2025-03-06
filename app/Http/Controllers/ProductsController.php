<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        $products = Products::all();
        return view("products.products", compact("sections", "products"));
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
    public function store(AddProductRequest $request)
    {
        products::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'The product has been added successfully');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, products $products)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;
        $data = $request->except('_method', '_token');
        $products = products::find($id);
        $products->update($data);
        session()->flash('edit', 'The section has been updated successfully.');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, products $products)
    {
        $id = $request->id;
        products::find($id)->delete();
        session()->flash('delete', 'The section has been deleted successfully.');
        return redirect('/products');
    }
}
