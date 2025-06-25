<?php

use Livewire\Volt\Component;
use Illuminate\Contracts\View\View;

new class extends Component {
    //

    public function render():View
    {
        return view('livewire.dashboard-manager')
                ->layout(']layout.app-view');
    }
}; ?>

<div>
    <p>for Eras</p>
</div>
