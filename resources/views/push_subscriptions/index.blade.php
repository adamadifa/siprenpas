@extends('layouts.app')
@section('titlepage', 'Push Subscription')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-info rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-bell-ringing fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Push Subscription</h4>
                        <p class="text-muted mb-0 small">Daftar perangkat yang berlangganan notifikasi push</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-bell-ringing me-1"></i> Push Subscription
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-bell-ringing fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Subscriber</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">USER / WALI</th>
                                <th class="text-white py-3">ENDPOINT</th>
                                <th class="text-white py-3 text-center">TGL DAFTAR</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $s)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 fw-bold text-dark">
                                        {{ $s->user->name ?? 'Guest' }}
                                        <br>
                                        <small class="text-muted">{{ $s->user->email ?? '-' }}</small>
                                    </td>
                                    <td class="py-2">
                                        <div class="text-truncate" style="max-width: 400px;" title="{{ $s->endpoint }}">
                                            {{ $s->endpoint }}
                                        </div>
                                    </td>
                                    <td class="py-2 text-center small text-muted">
                                        {{ $s->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('push-subscriptions.test', $s->id) }}" class="btn btn-icon btn-label-primary border" title="Test Notifikasi" style="width: 28px; height: 28px;">
                                                <i class="ti ti-bell-ringing fs-6"></i>
                                            </a>
                                            <form method="POST" class="deleteform" action="{{ route('push-subscriptions.destroy', $s->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-label-danger border delete-confirm" title="Hapus" style="width: 28px; height: 28px;">
                                                    <i class="ti ti-trash fs-6"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-bell-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Subscriber</h5>
                                        <p class="text-muted">Pengguna perlu mengaktifkan notifikasi di portal Siportuweb.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Hapus Subscriber?',
                text: "Notifikasi tidak akan terkirim lagi ke perangkat ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
