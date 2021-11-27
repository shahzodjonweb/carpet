{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.carpet')


@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="rasxod">
@if (empty($products[0]))
<div class="alert alert-warning mt-3" style="width:100%">Omborda tovar yo'q!</div> 
@else
<div class="col-md-8 mx-auto px-5 py-3 credit-form" id="tovar-rasxod-form">
  <form action="{{ route('check.store') }}" method="POST" id="myForm">
    @csrf
    <input type="hidden" id="isadmin"  name="isadmin" value="no">
    <h4 class="text-center mb-4">Товар расход</h4>
    <div class="form-row mb-3">
      <div class="input-group">
        <label for="barcode" class="col-md-4 mt-2">
         Barkod
        </label>
      <input type="text" class="form-control col-md-8" id="barcode"  name="barcode" oninput="getstatus()"  />
      </div>

    </div>
    <div class="alert alert-danger d-none wrong">This Barcode is not registered in our database!</div>
    <div class="alert alert-primary d-none right">Successfully Found!</div>

    <div class="form-row mb-3">
      <div class="input-group">
        <label for="productname" class="col-md-4 mt-2"
          >Mahsulot nomi <span class="text-danger">*</span></label
        >
        <input type="text" class="form-control col-md-8" id="productname"  name="productname" oninput="getstatus()" />
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

      <div class="form-row mb-3">
        <div class="input-group">
          <label for="stateofpurchase" class="col-md-4 mt-2"
            >Sotilish Holati</label
         >
          <select onchange="checker_state()"
            name="stateofpurchase"
            id="stateofpurchase"
            class="form-control col-md-8"
          >
            <option value="butun" selected>Butun</option>
            <option value="kesish">Kesish</option>
           
          </select>
        </div>
      </div>
<div class="statecontainer d-none">
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="volume_cut" class="col-md-4 mt-2"
            >Qancha kesish <span class="text-danger">*</span>
          </label>
          <input
            type="number"
            id="volume_cut"
            name="volume_cut"
            class="form-control col-md-8"
            value="0"
            oninput="changervolume()"
            required
          />
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="input-group">
          <label for="volume_cut" class="col-md-4 mt-2"
            > 
          </label>
         <div class="col-md-8 border border-primary rounded">
          <div class="alert alert-primary mt-2"> Eni: <span id="eni">100</span>sm</div>
          <div class="alert alert-primary"> Bo'yi: <span id="boyi">100</span>sm</div>
          <div class="alert alert-warning">Qoldi: <span id="hajm">100</span>m<sup>2</sup></div>

          <div id="barcoded" >
          </div>
        <input type="hidden" name="new_barcode"  id="new_barcode" value="{{ $info->barcode }}">
                 </div>
        </div>
      </div>

    
</div>


      <div class="form-row mb-3">
        <div class="input-group">
          <label for="volume" class="col-md-4 mt-2"
            >m<sup>2</sup> <span class="text-danger">*</span>
          </label>
          <input
            type="number"
            id="volume"
            name="volume"
            class="form-control col-md-8"
            value="0"
            required
          />
          <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2"><span id="eni_1">0</span>x<span id="boyi_1">0</span> sm</span>
          </div>
        </div>
       
      </div>

      <div class="form-row mb-3">
        <div class="input-group">
          <label for="price" class="col-md-4 mt-2"
            >Narx<span class="text-danger">*</span></label
          >
          <input
          oninput="pricechanger()"
            type="number"
            id="price"
            name="price"
            class="form-control col-md-8 secondaryLevel"
            value="0"
            required
          />
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
    <label for="all_price" class="col-md-4 mt-2"
      >Umumiy Narx<span class="text-danger">*</span></label
    >
    <input
    oninput="pricechanger()"
      type="number"
      id="all_price"
      name="all_price"
      class="form-control col-md-8"
      value="0"
      required
    />
  </div>
</div>

<div class="form-row mb-3">
  <div class="input-group">
    <label for="debt" class="col-md-4 mt-2">Qarz summasi</label>
    <input
      type="number"
      id="debt"
      name="debt"
      oninput="calculateWithDebt()"
      class="form-control col-md-7"
      value="0"
      disabled
    />
    <div class="input-group-append">
      <span class="input-group-text">%</span>
    </div>
    <input type="checkbox" id="debt-active" class="form-control col-md-1" >
  </div>
</div>

<div class="form-row mb-3">
  <div class="input-group">
    <label for="amount" class="col-md-4 mt-2"
      >Jami<span class="text-danger">*</span></label
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
        <button class="btn btn-success mx-auto submitbutton" type="button">Submit</button>
      </div>
    </form>
  </div>
@endif

 
@endsection

@section('js1')
<script>
  function calculateWithDebt(){
    all=parseInt($('#all_price').val());
    debt=parseInt($('#debt').val());
    fff=all-debt;
    $('#amount').val(fff);
  }
  </script>

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
        +'  <label for="volume'+mainId+'" class="col-md-4 mt-2"'
          +'  >m<sup>2</sup> <span class="text-danger">*</span>'
        +'  </label>'
        +'  <input'
         +'   type="number"'
         +'   id="volume'+mainId+'"'
         +'   name="volume'+mainId+'"'
         +'   oninput="namechanger()"'
         +'   class="form-control col-md-8"'
         +'   value="0"'
         +'   required/>'
        +'  <div class="input-group-append">'
          +'  <span class="input-group-text" id="basic-addon2"><span id="eni_1'+mainId+'">0</span>x<span id="boyi_1'+mainId+'">0</span> sm</span>'
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
  $('#all_price').val(sum);  
  $(".price_ch").text(sum);
});

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>

