<div>
    <div class="container py-4">

        <table class="table table-bordered text-center mb-4" style="table-layout: fixed;">
            <thead class="table-light">
                <tr>
                    <th>Mesin</th>
                    <th>Nomor SPK</th>
                    <th>Produk</th>
                    <th>Durasi Plan</th>
                    <th>Quantity Plan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    use Carbon\Carbon;
                    $start = Carbon::parse($pekerjaan->w_start);
                    $finish = Carbon::parse($pekerjaan->w_finish);
                    $durasi_plan = $start->diff($finish)->format('%h jam %i menit');
                @endphp
                <tr>
                    <td>{{$pekerjaan->mesin->nama ?? '__'}}</td>
                    <td>{{$pekerjaan->nomor_spk}}</td>
                    <td>{{$pekerjaan->produk}}</td>
                    <td>{{$durasi_plan}}</td>
                    <td>{{ $pekerjaan->quantity }}</td>
                </tr>
            </tbody>
        </table>
        
        <form wire:submit.prevent="simpan">
            <div class="mb-4">
                <div class="col-md-12 row">
                    <div class="col-md-3 d-flex flex-row justify-content-between-center align-items-center">
                        <div class="col-7 fw-bold">Pre Setting</div>
                        <div class="col-5 justify-end flex" onclick="startTimer('pre')">
                            <i class="bi bi-caret-right-fill color-green" style="font-size: 40px; color:rgb(98, 252, 132)"></i>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-row justify-between align-items-center">
                        <div class="col-3 text-start">Durasi :</div>
                        <div class="col-5">
                            <input type="text" class="form-control" style="background-color: #f0f0f0;" wire:model.live="durasi_pre" id="durasi_pre" readonly />
                        </div>
                        <div class="col-4 justify-content-center d-flex">
                            <div class="circle" onclick="stopTimer('pre')">
                                <i class="bi bi-circle-fill" style="font-size: 40px; color: red"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="col-md-3 d-flex flex-row justify-content-between-center align-items-center">
                        <div class="col-7 fw-bold">Running</div>
                        <div class="col-5 justify-end flex" onclick="startTimer('run')">
                            <i class="bi bi-caret-right-fill color-green" style="font-size: 40px; color:rgb(98, 252, 132)"></i>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-row justify-between align-items-center">
                        <div class="col-3 text-start">Durasi :</div>
                        <div class="col-5">
                            <input type="text" class="form-control" style="background-color: #f0f0f0;" wire:model.live="durasi_run" id="durasi_run" readonly />
                        </div>
                        <div class="col-4 justify-content-center d-flex">
                            <div class="circle" onclick="stopTimer('run')">
                                <i class="bi bi-circle-fill" style="font-size: 40px; color: red"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex flex-center gap-2">
                        <div class="col-md-6 d-flex flex-row justify-content-between align-items-center">
                            <div class="col-4 text-start">Quantity :</div>
                            <div class="col-auto">
                                <input type="number" wire:model.live="realisasi" class="form-control" style="background-color: #f0f0f0; width: 120px;" />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-row justify-content-between align-items-center">
                            <div class="col-4 text-start">Waste :</div>
                            <div class="col-auto"><input type="number" class="form-control" style="background-color: #f0f0f0;width: 120px;" wire:model.live="waste"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="col-md-3 d-flex flex-row justify-content-between-center align-items-center">
                        <div class="col-7 fw-bold">Trouble</div>
                        <div class="col-5 justify-end flex" onclick="startTimer('trouble')">
                            <i class="bi bi-caret-right-fill color-green" style="font-size: 40px; color:rgb(98, 252, 132)"></i>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-row justify-between align-items-center">
                        <div class="col-3 text-start">Durasi :</div>
                        <div class="col-5">
                            <input type="text" class="form-control" style="background-color: #f0f0f0;" wire:model.live="durasi_trouble" id="durasi_trouble" readonly />
                        </div>
                        <div class="col-4 justify-content-center d-flex">
                            <div class="circle" onclick="stopTimer('trouble')">
                                <i class="bi bi-circle-fill" style="font-size: 40px; color: red"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex flex-center gap-2 align-items-center">
                        <label class="col-4 text-start">Jenis Trouble :</label>
                        <select class="form-select" wire:model.live="j_trouble" style="width: 200px; background-color: #f0f0f0;">
                            <option value="">Pilih Trouble</option>
                            <option value="GLADE ROLL">GLADE ROLL</option>
                            <option value="NIPPING ROLL">NIPPING ROLL</option>
                            <option value="SLITTER">SLITTER</option>
                            <option value="FOLDING BLADE">FOLDING BLADE</option>
                            <option value="JAM FOLDER">JAM FOLDER</option>
                            <option value="JARUM (PUTUS)">JARUM (PUTUS)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="col-md-3 d-flex flex-row justify-content-between-center align-items-center">
                        <div class="col-7 fw-bold">Break Down</div>
                        <div class="col-5 justify-end flex" onclick="startTimer('break')">
                            <i class="bi bi-caret-right-fill color-green" style="font-size: 40px; color:rgb(98, 252, 132)"></i>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-row justify-between align-items-center">
                        <div class="col-3 text-start">Durasi :</div>
                        <div class="col-5">
                            <input type="text" class="form-control" style="background-color: #f0f0f0;" wire:model.live="durasi_break" id="durasi_break" readonly />
                        </div>
                        <div class="col-4 justify-content-center d-flex">
                            <div class="circle" onclick="stopTimer('break')">
                                <i class="bi bi-circle-fill" style="font-size: 40px; color: red"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex flex-center gap-2 align-items-center">
                        <label class="col-4 text-start">Jenis Break Down :</label>
                        <select class="form-select" wire:model.live="j_breakdown" style="width: 200px; background-color: #f0f0f0;">
                            <option value="">Pilih Break Down</option>
                            <option value="WEEB BREAK">WEEB BREAK</option>
                            <option value="OFF SENDIRI">OFF SENDIRI</option>
                            <option value="CONSULE ERROR">CONSULE ERROR</option>
                            <option value="REGISTER MACET">REGISTER MACET</option>
                            <option value="SENSOR UNIT">SENSOR UNIT</option>
                            <option value="MOTOR TINTA/AIR">MOTOR TINTA/AIR</option>
                            <option value="MOTOR PROT/SIGNA">MOTOR PROT/SIGNA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 align-items-center d-flex flex-row mt-3">
                    <div class="col-md-2  align-items-center">
                        <p class="text-center d-flex fw-bold">Bahan</p>
                    </div>
                
                    <div class="col-md-3 d-flex flex-row px-3  align-items-center">
                        <label class="form-label col-4">Plate :</label>
                        <input type="number" wire:model.live="plate" class="form-control col-4 form-control-putih w-50" style="background-color: #f0f0f0;"/>
                    </div>
                    <div class="col-md-3 d-flex flex-row px-3  align-items-center">
                        <label class="form-label col-4">Kertas :</label>
                        <input type="number" wire:model.live="kertas" class="form-control col-4 w-50 form-control-putih" style="background-color: #f0f0f0;"/>
                    </div>
                    <div class="col-md-3 row px-3  align-items-center">
                        <label class="form-label col-4 text-center align-items-center justify-center">Tinta :</label>
                        <input type="number" wire:model.live="tinta" class="form-control col-4 w-50 form-control-putih" style="background-color: #f0f0f0;"/>
                    </div>
                </div>
            </div>

            <div class="col-md-12 d-flex flex-row justify-between">
                <!-- Submit -->
                <div class="col-6 text-start">
                    <a href="{{ route('kerja') }}" class="btn btn-secondary">Back</a>
                </div>
                <!-- Submit -->
                <div class="col-6 text-end">
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            // Initialize JS after Livewire loads
            initializeTimers();
        });

        function initializeTimers() {
            window.timers = {};
            window.pausedByBreak = {}; // Menyimpan timer yang dihentikan saat break
        }

        function startTimer(id) {
            // Jika yang diklik adalah 'break', hentikan semua timer lain dan simpan status aktifnya
            if (id === 'break') {
                ['pre', 'run', 'trouble'].forEach((key) => {
                    if (window.timers[key]?.interval) {
                        clearInterval(window.timers[key].interval);
                        window.timers[key].interval = null;
                        window.pausedByBreak[key] = true; // Simpan bahwa timer ini dihentikan oleh 'break'
                    }
                });
            }
    
            // Jangan jalankan dua kali timer yang sama
            if (window.timers[id]?.interval) return;
    
            const input = document.getElementById(`durasi_${id}`);
            if (!window.timers[id]) window.timers[id] = { seconds: 0 };
    
            // Parse initial value if it exists
            if (input.value && input.value !== '00:00:00') {
                const parts = input.value.split(':');
                if (parts.length === 3) {
                    window.timers[id].seconds = parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseInt(parts[2]);
                }
            }
    
            // Tampilkan detik pertama
            window.timers[id].seconds++;
            input.value = formatTime(window.timers[id].seconds);
            
            // Trigger Livewire update
            input.dispatchEvent(new Event('input'));
    
            // Jalankan interval
            window.timers[id].interval = setInterval(() => {
                window.timers[id].seconds++;
                input.value = formatTime(window.timers[id].seconds);
                
                // Trigger Livewire update on each tick
                input.dispatchEvent(new Event('input'));
            }, 1000);
        }
    
        function stopTimer(id) {
            clearInterval(window.timers[id]?.interval);
            window.timers[id].interval = null;
    
            // Kalau yang dihentikan adalah 'break', maka lanjutkan timer yang sebelumnya dihentikan
            if (id === 'break') {
                Object.keys(window.pausedByBreak).forEach((key) => {
                    if (window.pausedByBreak[key]) {
                        startTimer(key);
                        window.pausedByBreak[key] = false; // Reset
                    }
                });
            }
        }
    
        function formatTime(seconds) {
            const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
            const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            return `${h}:${m}:${s}`;
        }
    </script>
</div>