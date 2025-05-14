<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mesin;
use App\Models\Pekerjaan as ModelPekerjaan;
use App\Models\Produksi as ModelProduksi;

class PekerjaanOperator extends Component
{
    use WithPagination;

    public $selectedPekerjaan;
    public $pilihanMenu = 'lihat';
    public $searchTriggered = false;
    public $id_mesin = 0;
    public $produksiIds = [];

    public function mount()
    {
        if (auth()->user()->role == 'admin') {
            $this->pilihanMenu = 'admin';
        }

        $this->selectedPekerjaan = ''; 
        $this->id_mesin = 0;

        // Ambil semua ID pekerjaan yang sudah ada produksinya
        $this->produksiIds = ModelProduksi::pluck('id')->toArray();
    }

    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }

    public function searchData()
    {
        $this->searchTriggered = true;
    }

    public function render()
    {
        // Ambil semua pekerjaan berdasarkan filter mesin jika ada
        $allPekerjaan = ModelPekerjaan::when($this->selectedPekerjaan, function ($query) {
            $query->where('id_mesin', $this->selectedPekerjaan);
        })->get();

        // Pisahkan: yang belum ada produksi dan yang sudah
        $belumProduksi = $allPekerjaan->filter(function ($pekerjaan) {
            return !in_array($pekerjaan->id, $this->produksiIds);
        });

        $sudahProduksi = $allPekerjaan->filter(function ($pekerjaan) {
            return in_array($pekerjaan->id, $this->produksiIds);
        });

        // Gabungkan: yang belum produksi di atas
        $sortedPekerjaan = $belumProduksi->concat($sudahProduksi);

        // Lakukan manual pagination (karena sudah bukan query builder)
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $items = $sortedPekerjaan->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $sortedPekerjaan->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.pekerjaan-operator', [
            'produksis' => $this->produksiIds,
            'getMesin' => Mesin::all(),
            'getPekerjaan' => $paginated,
        ]);
    }
}
