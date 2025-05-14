
<div>
    <div class="container">
        <div class="d-flex py-3 py-4 align-items-end" style="position: fixed; top: 0; z-index: 1; background-color: white; width: 100%; ">
            <div class="mt-5">
                <div class="col-12 d-flex align-items-end flex-row gap-2">
                    <label for="mesin" class="text-dark fw-bold fs-20" style="font-size: 25px">MESIN :</label>
                    <select wire:model.live="selectedMesin" id="mesin"  class="form-control" style="width: 250px; display: inline-block;">
                        <option value="">Cari Mesin </option>
                        @foreach($mesinList as $mesin)
                            <option value="{{ $mesin->id_mesin }}">{{ $mesin->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-5 pt-4">
            <div class="col-12">
                <div class="card border-dark">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">Mesin</th>
                                    <th class="text-center">No SPK</th>
                                    <th class="text-center">Produk</th>
                                    <th class="text-center">W start</th>
                                    <th class="text-center">W Finish</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">W Pre-setting</th>
                                    <th class="text-center">W Running</th>
                                    <th class="text-center">W Trouble</th>
                                    <th class="text-center">W Break</th>
                                    <th class="text-center">J Trouble</th>
                                    <th class="text-center">J Break</th>
                                    <th class="text-center">Realisasi</th>
                                    <th class="text-center">Weste</th>
                                    <th class="text-center">Speed <br/>(Quantity/Jam)</th>
                                    <th class="text-center">Plate</th>
                                    <th class="text-center">Kertas</th>
                                    <th class="text-center">Tinta</th>
                                    <th class="text-center">Tgl</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produksi as $data)
                                    <tr>
                                        <td class="text-center">{{ ($produksi->currentPage() - 1) * $produksi->perPage() + $loop->iteration }}</td>
                                        <td  class="text-center" >{{$data->pekerjaan && $data->pekerjaan->mesin ? $data->pekerjaan->mesin->nama : '-' }}</td>
                                        <td  class="text-center" >{{$data->pekerjaan->nomor_spk }}</td>
                                        <td  class="text-center" >{{$data->pekerjaan->produk }}</td>
                                        <td  class="text-center" >{{$data->pekerjaan->w_start }}</td>
                                        <td  class="text-center" >{{$data->pekerjaan->w_finish }}</td>
                                        <td  class="text-center" >{{$data->pekerjaan->quantity }}</td>
                                        <td  class="text-center" >{{$data->durasi_pre }}</td>
                                        <td  class="text-center" >{{$data->durasi_run }}</td>
                                        <td  class="text-center" >{{$data->durasi_trouble }}</td>
                                        <td  class="text-center" >{{$data->durasi_break }}</td>
                                        <td  class="text-center" >{{$data->j_trouble }}</td>
                                        <td  class="text-center" >{{$data->j_breakdown }}</td>
                                        <td  class="text-center" >{{$data->realisasi }}</td>
                                        <td  class="text-center" >{{$data->waste }}</td>
                                        <td  class="text-center" >{{ $data->speed }}</td>
                                        <td  class="text-center" >{{$data->plate }}</td>
                                        <td  class="text-center" >{{$data->kertas }}</td>
                                        <td  class="text-center" >{{$data->tinta }}</td>
                                        <td  class="text-center" >{{$data->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Pagination">
                            <ul class="pagination">
                            
                                @if ($produksi->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" wire:click="gotoPage(1)" style="cursor: pointer;">
                                        &laquo;&laquo; First
                                    </a>
                                </li>
                                @endif

                                <!-- {{-- Tombol Previous --}} -->
                                <li class="page-item {{ $produksi->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" wire:click="previousPage" wire:loading.attr="disabled" style="cursor: pointer;">
                                        &laquo; Previous
                                    </a>
                                </li>

                                <!-- menampilkan maksimal 3 halaman  -->
                                @php
                                $start = max($produksi->currentPage() - 2, 1);
                                $end = min($produksi->currentPage() + 2, $produksi->lastPage());
                                @endphp

                                @for ($page = $start; $page <= $end; $page++)
                                <li class="page-item {{ $page == $produksi->currentPage() ? 'active' : '' }}">
                                <a class="page-link" wire:click="gotoPage({{ $page }})" style="cursor: pointer;">{{ $page }}</a>
                                </li>
                                @endfor

                                <!-- {{-- Tombol Next --}} -->
                                <li class="page-item {{ !$produksi->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" wire:click="nextPage" wire:loading.attr="disabled" style="cursor: pointer;">
                                        Next &raquo;
                                    </a>
                                </li>

                                <!-- {{-- Tombol Last --}} -->
                                @if ($produksi->currentPage() < $produksi->lastPage() - 2)
                                <li class="page-item">
                                    <a class="page-link" wire:click="gotoPage({{ $$produksi->lastPage() }})" style="cursor: pointer;">
                                        Last &raquo;
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>