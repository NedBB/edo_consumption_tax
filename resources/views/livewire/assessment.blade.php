<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use App\Services\TaxpayerService;
use App\Services\AssetService;
use App\Services\AssessmentRuleService;
use App\Services\AssessmentService;
use Carbon\Carbon;

new class extends Component {

    public array $formData = [];
    public bool $isSubmitting = false;
    public ?array $apiResponse = null;
    public $taxpayer;
    public $taxpayer_id;
    public $type_id;
    public $asset_id;
    public $asset_type_id;
    public $profile_id;
    public $notes;
    public $reference_no;
    public $tax_amount;
    public $tax_year;
    public $assessment_rule_id;
    public $records;

    protected $listeners = ['selectionChanged' => 'changeAsset'];

    public function mount(AssetService $assetService)
    {
        $this->taxpayer = auth()->user();
        $this->records = $assetService->getAssetByTaxpayerId($this->taxpayer->taxpayer_id);
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->notes = "";
        $this->assessment_rule_id = 0;
        $this->tax_amount = 0;
        $this->tax_year = 0;

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

    public function changeAsset($value, AssetService $assetService,
     AssessmentRuleService $assessmentRule)
    {

        if ($value) {

            $assetObject = $this->records->firstWhere('asset_id', $value);
            $this->taxpayer_id = $this->taxpayer->taxpayer_id;
            $this->type_id = $this->taxpayer->typeid;
            $this->asset_id = $value;
            $this->asset_type_id = $assetObject->asset_type_id;
            $profile = $assetService->getProfileByAssetId($value);
            $this->profile_id = $profile->profile_id;
            $this->assessment_rule_id = $assessmentRule->getAssessmentRuleId($profile->profile_id,$this->asset_id,$this->taxpayer_id);

        } else {

        }
    }


    public function submitToApi(AssessmentService $assessService): void
    {
        $this->validate([
            'assessment_rule_id' => 'required|integer',
            'tax_year' => 'required|integer|digits:4',
            'tax_amount' => 'required|numeric',
            "notes" => 'required'
        ]);

        $this->isSubmitting = true;
        $this->apiResponse = null;

        $assessmentData = [
            "TaxPayerTypeID" => $this->taxpayer->taxpayer_id,
            "TaxPayerID" => $this->taxpayer->typeid,
            "Notes" => $this->notes,
            "AssetTypeID" => $this->asset_type_id,
            "AssetID" => $this->asset_id,
            "ProfileID" => $this->profile_id,
            "AssessmentRuleID" => $this->assessment_rule_id,
            "TaxYear" => $this->tax_year,
            "LstAssessmentItem" => [
                [
                    "AssessmentItemID" => 0,
                    "TaxBaseAmount" => $this->tax_amount
                ]
            ]
        ];



        try {
            $bearerToken = env('API_EIRS_TOKEN');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
                'Accept' => 'application/json'
            ])->post('https://apieirs.blouzatech.ng/RevenueData/Assessment/Insert', $assessmentData);

            if (!$response->successful()) {
                throw new \Exception('API request failed with status: ' . $response->status());
            }

            $data = $response->json();

            if ($data['Success'] === true) {

                $datax = [
                    "taxpayer_id" => $this->taxpayer->taxpayer_id,
                    "taxpayer_type_id" => $this->taxpayer->typeid,
                    "asset_type_id" => $this->asset_type_id,
                    "asset_id" => $this->asset_id,
                    "profile_id" => $this->profile_id,
                    "assessment_rule_id" => $this->assessment_rule_id,
                    "tax_year" => $this->tax_year,
                    "tax_amount" => $this->tax_amount,
                    "notes" => $this->notes,
                    "reference_code" => $data['Result'],
                    "status" => "pending"
                ];

                $insertRecord = $assessService->storeAssessment($datax);

                if (!$insertRecord) {
                    throw new \Exception('Failed to save assessment locally');
                }

                session()->flash('success', $data['Message'] ?? 'Assessment submitted successfully');
                $this->resetForm();

            }
            else {
                $errorMessage = $data['Message'] ?? 'Assessment failed without explanation';
                \Log::error('API assessment failed', ['response' => $data]);
                throw new \Exception($errorMessage);

            }
        }
        catch (\Exception $e) {
            \Log::error('Assessment error: ' . $e->getMessage(), [
                'exception' => $e,
                'assessmentData' => $assessmentData ?? null
            ]);

            session()->flash('error', $e->getMessage());
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
            <h2 class="mb-0 font-weight-bold" style="font-size: 20px" >Tax Assessment Submission</h2>
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

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Select Asset for Assessment</label>
                        <select wire:model="asset" @change="$dispatch('selectionChanged',{'value': $event.target.value})" class="form-select" id="basic-default-country" required>
                            <option value="">Select Asset</option>
                            @foreach ($records as $list)
                                <option value="{{$list->asset_id}}">{{$list->business_name}}</option>
                            @endforeach

                          </select>
                        @error('asset')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tax Year *</label>
                        <input wire:model="tax_year" type="number" min="2000" max="{{ now()->year + 1 }}" class="form-control">
                        @error('tax_year') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Base Amount *</label>
                        <input wire:model="tax_amount" type="number"  class="form-control">
                        @error('tax_amount') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea wire:model="notes" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                <!-- Assessment Items Section -->
                {{-- <div class="border-top pt-4 mb-4">
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
                </div> --}}

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
