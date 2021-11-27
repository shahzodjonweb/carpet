{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.discount')


@section('content1')
<div class="row mx-auto search-part mb-1 d-flex flex-row-reverse">
  
  <form action="{{ url('customer_ac/discount_search') }}" method="POST">
    @csrf  
              <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Ism familiya"  id="name_d"  name="name_d">
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <input type="text" class="form-control search-slt" placeholder="Karta raqami"  id="card_number"  name="card_number">
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                    <input type="text" class="form-control search-slt" placeholder="Passport"  id="passport_d"  name="passport_d">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                  <input type="text" class="form-control search-slt" placeholder="Balans"  id="amount_d"  name="amount_d">
              </div>
               
                  <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                      <button type="submit" class="btn btn-primary wrn-btn">Search</button>
                  </div>
              
      </div>
  </form>

</div>
<div class="row mx-auto">
   
    <table class="table mt1" id="SkladTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Ism Familiya</th>
          <th scope="col">Karta raqami</th>
          <th scope="col">Passport</th>
          <th scope="col">Karta balansi</th>
        </tr>
      </thead>
     
      <tbody>

        @foreach ($accounts as $account)
        <tr>
            <td>{{ $account->card_holder }}</td>
            <td>{{ $account->card_number }}</td>  
            <td>{{ $account->series }}</td>  
            <td>{{ $account->amount_money }} so'm</td> 
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