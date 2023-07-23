<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowComercialData extends Component
{

    public $periodo_start = '01-2007';
    public $periodo_end = '04-2007';
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

    public function onUsuarioSelectedChange($cao_usuarios_selected,$cao_usuarios_unselected)
    {
        $this->cao_usuarios_selected = $cao_usuarios_selected;
        $this->cao_usuarios_unselected = $cao_usuarios_unselected;
        if(count($this->cao_usuarios_selected)==0){
            $this->showRelatorio=false;
            $this->showPizza=false;
            $this->showGrafico=false;
        }
    }



    public function onShowRelatorio($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        $this->cao_usuarios_selected = $cao_usuarios_selected;
        $this->cao_usuarios_unselected = $cao_usuarios_unselected;
        $this->showRelatorio = !$this->showRelatorio;
    }

    public function onShowGrafico($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        $this->cao_usuarios_selected = $cao_usuarios_selected;
        $this->cao_usuarios_unselected = $cao_usuarios_unselected;
        $this->showGrafico = !$this->showGrafico;
    }

    public function onShowPizza($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        $this->cao_usuarios_selected = $cao_usuarios_selected;
        $this->cao_usuarios_unselected = $cao_usuarios_unselected;
        $this->showPizza = !$this->showPizza;
    }

    public function filterArray($result, $selected, $repeat)
    {
        $resultado = array_filter($result, function ($elemento) use ($selected, $repeat) {
            return in_array($elemento['co_usuario'], $selected) == $repeat;
        });
        return $resultado;
    }

    public function onStartChange($value)
    {
        $this->periodo_start = $value;
    }

    public function onEndChange($value)
    {
        $this->periodo_end = $value;
    }
}
