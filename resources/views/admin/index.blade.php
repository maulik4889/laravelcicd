

<!doctype html>
<html lang="en">
  <head>
  	<title>Matutto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet"  href="{{URL::asset('admin_assets/css/style.css')}}">
    <link href="{{ URL::asset('admin_assets/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('admin_assets/css/fonts.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('admin_assets/css/font-custom-icons.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('admin_assets/css/button.css') }}" type="text/css" rel="stylesheet">

    <!--owl-carousel-->
    <link href="{{ URL::asset('admin_assets/css/owl.carousel.cs') }}s" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('admin_assets/css/owl.theme.default.min.css') }}" type="text/css" rel="stylesheet">
    <!-- Scripting-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ URL::asset('admin_assets/js/modernizr.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin_assets/js/jquery.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?v=3&amp;libraries=places&key=AIzaSyANcuv0LgkyfghddzMStubt7ZoHBxU4Hx8" type="text/javascript"></script>
<!-- Global site tag (gtag.js) - Google Ads: 399373315 --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-399373315"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-399373315'); </script>

<!-- Event snippet for Sign-up conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. --> <script> function gtag_report_conversion(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-399373315/vbT0CNCA24ACEIPot74B', 'event_callback': callback }); return false; } </script>
  </head>
  <body>
  <div class="wrapper d-flex align-items-stretch">

  @include('admin.sidebar')
  <div id="content" class="p-4 p-md-5">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.getchange.password') }}">Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color:grey" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Logout</a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                          </form>
                </li>
           
              </ul>
            </div>
          </div>
        </nav>
      @yield('content')
</div>
</div>
    <script src="{{URL::asset('admin_assets/js/jquery.min.js')}}"></script>
    <script   src="{{URL::asset('admin_assets/js/popper.js')}}"></script>
    <script  src="{{URL::asset('admin_assets/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('admin_assets/js/main.js')}}"></script>
  </body>
</html>
