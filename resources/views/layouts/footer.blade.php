<footer class="content-footer footer bg-footer-theme">
    <div class="container-fluid">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                @if ($pengaturan)
                    , {{ $pengaturan->nama_sekolah }}
                @else
                    , made with ❤️ by <a href="https://pixinvent.com" target="_blank" class="fw-medium">Pixinvent</a>
                @endif
            </div>

        </div>
    </div>
</footer>
