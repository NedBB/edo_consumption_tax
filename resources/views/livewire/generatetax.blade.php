<?php

use Livewire\Volt\Component;
use Illuminate\Contracts\View\View;

new class extends Component {


    public function render():View {
         return view('livewire.generatetax',[])
                ->layout('layouts.app-view')
                ;
    }
}; ?>


<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <form wire:submit.prevent='searchDetails'>
            <div class="col-12">
                <div class="card mb-4">
                    <h5 class="card-header text-center">Generate Tax</h5>

                </div>
            </div>
        </form>
    </div>

    <div>

    {{-- <div class="row">
        <div class="col-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Typeahead</h5>
                    <div class="card-body">
                      <div class="row">
                        <!-- Basic -->
                        <div class="col-md-6 mb-4">
                          <label for="TypeaheadBasic" class="form-label">Basic</label>
                          <input
                            id="TypeaheadBasic"
                            class="form-control typeahead"
                            type="text"
                            autocomplete="off"
                            placeholder="Enter states from USA" />
                        </div>
                        <!-- Bloodhound -->
                        <div class="col-md-6 mb-4">
                          <label for="TypeaheadBloodHound" class="form-label">BloodHound (Suggestion Engine)</label>
                          <input
                            id="TypeaheadBloodHound"
                            class="form-control typeahead-bloodhound"
                            type="text"
                            autocomplete="off"
                            placeholder="Enter states from USA" />
                        </div>
                        <!-- Prefetch -->
                        <div class="col-md-6 mb-4">
                          <label for="TypeaheadPrefetch" class="form-label">Prefetch</label>
                          <input
                            id="TypeaheadPrefetch"
                            class="form-control typeahead-prefetch"
                            type="text"
                            autocomplete="off"
                            placeholder="Enter states from USA" />
                        </div>
                        <!-- Default Suggestions -->
                        <div class="col-md-6 mb-4">
                          <label for="TypeaheadSuggestions" class="form-label">Default Suggestions</label>
                          <input
                            id="TypeaheadSuggestions"
                            class="form-control typeahead-default-suggestions"
                            type="text"
                            autocomplete="off" />
                        </div>
                        <!-- Custom Template -->
                        <div class="col-md-6 mb-4 mb-md-0">
                          <label for="TypeaheadCustom" class="form-label">Custom Template</label>
                          <input
                            id="TypeaheadCustom"
                            class="form-control typeahead-custom-template"
                            type="text"
                            autocomplete="off"
                            placeholder="Search For Oscar Winner" />
                        </div>
                        <!-- Multiple Datasets -->
                        <div class="col-md-6">
                          <label for="TypeaheadMultipleDataset" class="form-label">Multiple Datasets</label>
                          <input
                            id="TypeaheadMultipleDataset"
                            class="form-control typeahead-multi-datasets"
                            type="text"
                            autocomplete="off" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
    </div> --}}
</div>
