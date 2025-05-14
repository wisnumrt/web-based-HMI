<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produksi; 
use App\Models\Mesin;
use App\Models\Pekerjaan;

class Laporan extends Component
{

    use WithPagination;
    public $selectedMesin;
    public $pilihanMenu = 'lihat';
    public $searchTriggered = false;
    public $id_mesin = 0;


    public function mount()
    {
        $this->selectedMesin = ''; 
        $this->id_mesin= 0;

 
    }
    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }

    public function render()
    {
        $produksi = Produksi::whereHas('pekerjaan', function ($query) {
            if ($this->selectedMesin) {
                $query->where('id_mesin', $this->selectedMesin);
            }
        })->with('pekerjaan.mesin')->paginate(10);

    
        return view('livewire.laporan', [
            'produksi' => $produksi,
            'mesinList' => Mesin::all(),
        ]);
    }
}


