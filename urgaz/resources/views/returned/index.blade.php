{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.return')


@section('content1')
<div class="row mx-auto search-part mb-1 d-flex flex-row-reverse">
  
  <form action="{{ url('customer_ac/discount_search') }}" method="POST">
    @csrf  
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 p-0 mx-1">
                  <input type="text" class="form-control search-slt" placeholder="Mahsulot nomi"  id="name"  name="name">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                  <input type="text" class="form-control search-slt" placeholder="Turi/Modeli"  id="model"  name="model">
              </div>
          
          <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
              <input type="text" class="form-control search-slt" placeholder="Hajmi"  id="volume"  name="volume">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
            <input type="text" class="form-control search-slt" placeholder="Dizayni"  id="design"  name="design">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
          <input type="text" class="form-control search-slt" placeholder="Narxi"  id="price"  name="color">
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
<div class="row mx-auto">
   
    <table class="table mt1" id="SkladTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Sana</th>
          <th scope="col">Barkod</th>
          <th scope="col">Mahsulot nomi</th>
          <th scope="col">Turi/Modeli</th>
          <th scope="col">Hajmi</th>
          <th scope="col">Dizayni</th>
          <th scope="col">Narxi</th>
        </tr>
      </thead>
     
      <tbody>

        @foreach ($products as $product)
        <tr>
          @php
          $paymenttime=date('d/m/Y',  strtotime($product->created_at));
      @endphp
            <td>{{ $paymenttime }}</td>
            <td>{{ $product->barcode }}</td>  
            <td>{{ $product->productname}}</td>  
            <td>{{ $product->type }}</td>  
            <td>{{ $product->volume}}</td>  
            <td>{{ $product->design }}</td>  
            <td>{{ $product->price }} so'm</td> 
        </tr>
          
        @endforeach

     
      </tbody>
    </table>
  </div>
 
@endsection

@section('js1')

    <script>

    $( ".discount-items" ).toggleClass('d-none');
    $( ".disclist" ).addClass('inner-active');

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