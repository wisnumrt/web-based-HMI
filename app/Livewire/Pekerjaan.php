<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pekerjaan as ModelPekerjaan;
use App\Models\Produksi;
use Carbon\Carbon;
use App\Models\Mesin;

class Pekerjaan extends Component
{
    use WithPagination;

    public $id_mesin;
    public $nomor_spk;
    public $produk;
    public $w_start;
    public $w_finish;
    public $quantity;

    public $selectedPekerjaan = ''; // For filtering jobs by machine
    public $pilihanMenu = 'lihat';

    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }

    public function mount()
    {
        if (auth()->User()->role != 'admin') {
            abort(403);
        }
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'id', 'id');
    }

    public function searchData()
    {
        // Will use the selectedPekerjaan value for filtering in render()
        $this->resetPage(); // Reset pagination when searching
    }

    public function simpan()
    {
        $this->validate([
            'id_mesin' => 'required',
            'nomor_spk' => 'required',
            'produk' => 'required',
            'w_start' => 'required',
            'w_finish' => 'required',
            'quantity' => 'required',
        ], [
            'id_mesin.required' => 'Mesin Harus Diisi',
            'nomor_spk.required' => 'No SPK Harus Diisi',
            'produk.required' => 'Produksi Harus Diisi',
            'w_start.required' => 'Waktu Start Harus Email',
            'w_finish.required' => 'Waktu Finish Udah Terdaftar',
            'quantity.required' => 'Quantity Harus Diisi',
        ]);

        $simpan = new ModelPekerjaan();
        $simpan->id_mesin = $this->id_mesin;
        $simpan->nomor_spk = $this->nomor_spk;
        $simpan->produk = $this->produk;
        $simpan->w_start = $this->w_start;
        $simpan->w_finish = $this->w_finish;
        $simpan->quantity = $this->quantity;
        $simpan->save();

        $this->reset(['id_mesin', 'nomor_spk', 'produk', 'w_start', 'w_finish', 'quantity']);
        session()->flash('success', 'Produk baru berhasil di tambah!!');
        $this->pilihanMenu = 'lihat';
    }

    public function batal()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->pilihanMenu = 'lihat';

        $this->dispatch('tutupModal');
    }

    // Check if a job has a production record
    public function hasProductionData($jobId)
    {
        return Produksi::where('id', $jobId)->exists();
    }

    public function render()
    {
        $query = ModelPekerjaan::with(['mesin']);
        
        // Apply machine filter if selected
        if (!empty($this->selectedPekerjaan)) {
            $query->where('id_mesin', $this->selectedPekerjaan);
        }
        
        $pekerjaan = $query->select(
            'id', // Make sure to include the primary key
            'id_mesin',
            'nomor_spk',
            'produk',
            'w_start',
            'w_finish',
            'quantity'
        )->paginate(10);
        
        // Determine which jobs have production data
        foreach ($pekerjaan as $job) {
            $job->hasProduction = $this->hasProductionData($job->id);
        }

        return view('livewire.pekerjaan', [
            'getPekerjaan' => $pekerjaan,
            'getMesin' => Mesin::all(),
        ]);
    }
}