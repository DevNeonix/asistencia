@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <span class="h1 text-info" id="hora">00:00:00</span>
                <div class="col-12 ">
                    <h5>Marcacion para el Producto <b>{{$ot->producto_fabricar}}</b> del cliente <b>{{$ot->cliente}}</b>
                    </h5>
                </div>

                <?php

                $empleados = DB::table('view_orden_trabajo_personal')->where('id_ot', $ot->id)->where('tipo', '>', -1)->get();

                ?>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="allChk" onclick="seleccionaTodos(this.checked)"></th>
                        <th>Nombre</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($empleados as $i)
                        <?php
                        $faltas = DB::table('faltas')->where('ot', $ot->id)->where('personal', $i->id_personal)->where('fecha', date("Y-m-d"))->get();

                        ?>
                        @if(count($faltas) == 0)
                            <tr>
                                <td>
                                    <?php

                                    $validasql = DB::select(DB::raw("select mod(count(*),2) as valida  from marcacion where personal=" . $i->id_personal . " and year(fecha)=year(now()) and month(fecha)=month(now()) and day(fecha)=day(now()) and orden_trabajo <> '" . $ot->id . "' "));
                                    $v = intval($validasql[0]->valida);
                                    //QUITANDO VALIDACION POR AHORA
                                    $v = 0;
                                    ?>
                                    @if($v == 0)

                                        <input id_personal="{{$i->id_personal}}" class="chkAsistencia" type="checkbox">

                                    @endif

                                </td>
                                <?php
                                $k = 0
                                ?>
                                <td>
                                    {{$i->nombre}}
                                    <?php
                                    $x = DB::select(DB::raw("select * from marcacion where orden_trabajo='" . $ot->id . "' and personal = " . $i->id_personal . " and year(fecha)=year(now()) and month(fecha)=month(now()) and day(fecha)=day(now()) "));
                                    ?>
                                    @foreach($x as $j)
                                        <p class="text-muted text-italic">

                                            <?php
                                            $k = $k + 1;
                                            ?>
                                            <b>{{$k%2==0?"Salió":'Ingresó' }}</b>: {{\Carbon\Carbon::parse($j->fecha)->diffForHumans(\Carbon\Carbon::now())}}
                                            @if($j->id == $x[count($x)-1]->id)
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="eliminaMarca({{$j->id}})">Eliminar
                                                </button>
                                            @endif
                                        </p>
                                    @endforeach

                                    @if($v == 1)<br> <p class="text-danger">Este personal se encuentra en otra
                                        OT</p> @endif
                                </td>

                            </tr>
                        @endif

                    @endforeach
                    </tbody>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-primary" onclick="enviarRegistro()">Registrar asistencia</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        function setHora() {
            var hora = document.getElementById("hora");
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();

            hora.innerHTML = h + ':' + m + ':' + s;
            setInterval(function () {
                var today = new Date();
                var h = "00" + today.getHours();
                var m = "00" + today.getMinutes();
                var s = "00" + today.getSeconds();

                hora.innerHTML = h.toString().slice(-2) + ':' + m.toString().slice(-2) + ':' + s.toString().slice(-2);
            }, 1000);
        }

        setHora();

        function seleccionaTodos(v) {
            $('.chkAsistencia').prop('checked', v);
        }

        function eliminaMarca(id) {
            if (confirm("¿Está seguro de eliminar este registro?")) {


                $.ajax({
                    url: '{{route("admin.marcacion.delete")}}',
                    type: 'delete',
                    data: {
                        id: id
                    },
                    cache: false,
                    success: function (res) {
                        alert(res.message);
                        window.location.reload();
                    }
                });
            }
        }

        function enviarRegistro() {
            var personal = [];
            $(".chkAsistencia").each(function (i) {
                if (this.checked) {
                    personal.push($(this).attr("id_personal"));
                }
            });

            $.ajax({
                url: '{{route("admin.marcacion.insert")}}',
                type: 'post',
                data: {
                    orden_trabajo:{{$ot->id}},
                    personal: personal
                },
                cache: false,
                success: function (res) {
                    alert(res.message);
                    window.location.reload();
                }
            });
        }

    </script>
@endsection
