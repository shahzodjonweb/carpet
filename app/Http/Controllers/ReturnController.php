<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer;
use App\credit;
use App\check;
use App\monthly;
use App\product;
use App\tech;
use App\admin;
use App\discount;
use App\expence;
use App\returned;
class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=returned::orderBy('created_at', 'desc')->get();
        return view('returned.index')->with('products',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('returned.create');
    }
    public function create2()
    {
        return view('returned.create2');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request['product']=='gilam'){
            $product=new returned();
            $product->productname = $request['productname'];
            $product->barcode = $request['barcode'];
            $product->number = $request['number'];
            $product->volume = $request['volume'];
            $product->d1 = $request['eni'];
            $product->d2 = $request['boyi'];
            $product->color = $request['color'];
            $product->type = $request['type'];
            $product->design = $request['design'];
            $product->price = $request['perm2'];
            $product->save();

            $storage=new product();
            $storage->productname = $request['productname'];
            $storage->barcode = $request['barcode'];
            $storage->number = $request['number'];
            $storage->volume = $request['volume'];
            $storage->d1 = $request['eni'];
            $storage->d2 = $request['boyi'];
            $storage->color = $request['color'];
            $storage->type = $request['type'];
            $storage->s3 = $request['design'];
            $storage->perm2 = $request['perm2'];
            $product->total = $request['perm2'];
            $storage->save();

            $expence=new expence();
            $expence->category = 'returned';
            $expence->comment = $request['product']."-".$request['productname']."-".$request['type'];
            $expence->price = $request['perm2'];
            $expence->save();

            $data=returned::orderBy('created_at', 'desc')->get();
            session()->flash('success','Muvaffaqqiyatli saqlandi!');
            return view('returned.index')->with('products',$data);
        }
        if($request['product']=='texnika'){
            $product=new returned();
            $product->productname = $request['productname'];
            $product->barcode = $request['barcode'];
            $product->number = $request['number'];
            $product->color = $request['color'];
            $product->type = $request['type'];
            $product->design = $request['design'];
            $product->price = $request['perm2'];
            $product->save();

            $storage=new tech();
            $storage->productname = $request['productname'];
            $storage->barcode = $request['barcode'];
            $storage->number = $request['number'];
            $storage->color = $request['color'];
            $storage->type = $request['type'];
            $storage->design = $request['design'];
            $storage->price = $request['perm2'];
            $storage->total = $request['perm2'];
            $storage->save();

            $expence=new expence();
            $expence->category = 'returned';
            $expence->comment = $request['product']."-".$request['productname']."-".$request['type'];
            $expence->price = $request['perm2'];
            $expence->save();
            $data=returned::orderBy('created_at', 'desc')->get();
            session()->flash('success','Muvaffaqqiyatli saqlandi!');
            return view('returned.index')->with('products',$data);
        }
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
        //
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
        //
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
