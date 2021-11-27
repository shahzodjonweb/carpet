@php 
$currentdate =date("Y-m-d H:i:s");
$nextdate = date('Y-m-d', strtotime("+6 days", strtotime($currentdate))); 
$credits = \App\credit::where('next_deadline', '<', $nextdate)->pluck('customer_id');
$customers = \App\customer::all()->whereIn('id',$credits);

@endphp 
<!DOCTYPE html>
<html>
  <head>
    <title>1C system</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    /> 
    <link rel="stylesheet" href="{{ URL::asset('fa/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" />
    @yield('css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            @if (Route::has('login'))
            
                @auth
                <li class="nav-item">
                    <a href="{{ url('/home') }}" >Home</a>
                </li>
                @else
                <li class="nav-item mx-5">
                    <a href="{{ route('login') }}" >Login</a>
                </li>

                    @if (Route::has('register'))
                    <li class="nav-item mx-5">
                        <a href="{{ route('register') }}" >Register</a>
                        </li>
                    @endif
                @endif
        @endif
          </ul>
         
        </div>
      </nav>
      <div class="mt-3">
        @yield('content')
      </div>
     
       @if(session()->has('success'))
       <script>
       showNotification('success', 'Success!', '{{ session()->get('success') }}');
       </script>
       
       @endif
    @yield('js')
 
  </body>
</html>
<!-- Ism familiya sharif -->
<!-- Unikal kod -->
