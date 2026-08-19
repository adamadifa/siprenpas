@php
    $isOrangTua = $user->hasRole('orang tua');
@endphp
<form action="{{ route('users.update', Crypt::encrypt($user->id)) }}" id="formeditUser" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon icon="ti ti-user" label="Nama User" name="name" value="{{ $user->name }}" />
    <x-input-with-icon icon="ti ti-user" label="Username" name="username" value="{{ $user->username }}" />
    <x-input-with-icon icon="ti ti-mail" label="Email" name="email" value="{{ $user->email }}" />
    <x-input-with-icon icon="ti ti-key" label="Password" name="password" type="password" />

    <div class="form-group mb-3">
        <label class="form-label">Status</label>
        <select class="form-select" name="status">
            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    @if ($isOrangTua)
        <div class="form-group mb-3">
            <label class="form-label">Role</label>
            <input type="text" class="form-control" value="Orang Tua" readonly disabled>
            <input type="hidden" name="role" value="orang tua">
        </div>
    @else
        <x-select label="Role" name="role" :data="$roles" key="name" textShow="name" selected="{{ $user->roles->first()->name ?? '' }}" />
        <x-select label="Unit" name="kode_unit" :data="$unit" key="kode_unit" textShow="nama_unit" upperCase="true"
            selected="{{ $user->kode_unit }}" />
        <x-select label="Departemen" name="kode_dept" :data="$dept" key="kode_dept" textShow="nama_dept" upperCase="true"
            selected="{{ $user->kode_dept }}" />
        <x-select label="Jabatan" name="kode_jabatan" :data="$jabatan" key="kode_jabatan" textShow="nama_jabatan" upperCase="true"
            selected="{{ $user->kode_jabatan }}" />
    @endif

    <div class="form-group">
        <button class="btn btn-primary w-100 shadow-sm" type="submit" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy me-1"></i> Update User
        </button>
    </div>
</form>

<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/users/edit.js') }}"></script>
