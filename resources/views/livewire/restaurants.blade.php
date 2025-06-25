<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use App\Services\CategoryService;
use App\Services\TaxpayerService;
use function Livewire\Volt\{state, mount};


new class extends Component {
   use WithPagination;

    public $select_entity;
    public $selectdata;
    public $title = "Restaurants";
    public $taxpayerlist;
    public $categorylist = [];

    public function mount(CategoryService $categoryService)
    {
        $this->categorylist = $categoryService->getList();

    }
    public function searchDetails(TaxpayerService $taxpayerService){
        //$this->selectdata = $this->select_entity;
        $this->resetPage();
       return $taxpayerService->getListByCategory($this->select_entity);

    }

    public function render():View
    {

        $taxpayers = app(TaxpayerService::class)
                    ->getListByCategory(6);

        return view('livewire.restaurants',['taxpayers' => $taxpayers])
                ->layout('layouts.app-view')
                ->title("Restaurants");
    }

}

?>

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <form wire:submit.prevent='searchDetails'>
            <div class="col-12">
                <div class="card mb-4">
                    <h5 class="card-header text-center">Tax Payers List for {{$title}}</h5>

                </div>
            </div>
        </form>
    </div>

    <div>

        <div class="table-responsive text-nowrap">

               <table class="table table-hover table-bordered font-13 table-striped" id="printTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>TYPE</th>
                        <th>RIN</th>
                        <th>MOBILE</th>
                        <th>EMAIL</th>
                        <th>TIN</th>
                        <th>TAX OFFICE</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @forelse ($taxpayers as $list)

                            <tr wire:key='{{$list->id}}'>
                            <td>
                                {{$list->id}}
                            </td>
                            <td>
                                {{$list->name ?? 'N/A'}}
                            </td>
                            <td>
                                {{$list->typename ?? 'N/A'}}
                            </td>
                            <td>
                                {{$list->rin ?? 'N/A'}}
                            </td>
                            <td class="text-capitalize">
                                {{"234".$list->phone ?? 'N/A'}}
                            </td>
                            <td class="text-capitalize">
                                {{$list->email ?? 'N/A'}}
                            </td>
                            <td class="text-capitalize">
                                {{$list->tin ?? 'N/A'}}
                            </td>
                            <td class="text-capitalize">
                                {{$list->tax_office ?? 'N/A'}}
                            </td>
                            <td class="change">

                                <a href="#" class="btn btn-primary btn-xs">details</a>
                            </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-danger">No data exist at the moment</td></tr>
                        @endforelse
                    </tbody>
                </table>

        </div>

        <div class="table table-hover table-bordered font-13 table-striped">
           {{$taxpayers->links()}}
        </div>

    </div>

</div>