function  getstatusnew(id){
    var barcode=$('#barcode'+id).val();
    var eni_max=0;
     if((barcode.length==8)||(barcode.length==9)){
    var token=$('input[name$="_token"]').val();
    $.post('{{ url('check/getproductlist_api') }}',   // url
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
            $("#volume"+id).val(data[0].volume);
            $("#eni_1").text(data[0].d1);
 $("#boyi_1").text(data[0].d2);
                $('.right'+id).removeClass('d-none');
                $('.wrong'+id).addClass('d-none');
          }
        });
       }
  }
// End for Anc
}

function  getstatusnew(id){
    var barcode=$('#barcode'+id).val();
    var eni_max=0;
     if((barcode.length==8)||(barcode.length==9)){
    var token=$('input[name$="_token"]').val();
    $.post('{{ url('check/getproductlist_api') }}',   // url
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
            $("#volume"+id).val(data[0].volume);
            $("#eni_1"+id).text(data[0].d1);
 $("#boyi_1"+id).text(data[0].d2);
                $('.right'+id).removeClass('d-none');
                $('.wrong'+id).addClass('d-none');
          }
        });
       }
  }

// <====================  end =============================>




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


$('.secondaryLevel').on('input', function() {
  var mainId=parseInt($('#lastid').val());
  var sum=parseInt($('#price').val());
  for(i=1;i<mainId;i++){
    sum+=parseInt($('#price'+i).val());
  }
  $('#all_price').val(sum);
  $(".price_ch").text(sum);
});
</script>
<script>



 let divDOM = document.getElementById("bar");
let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
svg.setAttribute('jsbarcode-value', '{{$info->barcode}}');
svg.className.baseVal = "barcode";
divDOM.appendChild(svg);

console.log(document.querySelector('.barcode'));
JsBarcode(".barcode").init();
var boyi=0;

let divDOM2 = document.getElementById("barcoded");
let svg2 = document.createElementNS("http://www.w3.org/2000/svg", "svg");
svg2.setAttribute('jsbarcode-value', '{{$info->barcode}}');
svg2.className.baseVal = "barcodee";
divDOM2.appendChild(svg2);
console.log(document.querySelector('.barcodee'));
JsBarcode(".barcodee").init();


function changervolume(){
  var cut=$('#volume_cut').val();

  if(cut>eni_max){
    $('#volume_cut').val(eni_max);
    return;
  }
 

  var eni=$('#eni').text();
  boyii=boyi-cut;
  var hajm=eni*boyii/10000;
  var volume=eni*cut/10000;
  $('#boyi').text(boyii);
  $('#boyi_1').text(cut);
  $('#hajm').text(hajm);
  $('#volume').val(volume);
  $('#size_ch').text(eni+'x'+cut);
}

