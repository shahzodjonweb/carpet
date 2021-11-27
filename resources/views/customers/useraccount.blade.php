{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')

<input type="hidden" name="contenttype" id="contenttype" value="kredit">
          <div class="row mx-auto clientInfoPart">
            <div class="col-6 row">
              <div class="col-5 pr-0">
                <p class="mt-2 mb-0" style="font-size: 20px;">
                  Mijozning ismi:
                </p>
              </div>
              <div class="col-7 clientNamePart pl-0">
                <p class="d-inline-block mt-2 mb-0">{{$customer->fullname}}</p>
              </div>
              
         
              <div class="col-12">
                <p class="d-inline-block mt-2 mb-0">Passport</p>
                <a href="./../storage/{{ $customer->passport}}" class="iconPassport"
                  ><i class="fas fa-file-image "></i
                ></a>
                <p class="d-inline-block mt-2 mb-0 ml-5">Sug'urta</p>
                <a href="./../storage/{{ $customer->insurance}}" class="iconInsurance"
                  ><i class="fas fa-file-alt "></i
                ></a>
              </div>
            </div>
            <div class="col-6 row">
              <div class="col-12 text-right mt-2 clientInfoButtons">
                
                <form style="display:inline-block" action="{{route('customerlist.edit',$customer->id )}}" >
                  @csrf
                  <button type="submit" class="clientButtons button-edit">
                    <i class="fas fa-edit"></i>
                  </button>
              </form>
                <form style="display:inline-block"   action="{{route('customerlist.destroy',$customer->id )}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="clientButtons button-delete">
                    <i class="fas fa-trash-alt"></i>
                  </button>
              </form>
                
                <button class="clientButtons button-exit" 
                onclick="window.location.assign('{{ route('customerlist.index') }}');">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </div>
         
          <div class="row mx-auto">
              @foreach ($customer->credits as $credit)
                  
              @endforeach
            <div class="credit-info row col-12">
              <div
                class="credit-info-header credit-info-header-active row col-12 mx-auto"
              >
              
                <div class="col-4">
                  <p class="d-inline-block">Kredit:</p>
                  <p class="d-inline-block credit-number">{{$credit->contractcode}}</p>
                </div>
                <div class="col-4">
                    <p class="d-inline-block">Unikal kod:</p>
                    <p class="d-inline-block credit-number">{{$credit->unicode}}</p>
                  </div>
                <div class="col-4 text-right">
                  <p class="d-inline-block">Hujjatlar:</p>
                  <a href="./../storage/{{ $credit->contract}}" class="credit-buttons credit-buttons-2">
                    <i class="fas fa-file-alt"></i>
                  </a>
                  @if ($credit->volume==0)
                  <a href="{{ url('customer_ac/pdf_tech',$customer->id)}}" class="credit-buttons credit-buttons-3">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                  @else
                  <a href="{{ route('customer_ac.show',$customer->id)}}" class="credit-buttons credit-buttons-3">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                  @endif
               
                </div>
              </div>
          
  @if ($credit->discount_amount > 0)
              <div class="alert alert-danger"  style="width:100%;margin-bottom:-1px">Chegirma: {{$credit->discount_amount}} so'm</div>
  @endif
              <div
                class="credit-info-body credit-info-body-active row col-12 mx-auto"
              >
              @php
              $datebrain=date('Y-m-d H:i:s',strtotime("+1 months", strtotime($credit->created_at)));
      @endphp

              <h3  class="mx-2">Grafik</h3>
              <table class="table mt-3 table-bordered" id="GrafikTable">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Сана</th>
                    <th scope="col">Карз суммаси</th>
                    <th scope="col">Ойлик тулов</th>
                    <th scope="col">%</th>
                    <th scope="col">Foiz</th>
                    <th scope="col">Qoldiq</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  if($credit->percentage > 0){

    

        $datediff =  strtotime("+".($credit->payment_time)." months", strtotime($datebrain)) - strtotime($datebrain);

        $creditdays=round($datediff / (60 * 60 * 24));

        $current_month=date('m', strtotime($paymenttime));

        $current_year=date('Y', strtotime($paymenttime));

        $number_of_days=cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

        $monthlypercent=$credit->percentage * ($credit->debt_amount - ($credit->debt_amount * $credit->first_payment / 100))/100*$number_of_days/$creditdays;

        $left=($credit->debt_amount - ($credit->debt_amount * $credit->first_payment / 100)) * (1+$credit->percentage/100);
        $debt=number_format($left, 1, '.', '');
        $payment_monthly=number_format(((($credit->debt_amount - ($credit->debt_amount * $credit->first_payment / 100))/$credit->payment_time)+$monthlypercent), 1, '.', '');
                  }else{

                  $left=$credit->debt_amount-($credit->debt_amount*$credit->first_payment/100);
                      $paymenttime=date('d/m/Y',  strtotime($datebrain));
                      $debt=number_format($left, 1, '.', '');
                      $payment_monthly=number_format(($left/$credit->payment_time), 1, '.', '');
                    }
                  @endphp
                 @for ($i = 0; $i < $credit->payment_time; $i++)
                 <tr 
                 @if(strtotime($credit->next_deadline) >=  strtotime("+".($i)." months", strtotime($credit->created_at)))
                    style="background-color:#E0FFBE"
                 @endif
                 >
                  <th scope="row">{{$paymenttime}}</th>
                  <td>{{$debt}} so'm</td>
                  <td>{{$payment_monthly}}so'm</td>
                  <td>{{$credit->percentage}} </td>
                  <td>0 so'm </td>
                 @if ($i == ($credit->payment_time-1))
                     <td>0 so'm</td>
                 @else
                 <td>{{number_format(($debt-$payment_monthly), 1, '.', '')}} so'm</td>
                 @endif
                 
                  @php
                  if($credit->percentage > 0){
                    $paymenttime=date('d/m/Y', strtotime("+".($i+1)." months", strtotime($datebrain)));
                  $current_month=date('m', strtotime("+".($i+1)." months", strtotime($datebrain)));

                  $current_year=date('Y', strtotime("+".($i+1)." months", strtotime($datebrain)));

                  $number_of_days=cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

                  $monthlypercent=$credit->percentage * ($credit->debt_amount - ($credit->debt_amount * $credit->first_payment / 100))/100*$number_of_days/$creditdays;

                  $payment_monthly=number_format(((($credit->debt_amount - ($credit->debt_amount * $credit->first_payment / 100))/$credit->payment_time)+$monthlypercent), 1, '.', '');
                   
                  $debt=$debt-$payment_monthly;
                  
                  }else{
                    $paymenttime=date('d/m/Y', strtotime("+".($i+1)." months", strtotime($datebrain)));
                  $debt=$debt-$payment_monthly;
                  }
                  
              @endphp
                </tr>
                 @endfor
                  
                 
                </tbody>
              </table>
              <h3 class="mx-2">To'lovlar</h3>
                <table class="table mt-3 table-bordered">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Sana</th>
                      <th scope="col">To'langan summa</th>
                      <th scope="col">Penya</th>
                      <th scope="col">Muddat</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($credit->monthly as $month)
                    <tr>

                      @php
                      $paymenttime=date('d/m/Y',  strtotime($month->created_at));
                      $paymentdeadline=date('d/m/Y',  strtotime($month->due_date));
                  @endphp

                    <th scope="row">{{ $paymenttime}}</th>
                      <td style="color:rgb(43, 197, 43)">{{ $month->payment_amount }}</td>
                      <td>{{ $month->penny}}</td>
                   
                      <td>{{ $paymentdeadline}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                      <td>Qarz Summasi:</td>
                      <td> {{$credit->debt_amount}} so'm</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Qoldiq summa:</td>
                      <td  style="color:red">{{$credit->debt_left}} so'm</td>
                    </tr>
                  </tbody>
                </table>
                <p class="col-12 pr-5 font-weight-bold text-danger text-right d-none">
                    Kredit yopilgan
                                    </p>
              </div>
            </div>
            
          </div>
     <div class="row my-5">
<div class="col-4 mx-5">
<div>Qarz Beruvchi: MCHJ "{{ $info->name }}"</div>
  <div>_________________________________________</div>
</div>

<div class="col-5 mx-5 text-right">
  <div>Qarz Oluvchi: {{$customer->fullname}}</div>
    <div>____________________________________</div>
  </div>

     </div>

@endsection

@section('js1')
   

<script>
         $('#tab-1').prop( "checked", false );
    $('#tab-2').prop( "checked", true );
    $('#tab-3').prop( "checked", false );
    $('#tab-4').prop( "checked", false );
    $('#tab-5').prop( "checked", false );
    $('#tab-6').prop( "checked", false );
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection