
@extends('layouts.pack.return')
@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="prixod">
<div id="notification-container"></div>
          <div class="col-md-8 mx-auto px-5 py-3 credit-form" id="tovar-prixod-form">
          <form action="{{ route('returns.store')}}" method="POST" id="myForm">
              @csrf
              <input type="hidden" name="product" id="product" value="texnika">
              <h4 class="text-center mb-4">Qaytgan Texnika</h4>
              <div class="form-row mb-3">
                <div class="input-group">
                  <div class="col-md-4 mt-3"></div>
                </div>
              </div>

              <div class="form-row mb-3">
                <div class="input-group">
                  <label for="barcode" class="col-md-4 mt-2">
                   Barkod
                  </label>
                <input type="text" class="form-control col-md-8" id="barcode"  name="barcode" oninput="getstatus()" />
                </div>
          
              </div>
              <div class="alert alert-danger d-none wrong">This Barcode is not registered in our database!</div>
              <div class="alert alert-primary d-none right">Successfully Found!</div>
          
            
                <div class="input-group">
                  <label for="productname" class="col-md-4 mt-2"
                    >Mahsulot nomi <span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    id="productname"
                    name="productname"
                    class="form-control"
                  />
              </div>
              
              <div class="input-group">
                <label for="color" class="col-md-4 mt-2"
                  >Rangi <span class="text-danger">*</span></label
                >
                <input
                  type="text"
                  id="color"
                  name="color"
                  class="form-control"
                />
              </div>
                <div class="input-group">
                  <label for="type" class="col-md-4 mt-2"
                    >Model <span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    id="type"
                    name="type"
                    class="form-control"
                  />

                </div>
                 
                  <div class="input-group">
                    <label for="design" class="col-md-4 mt-2"
                      >Dizayni <span class="text-danger">*</span></label
                    >
                    <input
                      type="text"
                      id="design"
                      name="design"
                      class="form-control"
                    />
                  </div>
            

              <div class="input-group">
                <label for="number" class="col-md-4 mt-2"
                  >Mahsulot soni <span class="text-danger">*</span></label
                >
                <input
                  type="number"
                  id="number"
                  name="number"
                  class="form-control"
                  oninput="calculate()"
                />
              
            </div>

              <div class="form-row mb-3">
                <div class="input-group">
                  <label for="perm2" class="col-md-4 mt-2"
                    >Narxi <span class="text-danger">*</span></label
                  >
                  <input
                    type="number"
                    id="perm2"
                    name="perm2"
                    class="form-control col-md-8"
                    oninput="calculate()"
                    value="0"
                    required
                  />
                </div>
              </div>
              <div class="form-row mb-3">
                <div class="input-group">
                  <label for="tax" class="col-md-4 mt-2">QQS</label>
                  <input
                    type="number"
                    id="tax"
                    name="tax"
                    class="form-control col-md-7"
                    value="15"
                    oninput="calculate()"
                  />
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                  <input type="checkbox" id="qqs-active" class="form-control col-md-1" checked>
                </div>
              </div>
              <div class="form-row mb-3">
                <div class="input-group">
                  <label for="total" class="col-md-4 mt-2"
                    >Umumiy summa(NDS bilan)<span class="text-danger">*</span></label
                  >
                  <input
                    type="number"
                    id="total"
                    name="total"
                    class="form-control col-md-8"
                    value="0"
                    required
                  />
                </div>
               </div>
              <div class="form-row text-center">
                <button type="button" class="btn btn-success mx-auto submitbutton" id="tovar-prixod-submit">Submit</button>
              </div>
            </form>
          </div>
@endsection

@section('js1')
<script>
  function calculate(){
    var volume=parseFloat($('#volume').val());
    var perm2=parseFloat($('#perm2').val());
    var nds=parseFloat($('#tax').val());
    var total= perm2+perm2*nds/100;
    $('#total').val(total);
  }
 
  
  $( ".product-items" ).toggleClass('d-none');
        $( ".prixod" ).addClass('inner-active');


        function  getstatus(){
    var barcode=$('#barcode').val();
   
     if(barcode.length==8){
    var token=$('input[name$="_token"]').val();
$.post('{{ url('check/getqueuelist_api') }}',   // url
       { 
         _token: token,
         barcode: barcode
        }, // data to be submit
       function(data, status, jqXHR) {// success callback
     console.log(data);
                if(data.length==0){
            $('.right').addClass('d-none');
                $('.wrong').removeClass('d-none');
          }else{
            $("#productname").val(data[0].productname);
            $("#volume").val(data[0].volume);
            $("#number").val(data[0].number);

            $("#color").val(data[0].color);
            $("#type").val(data[0].type);
            $("#eni").val(data[0].d1);
            $("#boyi").val(data[0].d2);
            $("#design").val(data[0].s3);

            $("#perm2").val(data[0].volume*data[0].price);
            
                $('.right').removeClass('d-none');
                $('.wrong').addClass('d-none');
                calculate();
          }
              
        
        });
       }
  }
  $(".submitbutton").click(function () {
    $('#myForm').submit();
});
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