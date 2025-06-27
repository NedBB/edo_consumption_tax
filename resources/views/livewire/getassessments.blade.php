<?php

use Livewire\Volt\Component;
use App\Services\AssessmentService;
use Illuminate\Contracts\View\View;

new class extends Component {

    public $assessments;

    public function boot(AssessmentService $assessService){
        $this->assessments =  $assessService->listAllAssessments();

    }

    public function render():View
    {
        return view('livewire.getassessments')
                ->layout('layouts.app-view');
    }
}; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="container mt-4">
            <div class="card">
        <div class="card-header text-white mb-3">
            <h2 class="mb-0 font-weight-bold" style="font-size: 20px" >View Assessments</h2>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tax ID</th>
                        <th>Asset Code</th>
                        <th>Notes</th>
                        <th>Reference Code</th>
                        <th>Year</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($assessments as $list)
                        <tr>
                            <td>{{$list->taxpayer_id}}</td>
                            <td>{{$list->asset_id}}</td>
                            <td>{{$list->notes}}</td>
                            <td>{{$list->reference_code}}</td>
                            <td>{{$list->tax_year}}</td>
                            <td>{{$list->tax_amount}}</td>
                            <td>{{$list->status}}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-danger">No record at this time</td></tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>
</div>
