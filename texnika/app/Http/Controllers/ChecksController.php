<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer;
use App\credit;
use App\check;
use App\product;
use App\productprice;
use App\monthly;
use App\queue;
use App\admin;
use App\stored;
use App\expence;
class ChecksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('check.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           
       

     if($request['isadmin'] == "yes")
    {
 
      //  check::getreciept($request['productname'],$request['amount']);
     
        if($request['searchtype'] == 'by_creditcode')
        {
            $validatedData = $request->validate([
                'amount' => 'required|min:0',
                'code' => 'required|min:4|exists:App\credit,contractcode',
            ]);
            
            $credit=credit::where('contractcode',$request['code'])->get();
           
        }
        if($request['searchtype'] == 'by_unicode')
        {
            $credit=credit::where('unicode',$request['code'])->get();
            $validatedData = $request->validate([
                'amount' => 'required|min:0',
                'code' => 'required|min:4|exists:App\credit,unicode',
            ]);
        }
       // dd($request);
     
        $credit_id=$credit[0]->id;
        
        $deadline_date=$credit[0]->payment_timeleft;
        $deadline_date=date('Y-m-d', strtotime("+1 day", strtotime($deadline_date)));
        $check= new check();
        $check-> from = 'Xaridor';
        $check-> to = 'Kompaniya';
        $check-> payment_amount = $request['amount'];

        $check-> credit_id = $credit_id;
        if($credit[0]->volume){
            $check-> volume = $credit[0]->volume;
        }else{
            $check-> volume = 0;
        }
        
        $check-> productname = $credit[0]->productname."(-)";
        $check-> payment_type = 'credit';
        $check->save();
       
        $left=$credit[0]->debt_amount-($credit[0]->debt_amount*$credit[0]->first_payment/100);
        $current_left=$credit[0]->debt_left;
        
        $monthly_report=credit::all()->find($credit_id)->monthly();
        if($monthly_report->count() === 0)
        {
            $last_due=$credit[0]->created_at;
        }else{
            $last_due=$monthly_report->latest('id')->first()->due_date;
        }
        $currentdate = date('Y-m-d', strtotime($last_due));
        $nextdate = date('Y-m-d', strtotime("+1 month", strtotime($last_due))); 
        $next_deadline=$nextdate;
        $today = strtotime(date("Y-m-d"));
        
        if($credit[0]->percentage == 0){
            $monthlypay=$left/$credit[0]->payment_time;

            $paidsum=$request['amount'];
            if(($credit[0]->debt_left - $request['amount'])<0 ){
                $paidsum=$credit[0]->debt_left;
            }
            if($monthly_report->count() != 0 ){
            $aa=$monthly_report->latest('id')->first();
            $updatelast=monthly::find($aa->id);
            if($aa->payment_amount<$monthlypay){
                $updatelast-> payment_amount = $monthlypay;
                $updatelast-> timestamps = false;
                $updatelast->update();
                $paidsum=$paidsum - ($monthlypay-$aa->payment_amount);
    
            }
        }
        
            $a=$paidsum/$monthlypay;
            $b=intval($a);
            if($a>$b){$a=$b+1;} 
            if($a==0){$a=$b+1;}
            for($i=1;$i<=$a;$i++){
    
                if($paidsum>$monthlypay){
                    $paidsum=$paidsum-$monthlypay;
                    $paynow=$monthlypay;
                    $paypenny=$monthlypay;
                }else{
                    $paynow=$paidsum;
                    $paypenny=$monthlypay-$paynow;
                }
    
            $monthly= new monthly();
            $monthly-> payment_amount = $paynow;
            $monthly-> credit_id = $credit_id;
            $monthly-> due_date =$nextdate;
            $monthly-> monthly_payment = $monthlypay;
    if($today>strtotime($nextdate)){
        $pennypay= $paynow*$credit[0]->penny/100;
        $monthly-> penny = $pennypay;
        $c=$monthlypay+$pennypay;
        $monthly-> monthly_payment = $c;
    }
            if($deadline_date<$nextdate){
                $qaytim=$paynow;
            }else{
                $monthly->save();
            }
           
            $next_deadline=$nextdate;
            $nextdate = date('Y-m-d', strtotime("+1 month", strtotime($nextdate)));
            }
          
            $monthly_last=monthly::find($monthly->id);
        if($monthly_last->payment_amount == $monthly_last->monthly_payment)
        {
            $next_deadline = date('Y-m-d', strtotime("+1 month", strtotime($next_deadline)));
        }
    
                if(($credit[0]->debt_left - $request['amount'])<0 ){
                    $updatecredit=credit::find($credit_id);
                    $updatecredit-> debt_left = 0;
                    $updatecredit-> next_deadline=$next_deadline;
                        $updatecredit->update();
                    session()->flash('success',"Kredit yopildi! Qaytim: ".($request['amount']- $credit[0]->debt_left)." so'm ");
            return view('check.index');
                }else{
                    $updatecredit=credit::find($credit_id);
                    $updatecredit-> debt_left = $credit[0]->debt_left - $request['amount'];
                    $updatecredit-> next_deadline=$next_deadline;
                        $updatecredit->update();
                }
    
                session()->flash('success','Muvaffaqqiyatli saqlandi!');
                return view('check.index');
        }else{

            $paymenttime=date('Y-m-d',  strtotime("-1 month", strtotime($credit[0]->next_deadline)));
           
           // $nextdate=$credit[0]->next_deadline;
            $datediff =  strtotime("+".($credit[0]->payment_time)." months", strtotime($credit[0]->created_at)) - strtotime($credit[0]->created_at);

            $creditdays=round($datediff / (60 * 60 * 24));
    
            $current_month=date('m', strtotime($paymenttime));
    
            $current_year=date('Y', strtotime($paymenttime));
    
            $number_of_days=cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
    
            $monthlypercent=$credit[0]->percentage * ($credit[0]->debt_amount - ($credit[0]->debt_amount * $credit[0]->first_payment / 100))/100*$number_of_days/$creditdays;

            $monthlypay=((($credit[0]->debt_amount - ($credit[0]->debt_amount * $credit[0]->first_payment / 100))/$credit[0]->payment_time)+$monthlypercent);

         // credit percentage part
            $paidsum=$request['amount'];
            if(($credit[0]->debt_left - $request['amount'])<0 ){
                $paidsum=$credit[0]->debt_left;
            }
            if($monthly_report->count() != 0 ){
            $aa=$monthly_report->latest('id')->first();
            $updatelast=monthly::find($aa->id);
            if($aa->payment_amount<$monthlypay){
                $updatelast-> payment_amount = $monthlypay;
                $updatelast-> timestamps = false;
                $updatelast->update();
                $paidsum=$paidsum - ($monthlypay-$aa->payment_amount);
    
            }
        }
    
            $a=$paidsum/$monthlypay;
            $b=intval($a);
            if($a>$b){$a=$b+1;} 
            if($a==0){$a=$b+1;}
            for($i=1;$i<=$a;$i++){
    
                $current_month=date('m', strtotime(date('Y-m-d', strtotime("-1 month", strtotime($nextdate)))));
    
                $current_year=date('Y', strtotime(date('Y-m-d', strtotime("-1 month", strtotime($nextdate)))));
        
                $number_of_days=cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
        
                $monthlypercent=$credit[0]->percentage * ($credit[0]->debt_amount - ($credit[0]->debt_amount * $credit[0]->first_payment / 100))/100*$number_of_days/$creditdays;
    
                $monthlypay=((($credit[0]->debt_amount - ($credit[0]->debt_amount * $credit[0]->first_payment / 100))/$credit[0]->payment_time)+$monthlypercent);

        
                if($paidsum>$monthlypay){
                    $paidsum=$paidsum-$monthlypay;
                    $paynow=$monthlypay;
                    $paypenny=$monthlypay;
                }else{
                    $paynow=$paidsum;
                    $paypenny=$monthlypay-$paynow;
                }
    
            $monthly= new monthly();
            $monthly-> payment_amount = $paynow;
            $monthly-> credit_id = $credit_id;
            $monthly-> due_date =$nextdate;
            $monthly-> monthly_payment = $monthlypay;
    if($today>strtotime($nextdate)){
        $pennypay= $paynow*$credit[0]->penny/100;
        $monthly-> penny = $pennypay;
        $c=$monthlypay+$pennypay;
        $monthly-> monthly_payment = $c;
    }
            if($deadline_date<$nextdate){
                $qaytim=$paynow;
            }else{
                $monthly->save();
            }
           
            $next_deadline=$nextdate;
            $nextdate = date('Y-m-d', strtotime("+1 month", strtotime($nextdate)));
            }
          
           
    
                if(($credit[0]->debt_left - $request['amount'])<0 ){
                    $updatecredit=credit::find($credit_id);
                    $updatecredit-> debt_left = 0;
                    $updatecredit-> next_deadline=$nextdate;
                        $updatecredit->update();
                    session()->flash('success',"Kredit yopildi! Qaytim: ".($request['amount']- $credit[0]->debt_left)." so'm ");
            return view('check.index');
                }else{
                    $updatecredit=credit::find($credit_id);
                    $updatecredit-> debt_left = $credit[0]->debt_left - $request['amount'];
                    $updatecredit-> next_deadline=$nextdate;
                        $updatecredit->update();
                }
    
                session()->flash('success','Muvaffaqqiyatli saqlandi!');
                return view('check.index');



    

      }

    }
    if($request['isadmin'] == "no"){
        $info= admin::all();
        $numb=$request['lastid']-1;
        $fullproductname="";
        $fullvolume=0;
        $fullprice=0;
        for($q=0;$q<=$numb;$q++){
            if($q==0){
                $fullproductname.=$request['productname'].' | ';
                $fullvolume+=$request['volume'];
            $fullprice+=$request['price'];
            }else{
                
                $fullproductname.=$request['productname'.$q].' | ';
                $fullvolume+=$request['volume'.$q];
                $fullprice+=$request['price'.$q];
            }
          
        }
        if($request['debt'] != 0){
            $fullproductname.=" #qarz";
            $expence=new expence();
            $expence->category = 'qarz';
            $expence->comment = $fullproductname.' - '.$request['all_price'].' so\'mlik tovar';
            $expence->price = $request['debt'];
            $expence->save();
        }
        $check= new check();
        $check-> from = 'Xaridor';
        $check-> to = 'Kompaniya';
        $check-> productname = $fullproductname;
        $check-> volume = $fullvolume;
        $check-> payment_amount = $fullprice;
        $check-> payment_type = $request['payment_type'];


            $productname = $request['productname'];
            $product=stored::where('productname',$productname)->get()->first();
       
           
        if($request['stateofpurchase']=='kesish'){
            $obsolete=stored::where('barcode',$request['barcode'])->get();
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
            $obsolete=stored::where('barcode',$request['barcode']);
            $obsolete->delete();
        }
        $check->save();

        for($q=0;$q<=$numb;$q++){
            if($q==0){
            }else{
                 $obsolete=stored::where('barcode',$request['barcode'.$q]);
        $obsolete->delete();
            }
          
        }
 $products=stored::all();

        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        return view('check.products')->with('products',$products)->with('info',$info[0]);
        
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
     
    }

    public function products(){
        $info= admin::all();
        $products=stored::all();
        return view('check.products')->with('products',$products)->with('info',$info[0]);
    }
    public function updateproducts(Request $request){
      
        $checkif=stored::where('barcode',$request['barcode'])->get();
                if(count($checkif)>0){
                  
                }else{
                    $product=new product();
                    $product-> barcode=$request['barcode'];
                    $product-> productname=$request['productname'];
                    $product-> number = $request['number'];
                    $product-> volume = $request['volume'];
                    $product-> perm2 = $request['perm2'];
                    $product-> qqs = $request['tax'];
                    $product-> total = $request['total'];
                    $product-> s3 = $request['design'];
                    $product-> d1 =$request['eni'];
                    $product-> d2 =$request['boyi'];
                    $product-> color =$request['color'];
                    $product-> type =$request['type'];
                $obsolete=queue::where('barcode',$request['barcode'])->get();
                if(count($checkif)>0){
                    $product-> s1 =$obsolete[0]-> s1;
                    $product-> s2 =$obsolete[0]-> s2;
                    $product-> s4 =$obsolete[0]-> s4;
                    $product-> s5 =$obsolete[0]-> s5;
                    $obsolete[0]->delete();
                }
                $product->save();
                
                }
           

        $products=stored::where('productname','!=',null)->distinct()->get('productname');
        session()->flash('success','Muvaffaqqiyatli saqlandi!');
        return view('check.getproducts')->with('products',$products);
    }
    public function storage_products(){
        $products=stored::all();
        return view('check.storage_products')->with('products',$products);
    }

    public function getproducts(){
        $products=stored::where('productname','!=',null)->distinct()->get('productname');
        return  view('check.getproducts')->with('products',$products);
    }

    public function getproductlist(){
        return view('check.getproductlist');
    }
    public function getproductlist_save(Request $request){
     // dd($request);
    

        if($request->type=='default'){
            $products=json_decode($request->all_products);
           
            for($i=0;$i<count($products);$i++){
                
                $checkif=queue::where('barcode',$products[$i][1])->get();
                if(count($checkif)>0){
                    continue;
                }
                $product=new queue();
                $product->productname = $products[$i][5];
                $product->barcode = $products[$i][1];
                $product->number = $products[$i][2];
                $product->volume = $products[$i][3];

                $string=$products[$i][4];
                $string=substr_replace($string ,"",-1);
                $string = str_replace(' ', '', $string);
                $string=trim($string);
                $x = stripos($string,'x');
                $d1 = substr($string, 0, $x);
                $d2 = substr($string, $x+1);
                $product->d1 = $d1;
                $product->d2 = $d2;

                $product->color = $products[$i][8];
                $product->type = $products[$i][10];
                $product->s1 = $products[$i][0];
                $product->s2 = $products[$i][6];
                $product->s3 = $products[$i][7];
                $product->s4 = $products[$i][9];
                $product->s5 = $products[$i][11];


                $product->save();
            }
            
            return view('check.getproductlist');
        }
       
        if($request->type=='direct'){
            $products=json_decode($request->all_products);
            for($i=0;$i<count($products);$i++){
               
                $checkif=stored::where('barcode',$products[$i][1])->get();
                if(count($checkif)>0){
                    continue;
                }
                $product=new product();
                $product->productname = $products[$i][0];
                $product->barcode = $products[$i][1];
                $product->number = $products[$i][2];
                $product->volume = $products[$i][3];
                $string=$products[$i][4];
                $string=substr_replace($string ,"",-1);
                $string = str_replace(' ', '', $string);
                $string=trim($string);
                $x = stripos($string,'x');
                $d1 = substr($string, 0, $x);
                $d2 = substr($string, $x+1);
                $product->d1 = $d1;
                $product->d2 = $d2;
                $product->color = $products[$i][8];
                $product->type = $products[$i][10];
                $product->s1 = $products[$i][0];
                $product->s2 = $products[$i][6];
                $product->s3 = $products[$i][7];
                $product->s4 = $products[$i][9];
                $product->s5 = $products[$i][11];
                $product->save();
            }
            
            return view('check.getproductlist');
        }
    }

    public function getproductlist_api(Request $request){
        $barcode=$request['barcode'];
        
        $data=stored::where('barcode',$barcode)->get();
        return $data;
    }      
    public function techproductlist_api(Request $request){
        $barcode=$request['barcode'];

        $data=stored::where('barcode',$barcode)->get();
        return $data;
    }     
    public function getqueuelist_api(Request $request){
        $barcode=$request['barcode'];
        $data=queue::where('barcode',$barcode)->get();
        $name=$data[0]->productname;
         $products=productprice::where('productname',$name)->get();
         if(empty($products[0])){
            $price=0;
        }else{
         $price=$products[0]->price;
         }
         $data[0]->price = $price;
        return $data;
    }    

    public function product_prices(){
      $products=productprice::all();
      $list=productprice::all()->toArray();
        return view('check.product_prices')->with('products',$products)->with('list',$list);
    }

    public function storage_search(Request $request){
       
       // $products=productprice::all();
        $result_id=stored::where('productname', 'LIKE', "%{$request['name']}%")->where('color', 'LIKE', "%{$request['color']}%")->where('type', 'LIKE', "%{$request['design']}%");
        if(!empty($request['volume'])){
            $a=$request['volume']-5;
            $b=$request['volume']+5;
            $result_id=$result_id->where('volume', '>',$a)->where('volume','<',$b);
        }
        if(!empty($request['d1'])){
            $a=$request['d1']-50;
            $b=$request['d1']+50;
            
            $result_id=$result_id->where('d1', '>',$a)->where('d1','<',$b);
        }
        if(!empty($request['d2'])){
            $a=$request['d2']-50;
            $b=$request['d2']+50;
            // $result_id=$result_id->get();
            // dd($result_id[0]['d2'].'  '.$request['d2']);
            $result_id=$result_id->where('d2', '>',$a)->where('d2','<',$b);
        }
       //dd($request['d2']);
        $result_id=$result_id->get();
       // $result=check::whereIn('credit_id',$result_id)->get();
       return view('check.storage_products')->with('products',$result_id);
      }
}
