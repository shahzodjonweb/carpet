<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer;
use App\credit;
use App\check;
use App\monthly;
use App\product;
use App\admin;
use App\discount;
use App\expence;
use PDF;

class CustomerAccountController extends Controller
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
    
        $customer=customer::find($id);
        $admin=admin::find(1);
        $credit=$customer->credits->first();
        return view('pdfview')->with('customer',$customer)->with('credit',$credit)->with('admin',$admin);
    }

    function pdf_tech($id){
      $customer=customer::find($id);
        $admin=admin::find(1);
        $credit=$customer->credits->first();
        return view('pdfview_tech')->with('customer',$customer)->with('credit',$credit)->with('admin',$admin);
    }
    function pdfcreate_tech($id){
       // retreive all records from db
        // $data = Employee::all();
        $customer=customer::find($id);
        $credit=$customer->credits->first();
        $admin=admin::find(1);
        // // share data to view
       // view()->share('customer',$customer)->share('credit',$credit);
        $pdf = PDF::loadView('pdffile_tech', ['customer' => $customer,'credit' => $credit,'admin'=>$admin]);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Responses
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

    public function createPDF($id) {
        // retreive all records from db
        // $data = Employee::all();
        $customer=customer::find($id);
        $credit=$customer->credits->first();
        $admin=admin::find(1);
        // // share data to view
       // view()->share('customer',$customer)->share('credit',$credit);
        $pdf = PDF::loadView('pdffile', ['customer' => $customer,'credit' => $credit,'admin'=>$admin]);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
      }
      public function discountreg(){
        return view('analize.discountreg');
      }
      public function discountreg_create(Request $request){
        if($request['regtype']=='credit'){
        $validatedData = $request->validate([
            'passport' => 'required|exists:App\customer,series|unique:App\discount,card_number',
            'cardnumber' => 'required|min:10|max:16',
        ]);

       $user=customer::where('series',$request['passport'])->get();
       $sum=$user[0]->credits()->sum('discount_amount');
      $newcard= new discount();
      $newcard->card_holder = $user[0]->fullname;
      $newcard->customer_id = $user[0]->id;
      $newcard->amount_money = $sum;
      $newcard->series = $request['passport'];
      $newcard->card_number = $request['cardnumber'];
      $newcard ->save();
      session()->flash('success','Muvaffaqqiyatli yakunlandi!');

        return view('analize.discountreg');
        }

        if($request['regtype']=='cash'){
         
        $newcard= new discount();
        $newcard->card_holder = $request['name'];
        $newcard->customer_id = 0;
        $newcard->amount_money = 0;
        $newcard->series = $request['passport'];
        $newcard->card_number = $request['cardnumber'];
        $newcard ->save();
        session()->flash('success','Muvaffaqqiyatli yakunlandi!');
  
          return view('analize.discountreg');
          }
      }
      public function discountget(){
        return view('analize.discountget');
      }

      public function discountget_api(Request $request){
          $cardnumber=$request['cardnumber'];
          $data=discount::where('card_number',$cardnumber)->get();
          return $data;
      }      
      public function discountget_check(Request $request){
        $validatedData = $request->validate([
            'cardnumber' => 'required|min:10|max:16|exists:App\discount,card_number',
            'money_amount' => 'required|min:4',
        ]);
        $cardnumber=$request['cardnumber'];
        $data=discount::where('card_number',$cardnumber)->first();
        $initial_money= $data->amount_money;
        //check::getreciept('Discount',$request['money_amount']);
        $data->amount_money =$initial_money - $request['money_amount'];
        $data->update();
          $expence=new expence();
          $expence->category = 'discount';
          $expence->comment = $data->card_holder.' - '.$data->card_number;
          $expence->price = $request['money_amount'];
          $expence->save();
          
        return view('analize.discountget');
      }
      public function discountitem(){
        $data=discount::all();
        return view('analize.discountitems')->with('accounts',$data);
      }
      
      public function discount_search(Request $request){
        $result_id=discount::where('card_holder', 'LIKE', "%{$request['name_d']}%")->where('card_number', 'LIKE', "%{$request['card_number']}%")->where('series', 'LIKE', "%{$request['passport_d']}%")->get();
        if($request['amount_d']){
           $pos = strpos($request['amount_d'], '-');
        if(!$pos){
          $a=$request['amount_d']-50000;
          $b=$request['amount_d']+50000;
          
          $result_id=$result_id->where('amount_money', '>',$a)->where('amount_money','<',$b);
      }else{
          $var1=substr($request['amount_d'], 0, $pos);
          $var2=substr($request['amount_d'], $pos+1,(strlen($request['amount_d'])-1) );
          $result_id=$result_id->where('amount_money', '>',$var1)->where('amount_money','<',$var2);
      }
      }  
        return view('analize.discountitems')->with('accounts',$result_id);
   
  }

}
