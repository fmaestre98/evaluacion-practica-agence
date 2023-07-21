<?php

namespace App\Http\Livewire;

use DateTime;
use Livewire\Component;
use PhpParser\Node\Expr\Cast\String_;
use App\Models\Cao_factura;
use App\Models\Cao_salario;

class RelatorioTable extends Component
{

    public $start;
    public $end;
    public $cursor_month;
    public $yearStart;
    public $yearEnd;
    public $usuario;
    public $dataPerMonth = [];
    public $receitasSaldo = 0;
    public $comisionSaldo = 0;
    public $costoFijoSaldo = 0;
    public $lucroSaldo = 0;
    public $brut_salario = 0;


    protected $listeners = ['udpateCursorMonth'];

    public function mount($usuario, $start, $end)
    {
        $this->brut_salario = Cao_salario::where('co_usuario', $usuario)->value('brut_salario') ?? 0;

        $this->cursor_month = $start;

        $this->dataPerMonth = $this->getAllData($usuario, $start, $end);

        $this->brut_salario = $this->realFormat($this->brut_salario);
    }



    public function getDateLabel($date)
    {

        $objeto_fecha = DateTime::createFromFormat('m-Y', $date);
        $nombre_mes = date_format($objeto_fecha, 'F');

        $anio = date_format($objeto_fecha, 'Y');

        return $nombre_mes . " " . $anio;
    }


    public function getMonthsInterval($start, $end)
    {
        $objeto_fecha1 = DateTime::createFromFormat('m-Y', $start);
        $objeto_fecha2 = DateTime::createFromFormat('m-Y', $end);

        $intervalo = $objeto_fecha1->diff($objeto_fecha2);

        $cantidad_meses = ($intervalo->y * 12) + $intervalo->m + 1;
        return $cantidad_meses;
    }


    //Get Receitas, Comision, Costo Fixo,Lucro
    public function getAllData($co_usuario, $start, $end)
    {
        $interval = $this->getMonthsInterval($start, $end);
        $array_response = [];
        $prev_month = DateTime::createFromFormat('m-Y', $start)->format('Y-m');
        for ($i = 1; $i <= $interval; $i++) {
            $objeto_fecha = DateTime::createFromFormat('m-Y', $start);

            $objeto_fecha->modify("+$i month");

            $fecha_siguiente_mes = $objeto_fecha->format('Y-m');

            $cao_facturas = Cao_factura::join('cao_os', 'cao_os.co_os', '=', 'cao_fatura.co_os')
                ->join('cao_usuario', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
                ->where('cao_usuario.co_usuario', '=', $co_usuario)
                ->whereBetween('cao_fatura.data_emissao', [$prev_month . '-01', $fecha_siguiente_mes . '-01'])
                ->selectRaw("SUM(cao_fatura.valor)-SUM(cao_fatura.total_imp_inc) as receita,
                ((SUM(cao_fatura.valor)-(SUM(cao_fatura.valor)*(SUM(cao_fatura.total_imp_inc)/100)))*(SUM(cao_fatura.comissao_cn)/100)) as comision")
                ->groupBy('cao_usuario.co_usuario')
                ->get()->toArray();


            foreach ($cao_facturas as $f) {
                $array_response[] = ['receita' => $this->realFormat($f['receita']), 'comision' => $this->realFormat($f['comision']), 'lucro' => $this->realFormat($f['receita'] - $this->brut_salario + $f['comision'])];
                $this->receitasSaldo += $f['receita'];
                $this->comisionSaldo += $f['comision'];
                $this->lucroSaldo += $f['receita'] - $this->brut_salario + $f['comision'];
                $this->costoFijoSaldo += $this->brut_salario;
            }

            $prev_month = $fecha_siguiente_mes;
        }
        $this->receitasSaldo = $this->realFormat($this->receitasSaldo);
        $this->comisionSaldo = $this->realFormat($this->comisionSaldo);
        $this->lucroSaldo = $this->realFormat($this->lucroSaldo);
        $this->costoFijoSaldo = $this->realFormat($this->costoFijoSaldo);
        return $array_response;
    }



    public function getReceitasPerMonth($co_usuario, $start, $end)
    {
        $interval = $this->getMonthsInterval($start, $end);
        $array_response = [];
        $prev_month = DateTime::createFromFormat('m-Y', $start)->format('Y-m');
        for ($i = 1; $i <= $interval; $i++) {
            $objeto_fecha = DateTime::createFromFormat('m-Y', $start);

            $objeto_fecha->modify("+$i month");

            $fecha_siguiente_mes = $objeto_fecha->format('Y-m');

            $cao_facturas = Cao_factura::join('cao_os', 'cao_os.co_os', '=', 'cao_fatura.co_os')
                ->join('cao_usuario', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
                ->where('cao_usuario.co_usuario', '=', $co_usuario)
                ->whereBetween('cao_fatura.data_emissao', [$prev_month . '-01', $fecha_siguiente_mes . '-01'])
                ->selectRaw("SUM(cao_fatura.valor)-SUM(cao_fatura.total_imp_inc) as valor")
                ->groupBy('cao_usuario.co_usuario')
                ->get()->toArray();


            foreach ($cao_facturas as $f) {
                $array_response[] = $this->realFormat($f['valor']);
                $this->receitasSaldo += $f['valor'];
            }

            $prev_month = $fecha_siguiente_mes;
        }
        $this->receitasSaldo = $this->realFormat($this->receitasSaldo);
        return $array_response;
    }

    public function getComision($co_usuario, $start, $end)
    {
        $interval = $this->getMonthsInterval($start, $end);
        $array_response = [];
        $prev_month = DateTime::createFromFormat('m-Y', $start)->format('Y-m');
        for ($i = 1; $i <= $interval; $i++) {
            $objeto_fecha = DateTime::createFromFormat('m-Y', $start);

            $objeto_fecha->modify("+$i month");

            $fecha_siguiente_mes = $objeto_fecha->format('Y-m');

            $cao_facturas = Cao_factura::join('cao_os', 'cao_os.co_os', '=', 'cao_fatura.co_os')
                ->join('cao_usuario', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
                ->where('cao_usuario.co_usuario', '=', $co_usuario)
                ->whereBetween('cao_fatura.data_emissao', [$prev_month . '-01', $fecha_siguiente_mes . '-01'])
                ->selectRaw("((SUM(cao_fatura.valor)-(SUM(cao_fatura.valor)*(SUM(cao_fatura.total_imp_inc)/100)))*(SUM(cao_fatura.comissao_cn)/100)) as comision")
                ->groupBy('cao_usuario.co_usuario')
                ->get()->toArray();


            foreach ($cao_facturas as $f) {
                $array_response[] = $this->realFormat($f['comision']);
                $this->comisionSaldo += $f['comision'];
            }

            $prev_month = $fecha_siguiente_mes;
        }
        $this->comisionSaldo = $this->realFormat($this->comisionSaldo);
        return $array_response;
    }

    public function realFormat($amount)
    {
        return 'R$ ' . number_format($amount, 2, ',', '.');
    }
}
