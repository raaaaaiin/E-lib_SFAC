<?php

namespace App\Http\Livewire;

use App\Facades\Util;
use App\Models\NoticeManager;
use App\Models\UserNotif;
use Livewire\Component;
use Livewire\WithPagination;

class nsidebar extends Component
{
    use WithPagination;
    protected $listeners = ['load'];

    public function render()
    {
       
        return view('livewire.nsidebar');
    }
  
    
}
