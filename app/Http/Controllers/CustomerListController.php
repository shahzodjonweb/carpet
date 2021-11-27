<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer;
use App\credit;
use App\check;
use App\monthly;
use App\product;
use App\admin;
use App\tech;
use App\sold;
use Illuminate\Support\Facades\Storage;
class CustomerListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers=customer::orderBy('created_at', 'desc')->get();
        return view('customers.index')->with('customers',$customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info= admin::all();
        $products=product::where('productname','!=',null)->distinct()->get('productname');
        $lastcredit_id=credit::all()->pluck('id');
        if($lastcredit_id->count() != 0){
            $lastcredit_id=credit::latest()->first()->unicode;
            $unicode=$lastcredit_id+1;
        } else { $unicode=20201021;  }
        
        return view('customers.addcustomer')->with('unicode',$unicode)->with('products',$products)->with('info',$info[0]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $info= admin::all();
        $validatedData = $request->validate([
            'name' => 'required|unique:App\customer,fullname',
            'series' => 'required|min:7|max:12|unique:App\customer,series',
            'passport' => 'required|file',
            'contract' => 'required|file',
            'givendate' => 'required|date|before:today',
            'bywhom' => 'required',
            'number' => 'required',
            'address' => 'required',
            'debt_amount' => 'required|min:0',
            'volume' => 'required|min:0',
            'percentage' => 'required|min:0|max:100',
            'debt-left' => 'required|min:0',
            'first_payment' => 'required|min:0|max:100',
            'penny' => 'required|min:0|max:100',
            'tax' => 'min:0|max:100',
            'discount' => 'min:0',
        ]);
                // save costomer info
                if($request->hasFile('passport')){
                    $passport=$request->passport->store('passport');
                }else{
                    $passport=0;
                }

                if($request->hasFile('insurance')){
                    $insurance=$request->insurance->store('insurance');
                }else{
                    $insurance=0;
                }

                if($request->hasFile('contract')){
                    $contract=$request->contract->store('contract');
                }else{
                    $contract=0;
                }
                

        $customer= new customer();     
        $customer-> fullname = $request['name'];
        $customer-> series =  $request['series'];
        $customer-> givendate =  $request['givendate'];
        $customer-> bywhom =  $request['bywhom'];
        $customer-> passport = $passport;
        $customer-> insurance = $insurance;
        $customer-> number = $request['number'];
        $customer-> number2 = $request['number2'];
        $customer-> address = $request['address'];
       $customer->save();

            // save credit info
            $numb=$request['lastid']-1;
            $fullproductname="";
            $fullvolume=0;
            for($q=0;$q<=$numb;$q++){
                if($q==0){
                    $fullproductname.=$request['productname'].' | ';
                    $fullvolume+=$request['volume'];
                }else{
                    
                    $fullproductname.=$request['productname'.$q].' | ';
                    $fullvolume+=$request['volume'.$q];
                }
              
            }
           
        $credit= new credit();
        $credit -> unicode = $request['unicode'];
        $credit -> contractcode = $request['contractcode'];
        $credit -> contract = $contract;
        $credit -> debt_amount = $request['debt_amount'];
        $credit-> productname = $fullproductname;
        $credit-> volume = $fullvolume;
        if($request['percentage']>0){
            $credit -> debt_left = $request['debt-left']*(1+$request['percentage']/100);
        }else{
            $credit -> debt_left = $request['debt-left'];
        }
        
        $credit -> first_payment = $request['first_payment'];
        $credit -> payment_time = $request['payment_time'];
        $currenttime=date("Y-m-d h:i:s a", time());
        $effectiveDate = date('Y-m-d', strtotime("+".$request['payment_time']." months", strtotime($currenttime)));
        $nextdate = date('Y-m-d', strtotime("+1 month", strtotime($currenttime)));
        $credit -> payment_timeleft = $effectiveDate;
        $credit -> payment_deadline = $nextdate;
        $credit -> next_deadline = $nextdate;
        $credit -> percentage = $request['percentage'];
        $credit -> penny = $request['penny'];
        $credit -> qqs = $request['tax'];
        $credit -> customer_id = $customer-> id;
        if($request['discount_type']=="percent"){
            $credit -> discount_percent = $request['discount'];
            $discount_c=$request['debt_amount']*$request['discount']/100;
            $credit -> discount_amount =$discount_c;
        }
        if($request['discount_type']=="cash"){
            $credit -> discount_amount =$request['discount'];
        }
        $credit -> save();


       

        for($q=0;$q<=$numb;$q++){
            if($q==0){
                $sold= new sold();
                $sold-> name= $request['productname'];
                $sold-> volume= $request['volume'];
                $sold-> price= $request['price'];
                $sold-> credit_id = $credit->id;
                 $sold->save();
            }else{
                $sold= new sold();
                $sold-> name= $request['productname'.$q];
                $sold-> volume= $request['volume'.$q];
                $sold-> price= $request['price'.$q];
                $sold-> credit_id = $credit->id;
                 $sold->save();
                 $obsolete=product::where('barcode',$request['barcode'.$q]);
                 $obsolete->delete();
            }
          
        }


            // save check info

        $check= new check();
        $check-> productname = $fullproductname;
        $check-> volume = $fullvolume;
        $check-> payment_amount = $request['debt_amount']-$request['debt-left'];

       // check::getreciept($request['productname'],($request['debt_amount']-$request['debt-left']));

        $check-> payment_type = 'credit';
        $check-> credit_id = $credit->id;
        if($request['stateofpurchase']=='kesish'){
            $obsolete=product::where('barcode',$request['barcode'])->get();
            $volume_ob=$obsolete[0]->volume;
            $d2_ob=$obsolete[0]->d2;
            $obsolete[0]->volume= $volume_ob-$request['volume'];
            $obsolete[0]->d2= $d2_ob-$request['volume_cut'];
            if($obsolete[0]->volume==$request['volume']){
                $obsolete[0]->delete();
                
            }else{
            $obsolete[0]->barcode= $request['new_barcode'];
            $info[0]->barcode= $request['new_barcode']+1;
            $info[0]->update();
            $obsolete[0]->update();
            }
        }else{
            $obsolete=product::where('barcode',$request['barcode']);
            $obsolete->delete();
        }
        $check->save();
        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        $customers=customer::orderBy('created_at', 'desc')->get();
        return view('customers.index')->with('customers',$customers);

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
        $customer=customer::find($id);
        return view('customers.update')->with('customer',$customer);
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

        $customer=customer::find($id);
        //dd($customer->passport->deleteimage());
        if($request->hasFile('passport')){
         
            Storage::delete($customer->passport);//$customer->passport->deleteimage();
            $image=$request->passport->store('passport'); 
            $customer->passport = $image;
        }
        if($request->hasFile('insurance')){
            Storage::delete($customer->insurance);
            //$customer->insurance->deleteimage();
            $image=$request->insurance->store('insurance'); 
            $customer-> insurance = $image;
        }

    
        $customer-> fullname = $request['name'];
        $customer-> number = $request['number'];
        $customer-> number2 = $request['number2'];
        $customer-> address = $request['address'];
        $customer->update();
        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        return redirect(route('customerlist.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer=customer::find($id);
        $credits=credit::where('customer_id',$customer->id)->get();
        foreach($credits as $credit){
            $credit->checks()->delete();
            $credit->monthly()->delete();
            $credit->delete();
        }
        $customer->delete();
        return view('customers.index')->with('customers',customer::all());

    }

    public function userAccount($id){
        $customer=customer::all()->find($id);
       $info=admin::all();
     return view('customers.useraccount')->with('customer',$customer)->with('info',$info[0]);
    }
    public function search(Request $request)
    {
        $result_id=credit::orderBy('created_at', 'desc');
        if($request['product'] == "gilam"){
            $result_id=$result_id->where('volume',">",0);
        }
        if($request['product'] == "tech"){
            $result_id=$result_id->whereIn('volume',[0,null]);
        }
        if($request['searchType'] == "contractcode")   {
            $value=$request['searchClientByCreditNumber'];
            $result_id=$result_id->where('contractcode', 'LIKE', "%{$value}%")->pluck('customer_id');
            $result=customer::whereIn('id',$result_id)->get();
           
            return view('customers.index')->with('customers',$result)->with('search',$request['searchType'])->with('value',$value);
            
        }

        if($request['searchType'] == "unicode")   {
            $value=$request['searchClientByUniqueNumber'];
            $result_id=$result_id->where('unicode', 'LIKE', "%{$value}%")->pluck('customer_id');
            $result=customer::whereIn('id',$result_id)->get();

            return view('customers.index')->with('customers',$result)->with('search',$request['searchType'])->with('value',$value);
        }

        if($request['searchType'] == "date")   {
            $date1=$request['searchStartDate'];
            $date2=$request['searchEndDate'];
            $result_id= $result_id->whereBetween('created_at', [$date1, $date2])->pluck('id');
            $result=customer::whereIn('id',$result_id)->get();

            return view('customers.index')->with('customers',$result)->with('search',$request['searchType'])->with('value1',$date1)->with('value2',$date2);

        }


        if($request['searchType'] == "name")   {
           $value=$request['searchClientName'];
           $result=customer::where('fullname', 'LIKE', "%{$value}%")->get();
           return view('customers.index')->with('customers',$result)->with('search',$request['searchType'])->with('value',$value);
        }
       
    }

    function create_tech(){
        return view('tech.incomingtech');
    }
    function save_tech(Request $request){
        
        $checkif=tech::where('barcode',$request['barcode'])->get();
                if(count($checkif)>0){
                  
                }else{
                    $product=new tech();
                    $product-> barcode=$request['barcode'];
                    $product-> productname=$request['productname'];
                    $product-> number = $request['number'];
                    $product-> price = $request['price'];

                    $product-> qqs = $request['tax'];
                    $product-> total = $request['total'];
                    $product-> color =$request['color'];
                    $product-> type =$request['type'];
                $product->save();
                
                }
           
        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        return view('tech.incomingtech');
    }
    function credit_tech(){
          $info= admin::all();
        $products=product::where('productname','!=',null)->distinct()->get('productname');
        $lastcredit_id=credit::all()->pluck('id');
        if($lastcredit_id->count() != 0){
            $lastcredit_id=credit::latest()->first()->unicode;
            $unicode=$lastcredit_id+1;
        } else { $unicode=20201021;  }
        return view('tech.outcomingtech_credit')->with('unicode',$unicode)->with('products',$products)->with('info',$info[0]);;
    }
    function credit_save_tech(Request $request){
        $info= admin::all();
        
                // save costomer info
                if($request->hasFile('passport')){
                    $passport=$request->passport->store('passport');
                }else{
                    $passport=0;
                }

                if($request->hasFile('insurance')){
                    $insurance=$request->insurance->store('insurance');
                }else{
                    $insurance=0;
                }

                if($request->hasFile('contract')){
                    $contract=$request->contract->store('contract');
                }else{
                    $contract=0;
                }
                $numb=$request['lastid']-1;
                $fullproductname="";
                $fullvolume=0;
                for($q=0;$q<=$numb;$q++){
                    if($q==0){
                        $fullproductname.=$request['productname'].' | ';
                    }else{
                        
                        $fullproductname.=$request['productname'.$q].' | ';
                    }
                  
                }
        $customer= new customer();
        $customer-> fullname = $request['name'];
        $customer-> series =  $request['series'];
        $customer-> givendate =  $request['givendate'];
        $customer-> bywhom =  $request['bywhom'];
        $customer-> passport = $passport;
        $customer-> insurance = $insurance;
        $customer-> number = $request['number'];
        $customer-> number2 = $request['number2'];
        $customer-> address = $request['address'];
        $customer->save();

            // save credit info
           
        $credit= new credit();
        $credit -> unicode = $request['unicode'];
        $credit -> contractcode = $request['contractcode'];
        $credit -> contract = $contract;
        $credit -> debt_amount = $request['debt_amount'];
        $credit-> productname = $fullproductname;
        $credit-> volume = 0;
        if($request['percentage']>0){
            $credit -> debt_left = $request['debt-left']*(1+$request['percentage']/100);
        }else{
            $credit -> debt_left = $request['debt-left'];
        }
        
        $credit -> first_payment = $request['first_payment'];
        $credit -> payment_time = $request['payment_time'];
        $currenttime=date("Y-m-d h:i:s a", time());
        $effectiveDate = date('Y-m-d', strtotime("+".$request['payment_time']." months", strtotime($currenttime)));
        $nextdate = date('Y-m-d', strtotime("+1 month", strtotime($currenttime)));
        $credit -> payment_timeleft = $effectiveDate;
        $credit -> payment_deadline = $nextdate;
        $credit -> next_deadline = $nextdate;
        $credit -> percentage = $request['percentage'];
        $credit -> penny = $request['penny'];
        $credit -> qqs = $request['tax'];
        $credit -> customer_id = $customer-> id;
        if($request['discount_type']=="percent"){
            $credit -> discount_percent = $request['discount'];
            $discount_c=$request['debt_amount']*$request['discount']/100;
            $credit -> discount_amount =$discount_c;
        }
        if($request['discount_type']=="cash"){
            $credit -> discount_amount =$request['discount'];
        }
        $credit -> save();
   

        for($q=0;$q<=$numb;$q++){
            if($q==0){
                $sold= new sold();
                $sold-> name= $request['productname'];
                $sold-> volume= 0;
                $sold-> price= $request['price'];
                $sold-> credit_id = $credit->id;
                 $sold->save();
                 $obsolete=tech::where('barcode',$request['barcode']);
        $obsolete->delete();
            }else{
                $sold= new sold();
                $sold-> name= $request['productname'.$q];
                $sold-> volume= 0;
                $sold-> price= $request['price'.$q];
                $sold-> credit_id = $credit->id;
                 $sold->save();
                 $obsolete=tech::where('barcode',$request['barcode'.$q]);
        $obsolete->delete();
            }
          
        }

      
            // save check info

        $check= new check();
        $check-> productname = $fullproductname;
        $check-> volume = 0;
        $check-> payment_amount = $request['debt_amount']-$request['debt-left'];

       // check::getreciept($request['productname'],($request['debt_amount']-$request['debt-left']));

        $check-> payment_type = 'credit';
        $check-> credit_id = $credit->id;
     
        $check->save();
        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        $customers=customer::orderBy('created_at', 'desc')->get();
        return view('customers.index')->with('customers',$customers);

    }
    function check_tech(){
        return view('tech.outcomingtech');
    }
    function check_save_tech(Request $request){
        $numb=$request['lastid']-1;
        $fullproductname="";
        $fullvolume=0;
        $fullprice=0;
        for($q=0;$q<=$numb;$q++){
            if($q==0){
                $fullproductname.=$request['productname'].' | ';
                $fullprice+=$request['price'];
            }else{
                
                $fullproductname.=$request['productname'.$q].' | ';
                $fullprice+=$request['price'.$q];
            }
          
        }

        $check= new check();
        $check-> productname = $fullproductname;
        $check-> volume = $fullvolume;
        $check-> payment_amount = $fullprice;
        $check-> payment_type = $request['payment_type'];
        $check->save();
       // check::getreciept($request['productname'],$request['amount']);
            $obsolete=tech::where('barcode',$request['barcode']);
            $obsolete->delete();

            for($q=0;$q<=$numb;$q++){
                if($q==0){
                     $obsolete=tech::where('barcode',$request['barcode']);
            $obsolete->delete();
                }else{
                     $obsolete=tech::where('barcode',$request['barcode'.$q]);
            $obsolete->delete();
                }
              
            }

        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        return view('tech.outcomingtech');
    }
    function storage_tech(){
        $products=tech::orderBy('created_at', 'desc')->get();;
        return view('tech.storage')->with('products',$products);
    }
    function storage_tech_search(Request $request){
         // $products=productprice::all();
         $result_id=tech::where('productname', 'LIKE', "%{$request['name']}%")->where('color', 'LIKE', "%{$request['coler']}%")->where('type', 'LIKE', "%{$request['model']}%");
        
        //dd($request['d2']);
         $result_id=$result_id->get();
        // $result=check::whereIn('credit_id',$result_id)->get();
        return view('tech.storage')->with('products',$result_id);
    }

}
