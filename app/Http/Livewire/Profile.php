<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserMeta;
use App\Models\Book;
use App\Models\IssueBookReq;
use App\Models\AwardsManager;
use App\Facades\Common;
use App\Facades\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\CustomCommonLive;

class Profile extends Component
{
    use CustomCommonLive;
    use WithFileUploads;
    public $current_user;
    public $name;
    public $email;
    public $address;
    public $phone;
    public $education;
    public $about_me;
    public $tab = '1';
    public $user_id = null;
    public $photo;
    public $cover;
    public $gender;
    public $proof = "";
    public $proof_link = "";
    public $photo_link;
    public $check = "";
    public $password_confirmation;
    public $password;
    public $current_password;
    public $isOwner = 0;
    public $isEdit = 0;
    public $cover_link;
    public $privacysearch;
    public $privacyborrow;
    public $privacyprofile;
    public $privacyleaderboard;
    public $privacyfuture;
    public $generalprivacy;
    public $awards;
    public $systempermission;
    public $request = [];
    public $currentlyBorrowed = [];
    protected $listeners = ["data_manager","cancelRequest",'refreshComponent' => '$refresh'];
    
    public function data_manager($datas){
        if(isset($datas["EditProfile"])){
         //$this->picvalidate();
        }
    }

    public function cancelRequest($id)
    {
        $obj = IssueBookReq::find($id);
        if ($obj) {
            $obj->delete();
            $this->sendMessage("Request Cancelled", "success");
            return;
        }
        $this->sendMessage(__("common.id_missing"), "error");
        $this->emit('refreshComponent');
    }
    public function mount($v_id)
    {
    if($v_id == Auth::id()){
         $this->user_id = Auth::id();
         $this->isOwner = 1;
    }else{
       $this->user_id = $v_id;
          $this->isOwner = 0;
    };
        $user_obj = User::find($this->user_id);
        if(!isset($user_obj)){
        abort(404, __("common.page_not_found"));
        }
        $this->current_user = $user_obj;
        $this->email = $user_obj->email;
        $this->name = $user_obj->name;
        $user_meta_obj = UserMeta::where("user_id", $user_obj->id)->first();
        if ($user_meta_obj) {
            $this->address = $user_meta_obj->get_address();
            $this->education = $user_meta_obj->get_education();
            $this->phone = $user_meta_obj->get_phone();
            $this->about_me = $user_meta_obj->get_about_me();
            $this->gender = $user_meta_obj->get_gender();
            $this->photo_link = asset("uploads/".$user_meta_obj->get_user_photo(),false);
            $this->cover_link = asset("uploads/".$user_meta_obj->get_user_coverphoto(),false);
            $this->privacysearch = $user_meta_obj->getprivacysearch($this->user_id);
            $this->privacyborrow = $user_meta_obj->getprivacyborrow($this->user_id);
            $this->privacyprofile = $user_meta_obj->getprivacyprofile($this->user_id);
            $this->privacyleaderboard = $user_meta_obj->getprivacyleaderboard($this->user_id);
            $this->privacyfuture = $user_meta_obj->getprivacyfuture($this->user_id);
            $this->generalprivacy = $user_meta_obj->getgeneralprivacy($this->user_id);
            $this->systempermission = $user_meta_obj->systempermission($this->user_id);

            $tmp = $user_obj->get_proof();
            $this->proof_link = !empty($tmp) ? $tmp : '';
            
        }
    }
    public function qrgenerate(){
     $this->validate([
            'name' => 'required',
            'phone' => 'required'

        ]);
         $this->saveProfile();
    redirect(route('print_id_cards', ["ids" => bin2hex(Auth::Id())]));
    }
    public function loadRequest(){
    $request = IssueBookReq::where("user_id", $this->user_id)->get();
    if(!$request->isEmpty()){
     
        foreach ($request as $data) {
            //#$user_img = Util::searchCollections($user->user_meta, "meta_key", "photo", "meta_value");
            $user = User::where("id", $data->user_id)->get();
            
            $book = Book::where("id", $data->book_id)->get();
            $user["Accession"] =  $data->sub_book_id;
            $user["Borrowed"] =  $data->expectedborrow;
            $user["id"] = $data->id;
            $user["Valid"] =  $data->validtill;
            foreach($book as $book_data){
            $user["title"]= $book_data->title;
            $user["desc"]=  $book_data->desc;
            }
            $user["created_at"] = Carbon::parse($data->date_borrowed);
            $user_img = User::get_user_photo($data->user_id);
            $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
           $user["name"] = User::get_user_name($data->user_id);
           $user["category"] = \App\Models\DeweyDecimal::where("id", $data->category)->get()->pluck("cat_name");
           $book_img = \App\Models\Book::where("id", $data->book_id)->get()->pluck("cover_img");
           if($book_img == "[null]" || $book_img =="[\"uploads\"]"){
           
            $user["book_img"] = asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           }else{
           
           $user["book_img"] = $book_img ? asset('uploads/' . $book_img) : asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           
           }
           $user["isReturned"] = $data->date_returned;
           if( $data->date_returned == ""){
           $user["isReturned"] = "<strong><span style='color:rgb(113 2 2)'>[Borrowed]</span></strong>";
           }else{
           $user["isReturned"] = "<strong><span style='color:#00AA00'>[Returned]</span></strong>";
           }
            array_push($this->request, $user);
        }
        
     }else{
    
     }
    
    }
    public function loadCurrentlyborrowed(){
    $current = \App\Models\Borrowed::where('user_id', $this->user_id)->wherenull('date_returned')->orderBy('id','DESC')->get();
    if(!$current->isEmpty()){
     
        foreach ($current as $data) {
        
            //#$user_img = Util::searchCollections($user->user_meta, "meta_key", "photo", "meta_value");
            $user = User::where("id", $data->user_id)->get();
            
            $book = Book::where("id", $data->book_id)->get();
            
            $user["Accession"] =  $data->sub_book_id;
            $user["Borrowed"] =  $data->date_borrowed;
            $user["Valid"] =  $data->date_to_return;
            foreach($book as $book_data){
            $user["title"]= $book_data->title;
            $user["desc"]=  $book_data->desc;
            }

            $user["created_at"] = Carbon::parse($data->date_borrowed);
            $user_img = User::get_user_photo($data->user_id);
            $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
           $user["name"] = User::get_user_name($data->user_id);
           $user["category"] = \App\Models\DeweyDecimal::where("id", $data->category)->get()->pluck("cat_name");
           $book_img = \App\Models\Book::where("id", $data->book_id)->get()->pluck("cover_img");
           if($book_img == "[null]" || $book_img =="[\"uploads\"]"){
           
            $user["book_img"] = asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           }else{
           
           $user["book_img"] = $book_img ? asset('uploads/' . $book_img) : asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           
           }
           $user["isReturned"] = $data->date_returned;
           if( $data->date_returned == ""){
           $user["isReturned"] = "<strong><span style='color:rgb(113 2 2)'>[Borrowed]</span></strong>";
           }else{
           $user["isReturned"] = "<strong><span style='color:#00AA00'>[Returned]</span></strong>";
           }
            array_push($this->currentlyBorrowed, $user);
        }
        
     }else{
    
     }
    
    }
    public function render()
    {
    $this->loadRequest();
     $this->awards = AwardsManager::where('user_id',$this->user_id)->get();
     $history = \App\Models\Borrowed::where('user_id', $this->user_id)->orderBy('id','DESC')->get();
     $merged_post = [];
     if(!$history->isEmpty()){
     
        foreach ($history as $data) {
            //#$user_img = Util::searchCollections($user->user_meta, "meta_key", "photo", "meta_value");
            $user = User::where("id", $data->user_id)->get();
            
            $book = Book::where("id", $data->book_id)->get();

            foreach($book as $book_data){
            
            $user["title"]= $book_data->title;
            
            $user["desc"]=  $book_data->desc;
            }
            $user["created_at"] = Carbon::parse($data->date_borrowed);
            $user_img = User::get_user_photo($data->user_id);
            $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
           $user["name"] = User::get_user_name($data->user_id);
           $user["category"] = \App\Models\DeweyDecimal::where("id", $data->category)->get()->pluck("cat_name");
           $book_img = \App\Models\Book::where("id", $data->book_id)->get()->pluck("cover_img");
           if($book_img == "[null]" || $book_img =="[\"uploads\"]"){
           
            $user["book_img"] = asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           }else{
           
           $user["book_img"] = $book_img ? asset('uploads/' . $book_img) : asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           
           }
           $user["isReturned"] = $data->date_returned;
           if( $data->date_returned == ""){
           $user["isReturned"] = "<strong><span style='color:rgb(113 2 2)'>[Borrowed]</span></strong>";
           }else{
           $user["isReturned"] = "<strong><span style='color:#00AA00'>[Returned]</span></strong>";
           }
            array_push($merged_post, $user);
        }
        
     }else{
     $user = User::where("id", $this->user_id)->get();
            $user["title"]= "This user has not borrowed any books yet.";
            $user["desc"]="Any borrowed books will appear in your timeline, and others who visit your profile may see them as well." ;
            $user["created_at"]=Carbon::parse(date('Y-m-d H:i:s'));
            $user_img = User::get_user_photo($this->user_id);
            $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
           $user["name"] = User::get_user_name($this->user_id);
           $user["category"] = "";
           $book_img = "antiplaceholder";
            $user["isReturned"] = "";
           if($book_img == "[null]" || $book_img =="[\"uploads\"]"){
           
            $user["book_img"] = asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           }else{
           
           $user["book_img"] = $book_img ? asset('uploads/' . $book_img) : asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           
           }
            array_push($merged_post, $user);
     }
   
        return view('livewire.profile',['merged_post' => $merged_post])->section('content');;
    }
    public function getTemplink(){
    return $this->photo->temporaryUrl();
    }public function getTemplinkC(){
    return $this->cover->temporaryUrl();
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);
         $this->photo_link = $this->getTemplink();
       
    }
    public function updatedCover()
    {
        $this->validate([
            'cover' => 'image|max:1024',
        ]);
         $this->cover_link = $this->getTemplinkC();
       
    }
    public function sendMessage($message, $type = 'info')
    {
        $this->dispatchBrowserEvent("show_message",
            ["type" => $type, "title" => "Info", "message" => $message]);
    }
    public function saveProfile()
    {
    
        $this->resetErrorBag();
        session()->flash("form_profile", true);
        $this->validate([
            'photo' => 'nullable|image|max:1024', // 1MB Max
            'cover' => 'nullable|image|max:1024' , // 1MB Max
            "phone" => "required|min:10",
            "name" => "required"
        ], ["phone.min" => __("common.phone_no_invalid"),
            "photo.image" => __("common.only_image"),
            "photo.max" => __("common.file_size_exceed"),
        ]);

        $user_obj = User::find($this->user_id);
        if ($user_obj) {
            $user_obj->name = $this->name;
            $user_obj->save();
             
             if(empty($this->current_password)){
    $this->sendMessage(__("common.user_details_has_been_saved"), "success");
    }else{
    $this->savePassword();
    }
            $path = config("app.DEFAULT_USR_IMG");;
            if ($this->photo) {
                $path = $this->photo->storePublicly('', 'custom');
                UserMeta::updateOrCreate(["meta_key" => "photo", "user_id" => $user_obj->id], ["meta_value" => $path]);
                $this->photo_link = asset("uploads/".$path,false);
               
            }
            if ($this->cover) {
                $path = $this->cover->storePublicly('', 'custom');
                UserMeta::updateOrCreate(["meta_key" => "cover", "user_id" => $user_obj->id], ["meta_value" => $path]);
                $this->cover_link = asset("uploads/".$path,false);
            }

            UserMeta::updateOrCreate(["meta_key" => "privacysearch", "user_id" => $user_obj->id], ["meta_value" => $this->privacysearch]);
           
            UserMeta::updateOrCreate(["meta_key" => "privacyborrow", "user_id" => $user_obj->id], ["meta_value" => $this->privacyborrow]);
            UserMeta::updateOrCreate(["meta_key" => "privacyprofile", "user_id" => $user_obj->id], ["meta_value" => $this->privacyprofile]);
            
            UserMeta::updateOrCreate(["meta_key" => "privacyleaderboard", "user_id" => $user_obj->id], ["meta_value" => $this->privacyleaderboard]);
            UserMeta::updateOrCreate(["meta_key" => "privacyfuture", "user_id" => $user_obj->id], ["meta_value" => $this->privacyfuture]);
            UserMeta::updateOrCreate(["meta_key" => "generalprivacy", "user_id" => $user_obj->id], ["meta_value" => $this->generalprivacy]);
            UserMeta::updateOrCreate(["meta_key" => "systempermission", "user_id" => $user_obj->id], ["meta_value" => $this->systempermission]);

			



            UserMeta::updateOrCreate(["meta_key" => "address", "user_id" => $user_obj->id], ["meta_value" => $this->address]);
            UserMeta::updateOrCreate(["meta_key" => "phone", "user_id" => $user_obj->id], ["meta_value" => $this->phone]);
            UserMeta::updateOrCreate(["meta_key" => "education", "user_id" => $user_obj->id], ["meta_value" => $this->education]);
            UserMeta::updateOrCreate(["meta_key" => "about_me", "user_id" => $user_obj->id], ["meta_value" => $this->about_me]);
            
            $this->check = "";
        }
       
    }

    public function savePassword()
    {
    dd("fired?");
        session()->flash("form_change_password", true);
        $this->validate([
            "current_password" => "required",
            "password" => "required|min:8|confirmed"], [
            "password.required" => __("common.password_req"),
            "password.min" => __("common.password_8_char_long"),
            "password.confirmed" => __("common.password_and_confirm_password_dont_match")
        ]);
        $current_user_obj = User::find($this->user_id);
        if ($current_user_obj && Hash::check($this->current_password, $current_user_obj->password)) {
            $current_user_obj->password = Hash::make($this->password_confirmation);
            $current_user_obj->save();
            $this->current_password = "";
            $this->password = "";
            $this->password_confirmation = "";
            session()->flash("alert-success", __("common.password_change_successfully"));
        } else {
            session()->flash("alert-danger", __("common.password_and_confirm_password_dont_match"));
        }

    }
}
