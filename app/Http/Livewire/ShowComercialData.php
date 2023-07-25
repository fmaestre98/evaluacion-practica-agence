<?php

namespace App\Http\Livewire;

use App\Helpers\Utils;
use Livewire\Component;

class ShowComercialData extends Component
{

    public $periodo_start = '01/01/2007';
    public $periodo_end = '01/04/2007';
    public $cao_usuarios;
    public $cao_usuarios_selected;
    public $cao_usuarios_unselected;
    public $showRelatorio = false;
    public $showGrafico = false;
    public $showPizza = false;

    
    protected $listeners = ['onEndChange', 'onStartChange', 'onShowRelatorio', 'onShowGrafico', 'onShowPizza', 'onUsuarioSelectedChange'];

    public function mount($cao_usuarios)
    {
        $this->cao_usuarios = $cao_usuarios;
        $this->cao_usuarios_selected = [];
        $this->cao_usuarios_unselected = $cao_usuarios;
    }

    public function onUsuarioSelectedChange($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        $this->cao_usuarios_selected = $cao_usuarios_selected;
        $this->cao_usuarios_unselected = $cao_usuarios_unselected;
        if (count($this->cao_usuarios_selected) == 0) {
            $this->hideData();
        }
    }



    public function onShowRelatorio($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        if (Utils::compareDates($this->periodo_start, $this->periodo_end)) {
            $this->cao_usuarios_selected = $cao_usuarios_selected;
            $this->cao_usuarios_unselected = $cao_usuarios_unselected;
            $this->showRelatorio = !$this->showRelatorio;
        } else {
            $this->hideData();
        }
    }

    public function onShowGrafico($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        if (Utils::compareDates($this->periodo_start, $this->periodo_end)) {
            $this->cao_usuarios_selected = $cao_usuarios_selected;
            $this->cao_usuarios_unselected = $cao_usuarios_unselected;
            $this->showGrafico = !$this->showGrafico;
        } else {
            $this->hideData();
        }
    }

    public function onShowPizza($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        if (Utils::compareDates($this->periodo_start, $this->periodo_end)) {
            $this->cao_usuarios_selected = $cao_usuarios_selected;
            $this->cao_usuarios_unselected = $cao_usuarios_unselected;
            $this->showPizza = !$this->showPizza;
        } else {
            $this->hideData();
        }
    }

    public function onStartChange($value)
    {
        $this->periodo_start = $value;
        if (Utils::compareDates($this->periodo_start, $this->periodo_end)) {
           $this->hideData();
        }
    }

    public function onEndChange($value)
    {
        $this->periodo_end = $value;
        if (Utils::compareDates($this->periodo_start, $this->periodo_end)) {
            $this->hideData();
        }
    }

    public function hideData()
    {
        $this->showPizza = false;
        $this->showGrafico = false;
        $this->showRelatorio = false;
    }
}
