{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.expence')


@section('content1')
<div class="row mx-auto search-part mb-1 d-flex flex-row-reverse">
  
  <form action="{{ url('expences/expences_search') }}" method="POST">
    @csrf  
        <div class="row">
               
                
                <div class="col-lg-4 col-md-4 col-sm-12 p-0 mx-1">
                  <input
                  type="date"
                  id="searchDate"
                  name="searchDate"
                  class="form-control search-slt"
                />
              </div>

              <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                  <input type="text" class="form-control search-slt" placeholder="Narxi"  id="price_ex"  name="price_ex">
              </div>


                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <button type="submit" class="btn btn-primary wrn-btn" style="padding-top: -5px;">Search</button>
                  </div>
                  <div class="col-3 row text-right ml-1">
       
                    <button type="button" class="plus-button col-5" onclick="showmodal()">
                      <i class="fas fa-plus"></i>
                      
                    </button>
                    <i onclick="getxsl()" class=" col-6 text-success mt-1  fas fa-file-excel fa-2x"></i>
                  </div>
              
      </div>
  </form>

</div>
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
          <button type="button" class="close" data-dismiss="modal" onclick="hidemodal()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <form method="POST" action="{{ route('expences.store') }}">
                @csrf
               <input type="hidden" name="category" id="category" value="qarz">
                 
                  <div class="form-group">
                    <label for="comment">Kommentariya</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                  </div>
                <div class="form-group row">
                  <label for="price" class="col-sm-2 col-form-label">Narx</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" value='0' min='0' id="price" name="price">
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
          <h5 class="modal-title" id="exampleModalLabel">Qarzni Yopish</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hidemodal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <form method="POST" action="{{ url('expences/paydebt') }}">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="form-group row">
                  <label for="price_edit" class="col-sm-2 col-form-label">Summa</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" value='0' min='0' id="price_edit" name="price_edit">
                  </div>
                </div>
              
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >To'landi</button>
      
        </div>
    </form>
      </div>
    </div>
  </div>




<div class="row mx-auto">
    <table class="table mt-1 table-bordered" id="xsltable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Sana</th>
          <th scope="col">Qarz ma'lumotlari</th>
          <th scope="col">Qarz miqdori</th>
            @if (Auth::user()->role == 'admin')
                        <th scope="col">Qarzni yopish</th>
                         <th scope="col"></th>
                        @endif
        
         
        </tr>
      </thead>
      <tbody>
     
        @foreach ($products as $product)
        <tr>
          
            @php
            $paymenttime=date('h:i d/m/Y',  strtotime($product->created_at));
        @endphp
                  <th scope="row">{{ $paymenttime }}</th>
          <td>{{$product->comment }}</td>
          <td>{{$product->price }}</td>
        
                      @if (Auth::user()->role == 'admin')
                        <td> <i class="fas fa-edit text-primary edit" onclick="editmenu({{$product->id}});"></i> </td>
                         <td>
          <form action="{{ route('expences.destroy',$product->id)  }}" method="post">
            @csrf
            @method('DELETE')
            <input type="hidden" name="type" id="type" value="qarz">
            <button style="background-color:none;border:none;"><i class="far fa-trash-alt text-danger delete"></i></button></form></td>
                        @endif
         
                 
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

        $( ".expences-items" ).toggleClass('d-none');
        $( ".expencelist" ).addClass('inner-active');
      
      
      
        function editmenu(id){
          var type,price,comment;
          @foreach ($products as $product)
          if({{$product->id}}==id){
            type="{{$product->category}}";
            comment="{{$product->comment}}";
            price={{$product->price}};
            id={{$product->id}};


          }
        
          @endforeach
          
          $('#category_edit').val(type);
          $('#comment_edit').val(comment);
          $('#price_edit').val(price);
          $('#id').val(id);
          $('#exampleModal_edit').removeClass('d-none');
        }

        $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", true );

function getxsl(){
  $("#xsltable").table2excel({
    //exclude: ".excludeThisClass",
    name: "Worksheet Name",
    filename: "SomeFile.xls", 
    preserveColors: true
});
}
   </script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection