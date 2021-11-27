{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="kredit">
<div class="col-md-8 mx-auto px-5 py-3 credit-form">
    <form action="{{route('customerlist.update',$customer->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
      <h4 class="text-center mb-4">Mijoz ma'lumotlarini o'zgartirish</h4>
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="name" class="col-md-4 mt-2"
            >Ism-familiya <span class="text-danger">*</span></label
          >
          <input
            type="text"
            id="name"
            name="name"
            value="{{ $customer->fullname }}"
            class="form-control col-md-8"
            required
          />
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="number" class="col-md-4 mt-2"
            >Telefon raqami <span class="text-danger">*</span>
          </label>
          <input
            type="text"
            id="number"
            name="number"
            value="{{ $customer->number }}"
            class="form-control col-md-8"
            required
          />
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="number2" class="col-md-4 mt-2"
            >Telefon raqami</label
          >
          <input
            type="text"
            id="number2"
            name="number2"
            value="{{ $customer->number2 }}"
            class="form-control col-md-8"
          />
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="address" class="col-md-4 mt-2">Adres</label>
          <input
            type="text"
            id="address"
            name="address"
            value="{{ $customer->address }}"
            class="form-control col-md-8"
          />
        </div>
      </div>
      
      <div class="form-row mb-3">
        <div class="input-group">
          <p class="col-md-4 pl-3 mb-0 mt-2">Passport</p>
          <div class="col-md-8 px-0">
            <label for="passport" class="label-file"
              >Choose a file</label>
            <input type="file" id="passport" name="passport" onchange="spin(1)"/>
            <div class="ml-5 spinner-grow text-info spinner_passport d-none" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <i class="ml-5 far text-success fa-check-circle spinner_passport_success fa-2x d-none" ></i>
          </div>
         
        </div>
      </div>


      @if ($customer->passport)
      <div class="form-row mb-3">
      Yuklangan fayl: <a href="{{$customer->passport}}">Passport</a>
    </div>
      @endif
      <div class="form-row mb-3">
        <div class="input-group">
          <p class="col-md-4 pl-3 mb-0 mt-2">Sug'urta</p>
          <div class="col-md-8 px-0">
            <label for="insurance" class="label-file">Choose a file</label>
            <input type="file" id="insurance" name="insurance" onchange="spin(2)" />
            <div class="ml-5 spinner-grow text-info spinner_ins d-none" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <i class="ml-5 far text-success fa-check-circle spinner_ins_success fa-2x d-none" ></i>
          </div>
        </div>
      </div>
      @if ($customer->insurance)
      <div class="form-row mb-3">
        Yuklangan fayl: <a href="{{$customer->insurance}}">Sug'urta</a>
    </div>
      @endif
     

      <hr />
    
      <div class="form-row text-center">
        <button class="btn btn-success mx-auto">Submit</button>
      </div>
    </form>
  </div>

@endsection

@section('js1')
   <script>
     function calculatepayment(){
       var debt=$('#debt_amount').val();
       var percent=$('#first_payment').val();
       var firstpayment=debt-(debt*percent)/100;
       $('#debt-left').val(firstpayment);
     }

     function spin(id){
       if(id==1){
        $('.spinner_passport').removeClass('d-none');
          setTimeout(
          function() 
          {
            $('.spinner_passport').addClass('d-none');
          $('.spinner_passport_success').removeClass('d-none');
          }, 2000);
       }

       if(id==2){
          $('.spinner_ins').removeClass('d-none');
            setTimeout(
            function() 
            {
              $('.spinner_ins').addClass('d-none');
            $('.spinner_ins_success').removeClass('d-none');
            }, 2000);   
        }
        
        if(id==3){
            $('.spinner_con').removeClass('d-none');
              setTimeout(
              function() 
              {
                $('.spinner_con').addClass('d-none');
              $('.spinner_con_success').removeClass('d-none');
              }, 2000);
        }
      

  
     }

   </script>
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
