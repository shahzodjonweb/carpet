<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer;
use App\credit;
use App\check;
use App\monthly;
use App\stored;
use App\expence;
use App\distributor;
class AnalizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_situation(){

        // $url="https://openexchangerates.org/api/latest.json?app_id=694dd93afc944676a32d9ad7f2d5ce4b;base=%22USD%22;symbols=%22UZS%22;";
        // $curl = curl_init($url);
        // curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($curl);
        // curl_close($curl);
        // $responsee=json_decode($response,true);
        // $rate=$responsee['rates']['UZS'];
        $rate=10405;

        $products=stored::all();
        $distributors=distributor::all();
        $payments=check::all();
        return view('adminpanel.paymentSituation')->with('products',$products)->with('payments',$payments)->with('rate',$rate)->with('distributors',$distributors);
    }
    public function fastpayment(Request $request){
       
        $rate=10405;
        switch ($request['to']) {
            case 'Kompaniya':
               
                if($request['payment_type_check']==1){
                    // ************ TOVAR O'TKAZISH *******************
                   // Distributor yuborgan tovarlar va Qaytgan tovarlar
                        $test_product=stored::where('productname',$request['productname'])->get();
                        $productname_all=$request['productname'];
                        $volume_all=$request['number'];
                        if($test_product->count()==0){
                            $product=new stored();
                            $product->productname=$request['productname'];
                            $product->number=$request['number'];
                            $product->save();
                        }else{
                            $numberOfProductsInStorage=$test_product[0]->number;
                            $test_product[0]->number=$numberOfProductsInStorage+$request['number'];
                            $test_product[0]->update();
                        }

                        if($request['lastid']>1){
                            for ( $index = 2; $index <= $request['lastid']; $index++) {
                                $productname_all.='/'.$request['productname'.($index-1)];
                                $volume_all+=$request['number'.($index-1)];
                                $test_product=stored::where('productname',$request['productname'.($index-1)])->get();
                                if($test_product->count()==0){
                                    $product=new stored();
                                    $product->productname=$request['productname'.($index-1)];
                                    $product->number=$request['number'.($index-1)];
                                    $product->save();
                                }else{
                                    $numberOfProductsInStorage=$test_product[0]->number;
                                    $test_product[0]->number=$numberOfProductsInStorage+$request['number'.($index-1)];
                                    $test_product[0]->update();
                                }
                            }
                        }
                   

                 // Distributor malumotlarini yangilash
                    if (strpos($request['from'], ' (dist.)') !== false) {
                        $dist_name = str_replace(' (dist.)',"",$request['from']);
                        $dist=distributor::where('name',$dist_name)->get()[0];
 
                        $lastAmount=$dist->amount;
                        if($request['payment_type'] != 'valyuta'){
                         $dist->amount=$lastAmount+$request['amount'];
                         $dist->update();
                        }else{
                         $dist->amount=$request['amount']*$rate;
                         $dist->update();
                        }
                                 $check=new check();
                                 $check->from=$dist_name;
                                 $check->to=$request['to'];
                                 $check->payment_amount=$request['amount'];
                                 $check->payment_type=$request['payment_type'];
                                 $check->productname=$productname_all;
                                 $check->volume=$volume_all;
                                 $check->save();
                                 break;
                     }
                     
                     
                     
                     //Qaytgan tovar uchun chek
                    $check=new check();
                    $check->from=$request['from'];
                    $check->to=$request['to'];
                    $check->payment_amount=$request['amount'];
                    $check->payment_type=$request['payment_type'];
                    $check->productname=$productname_all;
                    $check->volume=$volume_all;
                    $check->save();
                    break;
                }else{
                   
                    // ************ PUL O'TKAZISH *************
                    if (strpos($request['from'], ' (dist.)') !== false) {
                      // Distributorlar pul o'tkaza olmaydi
                     }
                   
                    // Xaridor Qarzi to'langanda check
                    if($request['payment_type2'] == 'qarz'){
                        $debted_person=check::where('to',$request['from'])->where('payment_type','qarz')->get();
                        
                        if(!empty($debted_person)){
                            $new_price=$debted_person[0]->payment_amount-$request['direct_price'];
                           // dd( $new_price);
                            if($new_price<=0){
                               
                                $debted_person[0]->delete();
                            }else{
                                $debted_person[0]->payment_amount=$new_price;
                                $debted_person[0]->update();
                            }
                        }
                     }
                    $check=new check();
                    $check->from=$request['from'];
                    $check->to=$request['to'];
                    $check->payment_amount=$request['direct_price'];
                    $check->payment_type=$request['payment_type2'];
                    $check->productname='Mavjud Emas';
                    $check->volume=$request['number'];
                    $check->save();
                     // xaridor mahsulot olgandagi check
                    // $check=new check();
                    // $check->from=$request['from'];
                    // $check->to=$request['to'];
                    // $check->payment_amount=$request['amount'];
                    // $check->payment_type=$request['payment_type'];
                    // $check->productname=$request['productname'];
                    // $check->volume=$request['number'];
                    // $check->save();
                    break;
                }
              
            // case 'Xaridor':
               
            //     if($request['payment_type_check']==1){
            //         $test_product=stored::where('productname',$request['productname'])->get();
                
            //         $numberOfProductsInStorage=$test_product[0]->number;
                    
            //         if(($numberOfProductsInStorage-$request['number'])>0){
            //             $test_product[0]->number=$numberOfProductsInStorage-$request['number'];
            //             $test_product[0]->update();
            //         }else{
            //             $test_product[0]->delete();
            //         }
            //             $check=new check();
            //             $check->from=$request['from'];
            //             $check->to=$request['to'];
            //             $check->payment_amount=$request['amount'];
            //             $check->payment_type=$request['payment_type'];
            //             $check->productname=$request['productname'];
            //             $check->volume=$request['number'];
            //             $check->save();
            //             break;
            //     }else{
                    
            //     }
               
            
            default:
            if($request['payment_type_check']==1){
               
                // <====!!! Faqatgina Companiya Customerga mahsulot bera oladi !!!====>

                //Faqatgina Companiya mahsulot bera oladi
                if($request['from']=="Kompaniya"){
                      $test_product=stored::where('productname',$request['productname'])->get();
                        $productname_all=$request['productname'];
                        $volume_all=$request['number'];
                    $numberOfProductsInStorage=$test_product[0]->number;
                    
                    
                    if(($numberOfProductsInStorage-$request['number'])>0){
                        $test_product[0]->number=$numberOfProductsInStorage-$request['number'];
                        $test_product[0]->update();
                    }else{
                        $test_product[0]->delete();
                    }

                            if($request['lastid']>1){
                                for ( $index = 2; $index <= $request['lastid']; $index++) {
                                    $test_product=stored::where('productname',$request['productname'.($index-1)])->get();
                                        $productname_all.='/'.$request['productname'.($index-1)];
                                        $volume_all+=$request['number'.($index-1)];
                                    if(($numberOfProductsInStorage-$request['number'])>0){
                                        $test_product[0]->number=$numberOfProductsInStorage-$request['number'.($index-1)];
                                        $test_product[0]->update();
                                    }else{
                                        $test_product[0]->delete();
                                    }
                                }
                            }
                        $check=new check();
                        $check->from=$request['from'];
                        $check->to=$request['to'];
                        $check->payment_amount=$request['amount'];
                        $check->payment_type=$request['payment_type'];
                        $check->productname=$productname_all;
                        $check->volume=$volume_all;
                        $check->save();
                        break;
                }
                
             

            }else{
                 // <====!!! Companiya va Customer Distributor ga mahsulot berolmaydi !!!====>

                 //Companiya va Customer Distributor ga pul topshiradi ....
                if (strpos($request['to'], ' (dist.)') !== false) {
                    //Qachonki Kompaniya distributorga pul berganida
                    $dist_name = str_replace(' (dist.)',"",$request['from']);
                    $dist=distributor::where('name',$dist_name)->get()[0];
                    $lastAmount=$dist->amount;
                    if($request['payment_type'] != 'valyuta'){
                     $dist->amount=$lastAmount-$request['direct_price'];
                     $dist->update();
                    }else{
                     $dist->amount=$lastAmount-$request['direct_price']*$rate;
                     $dist->update();
                    }
                    
    
                             $check=new check();
                             $check->from=$request['from'];
                             $check->to=$dist_name;
                             $check->payment_amount=$request['direct_price'];
                             $check->payment_type=$request['payment_type2'];
                             $check->productname='Mavjud Emas';
                             $check->volume=0;
                             $check->save();
                             break;
                }
                    break;
            }

        }

        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        return back();
    }
    public function index()
    {
        $checks=check::orderBy('created_at', 'desc')->get();
        $credits=credit::orderBy('created_at', 'desc')->get();
        $products=stored::all();
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
        $products=stored::all();
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