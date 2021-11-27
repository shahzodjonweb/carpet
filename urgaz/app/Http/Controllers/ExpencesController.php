<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer;
use App\credit;
use App\check;
use App\stored;
use App\productprice;
use App\monthly;
use App\expence;
use App\distributor;
class ExpencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products=expence::where('category','!=', 'qarz')->get();
       return view('expences.index')->with('products',$products);
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

            $product = new expence();
            $product->category = $request['category'];
            $product->comment = $request['comment'];
            $product->price = $request['price'];
            $product->save();
if($request['category']=="qarz"){
 
    $products=expence::where('category','=', 'qarz')->get();
    return view('expences.addexpence')->with('products',$products);  
}
            
    
            $products=expence::where('category','!=', 'qarz')->get();
            return view('expences.index')->with('products',$products);
            }else{
    
                $product = expence::find($request['id']);
    
                $product->category = $request['category_edit'];
                $product->comment = $request['comment_edit'];
                $product->price = $request['price_edit'];
                $product->update();
        
                $products=expence::where('category','!=', 'qarz')->get();
                return view('expences.index')->with('products',$products);
    
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
        $product = expence::find($id);
        $category= $product->category;

        $product->delete();

        if($category="qarz"){
            $products=expence::where('category','=', 'qarz')->get();
        return view('expences.addexpence')->with('products',$products);
        }
        $products=expence::where('category','!=', 'qarz')->get();
        return view('expences.index')->with('products',$products);
    }
    public function expences_search(Request $request){
      
        if(!empty($request['expence_type'])){
        $result_id=expence::where('category',$request['expence_type'])->get();}else{
            $result_id=expence::get();
        }
        if(!empty($request['price_ex'])){
            $a=$request['price_ex']-10000;
            $b=$request['price_ex']+10000;
            $result_id=$result_id->where('price', '>',$a)->where('price','<',$b);
        }
        return view('expences.index')->with('products',$result_id);
    }

    public function debt(){
        $products=expence::where('category','=', 'qarz')->get();
        return view('expences.addexpence')->with('products',$products);
    }

    public function paydebt(Request $request){
        $product = expence::find($request['id']);
        $productprice = $product->price;
        $left= $productprice-$request['price_edit']; 

        $check= new check();
        $check-> from = 'Qarzdor';
        $check-> to = 'Kompaniya';
        $check-> productname = $product->comment;
        $check-> volume = 0;
        $check-> payment_amount = $request['price_edit'];
        $check-> payment_type ="cash";
        $check-> save();

    if($left>0){
        $product->price = $left;
        $product->update();
        session()->flash('success','Muvaffaqqiyatli o\'tdi!');
    }else{
        if($left<0){
            session()->flash('success','Muvaffaqqiyatli o\'tdi! Qaytim:'.$request['price_edit']);
        }else{
            session()->flash('success','Muvaffaqqiyatli o\'tdi!');
        }
        $product->delete();
    }
    $products=expence::where('category','=', 'qarz')->get();
    return view('expences.addexpence')->with('products',$products);  
    }
}
