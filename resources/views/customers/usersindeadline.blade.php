{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="deadline">
 <!-- <div class="blue-line"></div> -->
 <div class="col-12 row mx-auto mt-3">

    @if ($customers->count() != 0) 
    <table class="table table-client ml-3">
        <thead>
          <tr class="bg-dark text-white">
            <th scope="col" class="border-right">Muddat</th>
            <th scope="col" class="border-right">Ism familiya</th>
            <th scope="col" class="border-right">Unikal kod</th>
            <th scope="col" class="border-right">Shartnoma</th>
            <th scope="col" class="border-right">Telefon raqami</th>
            <th scope="col" class="border-right">Qarz summasi</th>
            <th scope="col" class="border-right">Boshlang'ich to'lov</th>
            <th scope="col" class="border-right">Qolgan summa</th>
            <th scope="col" class="border-right">Foiz</th>
            <th scope="col">Ko'rish</th>
          </tr>
        </thead>
        <tbody style="background-color: #FEF0F0">
  @foreach ($customers as $customer)
          @foreach ($customer->credits as $credit)
            @php
                $lastdue = date('d/m/y', strtotime($credit->next_deadline)); 
            @endphp  
         
  <tr >
    <th scope="row" class="text-danger">{{$lastdue}}</th>
      <td >{{$customer->fullname}}</td>
      <td>{{$credit->unicode}}</td>
      <td>{{$credit->contractcode}}</td>
      <td  class="text-danger">{{$customer->number}}</td>
      <td>{{$credit->debt_amount}} so'm</td>
      <td>{{$credit->first_payment}} %</td>
      <td>{{$credit->debt_left}} so'm</td>
  
      @if ($customer->percentage)
      <td>
          {{$customer->percentage}} %</td>
      <td>
      @else
      <td>
          0 %</td>
      <td>
      @endif
         <a href="useraccount/{{$customer->id  }}"><i class="fas fa-eye"></i></a>
      </td>
    </tr>
    @endforeach
  @endforeach
  
       
         
        </tbody>
      </table>
    @else
        
      <div class="alert alert-warning" style="width:100%">No data!</div>

    @endif

  


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