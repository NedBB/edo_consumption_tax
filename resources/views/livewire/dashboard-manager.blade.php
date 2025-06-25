<?php

use Livewire\Volt\Component;
use Illuminate\Contracts\View\View;

new class extends Component {
    //

    public function render():View
    {
        return view('livewire.dashboard-manager')
                ->layout('layouts.app-view');
    }
}; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

    <div class="main-content">
      <!-- Header -->
      <div class="header">
        <h1>Taxpayer Management</h1>
        <div class="user-menu">
          <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search taxpayers...">
          </div>
          <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-bell"></i>
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0;"></div>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="stats-container">
        <div class="stat-card">
          <h3>Total Taxpayers</h3>
          <div class="value">1,248</div>
          <div class="change positive">
            <i class="fas fa-arrow-up"></i> 12% from last month
          </div>
        </div>
        <div class="stat-card">
          <h3>Active Taxpayers</h3>
          <div class="value">1,032</div>
          <div class="change positive">
            <i class="fas fa-arrow-up"></i> 8% from last month
          </div>
        </div>
        <div class="stat-card">
          <h3>Pending Filings</h3>
          <div class="value">187</div>
          <div class="change negative">
            <i class="fas fa-arrow-down"></i> 5% from last month
          </div>
        </div>
        <div class="stat-card">
          <h3>Revenue Collected</h3>
          <div class="value">$2.4M</div>
          <div class="change positive">
            <i class="fas fa-arrow-up"></i> 22% from last month
          </div>
        </div>
      </div>

      <div class="stats-container">
        <div class="stat-card">
          <h3>Total Taxpayers</h3>
          <div class="value">1,248</div>
          <div class="change positive">
            <i class="fas fa-arrow-up"></i> 12% from last month
          </div>
        </div>
        <div class="stat-card">
          <h3>Active Taxpayers</h3>
          <div class="value">1,032</div>
          <div class="change positive">
            <i class="fas fa-arrow-up"></i> 8% from last month
          </div>
        </div>
        <div class="stat-card">
          <h3>Pending Filings</h3>
          <div class="value">187</div>
          <div class="change negative">
            <i class="fas fa-arrow-down"></i> 5% from last month
          </div>
        </div>
        <div class="stat-card">
          <h3>Revenue Collected</h3>
          <div class="value">$2.4M</div>
          <div class="change positive">
            <i class="fas fa-arrow-up"></i> 22% from last month
          </div>
        </div>
      </div>

      <!-- Taxpayers Table -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Taxpayer ID</th>
              <th>Name</th>
              <th>TIN</th>
              <th>Category</th>
              <th>Status</th>
              <th>Last Filing</th>
              <th>Balance</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>TAX-1001</td>
              <td>John Doe</td>
              <td>123-456-789</td>
              <td>Individual</td>
              <td><span class="status active">Active</span></td>
              <td>15 Mar 2024</td>
              <td>$0.00</td>
              <td>
                <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
              </td>
            </tr>
            <tr>
              <td>TAX-1002</td>
              <td>Acme Corp</td>
              <td>987-654-321</td>
              <td>Corporate</td>
              <td><span class="status active">Active</span></td>
              <td>28 Feb 2024</td>
              <td>$1,250.00</td>
              <td>
                <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
              </td>
            </tr>
            <tr>
              <td>TAX-1003</td>
              <td>Jane Smith</td>
              <td>456-789-123</td>
              <td>Individual</td>
              <td><span class="status pending">Pending</span></td>
              <td>10 Jan 2024</td>
              <td>$350.50</td>
              <td>
                <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
              </td>
            </tr>
            <tr>
              <td>TAX-1004</td>
              <td>XYZ LLC</td>
              <td>789-123-456</td>
              <td>Corporate</td>
              <td><span class="status inactive">Inactive</span></td>
              <td>15 Dec 2023</td>
              <td>$0.00</td>
              <td>
                <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
              </td>
            </tr>
            <tr>
              <td>TAX-1005</td>
              <td>Global Enterprises</td>
              <td>321-654-987</td>
              <td>Corporate</td>
              <td><span class="status active">Active</span></td>
              <td>1 Mar 2024</td>
              <td>$5,780.00</td>
              <td>
                <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <div class="page-info">Showing 1 to 5 of 1,248 entries</div>
          <div class="page-controls">
            <button><i class="fas fa-chevron-left"></i></button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>4</button>
            <button>5</button>
            <button><i class="fas fa-chevron-right"></i></button>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="charts">
        <div class="chart-card">
          <h3>Taxpayer Registrations</h3>
          <div class="chart-placeholder">
            [Chart: Monthly registration trends]
          </div>
        </div>
        <div class="chart-card">
          <h3>Taxpayer Categories</h3>
          <div class="chart-placeholder">
            [Chart: Percentage by category]
          </div>
        </div>
      </div>
    </div>

   </div>
</div>
