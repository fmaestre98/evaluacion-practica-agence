<?php

namespace App\Http\Controllers;

use App\Models\Cao_factura;
use Illuminate\Http\Request;
use DateTime;
use App\Models\Cao_salario;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      /*  $cao_facturas=Cao_factura::join('cao_os', 'cao_os.co_os', '=', 'cao_fatura.co_os')
        ->join('cao_usuario','cao_usuario.co_usuario','=','cao_os.co_usuario')
        ->where('cao_usuario.co_usuario', '=', 'anapaula.chiodaro')
        ->whereBetween('cao_fatura.data_emissao',['2007-01-01','2007-03-01'])
        ->select('cao_os.co_os','cao_fatura.valor','cao_fatura.total_imp_inc','cao_fatura.data_emissao')
        ->get();*/
        $start='01-2007';
        $interval = 20;
        $co_usuario='anapaula.chiodaro';
        $array_response = [];
        $prev_month = DateTime::createFromFormat('m-Y', $start)->format('Y-m');
        for ($i = 1; $i <= $interval; $i++) {
            $objeto_fecha = DateTime::createFromFormat('m-Y', $start);

            $objeto_fecha->modify("+$i month");

            $fecha_siguiente_mes = $objeto_fecha->format('Y-m');

            $cao_facturas = Cao_factura::join('cao_os', 'cao_os.co_os', '=', 'cao_fatura.co_os')
            ->join('cao_usuario', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
            ->where('cao_usuario.co_usuario', '=', $co_usuario)
            ->whereBetween('cao_fatura.data_emissao', [$prev_month.'-01', $fecha_siguiente_mes.'-01'])
            ->selectRaw("((SUM(cao_fatura.valor)-(SUM(cao_fatura.valor)*(SUM(cao_fatura.total_imp_inc)/100)))*(SUM(cao_fatura.comissao_cn)/100)) as comision")
            ->groupBy('cao_usuario.co_usuario')
            ->get()->toArray();
            
            foreach ($cao_facturas as $f) {
                $array_response[]=$f;
            }
            
            
            $prev_month = $fecha_siguiente_mes;
        }
        return $array_response;
        return view('home');
    }
}
