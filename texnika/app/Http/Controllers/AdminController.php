<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin=admin::where('id',1)->get();
        return view('adminpanel.index')->with('admin',$admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin=admin::find($id);
        $admin-> main = $request['main'];
        $admin-> accountant = $request['accountant'];
        $admin-> name = $request['name'];
        $admin-> address = $request['address'];
        $admin-> inn_number = $request['inn_number'];
        $admin-> nds_number = $request['nds_number'];
        $admin->update();

        session()->flash('success','Muvaffaqqiyatli saqlandi!');

        $admin=admin::where('id',1)->get();
        return view('adminpanel.index')->with('admin',$admin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
