<?php

namespace App\Http\Livewire;

use App\Facades\Common;
use App\Facades\Util;
use App\Models\Payment;
use App\Models\User;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Transaction extends Component
{
    public $user_id;
    use WithPagination, CustomCommonLive;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["assignTrans", "data_manager"];
    public $search_keyword;
    public $sel_payment_type = "all";
    public $sel_working_year = "";

    public function mount()
    {
        $this->sel_working_year = Common::getWorkingYear();
    }

    public function data_manager($datas)
    {
        if (isset($datas["sel_id"])) {
            $this->user_id = $datas["sel_id"];
        }

    }

    public function render()
    {
        $this->dispatchBrowserEvent("tooltip_refresh");
        return view('livewire.transaction', ["receipts" => $this->load_data()]);
    }

    public function load_data()
    {
        $datas = Payment::with(["borrowed", "borrowed.book", "borrowed.sub_book"]);
        if (!Common::isSuperAdmin()) {
            $datas = $datas->whereIn("uid", [\Auth::id()]);
        }
        if (!empty($this->search_keyword)) {
            $datas = $datas->orWhere("invoice_no", "like", "%" . $this->search_keyword . "%")
                ->orWhere("payer_email", "like", '%' . $this->search_keyword . '%')
                ->orWhere("uid", $this->search_keyword)
                ->orWhere("refund_id", $this->search_keyword);
        }
        if ($this->sel_payment_type == "refund") {
            $datas = $datas->whereNotNull("refund_id");
        }
        $datas = $datas->where("working_year", $this->sel_working_year);
        if($this->search_keyword){
            $this->resetPage();
        }
        return $datas->has("borrowed.sub_book")->orderBy("id", "desc")->paginate(10);
    }

    public function assignTrans($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $rid = isset($datas["id"]) ? $datas["id"] : 0;
        $p_obj = Payment::find($rid);
        if ($p_obj) {
            $p_obj->uid = $this->user_id;
            $p_obj->save();
            $this->sendMessage(__("common.trans_success_assign"), "success");
        } else {
            $this->sendMessage(__("common.id_missing"), "error");
        }
    }
}
