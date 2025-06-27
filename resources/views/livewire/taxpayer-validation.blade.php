<?php

use Livewire\Volt\Component;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Services\TaxpayerService;
use Illuminate\Support\Facades\Session;

use App\Models\User;

new class extends Component {

    public string $taxId = '';
    public bool $isLoading = false;
    public string $error = '';
    public bool $showConfirmation = false;
    public string $taxpayerName = '';
     public $taxpayerRecord;

    // Simulate tax ID validation (replace with actual API/service call)
    public function validateTaxId(TaxpayerService $taxpayerService): void
    {
        if (strlen($this->taxId) < 5) return;

        $this->isLoading = true;
        $this->error = '';

        try {
            $record = $taxpayerService->getDetailByTaxpayerID($this->taxId);

            // Simulate API call delay
            sleep(1);

            if(is_null($record)){
                $this->error = 'Tax Payer ID not found.';
                $this->isLoading = false;
                return;
            }

                // In a real app, this would be an API call or database check
            $this->taxpayerName = $record->name;
            $this->taxpayerRecord = $record->user;

            //  $this->session()->put([
            //     'taxpayerName' => $this->record->name,
            //     'taxpayId' => $this->record->taxpayer_id,
            //     'user_id' => $this->record->user->id
            // ]);

            $this->showConfirmation = true;
            $this->dispatch('show-modal');


         } catch (\Exception $e) {
            $this->error = 'An error occurred during validation. Please try again.';
            logger()->error('Taxpayer validation error: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function confirmName(bool $isConfirmed)
    {

       $this->showConfirmation = false;
       $this->dispatch('hide-modal'); // Dispatch event to hide modal

        if ($isConfirmed) {

            Auth::login($this->taxpayerRecord);

            // Redirect to dashboard
            return $this->redirect(route('user.dashboard'), navigate: true);
        } else {
            $this->error = 'Please contact support to verify your identity.';
        }
    }

     public function render():View
    {
        return view('livewire.taxpayer-validation')
                ->layout('layouts.app-plain');
    }
}; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="min-vh-100 d-flex align-items-center justify-content-center">
            <div class="w-100" style="">
                <div class="col-md-6 offset-md-3" style="margin-top:-50px">
                    <div class="card shadow-sm">
                        <div class="card-header text-white">
                            <h5 class="mb-0 font-weight-bold text-center"><strong> Validation</strong></h5>
                        </div>

                        <div class="card-body">
                            <!-- Tax ID Input -->
                            <div class="mb-3">
                                <label for="taxId" class="form-label">Tax Identification Number</label>
                                <input
                                    type="text"
                                    id="taxId"
                                    class="form-control"
                                    wire:model.live="taxId"
                                    wire:change="validateTaxId"
                                    placeholder="Enter your Tax Payer ID"
                                >
                                @if($error)
                                    <div class="invalid-feedback d-block">
                                        {{ $error }}
                                    </div>
                                @endif
                            </div>

                            <!-- Loading Indicator -->
                            <div wire:loading wire:target="validateTaxId" class="text-center my-3">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Validating Tax ID...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal using Livewire's built-in modal system -->
    @if($showConfirmation)
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Business Name</h5>
                        <button
                            type="button"
                            class="btn-close"
                            wire:click="$set('showConfirmation', false)"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <p>Is this your Business name: <strong><span style="font-size: 18px">{{ $taxpayerName }}</span></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            wire:click="confirmName(false)"
                        >
                            No
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            wire:click="confirmName(true)"
                        >
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

<!-- Add this script to handle Bootstrap modal functionality -->
<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('closeModal', () => {
        const modal = document.querySelector('.modal.show');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.querySelector('.modal-backdrop').remove();
        }
    });
});
</script>
</div>
