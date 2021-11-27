{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.discount')


@section('content1')
<div class="alert">
  <button onclick="changetype(2)" type="button" class="btn btn-outline-primary float-right mx-1 button2">Naqd pul uchun</button>
  <button onclick="changetype(1)" type="button" class="btn btn-primary float-right mx-1 button1">Kreditorlar uchun</button>
  
</div>
<input type="hidden" name="contenttype" id="contenttype" value="discreg">
    <!-- <canvas id="line-chart" width="800" height="450"></canvas> -->
    <div class="col-7 mx-auto mt-5">
      <div class="px-4 mt-5 py-3 border bg-light">
      <form action="{{ url('customer_ac/discountreg_create') }}" id="myform" method="POST">
        @csrf
        <input type="hidden" id="isadmin"  name="isadmin" value="yes">
          <h4 class="text-center mb-4">Discount karta registratsiya</h4>
          @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<input type="hidden" name="regtype" id="regtype" value="credit">
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="passport" class="col-md-4 mt-2">
                 Passport Seriyasi
              </label>
            <input type="text" class="form-control col-md-8" id="passport"  name="passport" />
            </div>
          </div>
          <div class="form-row mb-3 changer d-none">
            <div class="input-group">
              <label for="name" class="col-md-4 mt-2">
                 Ism Sharif
              </label>
            <input type="text" class="form-control col-md-8" id="name"  name="name" />
            </div>
          </div>
          
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="cardnumber" class="col-md-4 mt-2">Karta raqami</label>
              <input
                type="text"
                id="cardnumber"
                name="cardnumber"
                class="form-control col-md-8"
                required
              />
            </div>
          </div>
        
          
          <div class="form-row text-center">
            <button type="button" class="btn btn-success mx-auto submitbutton">Registratsiya qilish</button>
          </div>
        </form>
      </div>
    </div>

@endsection

@section('js1')
   <script>
$(".submitbutton").click(function () {
    $('#myform').submit();
});
    $( ".discount-items" ).toggleClass('d-none');
    $( ".discreg" ).addClass('inner-active');
 
    function changetype(i){
      if(i==1){
        $( "#regtype" ).val('credit');
        $( ".button1" ).removeClass('btn-outline-primary');
        $( ".button1" ).addClass('btn-primary');
        $( ".button2" ).removeClass('btn-primary');
        $( ".button2" ).addClass('btn-outline-primary');
        $( ".changer" ).addClass('d-none');
      }
      if(i==2){
        $( "#regtype" ).val('cash');
        $( ".button2" ).removeClass('btn-outline-primary');
        $( ".button2" ).addClass('btn-primary');
        $( ".button1" ).removeClass('btn-primary');
        $( ".button1" ).addClass('btn-outline-primary');
        $( ".changer" ).removeClass('d-none');
      }
    }
   </script>

<script>
  $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", false );
$('#tab-3').prop( "checked", true );
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection