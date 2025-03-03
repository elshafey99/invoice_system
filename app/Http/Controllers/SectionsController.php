<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        return view("sections.sections", compact("sections"));
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
    public function store(AddSectionRequest $request)
    {
        $validated = $request->validated();

        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name)
        ]);
        session()->flash('Add', 'The section has been added successfully.');
        return redirect('/sections');
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request)
    {
        $id = $request->id;
        $data = $request->except('_method', '_token');
        $sections = sections::find($id);
        $sections->update($data);
        session()->flash('edit', 'The section has been updated successfully.');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('edit', 'The section has been deleted successfully.');
        return redirect('/sections');
    }
}
