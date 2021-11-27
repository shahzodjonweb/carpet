{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.pack.dashboard')


@section('content1')
<input type="hidden" name="contenttype" id="contenttype" value="admin">
    <!-- <canvas id="line-chart" width="800" height="450"></canvas> -->
    <div class="col-7 mx-auto">
      <div class="px-4 mt-5 py-3 border bg-light">
      <form action="{{ route('adminpanel.update',1) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="isadmin"  name="isadmin" value="yes">
          <h4 class="text-center mb-4">Kassa</h4>
          <div class="form-row mb-3">
          </div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="main" class="col-md-4 mt-2">
                Rahbar
              </label>
            <input type="text" class="form-control col-md-8" id="main"  name="main" value="{{ $admin[0]->main }}"/>
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="accountant" class="col-md-4 mt-2">Hisobchi</label>
              <input
                type="text"
                id="accountant"
                name="accountant"
                class="form-control col-md-8"
                value="{{ $admin[0]->accountant }}"
                required
              />
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="name" class="col-md-4 mt-2">Firma nomi</label>
              <input
                type="text"
                id="name"
                name="name"
                class="form-control col-md-8"
                value="{{ $admin[0]->name }}"
                required
              />
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="address" class="col-md-4 mt-2">Firma manzili</label>
              <input
                type="text"
                id="address"
                name="address"
                class="form-control col-md-8"
                value="{{ $admin[0]->address }}"
                required
              />
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="inn_number" class="col-md-4 mt-2">Firma Identifikatsiya raqami(INN)</label>
              <input
                type="text"
                id="inn_number"
                name="inn_number"
                class="form-control col-md-8"
                value="{{ $admin[0]->inn_number }}"
                required
              />
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="input-group">
              <label for="nds_number" class="col-md-4 mt-2">Firma Registratsiya raqami(NDS)</label>
              <input
                type="text"
                id="nds_number"
                name="nds_number"
                class="form-control col-md-8"
                value="{{ $admin[0]->nds_number }}"
                required
              />
            </div>
          </div>
          <div class="form-row text-center">
            <button type="submit" class="btn btn-success mx-auto">To'lash</button>
          </div>
        </form>
      </div>
    </div>

@endsection

@section('js1')
   <script>

   </script>
     <script>
      $('#tab-1').prop( "checked", false );
  $('#tab-2').prop( "checked", false );
  $('#tab-3').prop( "checked", false );
  $('#tab-4').prop( "checked", false );
  $('#tab-5').prop( "checked", false );
  $('#tab-6').prop( "checked", true );
   </script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection