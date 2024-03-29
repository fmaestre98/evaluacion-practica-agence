<div id="show_comercial">
        <div id="date_interval">
                <p>Período:</p>
                <input type="text" wire:model.debounce.1000ms="periodo_start" class="form-control" name="datepicker_start" id="datepicker_start" readonly />
                <p>a</p>
                <input type="text" wire:model.debounce.1000ms="periodo_end" class="form-control" name="datepicker_end" id="datepicker_end" readonly />
        </div>


        <livewire:comercial-form :cao_usuarios_selected="$cao_usuarios_selected" :cao_usuarios_unselected="$cao_usuarios_unselected" :wire:key="uniqid()" />
        <div wire:ignore>


                @if($showRelatorio)
                <div wire:loading.delay.long class="overlay" wire:target="showRelatorio">
                        <x-loading />
                </div>
                @foreach($cao_usuarios_selected as $usuario)
                <livewire:relatorio-table :usuario="$usuario" :start="$periodo_start" :end="$periodo_end" :wire:key="uniqid()" />
                @endforeach
                @endif

                @if($showGrafico)
                <div wire:loading.delay.long class="overlay" wire:target="showRelatorio">
                        <x-loading />
                </div>
                <livewire:bar-chart :co_usuarios=$cao_usuarios_selected :start="$periodo_start" :end="$periodo_end" :wire:key="uniqid()" />

                @endif

                @if($showPizza)
                <div wire:loading.delay.long class="overlay" wire:target="showRelatorio">
                        <x-loading />
                </div>
                <livewire:pie-chart :co_usuarios=$cao_usuarios_selected :start="$periodo_start" :end="$periodo_end" :wire:key="uniqid()" />
                @endif


        </div>

</div>