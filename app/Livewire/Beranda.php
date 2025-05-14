<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as ModelUser;
use App\Models\Custemer;
use App\Models\Laporan;
use App\Models\Treatment;
use Carbon\Carbon;

class Beranda extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.beranda', [ 
        ]);
    }
}
