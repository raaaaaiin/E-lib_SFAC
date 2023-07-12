<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Book;
use App\Facades\Common;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Timeline extends Component
{
    public $current_user;
    public $name;
    public $email;
    public $address;
    public $phone;
    public $education;
    public $about_me;
    public $tab = '1';
    public $user_id = null;
    public $photo = "";
    public $proof = "";
    public $proof_link = "";
    public $photo_link;
    public $check = "";
    public $merged;
    public $password_confirmation;
    public $password;
    public $current_password;
    public $isOwner = false;
    public function mount()
    {

        $this->user_id = Auth::id();
        $this->isOwner = true;
        $user_obj = User::find($this->user_id);
        if (!isset($user_obj))
        {
            abort(404, __("common.page_not_found"));
        }
        $this->current_user = $user_obj;
        $this->email = $user_obj->email;
        $this->name = $user_obj->name;
        $user_meta_obj = UserMeta::where("user_id", $user_obj->id)
            ->first();
        if ($user_meta_obj)
        {
            $this->address = $user_meta_obj->get_address();
            $this->education = $user_meta_obj->get_education();
            $this->phone = $user_meta_obj->get_phone();
            $this->about_me = $user_meta_obj->get_about_me();
            $this->photo_link = $user_meta_obj->get_user_photo();
            $tmp = $user_obj->get_proof();
            $this->proof_link = !empty($tmp) ? $tmp : '';
        }
    }

    public function activeUser()
    {

    }
    public function render()
    {

        $history = \App\Models\Borrowed::orderBy('id', 'DESC')->get();
        $awards = \App\Models\AwardsManager::orderBy('id', 'DESC')->get();
        $merged_post = [];


         foreach ($awards as $datas)
            {
            $user = User::where("id", $datas->user_id)
                    ->get();
              $user_meta_obj = UserMeta::where("user_id", $datas->user_id)
                    ->first();


                    $user["title"] = $datas->noticetitle;
                    $user["desc"] = $datas->notice;
                 $user["category"] = \App\Models\DeweyDecimal::where("id", "1")
                    ->get()
                    ->pluck("cat_name");
                $user["created_at"] = Carbon::parse($datas->created_at);
                $user_img = User::get_user_photo($datas->user_id);
                $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
                $user["name"] = User::get_user_name($datas->user_id);
                $user["View"] = "";
                    $user["book_img"] = asset('uploads/' . $datas->img .'.png',false);
                    $user["isReturned"] = "";
                    $user["Ripirins"] = "#";
                $user["views"] = $user_meta_obj->getprivacyfuture($datas->user_id);

                $user["Id"] = $datas->user_id;
                array_push($merged_post, $user);
            }
        if (!$history->isEmpty())
        {

            foreach ($history as $data)
            {
                $user_meta_obj = UserMeta::where("user_id", $data->user_id)
                    ->first();
                //#$user_img = Util::searchCollections($user->user_meta, "meta_key", "photo", "meta_value");
                $user = User::where("id", $data->user_id)
                    ->get();

                $book = Book::where("id", $data->book_id)
                    ->get();

                foreach ($book as $book_data)
                {
                    $user["title"] = $book_data->title;
                    $user["desc"] = $book_data->desc;
                }
                $user["Ripirins"] = route('details', ['page_slug' => Common::utf8Slug($book_data->title)]);
                $user["View"] = "View more";
                $user["created_at"] = Carbon::parse($data->date_borrowed);
                $user_img = User::get_user_photo($data->user_id);
                $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
                $user["name"] = User::get_user_name($data->user_id);
                $user["category"] = \App\Models\DeweyDecimal::where("id", $data->category)
                    ->get()
                    ->pluck("cat_name");
                $book_img = \App\Models\Book::where("id", $data->book_id)
                    ->get()
                    ->pluck("cover_img");
                if ($book_img == "[null]" || $book_img == "[\"uploads\"]")
                {

                    $user["book_img"] = asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
                }
                else
                {

                    $user["book_img"] = $book_img ? asset('uploads/' . $book_img) : asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);

                }
                $user["isReturned"] = $data->date_returned;
                if ($data->date_returned == "")
                {
                    $user["isReturned"] = "<strong><span style='color:rgb(113 2 2)'>[Borrowed]</span></strong>";
                }
                else
                {
                    $user["isReturned"] = "<strong><span style='color:#00AA00'>[Returned]</span></strong>";
                }
                $user["views"] = $user_meta_obj->getprivacyfuture($data->user_id);
                $user["Id"] = $data->user_id;
                array_push($merged_post, $user);
            }

        }
       



           $this->merged = $merged_post;
        return view('livewire.timeline');

    }



}

