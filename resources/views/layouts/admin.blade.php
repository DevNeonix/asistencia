<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Polindustria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body>


<div id="app">
    <div class="sidebar">
        <div class="sidebar__profile">
            <img class="d-block mx-auto p-4" src="{{asset('img/trabajoequipo.png')}}"/>
            <span class="profile__name">{{auth()->user()->name}}</span>
            <span class="profile__email"></span>
        </div>

        @php
            $menus = \App\Models\Menu::join('user_menus', 'menus.id', '=', 'user_menus.menu_id')->where('user_id',auth()->user()->id)->get();
        @endphp

        @foreach($menus as $menu)
            <div class="sidebar__item">
                <a class="sidebar__link waves-effect {{ active(route($menu->ruta)) }}" href="{{route($menu->ruta)}}"><i
                            class="fa fa-{{$menu->icon}}"></i>&nbsp;{{$menu->titulo}}</a>
            </div>
            {{--            <li><a href="{{route($menu->ruta)}}"><i class="fa fa-{{$menu->icon}}"></i><span>{{$menu->titulo}}</span></a></li>--}}
        @endforeach
        {{--        <div class="sidebar__item">--}}
        {{--            <a class="sidebar__link waves-effect d-flex justify-content-between align-items-center">Salidas--}}
        {{--                <i class="arrow-submenu icofont-arrow-right"></i>--}}
        {{--            </a>--}}
        {{--            <ul class="sidebar__submenu">--}}
        {{--                <li><a>Item 1</a></li>--}}
        {{--                <li><a>Item 2</a></li>--}}
        {{--                <li><a>Item 3</a></li>--}}
        {{--            </ul>--}}
        {{--        </div>--}}

    </div>
    <main class="main">
        <nav class="topbar navbar navbar-light bg-white d-flex">

            <i onclick="toggleSidebar()"
               class="fa fa-bars icon-lg p-3 mx-1 rounded d-flex d-md-none" style="cursor: pointer"></i>
            <a class="navbar-brand" href="#">{{env('APP_NAME','Polindustria Asistencias')}}</a>


            <div class="">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-none d-md-inline">{{auth()->user()->name}}</span>
                            <i class="icofont-user-suited d-inline d-md-none"></i>
                        </a>
                        <div class="dropdown-menu position-absolute dropdown-menu-right " style="z-index: 100">
                            {{--                            <a class="dropdown-item" href="#">Perfil</a>--}}
                            {{--                            <a class="dropdown-item" href="#">Planes</a>--}}
                            <a class="dropdown-item" href="{{route('admin.close')}}">Cerrar Sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content p-4">
            <div class="card">
                <div class="card-body">
                    @include('errors.alerts')
                    @yield('content')
                </div>
            </div>

        </div>
    </main>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
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
