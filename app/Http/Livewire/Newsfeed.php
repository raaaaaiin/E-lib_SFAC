<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Facades\Common;
use App\Facades\Util;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\BookMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\NoticeManager;
use Illuminate\Support\Facades\DB;

class Newsfeed extends Component
{
public $merged_post;
public $perPage = 10;
 public $data= 0;
 public $topborrow;
 public $toponline;
 public $topvisit;
 public $notices_for_me;

    public function data()
    {
        $this->data+= 100;
    }
public function activeUser(){
    }

    public function render()
    {
    
     $this->notices_for_me = NoticeManager::where(function($query){$query->orWhereJsonContains("user_id", [\Auth::id()])->orWhereJsonContains("role_id", User::get_current_user_roles_in_array());})->whereIn("active",[1])->get();
        $this->topborrow = DB::select("Select a.user_id as id,b.name as name, count(user_id) as times from borroweds a
join  users b on a.user_id = b.id GROUP BY a.user_id order by times desc limit 3;");
        $this->toponline =DB::Select("Select a.username,b.id as id, b.name as name, count(*)/(60*24) as times from visitor_trackings a
join  users b on a.username = b.email where a.time_alive = 1 GROUP BY a.username limit 3;");
        $this->topvisit =DB::select("Select userID as id,name, count(*) as times from web_checkin GROUP BY name order by times desc limit 3 ;");

         $per_page = 2;
         $this->merged_post = $this->limitload($per_page);
        return view('livewire.newsfeed');
    }

    public function limitload($per_page){
    $news = DB::select("Select a.*, b.cover_img,cat_name,d.meta_value as views,e.meta_value as photo,f.name
from newsfeeds a 
join books b on a.book_id = b.unique_id 
join dewey_decimals c on c.id = a.category 
join book_metas d on a.book_id = d.unique_id  
join users f on a.post_id = f.id
join user_metas e on a.post_id = e.user_id
where e.meta_key = 'photo' 
and d.meta_key = 'views'
order by a.id desc");
    $meta = new BookMeta();
    
     $merged_post = [];
        foreach ($news as $neews) {
            //#$user_img = Util::searchCollections($user->user_meta, "meta_key", "photo", "meta_value");
            $user = [];                                                                           // eloquent user where id = post id
            $unwanteddata = $neews->views;
            $user["views"] = $unwanteddata == null ? 0:$unwanteddata;
            $user["title"]= $neews->title;
            $user["desc"]=$neews->description;
            $user["created_at"]=$neews->created_at;
            $user_img = $neews->photo;                                                                                  
            $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
           $user["name"] = $neews->name;                                                                                
           $user["category"] = $neews->cat_name;                      // eloquent dewey id = category
           $book_img = $neews->cover_img;                                 // eloquent book unique id = book id
           if($book_img == "[null]" || $book_img =="[\"uploads\"]"){
           
            $user["book_img"] = asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           }else{
           
           $user["book_img"] = $book_img ? asset('uploads/' . $book_img) : asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           
           }
            $user["Id"] = $neews->post_id;
            array_push($merged_post, $user);
        }
        if(isset($merged_post[0]) && count($merged_post) > 1) {
            array_pop($merged_post);
          }
        return $merged_post;

    }
    public function try(){
     $this->perPage = $this->perPage + 5;
    }





    
}
