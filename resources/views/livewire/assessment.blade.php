<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;

new class extends Component {

    public array $formData = [];
    public bool $isSubmitting = false;
    public ?array $apiResponse = null;

    public function mount(): void
    {
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->formData = [
            'TaxPayerTypeID' => 0,
            'TaxPayerID' => 0,
            'Notes' => '',
            'AssetTypeID' => 0,
            'AssetID' => 0,
            'ProfileID' => 0,
            'AssessmentRuleID' => 0,
            'TaxYear' => Carbon::now()->year,
            'LstAssessmentItem' => [
                [
                    'AssessmentItemID' => 0,
                    'TaxBaseAmount' => 0
                ]
            ]
        ];
    }

    public function addAssessmentItem(): void
    {
        $this->formData['LstAssessmentItem'][] = [
            'AssessmentItemID' => 0,
            'TaxBaseAmount' => 0
        ];
    }

    public function removeAssessmentItem(int $index): void
    {
        if (count($this->formData['LstAssessmentItem']) > 1) {
            unset($this->formData['LstAssessmentItem'][$index]);
            $this->formData['LstAssessmentItem'] = array_values($this->formData['LstAssessmentItem']);
        }
    }

    public function submitToApi(): void
    {
        $this->validate([
            'formData.TaxPayerTypeID' => 'required|integer|min:1',
            'formData.TaxPayerID' => 'required|integer|min:1',
            'formData.AssetTypeID' => 'required|integer|min:1',
            'formData.AssetID' => 'required|integer|min:1',
            'formData.ProfileID' => 'required|integer|min:1',
            'formData.AssessmentRuleID' => 'required|integer|min:1',
            'formData.TaxYear' => 'required|integer|digits:4|min:2000|max:' . (Carbon::now()->year + 1),
            'formData.LstAssessmentItem.*.AssessmentItemID' => 'required|integer|min:1',
            'formData.LstAssessmentItem.*.TaxBaseAmount' => 'required|numeric|min:0',
        ]);

        $this->isSubmitting = true;
        $this->apiResponse = null;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.api.token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->timeout(30)->post(config('services.api.assessment_endpoint'), $this->formData);

            $this->apiResponse = $response->json();

            if ($response->successful()) {
                session()->flash('success', 'Assessment data submitted successfully!');
                $this->resetForm();
            }
        } catch (\Exception $e) {
            $this->apiResponse = ['error' => $e->getMessage()];
        } finally {
            $this->isSubmitting = false;
        }
    }

     public function render():View
    {

        return view('livewire.assessment')
                ->layout('layouts.app-view');
    }
}; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header text-white">
            <h2 class="mb-0">Tax Assessment Submission</h2>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($apiResponse && isset($apiResponse['error']))
                <div class="alert alert-danger mb-4">
                    Error: {{ $apiResponse['error'] }}
                </div>
            @endif

            <form wire:submit.prevent="submitToApi">
                <!-- Main Fields -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tax Payer Type ID *</label>
                        <input wire:model="formData.TaxPayerTypeID" type="number" min="1" class="form-control">
                        @error('formData.TaxPayerTypeID') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tax Payer ID *</label>
                        <input wire:model="formData.TaxPayerID" type="number" min="1" class="form-control">
                        @error('formData.TaxPayerID') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Asset Type ID *</label>
                        <input wire:model="formData.AssetTypeID" type="number" min="1" class="form-control">
                        @error('formData.AssetTypeID') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Asset ID *</label>
                        <input wire:model="formData.AssetID" type="number" min="1" class="form-control">
                        @error('formData.AssetID') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profile ID *</label>
                        <input wire:model="formData.ProfileID" type="number" min="1" class="form-control">
                        @error('formData.ProfileID') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Assessment Rule ID *</label>
                        <input wire:model="formData.AssessmentRuleID" type="number" min="1" class="form-control">
                        @error('formData.AssessmentRuleID') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tax Year *</label>
                        <input wire:model="formData.TaxYear" type="number" min="2000" max="{{ now()->year + 1 }}" class="form-control">
                        @error('formData.TaxYear') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea wire:model="formData.Notes" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                <!-- Assessment Items Section -->
                <div class="border-top pt-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Assessment Items</h4>
                        <button type="button" wire:click="addAssessmentItem" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>

                    @foreach($formData['LstAssessmentItem'] as $index => $item)
                        <div class="row g-3 mb-3 p-3 bg-light rounded">
                            <div class="col-md-5">
                                <label class="form-label small">Assessment Item ID *</label>
                                <input wire:model="formData.LstAssessmentItem.{{ $index }}.AssessmentItemID"
                                       type="number" min="1" class="form-control form-control-sm">
                                @error('formData.LstAssessmentItem.'.$index.'.AssessmentItemID')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label class="form-label small">Tax Base Amount *</label>
                                <input wire:model="formData.LstAssessmentItem.{{ $index }}.TaxBaseAmount"
                                       type="number" step="0.01" min="0" class="form-control form-control-sm">
                                @error('formData.LstAssessmentItem.'.$index.'.TaxBaseAmount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                @if($index > 0)
                                    <button type="button" wire:click="removeAssessmentItem({{ $index }})"
                                            class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Form Actions -->
                <div class="border-top pt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" wire:click="resetForm" class="btn btn-secondary">
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Submit Assessment</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
