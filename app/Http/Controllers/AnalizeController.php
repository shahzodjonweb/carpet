<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer;
use App\credit;
use App\check;
use App\monthly;
use App\product;
use App\expence;
class AnalizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checks=check::orderBy('created_at', 'desc')->get();
        $credits=credit::orderBy('created_at', 'desc')->get();
        $products=product::all();
        $expences=expence::all();
        $creditsum=0;
        foreach($credits as $credit){
            $creditsum+= $credit->debt_amount*$credit->first_payment/100;
        }

        $expencesum=0;
        foreach($expences as $expence){
            $expencesum+= $expence->price;
        }

        $debtsum=0;
        foreach($credits as $credit){
            $debtsum+= $credit->debt_left;
        }

        $cashchecks=$checks->where('payment_type','cash');
        $cashchecksum=0;
        foreach($cashchecks as $cashcheck){
            $cashchecksum+= $cashcheck->payment_amount;
        }

        $creditchecks=$checks->where('payment_type','credit');
        $creditchecksum=0;
        foreach($creditchecks as $creditcheck){
            $creditchecksum+= $creditcheck->payment_amount;
        }

         $productsum=0;
        foreach($products as $product){
            $productsum+= $product->total;
        }
       // dd($checks[0]->credit->unicode);
        return view('analize.index')->with('checks',$checks)->with('creditsum',$creditsum)->with('cashchecksum',$cashchecksum)->with('creditchecksum',$creditchecksum)->with('debtsum',$debtsum)->with('productsum',$productsum)->with('expencesum',$expencesum);
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

    public function search(Request $request)
    {
       

        $checks=check::orderBy('created_at', 'desc')->get();
        $credits=credit::orderBy('created_at', 'desc')->get();
        $products=product::all();
        $expences=expence::all();
        
        $creditsum=0;
        foreach($credits as $credit){
            $creditsum+= $credit->debt_amount*$credit->first_payment/100;
        }

        $debtsum=0;
        foreach($credits as $credit){
            $debtsum+= $credit->debt_left;
        }
        $expencesum=0;
        foreach($expences as $expence){
            $expencesum+= $expence->price;
        }
        $cashchecks=$checks->where('payment_type','cash');
        $cashchecksum=0;
        foreach($cashchecks as $cashcheck){
            $cashchecksum+= $cashcheck->payment_amount;
        }

        $creditchecks=$checks->where('payment_type','credit');
        $creditchecksum=0;
        foreach($creditchecks as $creditcheck){
            $creditchecksum+= $creditcheck->payment_amount;
        }

        $productsum=0;
        foreach($products as $product){
            $productsum+= $product->total;
        }

       // search part
            $resultid=check::orderBy('created_at', 'desc')->where('payment_type',  'LIKE', "%{$request['payment']}%");
            if($request['product'] == "gilam"){
                $resultid=$resultid->where('volume',">",0);
            }
            if($request['product'] == "tech"){
                $resultid=$resultid->whereIn('volume',[0,null]);
            }
        if(!(empty($request['searchStartDate'])&&empty($request['searchEndDate'])))   {

            $date1=$request['searchStartDate'];
            $date2=$request['searchEndDate'];
            $resultid= $resultid->whereBetween('created_at', [$date1, $date2]);
        }
       if($request['price']){
        $pos = strpos($request['price'], '-');

      if(!$pos){
        $a=$request['price']-50000;
        $b=$request['price']+50000;
        
        $resultid=$resultid->where('payment_amount', '>',$a)->where('payment_amount','<',$b);
    }else{
        $var1=substr($request['price'], 0, $pos);
        $var2=substr($request['price'], $pos+1,(strlen($request['price'])-1) );
        $resultid=$resultid->where('payment_amount', '>',$var1)->where('payment_amount','<',$var2);
    }
}
        $result=$resultid->get();
  
       
        $selecttype=$request['price'];
        return view('analize.index')->with('checks',$result)->with('creditsum',$creditsum)->with('cashchecksum',$cashchecksum)->with('creditchecksum',$creditchecksum)->with('debtsum',$debtsum)->with('productsum',$productsum)->with('expencesum',$expencesum)->with('selecttype',$selecttype);
   

 }

 

}