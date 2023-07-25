<div id="realatorio_table" class="table-responsive">
    @if (count($dataPerMonth) &&  $showComponent)
    <table class="table caption-top table-striped table-bordered">
        <caption>{{$usuario['no_usuario']}}</caption>
        <thead class="table-light">
            <tr>
                <th scope="col">Período</th>
                <th scope="col">Receita Líquida </th>
                <th scope="col">Custo Fixo</th>
                <th scope="col">Comissão</th>
                <th scope="col">Lucro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataPerMonth as $data)
            <tr>
                <th scope="row">{{$cursor_month}}</th>
                <td>{{$data['receita']}}</td>
                <td>{{$brut_salario}}</td>
                <td>{{$data['comision']}}</td>
                <td>{{$data['lucro']}}</td>
            </tr>
            @php
            $cursor_month = DateTime::createFromFormat('F Y', $cursor_month);

            $cursor_month->modify("+1 month");

            $cursor_month = $cursor_month->format('F Y');
            @endphp

            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th scope="row">SALDO</th>
                <td>{{$receitasSaldo}}</td>
                <td>{{$costoFijoSaldo}}</td>
                <td>{{$comisionSaldo}}</td>
                <td>{{$lucroSaldo}}</td>
            </tr>
        </tfoot>
    </table>
    @else
    <div class="alert alert-secondary" role="alert">
    <caption>{{$usuario['no_usuario']}} no tiene datos para mostrar en este periodo de tiempo</caption>
    </div>
    
    @endif


</div>