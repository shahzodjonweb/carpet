{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.discount')


@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="discget">
    <!-- <canvas id="line-chart" width="800" height="450"></canvas> -->
    <div class="col-7 mx-auto">
      <div class="px-4 mt-5 py-3 border bg-light">
      <form action="{{url('customer_ac/discountget_check') }}" method="POST" id="myform">
        @csrf
        <input type="hidden" id="isadmin"  name="isadmin" value="yes">
          <h4 class="text-center mb-4">Discount kartadan pul Yechish</h4>
          <div class="form-row mb-3">
          </div>
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="cardnumber" class="col-md-4 mt-2">
                Karta raqami
              </label>
            <input type="text" class="form-control col-md-8" id="cardnumber"  name="cardnumber" oninput="getstatus()" />
            </div>

          </div>
          <div class="alert alert-danger d-none wrong">This card number is not registered in our database!</div>
          <div class="alert alert-primary d-none right">Balans: <span id="money">0</span> so'm</div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="money_amount" class="col-md-4 mt-2">Pul miqdori</label>
              <input
                type="number"
                id="money_amount"
                name="money_amount"
                class="form-control col-md-8"
                oninput="pricechanger()"
                required
              />
            </div>
          </div>
        
          
          <div class="form-row text-center">
            <button type="button" class="btn btn-success mx-auto submitbutton">Pul yechish</button>
          </div>
        </form>
      </div>
    </div>

@endsection

@section('js1')
   <script>
       $(".sizecheck").addClass('d-none');
       $("#productname_ch").text('Chegirma');
       function pricechanger(){
    var price=$("#money_amount").val();
     $(".price_ch").text(price);
  }
function printDiv(divName) {
  $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
    window.print();
    $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
}

   function  getstatus(){
    var cardnumber=$('#cardnumber').val();
   
     if(cardnumber.length==13){
    var token=$('input[name$="_token"]').val();
$.post('{{ url('customer_ac/discountget_api') }}',   // url
       { 
         _token: token,
         cardnumber: cardnumber
        }, // data to be submit
       function(data, status, jqXHR) {// success callback
                if(data.length==0){
            $('.right').addClass('d-none');
                $('.wrong').removeClass('d-none');
          }else{
            $('#money').text(data[0].amount_money);
            $("#money_amount").val(data[0].amount_money);
            $("#money_amount").attr({
       "max" : data[0].amount_money,        // substitute your own
       "min" : 0          // values (or variables) here
    });
                $('.right').removeClass('d-none');
                $('.wrong').addClass('d-none');
          }
              
        
        });
       }
  }

  $(".submitbutton").click(function () {
    printDiv('check');
    $('#myform').submit();
});
$( ".discount-items" ).toggleClass('d-none');
    $( ".discget" ).addClass('inner-active');
   </script>

   <script>
     $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", true );
$('#tab-3').prop( "checked", false );
   </script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection