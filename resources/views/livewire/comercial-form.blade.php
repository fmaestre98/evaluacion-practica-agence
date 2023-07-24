<div class="col-md-12">
    
    <h3>Consultores:</h3>
    <div id="selects_container">
        <select wire:model.debounce.1000ms="selectedItemsModel" class="form-select" id="first_list" size="6" multiple aria-label="multiple select example">
            @foreach($cao_usuarios_unselected as $usuario)
            <option value="{{$usuario['co_usuario']}}">{{$usuario['no_usuario']}}</option>
            @endforeach

        </select>
        <div id="buttons_container">
            <button wire:click="getSelectedItems" type="button" id="button_select" class="btn btn-secondary btn-sm"> <i class="bi bi-box-arrow-in-right"></i></button>
            <button wire:click="getUnSelectedItems" type="button" id="button_desselect" class="btn btn-secondary btn-sm"> <i class="bi bi-box-arrow-in-left"></i></button>
        </div>
        <select wire:model.debounce.1000ms="unSelectedItemsModel" class="form-select" id="selected" size="6" multiple aria-label="multiple select example">
            @foreach($cao_usuarios_selected as $usuario)
             <option value="{{ $usuario['co_usuario']}}">{{$usuario['no_usuario']}}</option>
            @endforeach
        </select>

        <div id="actions_buttons_container" class="col-lg-2 ">
            <button wire:click="showRelatorio" type="button" class="btn btn-primary"><i class="bi bi-clipboard-data-fill"></i> Relátorio</button>
            <button wire:click="showGrafico" type="button" class="btn btn-info"><i class="bi bi-bar-chart-line-fill"></i> Gráfico</button>
            <button wire:click="showPizza" type="button" class="btn btn-success"><i class="bi bi-pie-chart-fill"></i> Pizza</button>
        </div>
    </div>

</div>