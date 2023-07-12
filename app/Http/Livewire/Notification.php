<?php

namespace App\Http\Livewire;

use App\Custom\BookCallBacks;
use App\Facades\Util;
use App\Models\Borrowed;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Notification extends Component
{

    public $search_keyword;
    use WithPagination, CustomCommonLive;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["deleteMainBook", "data_manager", "saveCategory", "toggleActiveMainBook"];
    public $cat_detail;
    public $show_inactive = false;
    public $enable_bulk_operation = false;
    public $sel_parent_cat;
    public $sel_sub_cat;
    public $sel_sb_id_bulk = [];

    /**
     * @return bool
     */
   

    public function render()
    {
        return view('livewire.notification');
    }

}
