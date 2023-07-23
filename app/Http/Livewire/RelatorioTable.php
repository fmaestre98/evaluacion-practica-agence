<?php

namespace App\Http\Livewire;

use DateTime;
use Livewire\Component;
use App\Models\Cao_factura;
use App\Models\Cao_salario;
use App\Helpers\Utils;

class RelatorioTable extends Component
{

    public $start;
    public $end;
    public $cursor_month;
    public $cursor_month_label;
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
        $this->loadData($usuario, $start, $end);
    }

    public function updatedUsuario()
    {
        $this->reset();
        $this->loadData($this->usuario, $this->start, $this->end);
    }

    public function updatedStart()
    {
        $this->reset();
        $this->loadData($this->usuario, $this->start, $this->end);
    }
    public function updatedEnd()
    {
        $this->reset();
        $this->loadData($this->usuario, $this->start, $this->end);
    }

    public function loadData($usuario, $start, $end)
    {
        $this->brut_salario = Cao_salario::where('co_usuario', $usuario)->value('brut_salario') ?? 0;

        $this->cursor_month = DateTime::createFromFormat('m-Y',  $start)->format('F Y');
        $this->dataPerMonth = $this->getAllData($usuario, $start, $end);

        $this->brut_salario = Utils::realFormat($this->brut_salario);
    }



    //Get Receitas, Comision, Costo Fixo,Lucro
    public function getAllData($co_usuario, $start, $end)
    {
        $interval = Utils::getMonthsInterval($start, $end);
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
                ->selectRaw("SUM(cao_fatura.valor-(cao_fatura.valor*(cao_fatura.total_imp_inc/100))) AS receita,
                SUM((cao_fatura.valor-(cao_fatura.valor*(cao_fatura.total_imp_inc/100)))*(cao_fatura.comissao_cn/100)) AS comision")
                ->groupBy('cao_usuario.co_usuario')
                ->get()->toArray();

            foreach ($cao_facturas as $f) {
                $array_response[] = ['receita' => Utils::realFormat($f['receita']), 'comision' => Utils::realFormat($f['comision']), 'lucro' => Utils::realFormat($f['receita'] - ($this->brut_salario + $f['comision']))];
                $this->receitasSaldo += $f['receita'];
                $this->comisionSaldo += $f['comision'];
                $this->lucroSaldo += $f['receita'] - $this->brut_salario + $f['comision'];
                $this->costoFijoSaldo += $this->brut_salario;
            }

            $prev_month = $fecha_siguiente_mes;
        }
        $this->receitasSaldo = Utils::realFormat($this->receitasSaldo);
        $this->comisionSaldo = Utils::realFormat($this->comisionSaldo);
        $this->lucroSaldo = Utils::realFormat($this->lucroSaldo);
        $this->costoFijoSaldo = Utils::realFormat($this->costoFijoSaldo);
        return $array_response;
    }
}
