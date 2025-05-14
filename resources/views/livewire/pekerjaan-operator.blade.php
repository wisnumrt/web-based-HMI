<div>
    <div class="container">
        @if (session()->has('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
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
        <div class="row mb-3">
            <div class="col-12 d-flex align-items-center flex-row gap-2 mb-4">
                <label for="mesin" class="text-dark fw-bold fs-20" style="font-size: 25px">MESIN :</label>
                <select id="mesin" class="form-control" style="width: 250px; display: inline-block;" wire:model.live="selectedPekerjaan">
                    <option value="">Pilih Mesin</option>
                    @foreach($getMesin as $mesin)
                        <option value="{{ $mesin->id_mesin }}">{{ $mesin->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <h4 style="margin-top: -10px;">DAFTAR PEKERJAAN</h4>   
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
                                <td>{{$pekerjaan->mesin->nama}}</td>
                                <td>{{$pekerjaan->nomor_spk}}</td>
                                <td>{{$pekerjaan->produk}}</td>
                                <td>{{$pekerjaan->w_start}}</td>
                                <td>{{$pekerjaan->w_finish}}</td>
                                <td>{{$pekerjaan->quantity}}</td>
                                <td class="text-center">
                                    <div class="cards">
                                        @if(in_array($pekerjaan->id, $produksis))
                                            <button class="btn fw-semibold br-2" style="background-color: #1BE828; cursor: default;">
                                                <i class="bi bi-check-lg" style="font-size: 1.5rem; color: white;"></i>
                                            </button>
                                        @else
                                            <a href="{{ route('produksi', ['id' => $pekerjaan->id]) }}" 
                                            class="btn fw-semibold br-2" 
                                            style="background-color: #1BE828;">
                                                RUN
                                            </a>
                                        @endif
                                    </div>
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
                <div class="col-md-12 text-start mt-3">
                    <a href="{{ route('dashboard')}}" class="btn btn-secondary">
                        Back
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

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