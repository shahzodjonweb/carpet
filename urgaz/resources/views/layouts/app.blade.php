@php 
$currentdate =date("Y-m-d H:i:s");
$nextdate = date('Y-m-d', strtotime("+6 days", strtotime($currentdate))); 
$credits = \App\credit::where('next_deadline', '<', $nextdate)->pluck('customer_id');
$customers = \App\customer::all()->whereIn('id',$credits);
$info= \App\admin::all();
$info=$info[0];

@endphp 


<!DOCTYPE html>
<html lang="en" style="background-color:#e5e5e5;">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{$info->name}}</title>
        <link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet" />
        <link href="{{ URL::asset('css/ss.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    </head>
    <body class="sb-nav-fixed">

    <div id="notification-container"></div>
     <div id="bar" class="d-none"></div>
    <div id="check" class="d-none" >
      <div class="mx-5 mt-5">
       <b> "{{$info->name}}"</b>
       <div>{{$info->address}}</div>
      </div>
      <br>
      <div class="for_one"><span><b>Nomi:</b> <span id="productname_ch">18x19</span> </span> <span class="ml-5"><b>Narxi:</b> <span class="price_ch">1000000</span> so'm</span></div>
      <div class="for_more"></div>
      <div class="sizecheck for_one"><b>O'lchami:</b> <span id="size_ch">10</span> m<sup>2</sup></div>
      <br>
      <div><span><b>Jami:</b> <span class="price_ch">1000000</span> so'm</span> 
       {{-- <span class="ml-5"><b>NDS:</b> <span id="price_nds_ch">1000000</span> so'm</span> --}}
      </div>
      <br>
      <div class="mx-5"> Tashrifingiz uchun rahmat!</div>
    </div>

    <div class="mainwindow">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">{{$info->name}}</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <a href="{{ route('deadline.index') }}" class="navbar-top-button button-bell deadline" style="text-decoration: none;" id="button-bell">
              <i class="fas fa-bell 
              @if ($customers->count()!=0)
              belling
              @endif
              "></i>
             
            </a>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                          @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                    </div>
                </li>
            </ul> 
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                            @if (Auth::user()->role == 'admin')
                            <div class="sb-sidenav-menu-heading">Boshqaruv</div>
                            <a class="nav-link asosiy" href="{{ route('analize.index') }}">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Asosiy Panel
                          </a>
                        @endif
                           
                            <div class="sb-sidenav-menu-heading">Mahsulotlar</div>

                            @if (Auth::user()->role == 'admin')
                            <a class="nav-link texnikalar" href="{{ url('customerlist/check_tech') }}" >
                              <div class="sb-nav-link-icon"><i class="fas fa-desktop"></i></div>
                              Texnikalar
                          </a>
                        @endif
                           
                            @if (Auth::user()->role == 'admin')
                            <a class="nav-link chegirma" href="{{ url('customer_ac/discountitem') }}" >
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Chegirma kartalari
                              
                            </a>
                        @endif
                           
                            
                           
                            <div class="sb-sidenav-menu-heading">Xarajatlar</div>
                            <a class="nav-link xarajat" href="{{ route('expences.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                               Umimiy Xarajatlar
                            </a>
                            <a class="nav-link qaytgan" href="{{ route('returns.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Qaytgan Tovarlar
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        @if (Auth::user()->role == 'admin')
                        Admin
                        @else
                           Kassir 
                        @endif
                       
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                  <div class="container-fluid">
                 @yield('content')
              
                  </div>
                </main>
                
            
            </div>
        </div>
        </div>
        <script src="{{ URL::asset('js/extention/choices.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('js/scripts.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('assets/demo/datatables-demo.js') }}"></script>
        <script src="{{ URL::asset('js/JsBarcode.all.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery.table2excel.js') }}"></script>
        <script type="text/javascript">
  
      var notification;
      var container = document.querySelector('#notification-container');
      var visible = false;
      var queue = [];
      
      function createNotification() {
        notification = document.createElement('div');
        var btn = document.createElement('button');
        var title = document.createElement('div');
        var msg = document.createElement('div');
        btn.className = 'notification-close';
        title.className = 'notification-title';
        msg.className = 'notification-message';
        btn.addEventListener('click', hideNotification, false);
        notification.addEventListener('animationend', hideNotification, false);
        notification.addEventListener('webkitAnimationEnd', hideNotification, false);
        notification.appendChild(btn);
        notification.appendChild(title);
        notification.appendChild(msg);
      }
      
      function updateNotification(type, title, message) {
        notification.className = 'notification notification-' + type;
        notification.querySelector('.notification-title').innerHTML = title;
        notification.querySelector('.notification-message').innerHTML = message;
      }
      
      function showNotification(type, title, message) {
        if (visible) {
          queue.push([type, title, message]);
          return;
        }
        if (!notification) {
          createNotification();
        }
        updateNotification(type, title, message);
        container.appendChild(notification);
        visible = true;
      }
      
      function hideNotification() {
        if (visible) {
          visible = false;
          container.removeChild(notification);
          if (queue.length) {
            showNotification.apply(null, queue.shift());
          }
        } 
      }
     
      
    </script>
       @if(session()->has('success'))
       <script>
       showNotification('success', 'Success!', '{{ session()->get('success') }}');
       </script>
       
       @endif
    @yield('js')
    </body>
</html>
