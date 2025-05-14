<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pekerjaan;
use Livewire\WithPagination;
use App\Models\Produksi as ModelProduksi;

class Produksi extends Component
{

    use WithPagination;
    public $id;
    public $durasi_pre = '';
    public $durasi_run = '';
    public $durasi_trouble = '';
    public $durasi_break = '';
    public $waste = '';
    public $j_trouble = '';
    public $realisasi = '';
    public $j_breakdown = '';
    public $plate = '';
    public $kertas = '';
    public $tinta = '';
    public $speed = ' ';
    public $pekerjaan;

    public function mount($id)
    {
        $this->pekerjaan = Pekerjaan::findOrFail($id);
        $this->id = $this->pekerjaan->id;
    }

    private function waktuKeMenit($waktu)
    {
        list($jam, $menit, $detik) = explode(':', $waktu);
        return ((int)$jam * 60) + (int)$menit + ((int)$detik / 60);
    }


    public function simpan()
    {
        $this->validate([
            'durasi_pre' => 'required|string',
            'durasi_run' => 'required|string',
            'durasi_trouble' => 'required|string',
            'durasi_break' => 'required|string',
            'j_trouble' => 'required|string',
            'j_breakdown' => 'required|string',
            'realisasi' => 'required|numeric',
            'waste' => 'required|numeric',
            'plate' => 'required|numeric',
            'kertas' => 'required|numeric',
            'tinta' => 'required|numeric',
        ],[
            'durasi_pre.required' => 'Durasi Pre Harus Diisi',
            'durasi_run.required' => 'Durasi Run Harus Diisi',
            'durasi_trouble.required' => 'Durasi Trouble Harus Diisi',
            'durasi_break.required' => 'Durasi Break Harus Diisi',
            'j_trouble.required' => 'Jenis Trouble Harus Diisi',
            'j_breakdown.required' => 'Jenis Breakdown Harus Diisi',
            'realisasi.required' => 'Realisasi Harus Diisi',
            'waste.required' => 'Waste Harus Diisi',
            'plate.required' => 'Plate Harus Diisi',
            'kertas.required' => 'Kertas Harus Diisi',
            'tinta.required' => 'Tinta Harus Diisi',
        ]);

        try {



            $setting = $this->waktuKeMenit($this->durasi_pre);
            $running = $this->waktuKeMenit($this->durasi_run);
            
            $totalMenit = $setting + $running;
            
            if($totalMenit > 0) {
                $this->speed = $this->realisasi / $totalMenit;
            } else {
                $this->speed = 0; 
            }

            
            
            
            // Create new record
            $produksi = ModelProduksi::create([
                'id' => $this->id,
                'durasi_pre' => $this->durasi_pre,
                'durasi_run' => $this->durasi_run,
                'durasi_trouble' => $this->durasi_trouble,
                'durasi_break' => $this->durasi_break,
                'j_trouble' => $this->j_trouble,
                'j_breakdown' => $this->j_breakdown,
                'realisasi' => $this->realisasi,
                'waste' => $this->waste,
                'speed' => $this->speed,
                'plate' => $this->plate,
                'kertas' => $this->kertas,
                'tinta' => $this->tinta,
            ]);

            session()->flash('success', 'Produk berhasil di upload!');
            return redirect()->route('kerja', );
            
        } catch (\Exception $e) {
            // Log the error for debugging
            dd($e->getMessage());
            \Log::error('Error saving production data: ' . $e->getMessage());
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    //     echo 'masuk';
    //     $this->validate([
    //         'durasi_pre' => 'required',
    //         'durasi_run' => 'required',
    //         'durasi_trouble' => 'required',
    //     ], [
    //         'durasi_pre.required' => 'Nama Harus Diisi',
    //         'durasi_run.required' => 'Kategori Harus Diisi',
    //         'durasi_trouble.required' => 'Harga Harus Diisi'
    //     ]);
    //     $simpan = new ModelProduksi();
    //     $simpan->id_pekerjaan = $this->id_pekerjaan;
    //     $simpan->durasi_pre = $this->durasi_pre;
    //     $simpan->durasi_run = $this->durasi_run;
    //     $simpan->durasi_trouble = $this->durasi_trouble;
    //     $simpan->j_trouble = $this->j_trouble;
    //     $simpan->durasi_break = $this->durasi_break;
    //     $simpan->j_breakdown = $this->j_breakdown;
    //     $simpan->realisasi = $this->realisasi;
    //     $simpan->waste = $this->waste;
    //     $simpan->plate = $this->plate;
    //     $simpan->kertas = $this->kertas;
    //     $simpan->tinta = $this->tinta;
    //     $simpan->save();

    //     $this->reset([
    //         'id_pekerjaan', 
    //         'durasi_pre', 
    //         'durasi_run', 
    //         'durasi_trouble', 
    //         'j_trouble', 
    //         'durasi_break', 
    //         'j_breakdown', 
    //         'realisasi', 
    //         'waste', 
    //         'plate', 
    //         'kertas', 
    //         'tinta', 
    //         ]);
    //     // $this->pilihanMenu = 'lihat';

    //     // // Simpan ke database (buat model atau sesuaikan)
    //     // Produksi::create([
    //     //     'pekerjaan_id' => $this->pekerjaan_id,
    //     //     'durasi_pre' => $this->durasi_pre,
    //     //     'durasi_run' => $this->durasi_run,
    //     //     'durasi_trouble' => $this->durasi_trouble,
    //     //     'durasi_break' => $this->durasi_break,
    //     //     'quantity' => $this->quantity,
    //     //     'waste' => $this->waste,
    //     //     'jenis_trouble' => $this->jenis_trouble,
    //     //     'jenis_breakdown' => $this->jenis_breakdown,
    //     //     'plate' => $this->plate,
    //     //     'kertas' => $this->kertas,
    //     //     'tinta' => $this->tinta,
    //     // ]);

    //     session()->flash('success', 'Data berhasil disimpan!');
    // }

    public function render()
    {
        return view('livewire.produksi');
    }
}
