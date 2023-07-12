<?php

namespace App\Http\Controllers;

use App\Models\DeweyDecimal;
use Illuminate\Http\Request;

class DeweyDecimalClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        return view("back.book.dewey");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DeweyDecimal $deweyDecimalClass
     * @return \Illuminate\Http\Response
     */
    public function show(DeweyDecimal $deweyDecimalClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DeweyDecimal $deweyDecimalClass
     * @return \Illuminate\Http\Response
     */
    public function edit(DeweyDecimal $deweyDecimalClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeweyDecimal $deweyDecimalClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeweyDecimal $deweyDecimalClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DeweyDecimal $deweyDecimalClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeweyDecimal $deweyDecimalClass)
    {
        //
    }
}
