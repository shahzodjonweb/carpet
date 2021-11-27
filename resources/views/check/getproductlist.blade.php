
@extends('layouts.pack.carpet')
@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="prixod">
<div id="notification-container"></div>
          <div class="col-md-8 mx-auto px-5 py-3 credit-form" id="tovar-prixod-form">
          <form action="{{ url('check/getproductlist_save')}}" method="POST" id="productsform">
              @csrf
              <h4 class="text-center mb-4">Keluvchi Tovarlar</h4>
              <div class="form-row mb-3">
                <div class="input-group">
                  <div class="col-md-4 mt-3"></div>
                </div>
              </div>
           
              <input type="hidden" name="all_products" id="all_products" >
              <input type="hidden" name="type" id="type">
              <div class="form-row mb-3">
                <div class="input-group">
                  <p class="col-md-4 pl-3 mb-0 mt-2">Faylni tanlang</p>
                  <div class="col-md-8 px-0">
                    <label for="products" class="label-file"
                      >Choose a file</label>
                    <input type="file" id="products" name="products" onchange="spin(1)"/>
                    <div class="ml-5 spinner-grow text-info product_list_upload d-none" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <i class="ml-5 far text-success fa-check-circle product_list_upload_success fa-2x d-none" ></i>
                  </div>
                 
                </div>
              </div>
              <div  class="m-3" style="border:solid 1px black">
              <b class="m-2">Available Products:</b>
             <pre class="m-4" id="products_data">
                Choose file to view
             </pre>
            </div>
             
           
          
              <div class="form-row text-center">
                <button type="button" class="btn btn-success mx-auto" id="tovar-prixod-submit" onclick="sendproducts()">Navbatga qo'shish</button>
                <button type="button" class="btn btn-success mx-auto" id="tovar-prixod-submit" onclick="sendtostorage()">Omborga qo'shish</button>

            </div>
            </form>
          </div>
@endsection

@section('js1')
<script>
  function occurrences(string, subString, allowOverlapping) {

string += "";
subString += "";
if (subString.length <= 0) return (string.length + 1);

var n = 0,
    pos = 0,
    step = allowOverlapping ? 1 : subString.length;

while (true) {
    pos = string.indexOf(subString, pos);
    if (pos >= 0) {
        ++n;
        pos += step;
    } else break;
}
return n;
}

  $( ".product-items" ).toggleClass('d-none');
        $( ".tovarlist" ).addClass('inner-active');
  

        function spin(id){
       if(id==1){

        $('.product_list_upload').removeClass('d-none');
          setTimeout(
          function() 
          {
            $('.product_list_upload').addClass('d-none');
          $('.product_list_upload_success').removeClass('d-none');
          }, 2000);
       }

   
  
     }
     product_list=Array.from(Array(0), () => new Array(5));
     product2_list=Array.from(Array(0), () => new Array(2));
     document.getElementById('products') 
            .addEventListener('change', function() { 
            var fr=new FileReader(); 
            fr.onload=function(){ 
                productlist='';
                product=fr.result;

                var counter = occurrences(fr.result, "*|");
                        a=0;
                        for(n=0;n<counter;n++){
                            b=product.indexOf("*|",a)+2;
                            productdesc2=(n+1)+'. ';
                        
                            product2_items=new Array(9);
                                for(i=0;i<=13;i++){
                                    
                                    a=product.indexOf("|",b);
                                    descs=product.substr(b,a-b);
                                    productdesc2+=descs+' ';
                                    b=a+1;
                                    // assigning to array
                                    if(i==0){
                                        product2_items[0]=descs;
                                    }
                                    if(i==3){
                                        product2_items[1]=descs;
                                    }
                                    if(i==4){
                                        product2_items[2]=descs;
                                    }
                                    if(i==6){
                                        product2_items[3]=descs;
                                    }
                                    if(i==7){
                                        product2_items[4]=descs;
                                    }
                                    if(i==8){
                                        product2_items[5]=descs;
                                    }
                                    if(i==9){
                                        product2_items[6]=descs;
                                    }
                                    if(i==10){
                                        product2_items[7]=descs;
                                    }
                                    if(i==11){
                                        product2_items[8]=descs;
                                    }
                                   
                                    
  
                                }

                                window.product2_list.push(product2_items);

                                productlist+=productdesc2+'\n';

                        }
                        //$('#products_data').text(productlist);
                       // console.log(product2_list);
                        // never let the go go
               console.log(product2_list);
                // for first
                productlist='';
                        var counter = occurrences(fr.result, "+|");
                        m=0;
                        barcode='';
                        for(o=0;o<counter;o++){
                            n=product.indexOf("+|",m)+2;
                            productdesc=(o+1)+'. ';
                        
                            product_items=new Array(12);
                                for(i=0;i<12;i++){
                                    
                                  if(i<5){
                                    m=product.indexOf("|",n);
                                    descs=product.substr(n,m-n);
                                    if(i==0){
                                      barcode=descs;
                                    }
                                  }
                                   

                                    if(i==0){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][1];
                                        }
                                    }
                                    }

                                    if(i==5){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][2];
                                        }
                                    }
                                    }

                                    if(i==6){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][3];
                                        }
                                    }
                                    }

                                    if(i==7){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][4];
                                        }
                                    }
                                    }

                                    if(i==8){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][5];
                                        }
                                    }
                                    }
                                    
                                    if(i==9){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][6];
                                        }
                                    }
                                    }
                                    if(i==10){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][7];
                                        }
                                    }
                                    }

                                    if(i==11){
                                    for(l=0;l<product2_list.length;l++){
                                        if(barcode==product2_list[l][0]){
                                            descs=product2_list[l][8];
                                        }
                                    }
                                    }

                                

                                    productdesc+=descs+' ';

                                    if(i<5){
                                      n=m+1;
                                  }
                                  
                                    // assigning to array
                                    product_items[i]=descs;
                                    
                                }

                                window.product_list.push(product_items);

                                productlist+=productdesc+'\n';

                        }
                        $('#products_data').text(productlist);
                      
                        // for second
                        
            } 
            
              
            fr.readAsText(this.files[0]); 
            
        }) 
        function sendproducts(){
            var products = JSON.stringify(product_list);
           // console.log(products);
            $('#all_products').val(products);
            $('#type').val('default');
            $('#productsform').submit();
          
        }
        function sendtostorage(){
            var products = JSON.stringify(product_list);
            $('#all_products').val(products);
            $('#type').val('direct');
            $('#productsform').submit();
          
        }
        
</script>

<script>
      $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", false );
$('#tab-3').prop( "checked", false );
$('#tab-4').prop( "checked", true );
$('#tab-5').prop( "checked", false );
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection