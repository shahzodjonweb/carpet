{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.app')


@section('content')

    <div class="wrapper">
        <div class="tabs">
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch" onclick="location.href='{{ route('expences.index') }}'">
            <label for="tab-1" class="tab-label">Xarajatlar</label>
            <div class="tab-content">
            {{-- All Content --}}
            @yield('content1')
            {{-- End of content --}}
             </div>
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-2" class="tab-switch" onclick="location.href='{{ url('expences/debt') }}'">
            <label for="tab-2" class="tab-label"> Qarzlar </label>
           </div>
         
        </div>
       
      </div>
      



@endsection

@section('js')
<script>
  
  $('.xarajat').addClass('active');
</script>
   @yield('js1')
@endsection

@section('css')
    @yield('css1')
@endsection
