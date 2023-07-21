<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowComercialData extends Component
{

    public $periodo_start = "01-2007";
    public $periodo_end = "02-2007";
    public $cao_usuarios_selected;
    public $cao_usuarios_unselected;
    public $selectedItemsModel = [];
    public $unSelectedItemsModel = [];
    public $showRelatorio = false;
    public $showGrafico = false;
    public $showPizza = false;

    protected $listeners = ['onEndChange', 'onStartChange'];

    public function mount($cao_usuarios)

    {
        $this->cao_usuarios_selected = [];
        $this->cao_usuarios_unselected = $cao_usuarios->toArray();
    }


    public function getSelectedItems()
    {
        // Obtener los elementos seleccionados
        $selected = $this->selectedItemsModel;
        $resultado = $this->filterArray($this->cao_usuarios_unselected, $selected, true);
        array_push($this->cao_usuarios_selected, ...$resultado);

        $this->cao_usuarios_unselected = $this->filterArray($this->cao_usuarios_unselected, $selected, false);
        // Limpiar la selección
        $this->selectedItemsModel = [];
    }

    public function getUnSelectedItems()
    {
        // Obtener los elementos seleccionados
        $selected = $this->unSelectedItemsModel;
        $resultado = $this->filterArray($this->cao_usuarios_selected, $selected, true);
        array_push($this->cao_usuarios_unselected, ...$resultado);


        $this->cao_usuarios_selected = $this->filterArray($this->cao_usuarios_selected, $selected, false);
        // Limpiar la selección
        $this->unSelectedItemsModel = [];
    }

    public function onEndChange($value)
    {
        $this->periodo_end = $value;
    }
    public function onStartChange($value)
    {
        $this->periodo_start = $value;
    }

    public function filterArray($result, $selected, $repeat)
    {
        $resultado = array_filter($result, function ($elemento) use ($selected, $repeat) {
            return in_array($elemento['co_usuario'], $selected) == $repeat;
        });
        return $resultado;
    }
}
