<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\Borrowed;
use App\Models\User;
use App\Traits\CustomCommonLive;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BasicIssuedBooks extends Component
{
    use WithPagination;
    use CustomCommonLive;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["startPayment"];

    public function load_data()
    {
        $users = User::find(Auth::id()); // Current Logged In Id
        $books_borrowed = Borrowed::with(["book", "sub_book","payment","user","issued_by_person"])->orwhereIn("user_id", $users);
        $books_borrowed = $books_borrowed->orderBy("id", "desc");
        return $books_borrowed->paginate(10);
    }

    public function render()
    {
        $this->dispatchBrowserEvent("tooltip_refresh");
        return view('livewire.basic-issued-books', ["items" => $this->load_data()]);
    }

    public function startPayment($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $uid = isset($datas["id"]) ? $datas["id"] : 0;
        $borr_id = isset($datas["borr_id"]) ? $datas["borr_id"] : 0;
        $b_id = isset($datas["b_id"]) ? $datas["b_id"] : 0;
        $sb_id = isset($datas["sb_id"]) ? $datas["sb_id"] : 0;
        $fineAmount = isset($datas["fine_amt"]) ? $datas["fine_amt"] : null;
        if ($uid && $fineAmount && $borr_id && $b_id && $sb_id) {
            $book_name = "N/A";
            $book_obj = \App\Models\Book::find($b_id);
            if ($book_obj) {
                $book_name = $book_obj->title;
            }
            \Session::put("current_req", ["late_fee" => $fineAmount, "book_name" => $book_name, "b_id" => $b_id, "sb_id" => $sb_id, "borr_id" => $borr_id, "uid" => $uid]);
            return redirect()->route("gateway.pay_fine");
        } else {
            $this->sendMessage(__("common.id_missing"),"error");
        }
    }
}
