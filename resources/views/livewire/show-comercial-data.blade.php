<div id="show_comercial">

    <div class="col-md-6">
        <p>Período: <input type="text" wire:model="periodo_start" class="form-control" name="datepicker_start" id="datepicker_start" /> a
            <input type="text" wire:model="periodo_end" class="form-control" name="datepicker_end" id="datepicker_end" />
    </div>

    <h3>Consultores</h3>
    <div id="selects_container">
        <select wire:model="selectedItemsModel" class="form-select" id="first_list" size="6" multiple aria-label="multiple select example">
            @foreach($cao_usuarios_unselected as $usuario)
            <option value="{{$usuario['co_usuario']}}">{{$usuario['no_usuario']}}</option>
            @endforeach

        </select>
        <div id="buttons_container">
            <button wire:click="getSelectedItems" type="button" id="button_select" class="btn btn-secondary btn-sm"> <i class="bi bi-box-arrow-in-right"></i></button>
            <button wire:click="getUnSelectedItems" type="button" id="button_desselect" class="btn btn-secondary btn-sm"> <i class="bi bi-box-arrow-in-left"></i></button>
        </div>
        <select wire:model="unSelectedItemsModel" class="form-select" id="selected" size="6" multiple aria-label="multiple select example">
            @foreach($cao_usuarios_selected as $usuario)
           # <option value="{{ $usuario['co_usuario']}}">{{$usuario['no_usuario']}}</option>
            @endforeach
        </select>

        <div id="actions_buttons_container" class="col-md-2">
            <button wire:click="$toggle('showRelatorio')" type="button" class="btn btn-primary"><i class="bi bi-clipboard-data-fill"></i> Relátorio</button>
            <button wire:click="$toggle('showGrafico')" type="button" class="btn btn-info"><i class="bi bi-bar-chart-line-fill"></i> Gráfico</button>
            <button wire:click="$toggle('showPizza')" type="button" class="btn btn-success"><i class="bi bi-pie-chart-fill"></i> Pizza</button>
        </div>
    </div>
    @if($showRelatorio)

    @foreach($cao_usuarios_selected as $usuario)
    <livewire:relatorio-table :usuario="$usuario" :start="$periodo_start" :end="$periodo_end" />
    @endforeach

    @endif

    @if($showGrafico)

    @endif

    @if($showPizza)

    @endif

    
</div>