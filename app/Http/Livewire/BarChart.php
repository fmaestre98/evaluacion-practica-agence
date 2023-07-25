<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Helpers\Utils;
use DateTime;
use App\Models\Cao_factura;
use App\Models\Cao_salario;

class BarChart extends Component
{
    public $start;
    public $end;
    public $co_usuarios;
    public $dataPerMonth = [];
    public $categories = [];
    public $data = [];
    public $custoFixoData = [];
    public $showComponent = true;

    public function mount($co_usuarios, $start, $end)
    {

        $this->loadData($co_usuarios, $start, $end);
    }

    public function updatedCo_usuarios()
    {
        $this->reset();
        $this->loadData($this->co_usuarios, $this->start, $this->end);
    }

    public function updatedStart()
    {
        $this->reset();
        $this->loadData($this->co_usuarios, $this->start, $this->end);
    }
    public function updatedEnd()
    {
        $this->reset();
        $this->loadData($this->co_usuarios, $this->start, $this->end);
    }

    public function loadData($co_usuarios, $start, $end)
    {
        if (Utils::compareDates($start, $end)) {

            $this->categories = Utils::getMonthsIntervalNames($start, $end);
            $this->dataPerMonth = $this->getReceitasPerMonth($co_usuarios, $start, $end);

            foreach ($co_usuarios as $co_usuario) {
                $this->data[] = ['type' => 'column', 'name' => $co_usuario['no_usuario'], 'data' => $this->dataPerMonth[$co_usuario['co_usuario']]];
            }

            $custoFixo = $this->getCustoFixoMedio($co_usuarios);

            for ($i = 0; $i < count($this->categories); $i++) {
                $this->custoFixoData[] = $custoFixo / count($this->categories);
            }
            $this->start = DateTime::createFromFormat('d/m/Y',  $start)->format('d F Y');
            $this->end = DateTime::createFromFormat('d/m/Y',  $end)->format('d F Y');
            $this->showComponent=true;
        }else{
            $this->showComponent=false;
        }
    }

    public function getCustoFixoMedio($co_usuarios)
    {
        $usuarios = array_column($co_usuarios, 'co_usuario');
        return Cao_salario::whereIn('co_usuario', $usuarios)->sum('brut_salario') ?? 0;
    }

    public function getReceitasPerMonth($co_usuarios, $start, $end)
    {
        $array_response = array();
        foreach ($co_usuarios as $u) {
            $array_response[$u['co_usuario']] = [];
        }

        $usuarios = array_column($co_usuarios, 'co_usuario');
        $interval = Utils::getMonthsInterval($start, $end);

        $prev_month = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
        for ($i = 1; $i <= $interval; $i++) {
            $objeto_fecha = DateTime::createFromFormat('d/m/Y', $start);

            $objeto_fecha->modify("+$i month");

            $fecha_siguiente_mes = $objeto_fecha->format('Y-m-d');
            $cao_facturas = Cao_factura::join('cao_os', 'cao_os.co_os', '=', 'cao_fatura.co_os')
                ->join('cao_usuario', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
                ->whereIn('cao_usuario.co_usuario', $usuarios)
                ->whereBetween('cao_fatura.data_emissao', [$prev_month, $fecha_siguiente_mes])
                ->selectRaw("SUM(cao_fatura.valor-(cao_fatura.valor*(cao_fatura.total_imp_inc/100))) AS receita, cao_usuario.co_usuario as co_usuario")
                ->groupBy('cao_usuario.co_usuario')
                ->get()->toArray();

            foreach ($cao_facturas as $f) {
                $array_response[$f['co_usuario']][] = $f['receita'];
            }

            $prev_month = $fecha_siguiente_mes;
        }

        return $array_response;
    }
}
