<?php

namespace App\Http\Livewire;

use App\Custom\BookCallBacks;
use App\Facades\Common;
use App\Facades\Util;



Use App\Models\IssueBookReq;
Use App\Models\SubBook;
use App\Traits\CustomCommonLive;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Borrowed;
use App\Models\User;
use App\Models\WebCheckIn;
use App\Models\UserNotif;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class BookDetail extends Component
{
    
  

    public function render()
    {
       
        return view('livewire.bookdetail');
    }
   
   
}
