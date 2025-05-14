<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as ModelUser;

class User extends Component
{

    public  $pilihanMenu = 'lihat';
    public $nama;
    public $telpon;
    public $email;
    public $password;
    public $role;
    public $pilpengguna;

    protected $table = 'users';

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
            'telpon' => 'required',
            'email' => ['required', 'email',  'unique:users,email'],
            'password' => 'required',
            'role' => 'required'
        ], [
            'nama.required' => 'Nama Harus Diisi',
            'telpon.required' => 'N0.Telpon Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Format Harus Email',
            'email.unique' => 'Email Udah Terdaftar',
            'password.required' => 'Password Harus Diisi',
            'role.required' => 'Status User Harus Diisi'
        ]);
        $simpan = new ModelUser();
        $simpan->name = $this->nama;
        $simpan->telp = $this->telp;
        $simpan->email = $this->email;
        $simpan->password = $this->password;
        $simpan->role = $this->role;
        $simpan->save();

        $this->reset(['nama', 'telp', 'email', 'password', 'role']);
        $this->pilihanMenu = 'lihat';
    }

    public function pilihedit($id){
        $this->pilpengguna = ModelUser::findOrFail($id);

        $this->nama = $this->pilpengguna->name;
        $this->telpon = $this->pilpengguna->telp;
        $this->email = $this->pilpengguna->email;
        $this->role = $this->pilpengguna->role;
        $this->pilihanMenu = 'edit';


    }

    public function simpanEdit(){
        $this->validate([
            'nama' => 'required',
            'telpon' => 'required',
            'email' => ['required', 'email',  'unique:users,email,'.$this->pilpengguna->id],
            'role' => 'required'
        ], [
            'nama.required' => 'Nama Harus Diisi',
            'telpon.required' => 'No.Telpon Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Format Harus Email',
            'email.unique' => 'Email Udah Terdaftar',
            'role.required' => 'Status User Harus Diisi'
        ]);
        $simpan = $this->pilpengguna;
        $simpan->name = $this->nama;
        $simpan->telp = $this->telpon;
        $simpan->email = $this->email;
        if($this->password){
            $simpan->password = $this->password;
        }
        $simpan->role = $this->role;
        $simpan->save();

        $this->reset(['nama', 'telpon', 'email', 'password', 'role', 'pilpengguna']);
        $this->pilihanMenu = 'lihat';
    }


    public function pilihhapus($id){
        $this->pilpengguna = ModelUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus()
    {
        if ($this->pilpengguna) {
            $this->pilpengguna->delete();
        }

        $this->reset(['pilpengguna']);
        $this->pilihanMenu = 'lihat';


        $this->dispatch('tutupModal');
    }

    public function batal()
    {
        $this->reset(['nama', 'email', 'role', 'pilpengguna']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->pilihanMenu = 'lihat';

        $this->dispatch('tutupModal');
    }


    public function render()
    {
        return view('livewire.user', [
            'getPengguna' => ModelUser::select('id', 'name', 'telp', 'email', 'role')->paginate(10)
        ]);
        // return view('livewire.user')->with(
        //     ['getPengguna' => ModelUser::all()
        //     ]
        // );
    }




}