function printDiv(divName) {
  $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
    window.print();
    $('.mainwindow').toggleClass('d-none');
    $('#'+divName).toggleClass('d-none');
}

function checker_state(){
var state=$('#stateofpurchase').val();
if(state=='butun'){
  $('.statecontainer').addClass('d-none');
}
if(state=='kesish'){
  $('.statecontainer').removeClass('d-none');
}
}
</script>

   <script>
  function pricechanger(){
    productname=$('#productname').val();
    total=$('#total').val();
    volume=$('#volume').val();
    $('#productname_ch').text(productname);
    $('.price_ch').text(total);
    $('.size_ch').text(volume);

    all=parseInt($('#all_price').val());
    debt=parseInt($('#debt').val());
    fff=all-debt;
    $('#amount').val(fff);
  }

      $( ".product-items" ).toggleClass('d-none');
        $( ".rasxod" ).addClass('inner-active');

        function  getstatus(){
    var barcode=$('#barcode').val();
   var eni_max=0;
     if((barcode.length==8)||(barcode.length==9)){
    var token=$('input[name$="_token"]').val();
$.post('{{ url('check/getproductlist_api') }}',   // url
       { 
         _token: token,
         barcode: barcode
        }, // data to be submit
       function(data, status, jqXHR) {// success callback
     
                if(data.length==0){
            $('.right').addClass('d-none');
                $('.wrong').removeClass('d-none');
          }else{
            $("#productname").val(data[0].productname);
            $('#productname_ch').text(data[0].productname);
            $("#volume").val(data[0].volume);
            $("#eni").text(data[0].d1);
            $("#eni_1").text(data[0].d1);
             $("#volume_cut").attr({
       "min" : 10,        // substitute your own
       "max" :   data[0].d1        // values (or variables) here
    });
            $("#boyi").text(data[0].d2);
            $("#boyi_1").text(data[0].d2);
            $("#hajm").text(data[0].volume);
           window.boyi=data[0].d2;
             window.eni_max=data[0].d2;
                $('.right').removeClass('d-none');
                $('.wrong').addClass('d-none');
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
        var volume=$('#volume').val();
        content+='<div><span><b>Nomi:</b> <span >'+name+'</span> </span> <span class="ml-5"><b>Narxi:</b> <span>'+price+'</span> so\'m</span></div><div class="sizecheck"><b>O\'lchami:</b> <span id="size_ch">'+volume+'</span> m<sup>2</sup></div>';
          // end
      for (i = 1; i <= num; i++) {      
        var name=$('#productname'+i).val();
        var price=$('#price'+i).val();
        var volume=$('#volume'+i).val();
          content+='<div><span><b>Nomi:</b> <span >'+name+'</span> </span> <span class="ml-5"><b>Narxi:</b> <span>'+price+'</span> so\'m</span></div><div class="sizecheck"><b>O\'lchami:</b> <span id="size_ch">'+volume+'</span> m<sup>2</sup></div>';
      }
      $('.for_more').html(content); 
     }

     
    }
  /*  <<<<<<<<<<<<<<<<<<<<<========== End ===============>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
  $(".submitbutton").click(function () {
       checkmore();
    var state=$('#stateofpurchase').val();
    if(state=='kesish'){
      printDiv('bar');
    }
    printDiv('check');
   $('#myForm').submit();
});
   </script>
<script>
  $('#tab-1').prop( "checked", true );
$('#tab-2').prop( "checked", false );
$('#tab-3').prop( "checked", false );
$('#tab-4').prop( "checked", false );
$('#tab-5').prop( "checked", false );

document.getElementById("debt-active").addEventListener("click",function(){
    if(!document.getElementById("debt-active").checked){
      document.getElementById("debt").setAttribute("disabled","");
      labit=$('#all_price').val();
      $('#amount').val(labit);
      $('#debt').val(0);
    }else{
      document.getElementById('debt').disabled = false;
      labit=$('#all_price').val();
      $('#debt').val(labit);
      $('#amount').val(0);
    }
    });
</script>
   
@endsection

@section('css1')
    <style>
        
    </style>
@endsection