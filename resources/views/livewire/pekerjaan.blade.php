<div>
    <div class="container">
        <div class="row">
            @if($pilihanMenu == 'lihat')
                <h4 style="margin-top: -10px;">DAFTAR PEKERJAAN</h4>
                @if (session()->has('success'))
                    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ session('success') }}
                    </div>
                
                    <script>
                        setTimeout(function () {
                            const alert = document.getElementById('success-alert');
                            if (alert) {
                                alert.classList.remove('show');
                                alert.classList.add('hide');
                            }
                        }, 2000);
                    </script>
                @endif
            @elseif($pilihanMenu == 'tambah')
                <h4 style="margin-top: -10px;">TAMBAH PEKERJAAN</h4>
            @endif
            @if($pilihanMenu != 'tambah')
            <div class="col-12 my-2">
                <button wire:click="pilihMenu('tambah')" class="btn btn-dark" style="height: 40px; width: 160px">
                <i class="bi bi-plus-lg" style="font-size: 15px"></i> Tambah Data</button>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                @if($pilihanMenu == 'lihat')
                <div class="card border-dark">
                    <table class="table table-striped table-bordered w-100">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Mesin</th>
                                <th class="text-center">No SPK</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">W. Start</th>
                                <th class="text-center">W. Finish</th>
                                <th class="text-center">Quantity</th>
                                
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($getPekerjaan as $pekerjaan)
                            <tr>
                                
                                <td class="text-center">{{ ($getPekerjaan->currentPage() - 1) * $getPekerjaan->perPage() + $loop->iteration }}</td>
                                <td>{{$pekerjaan->mesin->nama ?? '-'}}</td>
                                <td>{{$pekerjaan->nomor_spk}}</td>
                                <td>{{$pekerjaan->produk}}</td>
                                <td>{{$pekerjaan->w_start}}</td>
                                <td>{{$pekerjaan->w_finish}}</td>
                                <td>{{$pekerjaan->quantity}}</td>
                                <td class="text-center">
                                    <button 
                                        class="btn btn-warning  my-2">
                                        <i class="bi bi-pencil-square" style="font-size: 12px"></i>
                                    </button>
                                    <button 
                                        class="btn btn-danger"
                                        data-bs-toggle="modal" data-bs-target="#hapusModal">
                                        <i class="bi bi-trash3-fill" style="font-size: 12px"></i>
                                    </button>
                                </td>
                                
                            </tr>
                            @endforeach
            
                        </tbody>
                    </table>
                    <nav aria-label="Pagination">
                        <ul class="pagination">
                            {{-- Tombol First --}}
                            @if ($getPekerjaan->currentPage() > 3)
                            <li class="page-item">
                                <a class="page-link" wire:click="gotoPage(1)" style="cursor: pointer;">
                                    &laquo; First
                                </a>
                            </li>
                            @endif

                            <!-- {{-- Tombol Previous --}} -->
                            <li class="page-item {{ $getPekerjaan->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" wire:click="previousPage" wire:loading.attr="disabled" style="cursor: pointer;">
                                    &laquo; Previous
                                </a>
                            </li>
                            <!-- menampilkan maksimal  3 halaman  -->
                            @php
                            $start = max($getPekerjaan->currentPage() - 2, 1);
                            $end = min($getPekerjaan->currentPage() + 2, $getPekerjaan->lastPage());
                            @endphp

                            @for ($page = $start; $page <= $end; $page++)
                                <li class="page-item {{ $page == $getPekerjaan->currentPage() ? 'active' : '' }}">
                                <a class="page-link" wire:click="gotoPage({{ $page }})" style="cursor: pointer;">{{ $page }}</a>
                                </li>
                                @endfor

                                <!-- {{-- Tombol Next --}} -->
                                <li class="page-item {{ !$getPekerjaan->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" wire:click="nextPage" wire:loading.attr="disabled" style="cursor: pointer;">
                                        Next &raquo;
                                    </a>
                                </li>

                                <!-- {{-- Tombol Last --}} -->
                                @if ($getPekerjaan->currentPage() < $getPekerjaan->lastPage() - 2)
                                    <li class="page-item">
                                        <a class="page-link" wire:click="gotoPage({{ $getPekerjaan->lastPage() }})" style="cursor: pointer;">
                                            Last &raquo;
                                        </a>
                                    </li>
                                    @endif
                        </ul>
                    </nav>
                </div>

                @elseif($pilihanMenu == 'tambah')
                <div class="card border-primary">
                    <div class="card-header">
                        <form wire:submit='simpan'>
                            <label class="mt-2">Mesin</label>
                            <select class="form-control" wire:model="id_mesin" >
                                <option value="">Pilih Mesin</option>
                                @foreach($getMesin as $mesin)
                                <option value="{{$mesin->id_mesin}}">{{$mesin->nama}}</option>
                                @endforeach
                            </select>
                            @error('id_mesin')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <br>
                            <label class="mt-2">Nommor SPK</label>
                            <input type="text" class="form-control" wire:model='nomor_spk' placeholder="Masukkan Nommor SPK" />
                            @error('nomor_spk')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <br>
                            <label class="mt-2">Produk</label>
                            <input type="text" class="form-control" wire:model='produk' placeholder="Masukkan Produk" />
                            @error('produk')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <br>
                            <label class="mt-2">Waktu Start</label>
                            <input type="time" class="form-control" wire:model='w_start' placeholder="Masukkan Waktu Start" />
                            @error('w_start')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <br>
                            <label class="mt-2">Waktu finish</label>
                            <input type="time" class="form-control" wire:model='w_finish' placeholder="Masukkan Waktu finish" />
                            @error('w_finish')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <br>
                            <label class="mt-2">Quantity</label>
                            <input type="text" class="form-control" wire:model='quantity' placeholder="Masukkan Quantity" />
                            @error('quantity')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <br>
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            <button type="button" class="btn btn-secondary mt-3" wire:click='batal'>Batal</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div wire:ignore.self class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus <strong>{{$pilpengguna->name ?? ''}}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="batal">Batal</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" wire:click="hapus">Hapus</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Loading
    <div wire:ignore.self class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Mohon Tunggu...</p>
                </div>
            </div>
        </div>
    </div> -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('showLoading', () => {
                var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
                loadingModal.show();
            });

            Livewire.on('hideLoading', () => {
                var loadingModal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
                if (loadingModal) {
                    loadingModal.hide();
                }
            });
        });
    </script>

</div>