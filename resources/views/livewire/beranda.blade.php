<div>
    <div class="container">
        <div class="row mt-7" style="text-align: center">
            <h4 style=" color:rgb(119, 119, 119); font-size: 25px; font-weight: 700">Selamat Datang Di Aplikasi HMI</h4>
            
        </div>
        @if(auth()->user()->role == 'operator')
        <div class="col-md-12 mt-10 align-items-center justify-content-center d-flex" style="height: 80vh">

            <a href="{{ route('kerja')}}" class="btn btn-dark fw-bold" style=" font-size: 25px;">
                Daftar Pekerjaan
            </a>
                {{-- <button wire:click="#" class="btn bg-black text-white fw-semibold fs-4" style="justify-content: center; max-width: 250px; height: 100%">Daftar Pekerjaan</button> --}}
        </div>
        @endif

    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });
</script>