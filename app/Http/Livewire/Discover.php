<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Facades\Common;
use App\Models\UserDataMeta;
use App\Models\DeweyDecimal;

class Discover extends Component
{

     protected $listeners = ['saveData'];
     protected $mutex = "";
     
     
    
    public function verify($datas){
     $data = IssueBookReq::where("qrkey", $datas)->first();
     if(isset($data)){
     $this->issueBookRequested($data);
     }else{
     $this->sendMessage(__("commonv2.notvalid"), "info");
     }
    }

    public function render()
    {
    
     $books = Common::getBooksDetailsForFrontEnd();
     $reversed = array_reverse($books);
     $data = $this->paginate($reversed);
          
        return view('livewire.discover');
       
    }
    public function paginate($items, $perPage = 54, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
         $paginator =  new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
         $paginator->setPath(Paginator::resolveCurrentPath());
          
        return $paginator;
    }
    public function saveData($content){
    
    if($this->mutex == $content){

    }else{
  
    $this->checkifDataisCategories($content);
    $this->mutex = $content;
    }

        
    }

    public function checkifDataisCategories($content){
    $disseminate = explode(" ", $content);
    $datas =DeweyDecimal::whereIn('cat_name',$disseminate)->get();
   
    if(!$datas->isEmpty()){
    foreach($datas as $data){
    UserDataMeta::Create(["user_id" => \Auth::Id(),"meta_value" => $data->cat_name,"meta_key" => "Categories"]);

    }
    }else{
     UserDataMeta::Create(["user_id" => \Auth::Id(),"meta_value" => $content,"meta_key" => "Searches"]); 
    
    }

}
}
