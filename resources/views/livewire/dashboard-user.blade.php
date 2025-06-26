<?php

use Livewire\Volt\Component;
use Illuminate\Contracts\View\View;
use App\Services\TaxpayerService;
use Livewire\Attributes\Computed;
use function Livewire\Volt\{computed};

new class extends Component {
    //
    public $details;
    public $user;
    public function boot(TaxpayerService $taxpayerService) {
       $this->user = auth()->user();
      $records = $taxpayerService->getTaxpayerDetailByUserID($this->user->id);
      $this->details = $records[0];
    }


    public function render():View
    {

        //$details = $this->taxpayerService;

        return view('livewire.dashboard-user')
                ->layout('layouts.app-view');
    }
}; ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="summary-cards">
        <div class="card">
            <h3>Status</h3>
            <p class="status-active">Active</p>
        </div>
        <div class="card">
            <h3>Last Filing</h3>
            <p>15 Mar 2024</p>
        </div>
        <div class="card">
            <h3>Balance Due</h3>
            <p>$0.00</p>
        </div>
        <div class="card">
            <h3>Alerts</h3>
            <p>3 New</p>
        </div>
        </div>

        <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-home"
                          aria-controls="navs-top-home"
                          aria-selected="true">
                          Profile
                        </button>
                      </li>
                      {{-- <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-profile"
                          aria-controls="navs-top-profile"
                          aria-selected="false">
                          Profile
                        </button>
                      </li> --}}
                      {{-- <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-messages"
                          aria-controls="navs-top-messages"
                          aria-selected="false">
                          Messages
                        </button>
                      </li> --}}
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                        <div class="">
                            <div class="info-row">
                            <span class="info-label">Full Name:</span>
                            <span>{{$details->name}}</span>
                            </div>
                            <div class="info-row">
                            <span class="info-label">Tax ID:</span>
                            <span>{{$details->taxpayer_id}}</span>
                            </div>
                            <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span>{{$user->email}}</span>
                            </div>
                            <div class="info-row">
                            <span class="info-label">Phone:</span>
                            <span>{{is_null($details->phone)? "N\A" : "234$details->phone"}}</span>
                            </div>
                            <div class="info-row">
                            <span class="info-label">Address:</span>
                            <span>{{$details->address ?? "N\A"}}</span>
                            </div>
                            <div class="info-row">
                            <span class="info-label">TIN:</span>
                            <span>{{$details->tin ?? "N\A"}}</span>
                            </div>
                            <div class="info-row">
                            <span class="info-label">RIN:</span>
                            <span>{{$details->rin ?? "N\A"}}</span>
                            </div>
                            <div class="info-row">
                            <span class="info-label">Tax Office:</span>
                            <span>{{$details->tax_office ?? "N\A"}}</span>
                            </div>

                    </div>
                      </div>
                      <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                        <p>
                          Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
                          cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream
                          cheesecake fruitcake.
                        </p>
                        <p class="mb-0">
                          Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah
                          cotton candy liquorice caramels.
                        </p>
                      </div>
                      <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
                        <p>
                          Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                          cupcake gummi bears cake chocolate.
                        </p>
                        <p class="mb-0">
                          Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                          roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                          jelly-o tart brownie jelly.
                        </p>
                      </div>
                    </div>
                  </div>
        <!-- Tabs -->
        {{-- <div class="tabs">
        <div class="tab active">Profile Info</div> --}}
        {{-- <div class="tab">Assets</div>
        <div class="tab">Payments</div>
        <div class="tab">Documents</div> --}}
        {{-- </div> --}}

        <!-- Content Area -->
        <div class="content-area">
        <!-- Profile Info -->
            {{-- <div class="profile-info">
                <div class="info-row">
                <span class="info-label">Full Name:</span>
                <span>{{$details->name}}</span>
                </div>
                <div class="info-row">
                <span class="info-label">Tax ID:</span>
                <span>{{$details->taxpayer_id}}</span>
                </div>
                <div class="info-row">
                <span class="info-label">Email:</span>
                <span>{{$user->email}}</span>
                </div>
                <div class="info-row">
                <span class="info-label">Phone:</span>
                <span>{{is_null($details->phone)? "N\A" : "234$details->phone"}}</span>
                </div>
                <div class="info-row">
                <span class="info-label">Address:</span>
                <span>{{$details->address ?? "N\A"}}</span>
                </div>
                <div class="info-row">
                <span class="info-label">TIN:</span>
                <span>{{$details->tin ?? "N\A"}}</span>
                </div>
                <div class="info-row">
                <span class="info-label">RIN:</span>
                <span>{{$details->rin ?? "N\A"}}</span>
                </div>
                <div class="info-row">
                <span class="info-label">Tax Office:</span>
                <span>{{$details->tax_office ?? "N\A"}}</span>
                </div>

            </div> --}}


        <!-- Recent Filings -->
        {{-- <div class="filings-list">
            <h3>Recent Filings</h3>
            <div class="filing-item">
            <div>2023 Annual Return</div>
            <div class="filing-status status-filed">Filed</div>
            <small>15 Mar 2024</small>
            </div>
            <div class="filing-item">
            <div>2024 Q1 Return</div>
            <div class="filing-status status-pending">Pending</div>
            <small>Due 30 Apr 2024</small>
            </div>
            <div class="filing-item">
            <div>2023 VAT Adjustment</div>
            <div class="filing-status status-filed">Filed</div>
            <small>10 Jan 2024</small>
            </div>
        </div> --}}
        </div>
    </div>

</div>
