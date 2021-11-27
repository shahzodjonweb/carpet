{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')

@section('content1')

@php
//Kompaniya mablag'i
    $un_customers=$distributors->pluck('name')->toArray();
    $dist_array=$un_customers;
    array_push($un_customers,'Kompaniya');
    //$naqt = $payments->where('from','Kompaniya')->whereNotIn('to',$dist_array)->where('payment_type','cash');
    //dd($naqt);
    $naqt = $payments->where('from','Kompaniya')->whereNotIn('to',$dist_array)->where('payment_type','cash')->sum('payment_amount');
    $plastik = $payments->where('from','Kompaniya')->whereNotIn('to',$dist_array)->where('payment_type','terminal')->sum('payment_amount');
    $valyuta = $payments->where('from','Kompaniya')->whereNotIn('to',$dist_array)->where('payment_type','valyuta')->sum('payment_amount');
    $dist_payment = $distributors->sum('amount');

    $perechislenie=$payments->where('to','Kompaniya')->whereNotIn('from',$dist_array)->where('payment_type','perechisleniya')->sum('payment_amount');

    $customers=$payments->whereNotIn('to',$un_customers);
    $a=$payments->whereNotIn('to',$un_customers)->where('payment_type','cash')->sum('payment_amount');
    $b=$payments->whereNotIn('to',$un_customers)->where('payment_type','terminal')->sum('payment_amount');
    $c=$payments->whereNotIn('to',$un_customers)->where('payment_type','valyuta')->sum('payment_amount');
    $customers_payment=number_format(($a/$rate+$b/$rate+$c), 2, '.', '');
    $customers=$payments->whereNotIn('to',$un_customers);
    //dd($customers);

    $debts=$payments->whereNotIn('to',$un_customers)->where('payment_type','qarz');
    $debts_payment=$payments->whereNotIn('to',$un_customers)->where('payment_type','qarz')->sum('payment_amount');
    $debts_payment=number_format(($debts_payment/$rate), 2, '.', '');

@endphp

<!-- Modal -->

  <div class="fastPaymentModal d-none modal bd-example-modal-lg" tabindex="-1" role="dialog" style="overflow-y: scroll" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <form action="{{url('analize/fastpayment')}}" method="post">
            @csrf
        <div class="modal-header" >
            <h5 class="modal-title " id="exampleModalLongTitle">Tezkor o'tkazma </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="showpaymentmodal()">
              <span aria-hidden="true" >&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
           
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group row">
                            <label for="from" class="col-3 col-form-label text-make-dark">To'lovchi</label>
                            <div class="col-9">
                                <input type="text" list="fromm" class="form-control input-sm" id="from" name="from" required/>
                                <datalist id="fromm" >
                                 
                                  <option  value="Xaridor" ></option>
                                  <option  value="Kompaniya"></option>
                                      @foreach ($distributors as $item)
                                          <option value="{{$item->name}} (dist.)">Distributor</option>
                                      @endforeach
                                      @foreach ($customers->unique('to') as $item)
                                          <option value="{{$item->to}}">Mijoz</option>
                                      @endforeach
                                </datalist>
                            </div>
                          </div>
                    </div>
                    <div class="col">
                        <div class="form-group row">
                            <label for="to" class="col-3 col-form-label text-make-dark">Oluvchi</label>
                            <div class="col-9">
                                <input type="text" list="too" class="form-control input-sm" id="to" name="to" required/>
                              <datalist id="too" >
                               
                                <option  value="Xaridor" ></option>
                                <option  value="Kompaniya"></option>
                                
                                    @foreach ($distributors as $item)
                                        <option value="{{$item->name}} (dist.)">Distributor</option>
                                    @endforeach
                                    @foreach ($customers->unique('to') as $item)
                                        <option value="{{$item->to}}">Mijoz</option>
                                    @endforeach
                              </datalist>
                            </div>
                          </div>
                    </div>
                </div>
    
                <hr>
                <div class="withProducts">
                    <div class="row my-2">
                            <div class="col-4">
                                <div class="form-group row">
                                    <label for="number" class="col-4 col-form-label text-make-dark">Soni:</label>
                                    <div class="col-8">
                                        <input oninput="paymentControl()" type="number" class="form-control" id="number2" name="number2" value=1>
                                      </div>
                                  </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group row">
                                    <label for="boyi" class="col col-form-label text-make-dark">Bo'yi:</label>
                                    <div class="col">
                                        <input oninput="paymentControl()" type="number" class="form-control" id="boyi" name="boyi" value=0>
                                      </div>
                                  </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group row">
                                    <label for="eni" class="col col-form-label text-make-dark">Eni:</label>
                                    <div class="col">
                                        <input oninput="paymentControl()" type="number" class="form-control" id="eni" name="eni" value=0>
                                      </div>
                                  </div>
                            </div>
                            <input type="hidden" name="number"id="number" val="0">
                    </div>
                <div class="row my-2">
                    <div class='col-5 row'>
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="price" class="col col-form-label text-make-dark">Narxi(dona/narx):</label>
                                <div class="col">
                                    <input oninput="paymentControl()" type="number" class="form-control" id="price" name="price" value=0>
                                  </div>
                              </div>
                        </div>
                    </div>
                    
                    <div class="col-7">
                        <div class="form-group row">
                            <label for="payment_type" class="col-3 col-form-label text-make-dark">Maxsulot:</label>
                            <div class="col-9">
                                <input type="text" list="products" class="form-control input-sm" id="productname" name="productname" />
                                <datalist id="products" >
                                      @foreach ($products as $item)
                                          <option value="{{$item->productname}}">{{$item->number}} </option>
                                      @endforeach
                                </datalist>
                              </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="lastid" id="lastid" value="1">

                <div class="moreproduct">
                
                </div>
                
                <div class="d-flex flex-row-reverse my-3">
                  <button type="button" class="btn btn-danger deleteproduct mx-2 d-none" onclick="deleteProduct()">-Delete</button>
                  <button type="button" class="btn btn-primary mx-2" onclick="addProduct()">+Add</button>
                  
                </div>
                <hr>
                <div class="row my-2">
                    <div class="col-5">
                        <div class="form-group row">
                            <label for="payment_type" class="col-4 col-form-label text-make-dark">To'lov turi:</label>
                            <div class="col-8">
                                <select onchange="typeControl()" id="payment_type" name="payment_type" class="custom-select  mb-3">
                                    <option selected value="cash">Naqt</option>
                                    <option value="valyuta">Valyuta</option>
                                    <option value="plastik">Plastik</option>
                                    <option value="perechisleniya">Perechisleniya</option>
                                    <option value="qarz">Qarz</option>
                                  </select>
                              </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group row">
                            <div class="col-5 text-make-dark ">
                                Umumiy Narx:
                              </div>
                            <div class="col-7">
                                <input type="hidden" name="amount"  id="amount" value="0">
                              <span class="payment-controller text-make-dark">0</span> <span class="valyuta-controller">So'm</span>
                            </div>
                          </div>
                    </div>
                    <div class="col-2">
                        <div class="form-check">
                            <input onclick="paymentControl()" class="form-check-input" type="checkbox" value="" id="nds">
                            <label class="form-check-label text-make-dark" for="nds">
                              NDS (15%)
                            </label>
                          </div>
                    </div>
                </div>
                <div class="row rateshow d-none">
                    <div class="col-6">
                     <div class="form-group row">
                         <label for="usd_rate" class="col col-form-label text-make-dark">Valyuta Kursi:</label>
                         <div class="col">
                             <input type="number" class="form-control" name="usd_rate" id="usd_rate" value='{{$rate}}'>
                           </div>
                       </div>
                 </div>
             </div>
                <hr>
            </div>
            
                 
                
                <div class="d-none withoutProducts">
                  
                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label for="price" class="col col-form-label text-make-dark">Narxi(dona/narx):</label>
                                <div class="col">
                                    <input oninput="paymentControl()" type="number" class="form-control" id="direct_price" name="direct_price" value=0>
                                  </div>
                              </div>
                        </div>
    
                        <div class="col">
                            <div class="form-group row">
                                <label for="payment_type2" class="col-5 col-form-label text-make-dark">To'lov turi:</label>
                                <div class="col-7">
                                    <select onchange="typeControl2()" id="payment_type2" name="payment_type2" class="custom-select  mb-3">
                                        <option selected value="cash">Naqt</option>
                                        <option value="valyuta">Valyuta</option>
                                        <option value="plastik">Plastik</option>
                                        <option value="perechisleniya">Perechisleniya</option>
                                        <option value="qarz">Qarz</option>
                                      </select>
                                  </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="row rateshow d-none">
                        <div class="col-6">
                         <div class="form-group row">
                             <label for="usd_rate2" class="col col-form-label text-make-dark">Valyuta Kursi:</label>
                             <div class="col">
                                 <input  type="number" class="form-control" name="usd_rate" id='usd_rate2' value='{{$rate}}'>
                               </div>
                           </div>
                     </div>
                 </div>
                    <hr>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check_payment_type" name="check_payment_type" onclick="checkPaymentType()">
                    <label class="form-check-label" for="check_payment_type">
                      To'gridan to'g'ri to'lov (Mahsulotsiz)
                    </label>
                    <input type="hidden" name="payment_type_check" id="payment_type_check" value=1>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="showpaymentmodal()">Chiqish</button>
            <button type="submit" class="btn btn-primary">O'tkazish</button>
          </div>
        </form>
      </div>
    </div>
  </div>




<div class="container">
    <div class="alert alert-primary">
        <div class="row">
            <div class="col-6 font-weight-bold">Kompaniya kassasi:</div>
            <div class="col-4">${{number_format(($naqt/$rate+$plastik/$rate+$valyuta), 2, '.', '')}}</div>
            <div class='col-2 text-right'>
                <div class="btn btn-success px-3 py-1" onclick="showpaymentmodal()">+</div>
            </div>
        </div>
        <div class="row">
            <div class="col text-right">Naqt:</div>
            <div class="col">{{$naqt}} so'm</div>
        </div>
        <div class="row">
            <div class="col text-right">Plastik:</div>
            <div class="col">{{$plastik}} so'm</div>
        </div>
        <div class="row">
            <div class="col text-right">Valyuta:</div>
            <div class="col">${{$valyuta}}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-right">Perechisleniya:</div>
            <div class="col">${{$perechislenie}}</div>
        </div>
        
    </div>
    <div class="alert alert-primary">
            <div class="row">
                <div class="col font-weight-bold">Distribyutorlarga to'lanishi kerak bo'lgan jami mablag':</div>
                <div class="col">${{ number_format($dist_payment/$rate, 2, '.', '') }}({{$dist_payment}} so'm)</div>
            </div>
            
            @foreach ($distributors as $distributor)
            <div class="row">
                <div class="col-5">{{$distributor->name}}:</div>
                <div class="col-7">${{ number_format($distributor->amount/$rate, 2, '.', '') }}({{$dist_payment}} so'm)</div>
            </div>
            @endforeach
    </div>
    <div class="alert alert-success">
        
        <div class="row">
            <div class="col font-weight-bold">Mijozlardan olingan jami mablag':</div>
            <div class="col">${{$customers_payment}}</div>
        </div>
        
        @foreach ($customers as $customer)
        <div class="row">
            <div class="col-5">{{$customer->to}}:</div>
            <div class="col-7">
                @if ($customer->payment_type=="valyuta")
                    $ {{$customer->payment_amount}}
                @else
                {{$customer->payment_amount}} so'm
                @endif
                </div>
        </div>
        @endforeach
    </div>

    <div class="alert alert-warning">
        
        <div class="row">
            <div class="col font-weight-bold">Sklad:</div>
            <div class="col"></div>
        </div>
        @foreach ($products as $product)
        <div class="row">
            <div class="col-5">{{$product->productname}}:</div>
            <div class="col-7"> ( {{$product->number}} m <sup>2</sup> ) </div>
        </div>
        @endforeach
    </div>

    <div class="alert alert-success">
        
        <div class="row">
            <div class="col font-weight-bold">Jami qarzlar:</div>
            <div class="col">${{$debts_payment}}</div>
        </div>
        
        @foreach ($debts as $debt)
        <div class="row">
            <div class="col-5">{{$debt->to}}:</div>
            <div class="col-7">
                @if ($debt->payment_type=="valyuta")
                    $ {{$debt->payment_amount}}
                @else
                {{$debt->payment_amount}} so'm
                @endif
                </div>
        </div>
        @endforeach
    </div>

</div>
@endsection

@section('js1')
   <script>
         function  paymentControl(){
            var mainId=parseInt($('#lastid').val());
        methersq=parseInt($('#number2').val())*(parseInt($('#eni').val())*parseInt($('#boyi').val())/10000);
        $('#number').val(methersq);
        var price=parseInt($('#price').val());
        var sum=methersq*price;
        if(mainId>1){
            for (let index = 2; index <= mainId; index++) {
                methersq=parseInt($('#number2'+(index-1)).val())*(parseInt($('#eni'+(index-1)).val())*parseInt($('#boyi'+(index-1)).val())/10000);
                $('#number'+(index-1)).val(methersq);
                sum+=methersq*parseInt($('#price'+(index-1)).val());    
            }
        }
   
            if(document.getElementById("nds").checked){
                $('.payment-controller').text(sum+sum*15/100);
                $('#amount').val(sum+sum*15/100);
            }else{
                $('.payment-controller').text(sum);
                $('#amount').val(sum);
            }
}
       function calculate_all(){
      
        
       }
       function addProduct(){
var mainId=parseInt($('#lastid').val());
htmlContent=' <div class="pr'+mainId+'"> <div class="row my-2"><div class="col-4"><div class="form-group row"><label for="number" class="col-4 col-form-label text-make-dark">Soni:</label><div class="col-8"><input oninput="paymentControl()" type="number" class="form-control" id="number2'+mainId+'" name="number2'+mainId+'" value=1></div></div></div><div class="col-4"><div class="form-group row"><label for="boyi" class="col col-form-label text-make-dark">Bo\'yi:</label><div class="col"><input oninput="paymentControl()" type="number" class="form-control" id="boyi'+mainId+'" name="boyi'+mainId+'" value=0></div></div> <input type="hidden" name="number'+mainId+'"id="number'+mainId+'" val="0"></div><div class="col-4"><div class="form-group row"><label for="eni" class="col col-form-label text-make-dark">Eni:</label><div class="col"><input oninput="paymentControl()" type="number" class="form-control" id="eni'+mainId+'" name="eni'+mainId+'" value=0></div></div></div></div><div class="row my-2"><div class=\'col-5 row\'><div class="col-12"> <div class="form-group row"><label for="price" class="col col-form-label text-make-dark">Narxi(m2/narx):</label><div class="col"><input oninput="paymentControl()" type="number" class="form-control" id="price'+mainId+'" name="price'+mainId+'" value=0></div></div></div></div><div class="col-7"><div class="form-group row"><label for="payment_type" class="col-3 col-form-label text-make-dark">Maxsulot:</label><div class="col-9"><input type="text" list="products" class="form-control input-sm" id="productname'+mainId+'" name="productname'+mainId+'" /><datalist id="products" >'
                                      @foreach ($products as $item)
                                          +'<option value="{{$item->productname}}">{{$item->number}} </option>'
                                      @endforeach
                                +'</datalist></div></div></div></div></div>';


   $('.moreproduct').append(htmlContent);
   $('#lastid').val(mainId+1);
   if(mainId>0){
    $('.deleteproduct').removeClass('d-none');
   }else{
    $('.deleteproduct').addClass('d-none');
   }
//For Anc
   $('.secondaryLevel').on('input', function() {
  var mainId=parseInt($('#lastid').val());
  var sum=parseInt($('#price').val());
  for(i=1;i<mainId;i++){
    sum+=parseInt($('#price'+i).val());
  }
  $('#debt_amount').val(sum);
});

}
function deleteProduct(){
  var mainId=parseInt($('#lastid').val())-1;
  $('.pr'+mainId+'').remove();
  $('#lastid').val(mainId);
  if(mainId>1){
    $('.deleteproduct').removeClass('d-none');
   }else{
    $('.deleteproduct').addClass('d-none');
   }
}

   

        function  typeControl(){
            if($('#payment_type').val()=='valyuta'){
                $('.valyuta-controller').text("$");
                $('.rateshow').removeClass('d-none');

            }else{
                $('.valyuta-controller').text("so'm");
                $('.rateshow').addClass('d-none');
            }
        }
        function  typeControl2(){
            if($('#payment_type2').val()=='valyuta'){
                $('.rateshow').removeClass('d-none');

            }else{
                $('.rateshow').addClass('d-none');
            }
        }
        paymentControl();
        
        function checkPaymentType(){
            if(!document.getElementById("check_payment_type").checked){
                $('.withProducts').removeClass("d-none");
                $('.withoutProducts').addClass("d-none");
                $('#payment_type_check').val(1);
                }else{
                $('.withProducts').addClass("d-none");
                $('.withoutProducts').removeClass("d-none");
                $('#payment_type_check').val(0);
                }
        }
        function showpaymentmodal(){
            $('.fastPaymentModal').toggleClass("d-none");
        }
   </script>
@endsection

@section('css1')
    <style>
        .text-right{
            text-align: right;
        }
        .text-make-dark{
            color: black!important;
            font-weight: bold!important;
        }
    </style>
@endsection