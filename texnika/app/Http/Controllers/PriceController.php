<?php

namespace App\Http\Controllers;
use App\customer;
use App\credit;
use App\check;
use App\stored;
use App\productprice;
use App\monthly;
use App\queue;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if(empty($request['id'])){

        $product = new productprice();
        $product->productname = $request['name'];
        $product->price = $request['amount'];
        $product->save();

        $products=productprice::all();
        return view('check.product_prices')->with('products',$products);
        }else{

            $product = productprice::find($request['id']);

            $product->productname = $request['name_edit'];
            $product->price = $request['amount_edit'];
            $product->update();
    
            $products=productprice::all();
            return view('check.product_prices')->with('products',$products);

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
        $product = productprice::find($id);
        $product->delete();

        $products=productprice::all();
        return view('check.product_prices')->with('products',$products);

    }
}
