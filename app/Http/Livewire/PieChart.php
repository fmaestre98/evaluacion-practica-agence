<?php

namespace App\Http\Livewire;

use App\Models\Cao_factura;
use Livewire\Component;
use App\Helpers\Utils;
use DateTime;


class PieChart extends Component
{
    public $start;
    public $end;
    public $co_usuarios;
    public $data = [];
    public $categories = [];
    public $custoFixoData = [];
    public $total;
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
            $arrayResponse = $this->getReceitaLiquidaTotal($co_usuarios, $start, $end);

            foreach ($co_usuarios as $co_usuario) {
                if (array_key_exists($co_usuario['co_usuario'], $arrayResponse)) {
                    $porciento = ($arrayResponse[$co_usuario['co_usuario']] * 100) / $this->total;
                    $this->data[] = ['name' => $co_usuario['no_usuario'], 'y' => $porciento];
                } else {
                    $this->data[] = ['name' => $co_usuario['no_usuario'], 'y' => 0];
                }
            }

            $this->start = DateTime::createFromFormat('d/m/Y',  $start)->format('d F Y');
            $this->end = DateTime::createFromFormat('d/m/Y',  $end)->format('d F Y');
            $this->showComponent = true;
        } else {
            $this->showComponent = false;
        }
    }



    public function getReceitaLiquidaTotal($co_usuarios, $start, $end)
    {
        $array_response = array();

        $usuarios = array_column($co_usuarios, 'co_usuario');
        $start = DateTime::createFromFormat('d/m/Y', $start);
        $end = DateTime::createFromFormat('d/m/Y', $end);
        $start = $start->format('Y-m-d');
        $end = $end->format('Y-m-d');


        $cao_facturas = Cao_factura::join('cao_os', 'cao_os.co_os', '=', 'cao_fatura.co_os')
            ->join('cao_usuario', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
            ->whereIn('cao_usuario.co_usuario', $usuarios)
            ->whereBetween('cao_fatura.data_emissao', [$start, $end])
            ->selectRaw("SUM(cao_fatura.valor-(cao_fatura.valor*(cao_fatura.total_imp_inc/100))) AS receita, cao_usuario.co_usuario as co_usuario")
            ->groupBy('cao_usuario.co_usuario')
            ->get()->toArray();

        foreach ($cao_facturas as $f) {
            $array_response[$f['co_usuario']] = $f['receita'];
            $this->total = $this->total + $f['receita'];
        }

        return $array_response;
    }
}
