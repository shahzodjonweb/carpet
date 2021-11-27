{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.carpet')


@section('content1')

<div class="row mx-auto search-part mb-1 d-flex flex-row-reverse">
  
  <form action="{{ url('check/storage_search') }}" method="POST">
    @csrf  
              <div class="row">
                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Nomi"  id="name"  name="name">
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Dizayni"  id="design"  name="design">
                  </div>
                  <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                    <input type="text" class="form-control search-slt" placeholder="Eni"  id="d1"  name="d1">
                </div>
                <span style="background-color: rgb(78, 76, 76);padding:4px 10px 4px 10px;color:white;">
                  x
              </span>
                <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                    <input type="text" class="form-control search-slt" placeholder="Bo'yi"  id="d2"  name="d2">
                </div>
                
                <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                  <input type="text" class="form-control search-slt" placeholder="M2"  id="volume"  name="volume">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
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
                  <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
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
          <th scope="col">Turi</th>
          <th scope="col">O'lchami</th>
          <th scope="col">1</th>
          <th scope="col">Dizayn</th>
          <th scope="col">3</th>
          <th scope="col">4</th>
          <th scope="col">5</th>
          <th scope="col">m<sup>2</sup></th>
          <th scope="col">1 m<sup>2</sup> narxi</th>
          <th scope="col">Umumiy qiymati</th>
          <th scope="col">НДС</th>
        </tr>
      </thead>
      @php
          $productm2=0;
          $producttotal=0;
          $productqqs=0;
          foreach($products as $product){
            $productm2+=$product->volume;
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
          <td>{{$product->d1.'x'.$product->d2}}</td>
          <td>{{$product->s1}}</td>
          <td>{{$product->s2}}</td>
          <td>{{$product->s3}}</td>
          <td>{{$product->s4}}</td>
          <td>{{$product->s5}}</td>
          <td>{{$product->volume}}</td>
          <td>{{$product->perm2}}</td>
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
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Jami</td>
          <td>{{$productm2}}</td>
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
$('#tab-4').prop( "checked", false );
$('#tab-5').prop( "checked", false );
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection