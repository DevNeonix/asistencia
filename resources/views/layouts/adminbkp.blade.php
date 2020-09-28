<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Polindustria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
            padding: 0;
            margin: 0;
        }

        i.fa {
            font-size: 16px;
        }

        p {
            font-size: 16px;
            line-height: 1.42857143;
        }

        .header {
            position: fixed;
            z-index: 10;
            top: 0;
            left: 0;
            background: #3498DB;
            width: 100%;
            height: 50px;
            line-height: 50px;
            color: #fff;
        }

        .header .logo {
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header #menu-action {
            display: block;
            float: left;
            width: 60px;
            height: 50px;
            line-height: 50px;
            margin-right: 15px;
            color: #fff;
            text-decoration: none;
            text-align: center;
            background: rgba(0, 0, 0, 0.15);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .header #menu-action i {
            display: inline-block;
            margin: 0 5px;
        }

        .header #menu-action span {
            width: 0px;
            display: none;
            overflow: hidden;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .header #menu-action:hover {
            background: rgba(0, 0, 0, 0.25);
        }

        .header #menu-action.active {
            width: 250px;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .header #menu-action.active span {
            display: inline;
            width: auto;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .sidebar {
            position: fixed;
            z-index: 10;
            left: 0;
            top: 50px;
            height: 100%;
            width: 60px;
            background: #fff;
            border-right: 1px solid #ddd;
            text-align: center;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .sidebar:hover,
        .sidebar.active,
        .sidebar.hovered {
            /*width: 250px;*/
            min-width: 250px;
            width: fit-content;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            display: block;
        }

        .sidebar ul li a {
            display: block;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
            border-bottom: 1px solid #ddd;
            color: #444;
            text-align: left;
        }

        .sidebar ul li a i {
            display: inline-block;
            width: 60px;
            height: 60px;
            line-height: 60px;
            text-align: center;
            -webkit-animation-duration: 0.7s;
            -moz-animation-duration: 0.7s;
            -o-animation-duration: 0.7s;
            animation-duration: 0.7s;
            -webkit-animation-fill-mode: both;
            -moz-animation-fill-mode: both;
            -o-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .sidebar ul li a span {
            display: inline-block;
            height: 60px;
            line-height: 60px;
        }

        .sidebar ul li a:hover {
            background-color: #eee;
        }

        .main {
            position: relative;
            display: block;
            top: 50px;
            left: 0;
            padding: 15px;
            padding-left: 75px;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .main.active {
            padding-left: 275px;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        .main .jumbotron {
            background-color: #fff;
            padding: 30px !important;
            border: 1px solid #dfe8f1;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .main .jumbotron h1 {
            font-size: 24px;
            margin: 0;
            padding: 0;
            margin-bottom: 12px;
        }

        @-webkit-keyframes swing {
            20% {
                -webkit-transform: rotate3d(0, 0, 1, 15deg);
                transform: rotate3d(0, 0, 1, 15deg);
            }
            40% {
                -webkit-transform: rotate3d(0, 0, 1, -10deg);
                transform: rotate3d(0, 0, 1, -10deg);
            }
            60% {
                -webkit-transform: rotate3d(0, 0, 1, 5deg);
                transform: rotate3d(0, 0, 1, 5deg);
            }
            80% {
                -webkit-transform: rotate3d(0, 0, 1, -5deg);
                transform: rotate3d(0, 0, 1, -5deg);
            }
            100% {
                -webkit-transform: rotate3d(0, 0, 1, 0deg);
                transform: rotate3d(0, 0, 1, 0deg);
            }
        }

        @keyframes swing {
            20% {
                -webkit-transform: rotate3d(0, 0, 1, 15deg);
                -ms-transform: rotate3d(0, 0, 1, 15deg);
                transform: rotate3d(0, 0, 1, 15deg);
            }
            40% {
                -webkit-transform: rotate3d(0, 0, 1, -10deg);
                -ms-transform: rotate3d(0, 0, 1, -10deg);
                transform: rotate3d(0, 0, 1, -10deg);
            }
            60% {
                -webkit-transform: rotate3d(0, 0, 1, 5deg);
                -ms-transform: rotate3d(0, 0, 1, 5deg);
                transform: rotate3d(0, 0, 1, 5deg);
            }
            80% {
                -webkit-transform: rotate3d(0, 0, 1, -5deg);
                -ms-transform: rotate3d(0, 0, 1, -5deg);
                transform: rotate3d(0, 0, 1, -5deg);
            }
            100% {
                -webkit-transform: rotate3d(0, 0, 1, 0deg);
                -ms-transform: rotate3d(0, 0, 1, 0deg);
                transform: rotate3d(0, 0, 1, 0deg);
            }
        }

        .swing {
            -webkit-transform-origin: top center;
            -ms-transform-origin: top center;
            transform-origin: top center;
            -webkit-animation-name: swing;
            animation-name: swing;
        }

        .bs-callout {
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #eee;
            border-left-width: 5px;
            border-radius: 3px;
            background: white;
        }

        table {
            background: white;
        }

        .bs-callout h4 {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .bs-callout p:last-child {
            margin-bottom: 0;
        }

        .bs-callout code {
            border-radius: 3px;
        }

        .bs-callout + .bs-callout {
            margin-top: -5px;
        }

        .bs-callout-default {
            border-left-color: #777;
        }

        .bs-callout-default h4 {
            color: #777;
        }

        .bs-callout-primary {
            border-left-color: #428bca;
        }

        .bs-callout-primary h4 {
            color: #428bca;
        }

        .bs-callout-success {
            border-left-color: #5cb85c;
        }

        .bs-callout-success h4 {
            color: #5cb85c;
        }

        .bs-callout-danger {
            border-left-color: #d9534f;
        }

        .bs-callout-danger h4 {
            color: #d9534f;
        }

        .bs-callout-warning {
            border-left-color: #f0ad4e;
        }

        .bs-callout-warning h4 {
            color: #f0ad4e;
        }

        .bs-callout-info {
            border-left-color: #5bc0de;
        }

        .bs-callout-info h4 {
            color: #5bc0de;
        }

        .table-responsive-stack tr {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
        }


        .table-responsive-stack td,
        .table-responsive-stack th {
            display: block;
            /*
               flex-grow | flex-shrink | flex-basis   */
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
        }

        .table-responsive-stack .table-responsive-stack-thead {
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .table-responsive-stack tr {
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                border-bottom: 3px solid #ccc;
                display: block;

            }

            /*  IE9 FIX   */
            .table-responsive-stack td {
                float: left \9;
                width: 100%;
            }
        }


    </style>
</head>
<body>
<div class="header">
    <a href="#" id="menu-action">
        <i class="fa fa-bars"></i>
        <span>Cerrar</span>
    </a>
    <div class="logo">
        Admin | <?php
        $id = Session::get('usuario');
        $user = DB::table('users')->where('id', $id)->get()[0];
        echo $user->name;
        ?>
    </div>

</div>
<div class="sidebar">
    <ul>
        @php
            $menus = \App\Models\Menu::join('user_menus', 'menus.id', '=', 'user_menus.menu_id')->get();
        @endphp

        @foreach($menus as $menu)
            <li><a href="{{route($menu->ruta)}}"><i class="fa fa-{{$menu->icon}}"></i><span>{{$menu->titulo}}</span></a></li>
        @endforeach

        <li><a href="{{route('admin.close')}}"><i class="fa fa-close"></i><span>Cerrar Sesión </span></a></li>
    </ul>
</div>

<!-- Content -->
<div class="main">
    <div class="container-fluid">
        @include('errors.alerts')
        @yield('content')
    </div>
</div>
<script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
    $('#menu-action').click(function () {
        $('.sidebar').toggleClass('active');
        $('.main').toggleClass('active');
        $(this).toggleClass('active');

        if ($('.sidebar').hasClass('active')) {
            $(this).find('i').addClass('fa-close');
            $(this).find('i').removeClass('fa-bars');
        } else {
            $(this).find('i').addClass('fa-bars');
            $(this).find('i').removeClass('fa-close');
        }
    });
    // $('.sidebar').addClass('active');
    // $('.main').addClass('active');
    // $("#menu-action").toggleClass('active');
    // $("#menu-action").find('i').addClass('fa-close');
    // $("#menu-action").find('i').removeClass('fa-bars');


    // Add hover feedback on menu
    $('#menu-action').hover(function () {
        $('.sidebar').toggleClass('hovered');
    });
    $(document).ready(function () {


        // inspired by http://jsfiddle.net/arunpjohny/564Lxosz/1/
        $('.table-responsive-stack').find("th").each(function (i) {

            $('.table-responsive-stack td:nth-child(' + (i + 1) + ')').prepend('<span class="table-responsive-stack-thead">' + $(this).text() + ':</span> ');
            $('.table-responsive-stack-thead').hide();
        });


        $('.table-responsive-stack').each(function () {
            var thCount = $(this).find("th").length;
            var rowGrow = 100 / thCount + '%';
            //console.log(rowGrow);
            $(this).find("th, td").css('flex-basis', rowGrow);
        });


        function flexTable() {
            if ($(window).width() < 768) {

                $(".table-responsive-stack").each(function (i) {
                    $(this).find(".table-responsive-stack-thead").show();
                    $(this).find('thead').hide();
                });


                // window is less than 768px
            } else {


                $(".table-responsive-stack").each(function (i) {
                    $(this).find(".table-responsive-stack-thead").hide();
                    $(this).find('thead').show();
                });


            }
// flextable
        }

        flexTable();

        window.onresize = function (event) {
            flexTable();
        };


// document ready
    });


</script>
@yield('scripts')
</body>
</html>
