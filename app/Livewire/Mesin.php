<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mesin as ModelMesin;

class Mesin extends Component
{
    public  $pilihanMenu = 'lihat';
    public $nama;
    public $pilMesin;

    protected $table = 'mesin';

    public function mount(){
        if(auth()->User()->role != 'admin'){
            abort(403);
        }

        if(auth()->User()->role == 'operator'){
            return redirect('/welcom.blade')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function pilihMenu($menu){
        $this->pilihanMenu = $menu;
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Mesin  Harus Diisi',
        ]);
        $simpan = new ModelMesin();
        $simpan->nama = $this->nama;
        $simpan->save();

        $this->reset(['nama']);
        $this->pilihanMenu = 'lihat';
    }


    public function pilihedit($id){
        $this->pilMesin = ModelMesin::findOrFail($id);

        $this->nama = $this->pilMesin->nama;
        $this->pilihanMenu = 'edit';


    }

    public function simpanEdit(){
        $this->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Mesin Harus Diisi',
        ]);
        $simpan = $this->pilMesin;
        $simpan->nama = $this->nama;
        $simpan->save();

        $this->reset(['nama']);
        session()->flash('success', 'Mesin baru berhasil di tambah!!');
        $this->pilihanMenu = 'lihat';
    }

    public function pilihhapus($id){
        $this->pilMesin = ModelMesin::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus()
    {
        if ($this->pilMesin) {
            $this->pilMesin->delete();
        }

        $this->reset(['pilMesin']);
        $this->pilihanMenu = 'lihat';


        $this->dispatch('tutupModal');
    }


    public function batal()
    {
        $this->reset(['nama']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->pilihanMenu = 'lihat';

        $this->dispatch('tutupModal');
    }
    public function render()
    {
        return view('livewire.mesin',  [
            'getMesin' => ModelMesin::select('id_mesin', 'nama')->paginate(10)
        ]);
    }
}
