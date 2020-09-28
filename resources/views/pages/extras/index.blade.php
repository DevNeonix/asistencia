@extends('layouts.admin')
@section('content')

    <div class="col-12">
        <h1 class="h3">Asignación de Horas Extras</h1>
        <div class="form-group col-md-6">
            <label for="">Seleccion Personal</label>
            <select id="personal" class="form-control select2" onchange="buscaOt(this.value)">
                <option value=""></option>
                @foreach($personal as $p)
                    <option value="{{$p->id}}">{{$p->apellidos." ".$p->nombres}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="">Seleccion OT</label>
            <select id="ots" class="form-control select2" onchange="buscaFechas()">
                <option value=""></option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="">Seleccion Fecha de asistencia</label>
            <select id="fecha" class="form-control select2">
                <option value=""></option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="">Horas extras</label>
            <input type="number" id="horas" min="0" max="4" class="form-control" value="0" onchange="(this.value>4)?this.value=4:this.value=this.value;calculaMinutos();">
        </div>
        <div class="form-group col-md-6">
            <label for="">Minutos extras</label>
            <input type="number" id="minutos" min="0" max="59" class="form-control" value="0" onchange="(this.value>59)?this.value=59:this.value=this.value;calculaMinutos();">
        </div>
        <div class="col-md-12">
            <span class="text-bold" id="totmin">0</span> total minutos extras
        </div>
        <div class="form-group col-md-6">
            <button class="btn btn-primary btn-block btn-disabled" disabled>Guardar</button>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        var totmin = 0;
        $(".select2").select2();
        function resetExtras(){
            totmin=0;
            document.getElementById("horas").value = "0";
            document.getElementById("minutos").value = "0";
            calculaMinutos();
        }
        function calculaMinutos(){
            var horas=document.getElementById("horas").value;
            var minutos=document.getElementById("minutos").value;
            totmin = parseFloat(horas*60)+parseFloat(minutos);
            document.getElementById("totmin").innerText=totmin;
        }
        function buscaOt(id) {
            resetExtras();
            let o = `<option value=""></option>`;
            document.getElementById("ots").innerHTML = "";
            $.ajax({
                url: "{{route('api.ots_personal2')}}",
                data: "id=" + id,
                type: 'GET',
                cache: false,
                success: function (res) {
                    console.log(res)
                    var ots = res.data;
                    var ox = "";
                    for (let ot of ots) {
                        ox = ox + `<option value="${ot.id_ot}">${ot.nro_orden + ' ' + ot.cliente + ' ' + ot.producto_fabricar}</option>`
                    }
                    document.getElementById("ots").innerHTML = o + ox;
                },
                error: function (e) {
                    alert('Error: ' + e);
                }
            });
        }
        function buscaFechas() {
            resetExtras();
            document.getElementById("fecha").innerHTML = "";

            var personal = document.getElementById("personal").value;
            var ot = document.getElementById("ots").value;

            $.ajax({
                url: "{{route('api.marcacion.list')}}",
                data: "personal=" + personal+"&orden_trabajo="+ot,
                type: 'GET',
                cache: false,
                success: function (res) {
                    var oo = "";
                    for(let f of res){
                        console.log(f.fecha);
                        oo = oo +`<option value="${f.fecha}">${f.fecha}</option>`
                    }
                    document.getElementById("fecha").innerHTML = oo;
                },
                error: function (e) {
                    alert('Error: ' + e);
                }
            });
        }
    </script>
@endsection