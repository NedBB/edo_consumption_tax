<?php

use Livewire\Volt\Component;
use Illuminate\Contracts\View\View;

new class extends Component {
    //

    public function render():View
    {
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

        <!-- Tabs -->
        <div class="tabs">
        <div class="tab active">Profile Info</div>
        {{-- <div class="tab">Tax Filings</div>
        <div class="tab">Payments</div>
        <div class="tab">Documents</div> --}}
        </div>

        <!-- Content Area -->
        <div class="content-area">
        <!-- Profile Info -->
        <div class="profile-info">
            <div class="info-row">
            <span class="info-label">Full Name:</span>
            <span>John Doe</span>
            </div>
            <div class="info-row">
            <span class="info-label">Tax ID:</span>
            <span>12345</span>
            </div>
            <div class="info-row">
            <span class="info-label">Email:</span>
            <span>john@example.com</span>
            </div>
            <div class="info-row">
            <span class="info-label">Phone:</span>
            <span>+1 (555) 123-4567</span>
            </div>
            <div class="info-row">
            <span class="info-label">Address:</span>
            <span>123 Main St, City, Country</span>
            </div>
            <div class="info-row">
            <span class="info-label">TIN:</span>
            <span>987654321</span>
            </div>
            <div class="info-row">
            <span class="info-label">Tax Office:</span>
            <span>Central Tax Authority</span>
            </div>
            <div class="info-row">
            <span class="info-label">Category:</span>
            <span>Individual</span>
            </div>
        </div>

        <!-- Recent Filings -->
        <div class="filings-list">
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
        </div>
        </div>
    </div>

</div>
