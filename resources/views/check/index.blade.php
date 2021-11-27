{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')

<input type="hidden" name="contenttype" id="contenttype" value="kassa">
    <!-- <canvas id="line-chart" width="800" height="450"></canvas> -->
    <div class="col-7 mx-auto">
      <div class="px-4 mt-5 py-3 border bg-light">
      <form action="{{ route('check.store') }}" method="POST" id="myForm">
        @csrf
        <input type="hidden" id="isadmin"  name="isadmin" value="yes">
          <h4 class="text-center mb-4">Kassa</h4>
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
              <label for="searchtype" class="col-md-4 mt-2">
                Qidiruv turi
              </label>
              <select name="searchtype" id="searchtype" class="form-control">
                <option value="by_creditcode">Shartnoma raqami</option>
                <option value="by_unicode">Unikal kod</option>
              </select>
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="credit-number" class="col-md-4 mt-2">
                Raqamni kiriting
              </label>
              <input type="text" class="form-control col-md-8" id="code"  name="code"/>
            </div>
          </div>

          

          <div class="form-row mb-3">
            <div class="input-group">
              <label for="amount" class="col-md-4 mt-2" >Summa </label>
              <input
                type="number"
                id="amount"
                name="amount"
                class="form-control col-md-8"
                oninput="pricechanger()"
                required
              />
            </div>
          </div>

          <div class="form-row text-center">
            <button type="button" class="btn btn-success mx-auto submitbutton">To'lash</button>
          </div>
        </form>
      </div>
    </div>
@endsection

@section('js1')
<script>
  function pricechanger(){
    var searchtype=$("#searchtype").val();
    var code=$("#code").val();
    var price=$("#amount").val();
    if(searchtype=='by_unicode'){
      code=code+'(U)';
    }
    if(searchtype=='by_creditcode'){
      code=code+'(SH)';
    }
    $("#productname_ch").text(code);
     $(".price_ch").text(price);
     $(".sizecheck").addClass('d-none');
  }
function printDiv(divName) {
  $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
    window.print();
    $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
}

$(".submitbutton").click(function () {
    printDiv('check');
   $('#myForm').submit();
});
</script>

<script>
  $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", false );
$('#tab-3').prop( "checked", false );
$('#tab-4').prop( "checked", false );
$('#tab-5').prop( "checked", true );
$('#tab-6').prop( "checked", false );
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection