{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.tech')


@section('content1')

<div class="row mx-auto search-part mb-1 d-flex flex-row-reverse">
  
  <form action="{{ url('customerlist/storage_tech_search') }}" method="POST">
    @csrf  
              <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Nomi"  id="name"  name="name">
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Modeli"  id="model"  name="model">
                  </div>
              
              <div class="col-lg-3 col-md-3 col-sm-12 p-0 mx-1">
                  <input type="text" class="form-control search-slt" placeholder="Rangi"  id="color"  name="color">
              </div>

                  {{-- <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <select class="form-control search-slt" id="exampleFormControlSelect1">
                          <option>Select Vehicle</option>
                          <option>Example one</option>
                          <option>Example one</option>
                          <option>Example one</option>
                          <option>Example one</option>
                          <option>Example one</option>
                          <option>Example one</option>
                      </select>
                  </div> --}}
                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <button type="submit" class="btn btn-primary wrn-btn" style="padding-top: -5px;">Search</button>
                  </div>
              
      </div>
  </form>

</div>


<input type="hidden" name="contenttype" id="contenttype" value="sklad">
<div class="row mx-auto">
    <table class="table " id="SkladTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Sana</th>
          <th scope="col">Mahsulot nomi</th>
          <th scope="col">Barkod</th>
          <th scope="col">Rangi</th>
          <th scope="col">Model</th>
          <th scope="col">Dizayn</th>
          <th scope="col">Umumiy qiymati</th>
          <th scope="col">НДС</th>
        </tr>
      </thead>
      @php
          $productm2=0;
          $producttotal=0;
          $productqqs=0;
          foreach($products as $product){
            $producttotal+=$product->total;
            $productqqs+=$product->qqs;
          }
      @endphp
      <tbody>
        <tr>
        </tr>
        @foreach ($products as $product)
        <tr>
          @php
          $paymenttime=date('d/m/Y',  strtotime($product->created_at));
      @endphp
          <td>{{$paymenttime}}</td>
          <td>{{$product->productname}}</td>
          <td>{{$product->barcode}}</td>
          <td>{{$product->color}}</td>
          <td>{{$product->type}}</td>
          <td>{{$product->type}}</td>
          <td>{{$product->total}}</td>
          @if($product->qqs==0)
          <td><i class="fas fa-times text-danger"></i></td>
          @else
              
            <td>{{$product->qqs}}</td>
          @endif
          
          
        </tr>
        @endforeach

        <tr class="font-weight-bold">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Jami:</td>
          <td></td>
          <td>{{$producttotal}}</td>
          <td>{{$productqqs}}</td>
        </tr>
      </tbody>
    </table>
  </div>
 
@endsection

@section('js1')
   <script>
        $( ".product-items" ).toggleClass('d-none');
        $( ".sklad" ).addClass('inner-active');
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