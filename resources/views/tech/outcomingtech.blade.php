
@extends('layouts.pack.tech')
@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="prixod">
<div id="notification-container"></div>
          <div class="col-md-8 mx-auto px-5 py-3 credit-form" id="tovar-prixod-form">
          <form action="{{ url('customerlist/check_save_tech')}}" method="POST" id="myForm">
              @csrf
              <h4 class="text-center mb-4">Товар расход</h4>
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
                    oninput="pricechanger()"
                    id="productname"
                    name="productname"
                    class="form-control"
                    value="0"
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
                 
         

              <div class="form-row mb-3">
                <div class="input-group">
                  <label for="price" class="col-md-4 mt-2"
                    >Narxi <span class="text-danger">*</span></label
                  >
                  <input
                    type="number"
                    id="price"
                    name="price"
                    class="form-control col-md-8 secondaryLevel"
                    oninput="pricechanger()"
                    value="0"
                    required
                  />
                </div>
              </div>
              
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="payment_type" class="col-md-4 mt-2"
            >To'lov turi</label
         >
          <select
            name="payment_type"
            id="payment_type"
            class="form-control col-md-8"
          >
            <option value="cash" selected>Naqt pul</option>
            <option value="terminal">Terminal</option>
            <option value="valyuta" >Valyuta</option>
            <option value="prechisleniya">Prechisleniya</option>
          </select>
        </div>
      </div>
      <input type="hidden" name="lastid" id="lastid" value="1">
      <div class="moreproduct">
      
      </div>
      
      <div class="d-flex flex-row-reverse my-3">
        <button type="button" class="btn btn-danger deleteproduct mx-2 d-none" onclick="deleteProduct()">-O'chirish</button>
        <button type="button" class="btn btn-primary mx-2" onclick="addProduct()">+Qo'shish</button>
      </div>
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="amount" class="col-md-4 mt-2"
            >Umumiy Narx<span class="text-danger">*</span></label
          >
          <input
          oninput="pricechanger()"
            type="number"
            id="amount"
            name="amount"
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

 
function addProduct(){
var mainId=parseInt($('#lastid').val());
  htmlContent='<div class="pr'+mainId+'  bg-light my-2 p-3">'
    +'<h5>Mahsulot №'+(mainId+1)+'</h5>'
+'<div class="form-row mb-3 ">'
        +'<div class="input-group">'
          +'<label for="barcode'+mainId+'" class="col-md-4 mt-2">'
          +' Barkod'
         +' </label>'
        +'<input type="text" class="form-control col-md-8" id="barcode'+mainId+'"  name="barcode'+mainId+'" oninput="getstatusnew('+mainId+')" />'
       +' </div>'
      +'</div>'
     +' <div class="alert alert-danger d-none wrong'+mainId+'">This Barcode is not registered in our database!</div>'
     +' <div class="alert alert-primary d-none right'+mainId+'">Successfully Found!</div>'
     +' <div class="form-row mb-3">'
       +' <div class="input-group">'
         +' <label for="productname'+mainId+'" class="col-md-4 mt-2">Mahsulot nomi <span class="text-danger">*</span></label>'
         +' <input'
         +' type="text"'
         +' id="productname'+mainId+'"'
         +' name="productname'+mainId+'"'
         +' oninput="namechanger()"'
         +' class="form-control col-md-8"'
         +' required />'
       +' </div>'
     +' </div>'
     +' <div class="form-row mb-3">'
      +'  <div class="input-group">'
        +'  <label for="model'+mainId+'" class="col-md-4 mt-2"'
          +'  >Mahsulot modeli <span class="text-danger">*</span>'
        +'  </label>'
        +'  <input'
         +'   type="text"'
         +'   id="model'+mainId+'"'
         +'   name="model'+mainId+'"'
         +'   oninput="namechanger()"'
         +'   class="form-control col-md-8"'
         +'   required/>'
        +'  <div class="input-group-append">'
          +'  <span class="input-group-text" id="basic-addon2"><span id="eni_1">0</span>x<span id="boyi_1">0</span> sm</span>'
         +' </div>'
       +' </div></div>'
       +'<div class="form-row mb-3">'
        +'<div class="input-group"> <label for="price'+mainId+'" class="col-md-4 mt-2">Mahsulot Narxi</label>'
          +'<input type="number" id="price'+mainId+'" name="price'+mainId+'" value="0"' 
          +'oninput="calculatepayment()" class="form-control col-md-8 secondaryLevel" /><div class="input-group-append">'
            +'<span class="input-group-text">so\'m</span></div></div></div>'
   +' </div>';

   

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
  $('#amount').val(sum);
  $('.price_ch').text(sum);
});



// <<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>

function  getstatusnew(id){
    var barcode=$('#barcode'+id).val();
    var eni_max=0;
     if((barcode.length==8)||(barcode.length==9)){
    var token=$('input[name$="_token"]').val();
    $.post('{{ url('check/techproductlist_api') }}',   // url
       { 
         _token: token,
         barcode: barcode
        }, // data to be submit
       function(data, status, jqXHR) {// success callback
     
                if(data.length==0){
            $('.right'+id).addClass('d-none');
                $('.wrong'+id).removeClass('d-none');
          }else{
            $("#productname"+id).val(data[0].productname);
            $("#model"+id).val(data[0].type);
         
                $('.right'+id).removeClass('d-none');
                $('.wrong'+id).addClass('d-none');
                
          }
        });
       }
  }
// End for Anc
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

function  getstatusnew(id){
    var barcode=$('#barcode'+id).val();
    var eni_max=0;
     if((barcode.length==8)||(barcode.length==9)){
    var token=$('input[name$="_token"]').val();
    $.post('{{ url('check/techproductlist_api') }}',   // url
       { 
         _token: token,
         barcode: barcode
        }, // data to be submit
       function(data, status, jqXHR) {// success callback
     
                if(data.length==0){
            $('.right'+id).addClass('d-none');
                $('.wrong'+id).removeClass('d-none');
          }else{
            $("#productname"+id).val(data[0].productname);
            $("#model"+id).val(data[0].type);
         
                $('.right'+id).removeClass('d-none');
                $('.wrong'+id).addClass('d-none');
                
          }
        });
       }
  }

$('.secondaryLevel').on('input', function() {
  var mainId=parseInt($('#lastid').val());
  var sum=parseInt($('#price').val());
  for(i=1;i<mainId;i++){
    sum+=parseInt($('#price'+i).val());
  }
  $('#amount').val(sum);
  $('.price_ch').text(sum);
});



  $('.sizecheck').addClass('d-none');
  function pricechanger(){
    productname=$('#productname').val();
    price=$('#price').val();
    $('#productname_ch').text(productname);
    $('.price_ch').text(price);
  }
  // function calculate(){
  //   var volume=parseFloat($('#volume').val());
  //   var perm2=parseFloat($('#perm2').val());
  //   var nds=parseFloat($('#tax').val());
  //   var total= perm2+perm2*nds/100;
  //   $(".price_ch").text(total);
  //   $('#total').val(total);
  // }
 
 
function printDiv(divName) {
  $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
    window.print();
    $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
} 
  $( ".product-items" ).toggleClass('d-none');
        $( ".prixod" ).addClass('inner-active');


        function  getstatus(){
    var barcode=$('#barcode').val();
   
     if((barcode.length==8)||(barcode.length==9)){
    var token=$('input[name$="_token"]').val();
$.post('{{ url('check/techproductlist_api') }}',   // url
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
              $("#productname_ch").text(data[0].productname);
            $("#number").val(data[0].number);
            $("#color").val(data[0].color);
            $("#type").val(data[0].type);
            $("#size_ch").text('none');
          
            
                $('.right').removeClass('d-none');
                $('.wrong').addClass('d-none');
                calculate();
          }
              
        
        });
       }
  }
  /*  <<<<<<<<<<<<<<<<<<<<<========== Check ===============>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
    function checkmore(){
      var num=parseInt($('#lastid').val())-1;
      var content='';
     if(num>=1){
      $('.for_one').addClass("d-none");
      //for first
      var name=$('#productname').val();
        var price=$('#price').val();
          content+='<div><span><b>Nomi:</b> <span >'+name+'</span> </span> <span class="ml-5"><b>Narxi:</b> <span>'+price+'</span> so\'m</span></div>';
          // end
      for (i = 1; i <= num; i++) {      
        var name=$('#productname'+i).val();
        var price=$('#price'+i).val();
          content+='<div><span><b>Nomi:</b> <span >'+name+'</span> </span> <span class="ml-5"><b>Narxi:</b> <span>'+price+'</span> so\'m</span></div>';
      }
      $('.for_more').html(content); 
     }

    
    }
  /*  <<<<<<<<<<<<<<<<<<<<<========== End ===============>>>>>>>>>>>>>>>>>>>>>>>>>>>> */

  $(".submitbutton").click(function () {
    checkmore();
    printDiv('check');
    
    $('#myForm').submit();
});
</script>
<script>
  $('#tab-1').prop( "checked", true );
$('#tab-2').prop( "checked", false );
$('#tab-3').prop( "checked", false );
</script>
@endsection


@section('css1')
    <style>
        
    </style>
@endsection