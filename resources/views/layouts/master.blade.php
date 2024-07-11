 <!-- JavaScript -->
 <script src="{{asset('js/bundle.js?ver=3.0.3')}}"></script>
    <script src="{{asset('js/scripts.js?ver=3.0.3')}}"></script>

    <script src="{{asset('js1/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('js1/Verhoeff.js')}}"></script>
    <script type="text/javascript" src="{{asset('js1/common/iorms.js')}}"></script>
    <script src="{{asset('js1/jquery.validate.min.js')}}"></script>  
    <script src="{{asset('js1/bootstrap.min.js')}}"></script> 
    <!-- <script src="{{asset('js/jquery.datatables.min.js')}}"></script>  -->

    <script src="{{asset('js1/jquery.datatables.min.js')}}"></script> 
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script> 

    <!-- Helpers -->

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('js1/config.js')}}"></script> 
    <script src="{{asset('js/customprofile.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>

    <script type="text/javascript"> 
    var APP_URL ='{{ URL::to('/') }}';
</script>





    <!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
    <!-- Page Title  -->
    <title>NORKA | JOB PORTAL</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('css/dashlite.css?ver=3.0.3')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('css/theme.css?ver=3.0.3')}}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery.ui.autocomplete.css') }}" media="all" rel="stylesheet" type="text/css">
</head>


<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            @include('layouts.sidebar')
            <div class="nk-wrap ">
            @include('layouts.header')
            <div class="nk-content ">
            @yield('contents')
            </div>
            @include('layouts.footer')

            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- select region modal -->

   
</body>

</html>

           
               
