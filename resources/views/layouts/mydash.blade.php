<!DOCTYPE >
<html lang="en">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   
    <title>Short Links Generator Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">



    <style>
        table td{
            padding:.40rem !important;
        }
        
        table{
            font-size:8px;
            font-weight:bold;
        }
        @media screen and (max-width:500px){
          .nav-item .collapsed{
            font-size:34px;
           }
            table{
                font-size:4px !important;
                width:100px !important;
                font-weight:bold;

            }
            table td{
                font-size:5px !important;

                width:10px;
                padding-top:.01rem !important;
                padding-bottom:.01rem !important;

            }
        }
    </style>
</head>

<body id="page-top">
    @yield('content')

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('js/demo/chart-pie-demo.js')}}"></script>

</body>

</html>
