{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')

<input type="hidden" name="contenttype" id="contenttype" value="moliya">


          <div class="row mx-auto search-part mb-1 d-flex flex-row-reverse">
       
            <form action="{{ url('search') }}" method="POST">
              @csrf  
                        <div class="row">
                          <span style="background-color: rgb(78, 76, 76);padding:4px 10px 4px 10px;color:white;">
                            Dan
                        </span>
                          <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                          @if (empty($ot))
                          
                          <input
                          type="date"
                          id="searchStartDate"
                          name="searchStartDate"
                          class="form-control search-slt"
                        />
                            @else
                           
                            <input
                            type="date"
                            id="searchStartDate"
                            name="searchStartDate"
                            class="form-control search-slt"
                            value={{$ot}}
                          />
                            @endif
            
                          </div>
                          <span style="background-color: rgb(78, 76, 76);padding:4px 10px 4px 10px;color:white;">
                           Gacha
                        </span>
                          <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                          
                          @if (empty($do))
                          <input
                          type="date"
                          id="searchEndDate"
                          name="searchEndDate"
                          class="form-control search-slt"
                        />
                         
                          @else
                          <input
                          type="date"
                          id="searchEndDate"
                          name="searchEndDate"
                          value={{$do}}
                          class="form-control search-slt"
                        />
                        
                          @endif
                          </div>
            
                          <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                                <input type="text" class="form-control search-slt" placeholder="Narx"  id="price"  name="price">
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
                            <select class="form-control search-slt" id="payment" name="payment">
                              <option value="" 
                            @if (empty($selecttype)||$selecttype=='')
                            selected
                            @endif>To'lov</option> 
                            <option value="credit"
                            @if (!empty($selecttype))
                            @if ($selecttype=='credit')
                            selected
                            @endif
                            @endif>Kredit bo'yicha</option>
                            <option value="cash"
                            @if (!empty($selecttype))
                            @if ($selecttype=='cash')
                            selected
                            @endif
                            @endif>Naqd pul bo'yicha</option>
                            <option value="prechisleniya"
                            @if (!empty($selecttype))
                            @if ($selecttype=='prechisleniya')
                            selected
                            @endif
                            @endif>Prechisleniya</option>
                            <option value="valyuta"
                            @if (!empty($selecttype))
                            @if ($selecttype=='valyuta')
                            selected
                            @endif
                            @endif>Valyuta</option>
                            
                          </select>
                      </div>
            
                      <div class="col-lg-1 col-md-1 col-sm-12 p-0 mx-1">
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
                        @endif>Texnika</option>
                       
                        
                      </select>
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
                        
            <i onclick="showtoggle()" class="far  mt-1 fa-chart-bar fa-2x text-danger ml-4"></i>
            <i onclick="getxsl()" class="ml-2 text-success mt-1  fas fa-file-excel fa-2x"></i>
                </div>
            </form>


           

          </div>
   


          <div class="row col-11 mx-auto my-4 statistics d-none">
            <div class="alert alert-info col-12 row" role="alert">
              <h4 class="alert-heading mx-auto text-center col-12 mb-4">
                Moliyaviy ahvol
              </h4>
            
              <div class="col-6 row">
                <p class="col-7">Boshlang'ich badal summmalari:</p>
                <p class="col-5 font-weight-bold">{{$creditsum}} so'm</p>
              </div>
              <div class="col-6 row">
                <p class="col-7">Oylik qilingan to'lovlar:</p>
                <p class="col-5 font-weight-bold">{{$creditchecksum}} so'm</p>
              </div>
              <div class="col-6 row">
                <p class="col-7">Oylik tushumlar:</p>
                <p class="col-5 font-weight-bold">{{$cashchecksum}} so'm</p>
              </div>
              <div class="col-6 row">
                <p class="col-7">Qarz umumiy summasi:</p>
                <p class="col-5 font-weight-bold">{{$debtsum}} so'm</p>
              </div>
              <div class="col-6 row">
                <p class="col-7">Keltirilgan tovarlar:</p>
                <p class="col-5 font-weight-bold">{{$productsum}} so'm</p>
              </div>
              <div class="col-6 row">
                <p class="col-7">Xarajatlar:</p>
                <p class="col-5 font-weight-bold">{{$expencesum}} so'm</p>
              </div>

              <div class="col-6 row">
                <p class="col-7">Kassadagi Pul:</p>
                <p class="col-5 font-weight-bold">{{$creditchecksum+$cashchecksum-$expencesum}} so'm</p>
              </div>
            </div>
          </div>
          <!-- Tableni ichida bo'ladi: Sana. Shartnoma raqami. Unikal kodi. To'lagan puli. Qoldiq summasi. kassa yo kredit. 
            Ko'rish' -->
@if ($checks->count() === 0)
    <div class="alert alert-warning mt-3" style="width:100%">No data</div> 
    @else
   
    <table class="table mt-3" id="xsltable">
        <thead class="thead-light">
          <tr>
            <th scope="col">Sana</th>
            <th scope="col">Mahsulot nomi</th>
            <th scope="col">m<sup>2</sup></th>
            <th scope="col">To'langan pul</th>
            <th scope="col">Qoldiq summa</th>
            <th scope="col">To'lov turi</th>
            <th scope="col">Ko'rish</th>
          </tr>
        </thead>
        <tbody>
          
            @foreach ($checks as $check)
            @if ($check->credit)
               
            <tr>
              @php
              $paymenttime=date('h:i d/m/Y',  strtotime($check->created_at));
          @endphp
                    <th scope="row">{{ $paymenttime }}</th>
                    <td>{{ $check->productname }}</td>
                    <td>{{ $check->volume }} </td>
                    <td>{{ $check->payment_amount }}</td>
                    <td>{{ $check->credit->debt_left }}</td>
                    <td class="text-danger">Kredit</td>
                    <!--Bu kreditga berilganmi yoki naqdga sotilganmi shu maqsadda-->
                    <td> <a href="useraccount/{{$check->credit->customer_id  }}"><i class="fas fa-eye"></i></a></td>
            </tr> 

    
            @endif

            @if ($check->payment_type == "cash")
               
            <tr>
              @php
              $paymenttime=date('h:i d/m/Y',  strtotime($check->created_at));
          @endphp
                <th scope="row">{{ $paymenttime }}</th>
                    <td>{{ $check->productname }}</td>
                    <td>{{ $check->volume }} </td>
                    <td>{{ $check->payment_amount }}</td>
                    <td>Qarz yo'q</td>
                  
                    <td  class="text-warning">Naqd</td>
                   
                   
                    <!--Bu kreditga berilganmi yoki naqdga sotilganmi shu maqsadda-->
                    <td> <i class="fas fa-eye" style="color:rgb(180, 180, 180)"></i></td>
                  </tr> 

    
            @endif
            @if ($check->payment_type == "terminal")
               
            <tr>
              @php
              $paymenttime=date('h:i d/m/Y',  strtotime($check->created_at));
          @endphp
                <th scope="row">{{ $paymenttime }}</th>
                    <td>{{ $check->productname }}</td>
                    <td>{{ $check->volume }} </td>
                    <td>{{ $check->payment_amount }}</td>
                    <td>Qarz yo'q</td>
                  
                    <td  class="text-info">Terminal</td>
                   
                   
                    <!--Bu kreditga berilganmi yoki naqdga sotilganmi shu maqsadda-->
                    <td> <i class="fas fa-eye" style="color:rgb(180, 180, 180)"></i></td>
                </tr> 

    
            @endif
            @if ($check->payment_type == "prechisleniya")
               
            <tr>
              @php
              $paymenttime=date('h:i d/m/Y',  strtotime($check->created_at));
          @endphp
                <th scope="row">{{ $paymenttime }}</th>
                    <td>{{ $check->productname }}</td>
                    <td>{{ $check->volume }} </td>
                    <td>{{ $check->payment_amount }}</td>
                    <td>Qarz yo'q</td>
                  
                    <td  class="text-primary">Prechisleniya</td>
                   
                   
                    <!--Bu kreditga berilganmi yoki naqdga sotilganmi shu maqsadda-->
                    <td> <i class="fas fa-eye" style="color:rgb(180, 180, 180)"></i></td>
                </tr> 

    
            @endif
            @if ($check->payment_type == "valyuta")
               
            <tr>
              @php
              $paymenttime=date('h:i d/m/Y',  strtotime($check->created_at));
          @endphp
                <th scope="row">{{ $paymenttime }}</th>
                    <td>{{ $check->productname }}</td>
                    <td>{{ $check->volume }} </td>
                    <td>{{ $check->payment_amount }}</td>
                    <td>Qarz yo'q</td>
                  
                    <td  class="text-success">Valyuta</td>
                   
                   
                    <!--Bu kreditga berilganmi yoki naqdga sotilganmi shu maqsadda-->
                    <td> <i class="fas fa-eye" style="color:rgb(180, 180, 180)"></i></td>
                </tr> 

    
            @endif
          
            @endforeach
         
         
        </tbody>
      </table>


@endif

@endsection

@section('js1')
   <script>
        
function getxsl(){
  $("#xsltable").table2excel({
    //exclude: ".excludeThisClass",
    name: "Worksheet Name",
    filename: "SomeFile.xls", 
    preserveColors: true
});
}



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

function changed(){
  document.getElementById("selection").submit();
}
   </script>
     <script>
       function  showtoggle(){
       
       $('.fa-chart-bar').toggleClass('text-danger');
       $('.fa-chart-bar').toggleClass('text-success');
        $('.statistics').slideToggle( "fast", function() {
          $('.statistics').toggleClass('d-none');
  });
       }
       function  showtoggle2(){
        $('.fa-angle-down').toggleClass('d-none');
        $('.fa-angle-up').toggleClass('d-none');
        
        $('#selection').slideToggle( "fast", function() {
          $('#selection').toggleClass('d-none');
  });
       }
    </script>

    <script>
       $('#tab-1').prop( "checked", true );
   $('#tab-2').prop( "checked", false );
   $('#tab-3').prop( "checked", false );
   $('#tab-4').prop( "checked", false );
   $('#tab-5').prop( "checked", false );
   $('#tab-6').prop( "checked", false );
    </script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection