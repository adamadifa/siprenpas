<form id="formCreateQuestionnaire" action="{{ route('admin.questionnaires.store') }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label fw-semibold">Judul</label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa fa-heading text-primary"></i></span>
            <input type="text" class="form-control shadow-sm" name="title" id="title" required placeholder="Masukkan judul kuisioner">
        </div>
        <div class="invalid-feedback" id="titleError"></div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label fw-semibold">Deskripsi</label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa fa-align-left text-success"></i></span>
            <textarea class="form-control shadow-sm" name="description" id="description" style="min-height: 90px;" placeholder="Masukkan deskripsi singkat kuisioner..."></textarea>
        </div>
        <div class="invalid-feedback" id="descError"></div>
    </div>
    <button type="submit" class="btn btn-primary w-100 fw-bold" id="btnSubmit">Simpan</button>
</form>
<script>
    var triedSubmit = false;
    function showError(input, errorId, message) {
        $(input).addClass('is-invalid border-danger');
        $(errorId).text(message).show();
        $(input).closest('.input-group').addClass('border border-danger rounded-2');
    }
    function clearError(input, errorId) {
        $(input).removeClass('is-invalid border-danger');
        $(errorId).hide().text('');
        $(input).closest('.input-group').removeClass('border border-danger rounded-2');
    }
    function validateForm(showAllError = false) {
        let valid = true;
        const title = $('#title').val().trim();
        if (title.length < 3) {
            if (showAllError || triedSubmit) showError('#title', '#titleError', 'Judul minimal 3 karakter');
            valid = false;
        } else {
            clearError('#title', '#titleError');
        }
        const desc = $('#description').val().trim();
       
        if (desc.length < 5) {
            if (showAllError || triedSubmit) showError('#description', '#descError', 'Deskripsi minimal 5 karakter jika diisi');
            valid = false;
        } else {
            clearError('#description', '#descError');
        }
        return valid;
    }
    $(document).on('input', '#title, #description', function() {
        validateForm(false);
    });
    $(document).on('submit', '#formCreateQuestionnaire', function(e) {
        triedSubmit = true;
        if (!validateForm(true)) {
            e.preventDefault();
            return;
        }
        // Cegah double submit
        $('#btnSubmit').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...');
    });
</script>
