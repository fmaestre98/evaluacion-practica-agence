<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComercialForm extends Component
{
    public $cao_usuarios_selected;
    public $cao_usuarios_unselected;
    public $selectedItemsModel = [];
    public $unSelectedItemsModel = [];



    public function mount($cao_usuarios_selected, $cao_usuarios_unselected)
    {
        $this->loadData($cao_usuarios_selected, $cao_usuarios_unselected);
    }

    public function updatedCao_usuarios_selected()
    {

        $this->reset();
        $this->loadData($this->cao_usuarios_selected, $this->cao_usuarios_unselected);
    }

    public function updatedCao_usuarios_unselected()
    {
        $this->reset();
        $this->loadData($this->cao_usuarios_selected, $this->cao_usuarios_unselected);
    }


    public function loadData($cao_usuarios_selected, $cao_usuarios_unselected)
    {


        $this->cao_usuarios_selected = $cao_usuarios_selected;
        $this->cao_usuarios_unselected = $cao_usuarios_unselected;
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
        $this->emitUp('onUsuarioSelectedChange', $this->cao_usuarios_selected, $this->cao_usuarios_unselected);
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
        $this->emitUp('onUsuarioSelectedChange', $this->cao_usuarios_selected, $this->cao_usuarios_unselected);
    }

    public function filterArray($result, $selected, $repeat)
    {
        $resultado = array_filter($result, function ($elemento) use ($selected, $repeat) {
            return in_array($elemento['co_usuario'], $selected) == $repeat;
        });
        return $resultado;
    }



    public function showRelatorio()
    {
        if (count($this->cao_usuarios_selected)) {
            $this->emitUp('onShowRelatorio', $this->cao_usuarios_selected, $this->cao_usuarios_unselected);
        }
    }

    public function showGrafico()
    {
        if (count($this->cao_usuarios_selected)) {
            $this->emitUp('onShowGrafico', $this->cao_usuarios_selected, $this->cao_usuarios_unselected);
        }
    }

    public function showPizza()
    {
        if (count($this->cao_usuarios_selected)) {
            $this->emitUp('onShowPizza', $this->cao_usuarios_selected, $this->cao_usuarios_unselected);
        }
    }




    public function render()
    {
        return view('livewire.comercial-form');
    }
}
