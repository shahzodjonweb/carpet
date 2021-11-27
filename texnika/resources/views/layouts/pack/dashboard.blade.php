{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.app')


@section('content')

    <div class="wrapper">
        <div class="tabs">
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch" onclick="location.href='{{ url('analize/situation') }}'">
            <label for="tab-1" class="tab-label">Bosh Sahifa</label>
            <div class="tab-content">
            {{-- All Content --}}
            @yield('content1')
            {{-- End of content --}}
             </div>
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-2" class="tab-switch" onclick="location.href='{{ route('customerlist.index') }}'">
            <label for="tab-2" class="tab-label">Mijozlar</label>
          </div>
          
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-4" class="tab-switch" onclick="location.href='{{url('customerlist/credit_tech')}}'">
            <label for="tab-4" class="tab-label">Kredit Jihozlar</label>
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-5" class="tab-switch" onclick="location.href='{{ route('check.index') }}'">
            <label for="tab-5" class="tab-label">Kredit So'ndirish</label>
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-8" class="tab-switch" onclick="location.href='{{  route('analize.index')  }}'">
            <label for="tab-8" class="tab-label">To'lovlar</label>
          </div>

          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-7" class="tab-switch" onclick="location.href='{{ route('distributor.index') }}'">
            <label for="tab-7" class="tab-label">Distribyutorlar</label>
          </div>

          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-6" class="tab-switch" onclick="location.href='{{ route('adminpanel.edit',1) }}'">
            <label for="tab-6" class="tab-label">Admin Panel</label>
          </div>
        </div>
       
      </div>
      



@endsection

@section('js')
<script>
  
  $('.asosiy').addClass('active');

</script>
   @yield('js1')
@endsection

@section('css')
    @yield('css1')
@endsection
