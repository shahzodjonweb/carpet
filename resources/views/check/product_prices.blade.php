{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.carpet')


@section('content1')
@php
  $lists=json_encode($products);
@endphp
<input type="hidden" name="contenttype" id="contenttype" value="pprice">

  <!-- Modal -->
  <div class="modal d-none" id="exampleModal" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mahsulot qo'shish</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hidemodal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <form method="POST" action="{{ route('pricelist.store') }}">
                @csrf
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label">Maxsulot</label>
                  <div class="col-sm-10">
                    <input type="text"  class="form-control" id="name" name="name" >
                  </div>
                </div>
                <div class="form-group row">
                  <label for="amount" class="col-sm-2 col-form-label">Narxi</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" value='0' min='0'  name="amount">
                  </div>
                </div>
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hidemodal()">Orqaga</button>
          <button type="submit" class="btn btn-primary" >Saqlash</button>
      
        </div>
    </form>
      </div>
    </div>
  </div>
  <!-- Modal edit -->
  <div class="modal d-none" id="exampleModal_edit" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tahrirlash</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hidemodal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <form method="POST" action="{{ route('pricelist.store') }}">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="form-group row">
                  <label for="name_edit" class="col-sm-2 col-form-label">Maxsulot</label>
                  <div class="col-sm-10">
                    <input type="text"  class="form-control" id="name_edit" name="name_edit" >
                  </div>
                </div>
                <div class="form-group row">
                  <label for="amount_edit" class="col-sm-2 col-form-label">Narxi</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" value='0' min='0'  id="amount_edit"  name="amount_edit">
                  </div>
                </div>
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hidemodal()">Orqaga</button>
          <button type="submit" class="btn btn-primary" >Saqlash</button>
      
        </div>
    </form>
      </div>
    </div>
  </div>


<div class="row mx-auto search-part">
  
    <div class="col-1 text-right">
       
      <button type="submit" class="plus-button"  onclick="showmodal()">
        <i class="fas fa-plus"></i>
      </button>
    
    </div>
  </div>

<div class="row mx-auto">
    <table class="table mt-3 table-bordered" id="SkladTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Mahsulot nomi</th>
          <th scope="col">1 m<sup>2</sup> Narxi</th>
          <th scope="col">Tahrirlash</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
     
        @foreach ($products as $product)
        <tr>
          
        <td>{{$product->productname }}</td>
          <td>{{$product->price }}</td>
          <td> <i class="fas fa-edit text-primary edit" onclick="editmenu({{$product->id}});"></i> </td>
          <td>
          <form action="{{ route('pricelist.destroy',$product->id)  }}" method="post">
            @csrf
            @method('DELETE')
            <button style="background-color:none;border:none;"><i class="far fa-trash-alt text-danger delete"></i></button></form></td>
                 
        </tr>
        @endforeach

    
      </tbody>
    </table>
  </div>
 
@endsection

@section('js1')
   <script>

function showmodal(){
       $('#exampleModal').removeClass('d-none');
     }
     function hidemodal(){
       $('#exampleModal').addClass('d-none');
       $('#exampleModal_edit').addClass('d-none');
     }

        $( ".product-items" ).toggleClass('d-none');
        $( ".pprice" ).addClass('inner-active');
      
      
        function editmenu(id){
          var name,price;
          @foreach ($products as $product)
          if({{$product->id}}==id){
            name="{{$product->productname}}";
            price={{$product->price}};
            id={{$product->id}};


          }
        
          @endforeach
          
          $('#name_edit').val(name);
          $('#amount_edit').val(price);
          $('#id').val(id);
          $('#exampleModal_edit').removeClass('d-none');
        }
   </script>
   <script>
    $('#tab-1').prop( "checked", false );
  $('#tab-2').prop( "checked", false );
  $('#tab-3').prop( "checked", false );
  $('#tab-4').prop( "checked", false );
  $('#tab-5').prop( "checked", true );
  </script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection