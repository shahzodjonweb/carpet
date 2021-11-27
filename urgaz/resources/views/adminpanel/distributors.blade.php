{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')
<div class="row mx-auto search-part mb-1 d-flex flex-row-reverse">
  
  <form action="{{ url('expences/expences_search') }}" method="POST">
    @csrf  
        <div class="row mx-4">
        
                  <div class="col row text-right ml-4">
       
                    <button type="button" class="col plus-button" onclick="showmodal()">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
              
      </div>
  </form>

</div>
{{-- @php
  $lists=json_encode($distributors);
@endphp --}}
<input type="hidden" name="contenttype" id="contenttype" value="pprice">

  <!-- Modal -->
  <div class="modal d-none" id="exampleModal" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mahsulot qo'shish</h5>
          <button type="button" class="close" data-dismiss="modal" onclick="hidemodal()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <form method="POST" action="{{ route('distributor.store') }}">
                @csrf
                <div class="form-group row">
                  <label for="price" class="col-sm-2 col-form-label">Nomi</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="price" class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="price" class="col-sm-2 col-form-label">Telefoni</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone">
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
         
            <form method="POST" action="{{ route('distributor.store') }}">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="form-group row">
                  <label for="price" class="col-sm-2 col-form-label">Nomi</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_edit" name="name_edit">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="price" class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="address_edit" name="address_edit">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="price" class="col-sm-2 col-form-label">Telefoni</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone_edit" name="phone_edit">
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




<div class="row mx-auto">
    <table class="table mt-1 table-bordered" id="xsltable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Nomi</th>
          <th scope="col">Adresi</th>
          <th scope="col">Telefon</th>
          <th scope="col">Qarz</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
     @foreach ($distributors as $distributor)
     <td>{{ $distributor->name }}</td>
     <td>{{ $distributor->address }}</td>
     <td>{{ $distributor->phone }}</td>
     <td>${{ $distributor->amount }}</td>
     <td> <i class="fas fa-edit text-primary edit" onclick="editmenu({{$distributor->id}});"></i> </td>
     <td>
<form action="{{ route('distributor.destroy',$distributor->id)  }}" method="post">
@csrf
@method('DELETE')
<input type="hidden" name="type" id="type" value="qarz">
<button style="background-color:none;border:none;"><i class="far fa-trash-alt text-danger delete"></i></button></form></td>
    </tbody>
     @endforeach
       

    
     
    </table>
  </div>
 
@endsection

@section('js1')
   <script>
  $('#tab-7').prop( "checked", true );
     function showmodal(){
       $('#exampleModal').removeClass('d-none');
     }
     function hidemodal(){
       $('#exampleModal').addClass('d-none');
       $('#exampleModal_edit').addClass('d-none');
     }

        $( ".expences-items" ).toggleClass('d-none');
        $( ".expencelist" ).addClass('inner-active');
      
       
        function editmenu(id){
          var name,address,phone;
          @foreach ($distributors as $distributor)
          if({{$distributor->id}}==id){
            name="{{$distributor->name}}";
            address="{{$distributor->address}}";
            phone="{{$distributor->phone}}";
            id={{$distributor->id}};


          }
        
          @endforeach
          
          $('#name_edit').val(name);
          $('#address_edit').val(address);
          $('#phone_edit').val(phone);
          $('#id').val(id);
          $('#exampleModal_edit').removeClass('d-none');
        }
 
   </script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection