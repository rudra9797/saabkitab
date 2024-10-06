<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row =  Unit::where(['user_id'=>Auth::user()->id])->count();       

        $units = Unit::filter(request(['search']))
                ->where(['user_id'=>Auth::user()->id])
                ->sortable()
                ->paginate($row)
                ->appends(request()->query());

        return view('units.index', [
            'units' => $units,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:units,name',
            'slug' => 'required|unique:units,slug',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['user_id'] = Auth::user()->id;

        Unit::create($validatedData);

        return Redirect::route('units.index')->with('success', 'Unit has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
      abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('units.edit', [
            'unit' => $unit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $rules = [
            'name' => 'required|unique:units,name,'.$unit->id,
            'slug' => 'required|unique:units,slug,'.$unit->id,
        ];

        $validatedData = $request->validate($rules);
        $validatedData['user_id'] = Auth::user()->id;

        Unit::where('slug', $unit->slug)->update($validatedData);

        return Redirect::route('units.index')->with('success', 'Unit has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        Unit::destroy($unit->id);

        return Redirect::route('units.index')->with('success', 'Unit has been deleted!');
    }
}
