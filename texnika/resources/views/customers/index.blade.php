{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')



{{-- <div class="row mx-auto search-part mb-4">
  
    <form action="#" method="post" novalidate="novalidate">
        
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                        <input type="text" class="form-control search-slt" placeholder="Nomi">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                        <input type="text" class="form-control search-slt" placeholder="Dizayni">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Eni">
                  </div>
                  <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Bo'yi">
                  </div>

                  <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                    <input type="text" class="form-control search-slt" placeholder="M2">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                    <input type="text" class="form-control search-slt" placeholder="Rangi">
                </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                        <select class="form-control search-slt" id="exampleFormControlSelect1">
                            <option>Select Vehicle</option>
                            <option>Example one</option>
                            <option>Example one</option>
                            <option>Example one</option>
                            <option>Example one</option>
                            <option>Example one</option>
                            <option>Example one</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                        <button type="button" class="btn btn-danger wrn-btn">Search</button>
                    </div>
                
        </div>
    </form>
  
</div> --}}

<input type="hidden" name="contenttype" id="contenttype" value="kredit">
<form action="searchcustomer" method="POST">
  @csrf
<div class="row mx-auto search-part">
    <div class="col-2">
      <select class="form-control" id="searchType" name="searchType">
        <option value="name"
        @if (!empty($search))
            @if ($search == "name")
            selected
            @endif
        @endif
      
        >Ism bo'yicha</option>
        <option value="contractcode"
        @if (!empty($search))
            @if ($search == "contractcode")
            selected
            @endif
        @endif
    >Shartnoma raqami</option>
        <option value="unicode"
        @if (!empty($search))
            @if ($search == "unicode")
            selected
            @endif
        @endif
        >Unikal kod</option>
        <option value="date"
        @if (!empty($search))
            @if ($search == "date")
            selected
            @endif
        @endif
        >Sana</option>
      </select>
    </div>

@php
    $default=1111;
@endphp

    <div class="input-group col-4 searchDivs
    @if(!empty($search))
    @if ($search == "name")
     
    @else
      d-none
    @endif
    @endif
    " id="searchByName">
      <label for="searchClientName" class="mt-2 mr-3"
        >Ism familiya</label
      >
      <input
        type="text"
        id="searchClientName"
        name="searchClientName"
        class="form-control search-input"

         @if (!empty($value))
        @if ($search == "name")
        value="{{$value}}"
        @endif
    
    @endif
      />
    </div>
    <div
      class="input-group col-4 searchDivs
      @if(!empty($search))
        @if ($search == "contractcode")
        
        @else
          d-none
        @endif
      @else
        d-none
      @endif
      "
      id="searchByCreditNumber"
    >
      <label for="searchClientByCreditNumber" class="mt-2 mr-3"
        >Shartnoma raqami</label
      >
      <input
        type="text"
        id="searchClientByCreditNumber"
        name="searchClientByCreditNumber"
        class="form-control search-input"

        @if (!empty($value))
        @if ($search == "contractcode")
        value="{{$value}}"
        @endif
    
      @endif
      />
    </div>
    <div
      class="input-group col-4 searchDivs
      @if(!empty($search))
      @if ($search == "unicode")
      
      @else
        d-none
      @endif
    @else
      d-none
    @endif"
      id="searchByUniqueNumber"
    >
      <label for="searchClientByUniqueNumber" class="mt-2 mr-3"
        >Unikal kod</label
      >
      <input
        type="text"
        id="searchClientByUniqueNumber"
        name="searchClientByUniqueNumber"
        class="form-control search-input"

        @if (!empty($value))
        @if ($search == "unicode")
        value="{{$value}}"
        @endif
    
      @endif
      />
    </div>
    <div class="input-group col-4 searchDivs
    @if(!empty($search))
    @if ($search == "date")
    
    @else
      d-none
    @endif
  @else
    d-none
  @endif
    " id="searchByDate">
      <div class="input-group col-6">
        <label for="searchStartDate" class="mt-2 mr-3">От</label>
        <input
          type="date"
          id="searchStartDate"
          name="searchStartDate"
          class="form-control search-input"

          @if (!empty($value1))
          value="{{$value1}}"
        @endif
        />
      </div>
      <div class="input-group col-6">
        <label for="searchEndDate" class="mt-2 mr-3">До</label>
        <input
          type="date"
          id="searchEndDate"
          name="searchEndDate"
          class="form-control search-input"
          @if (!empty($value2))
          value="{{$value2}}"
        @endif
        />
      </div>
    </div> 
    <div class="col-1">
      <select class="form-control search-slt" id="product" name="product">
        <option value="" 
      @if (empty($selecttype)||$selecttype=='')
      selected
      @endif>Tovar</option> 
      <option value="gilam"
      @if (!empty($selecttype))
      @if ($selecttype=='gilam')
      selected
      @endif
      @endif>Gilam</option>
      <option value="tech"
      @if (!empty($selecttype))
      @if ($selecttype=='tech')
      selected
      @endif
      @endif>Kredit</option>
     
      
    </select>
</div>
    <div class="col-1">
      <button type="submit"  class="search-button">
        <i class="fas fa-search"></i>
      </button>
    </div>

  </form>

    <div class="col-3 d-none searchDivs" id="emptySpaceDiv"></div>
    <div class="col-1 text-right">
        <form action="{{route('customerlist.create')}}">
      <button type="submit" class="plus-button">
        <i class="fas fa-plus"></i>
      </button>
    </form>
    </div>
  </div>

  <!-- <div class="blue-line"></div> -->
  <div class="col-12 row mx-auto mt-3">

    @if ($customers->count() != 0)
    <table class="table table-client">
        <thead>
          <tr class="bg-dark text-white">
            <th scope="col" class="border-right">Ism familiya</th>
            <th scope="col" class="border-right">Passport Seriya</th>
            <th scope="col" class="border-right">Unikal kod</th>
            <th scope="col" class="border-right">Shartnoma</th>
            <th scope="col" class="border-right">Telefon raqami</th>
            <th scope="col" class="border-right">Qarz summasi</th>
            <th scope="col" class="border-right">Boshlang'ich to'lov</th>
            <th scope="col" class="border-right">Qolgan summa</th>
            <th scope="col" class="border-right">Foiz</th>
            <th scope="col">Ko'rish</th>
          </tr>
        </thead>
        <tbody>
  @foreach ($customers as $customer)
          @foreach ($customer->credits as $credit)
              
          @endforeach
  <tr>
      <th scope="row">{{$customer->fullname}}</th>
      <td>{{$customer->series}}</td>
      <td>{{$credit->unicode}}</td>
      <td>{{$credit->contractcode}}</td>
      <td>{{$customer->number}}</td>
      <td>{{$credit->debt_amount}} so'm</td>
      <td>{{$credit->first_payment}} %</td>
      <td>{{$credit->debt_left}} so'm</td>
  
      @if ($customer->percentage)
      <td>
          {{$customer->percentage}} %</td>
      <td>
      @else
      <td>
          0 %</td>
      <td>
      @endif
         <a href="useraccount/{{$customer->id}}"><i class="fas fa-eye"></i></a>
      </td>
    </tr>
  @endforeach
  
       
         
        </tbody>
      </table>
    @else
        
      <div class="alert alert-warning" style="width:100%">No data!</div>

    @endif

  


  </div>

@endsection

@section('js1')
<script>
     
  document.getElementById("searchType").addEventListener("change", function() {
    var divs = document.getElementsByClassName("searchDivs");
    for (var i = 0; i < divs.length; i++) {
      divs[i].classList.add("d-none");
    }
    if (document.getElementById("searchType").value == "date") {
      document.getElementById("searchByDate").classList.remove("d-none");
    } else if (document.getElementById("searchType").value == "name") {
      document.getElementById("searchByName").classList.remove("d-none");
      document.getElementById("emptySpaceDiv").classList.remove("d-none");
    } else if (document.getElementById("searchType").value == "contractcode") {
      document.getElementById("searchByCreditNumber").classList.remove("d-none");
      document.getElementById("emptySpaceDiv").classList.remove("d-none");
    } else if (document.getElementById("searchType").value == "unicode") {
      document.getElementById("searchByUniqueNumber").classList.remove("d-none");
      document.getElementById("emptySpaceDiv").classList.remove("d-none");
    }
  });
  
     </script>
      <script>
        $('#tab-1').prop( "checked", false );
    $('#tab-2').prop( "checked", true );
    $('#tab-3').prop( "checked", false );
    $('#tab-4').prop( "checked", false );
    $('#tab-5').prop( "checked", false );
    $('#tab-6').prop( "checked", false );
     </script>
@endsection

@section('css1')
    <style>
        th{
            font-size:12px;
        }
        tr{
            font-size:12px;
        }
    </style>
@endsection