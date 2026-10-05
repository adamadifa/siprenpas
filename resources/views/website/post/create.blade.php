<form action="{{ route('post.store') }}" id="formCreatePost" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf

    <!-- Info Callout -->
    <div class="p-3 bg-emerald-50/80 border border-emerald-200/80 rounded-xl flex items-start gap-2.5 text-xs text-emerald-900">
        <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
        <div>
            <strong class="font-bold">Publikasi Warta Website:</strong>
            <p class="text-[11px] text-emerald-800/90 mt-0.5">Foto sampul akan otomatis dioptimasi dan dikonversi ke format WebP berkualitas tinggi untuk kecepatan akses website.</p>
        </div>
    </div>
    
    <!-- Image Upload Area -->
    <div class="space-y-1.5">
        <label for="image_create" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-photo text-sm text-slate-400"></i>
            <span>Gambar Sampul (Cover Post) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        
        <div class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl p-4 transition-all bg-slate-50/60 hover:bg-emerald-50/20 text-center cursor-pointer group">
            <input type="file" 
                   name="image" 
                   id="image_create" 
                   accept="image/jpeg,image/png,image/jpg,image/webp" 
                   required 
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                   onchange="previewImageCreate(this)">
            
            <div id="preview_placeholder_create" class="flex flex-col items-center justify-center py-2">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mb-2 shadow-2xs group-hover:scale-110 transition-transform">
                    <i class="ti ti-upload text-xl"></i>
                </div>
                <p class="text-xs font-bold text-slate-700 mb-0.5">Pilih atau Seret Foto Sampul ke Sini</p>
                <p class="text-[11px] text-slate-400">Mendukung format JPG, PNG, WEBP (Maksimal 4 MB)</p>
            </div>

            <div id="preview_container_create" class="hidden relative max-w-sm mx-auto">
                <img id="preview_img_create" src="#" alt="Preview" class="rounded-xl max-h-48 mx-auto object-cover border border-slate-200 shadow-sm">
                <p class="text-[11px] text-emerald-700 font-bold mt-2 flex items-center justify-center gap-1">
                    <i class="ti ti-circle-check text-base"></i> Foto terpilih (Klik area untuk mengganti)
                </p>
            </div>
        </div>
    </div>

    <!-- Title Input -->
    <div class="space-y-1.5">
        <label for="title" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-heading text-sm text-slate-400"></i>
            <span>Judul Warta / Artikel <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-file-text text-base"></i>
            </div>
            <input type="text" 
                   name="title" 
                   id="title" 
                   placeholder="Masukkan judul artikel yang menarik..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                   required>
        </div>
    </div>

    <!-- Grid: Unit & Kategori -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
        <!-- Unit Selection -->
        <div class="space-y-1.5">
            <label for="kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-building text-sm text-slate-400"></i>
                <span>Unit Pendidikan / Dept <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-building text-base"></i>
                </div>
                <select name="kode_unit" 
                        id="kode_unit" 
                        class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" 
                        required>
                    @foreach ($units as $u)
                        <option value="{{ $u->kode_unit }}" {{ ($default_unit ?? '') == $u->kode_unit ? 'selected' : '' }}>
                            {{ $u->nama_unit }} ({{ $u->kode_unit }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Kategori Selection -->
        <div class="space-y-1.5">
            <label for="category_id" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-category text-sm text-slate-400"></i>
                <span>Kategori Berita <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-category text-base"></i>
                </div>
                <select name="category_id" 
                        id="category_id" 
                        class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" 
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Content Summernote -->
    <div class="space-y-1.5">
        <label for="content_create" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-file-description text-sm text-slate-400"></i>
            <span>Isi Konten Berita <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="border border-slate-300 rounded-xl overflow-hidden shadow-2xs">
            <textarea name="content" id="content_create" class="form-control" placeholder="Tuliskan isi warta atau artikel lengkap..."></textarea>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitPost" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Publikasikan Post</span>
        </button>
    </div>
</form>

<script>
    function previewImageCreate(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_img_create').attr('src', e.target.result);
                $('#preview_container_create').removeClass('hidden');
                $('#preview_placeholder_create').addClass('hidden');
                clearError($('#image_create'));
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function() {
        const form = $("#formCreatePost");

        // Function to init Summernote
        function initPostSummernoteCreate() {
            if ($('#content_create').next('.note-editor').length) {
                $('#content_create').summernote('destroy');
            }

            $('#content_create').summernote({
                height: 280,
                dialogsInBody: true,
                placeholder: 'Tuliskan naskah warta, rilis berita kegiatan, atau artikel edukasi di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents) {
                        const isEmpty = $('#content_create').summernote('isEmpty');
                        if (!isEmpty) {
                            clearError($('#content_create'));
                        }
                    }
                }
            });
        }

        // Initialize immediately & after modal shown
        initPostSummernoteCreate();
        $('#mdlcreate').on('shown.bs.modal', function() {
            initPostSummernoteCreate();
        });

        // Validation Rules Map
        const validationRules = {
            'image': {
                required: true,
                message: 'Foto sampul warta wajib dipilih'
            },
            'title': { 
                required: true, 
                message: 'Judul artikel wajib diisi'
            },
            'kode_unit': { 
                required: true, 
                message: 'Unit pendidikan wajib dipilih' 
            },
            'category_id': {
                required: true,
                message: 'Kategori berita wajib dipilih'
            },
            'content': {
                required: true,
                message: 'Isi konten berita wajib diisi'
            }
        };

        window.showError = function(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
            if ($el.attr('name') === 'image') {
                $el.closest('.relative.border-2').addClass('border-rose-500 bg-rose-50/30').removeClass('border-slate-300');
            } else if ($el.attr('name') === 'content') {
                $el.closest('.border').addClass('border-rose-500 ring-2 ring-rose-500/20').removeClass('border-slate-300');
            } else {
                $el.addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
                   .removeClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
                $el.siblings('.pointer-events-none').find('i').addClass('text-rose-500').removeClass('text-slate-400');
            }
            
            $container.find('.error-msg').remove();
            $container.append(`
                <p class="error-msg text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1 animate-in fade-in duration-200">
                    <i class="ti ti-alert-circle text-xs shrink-0"></i>
                    <span>${message}</span>
                </p>
            `);
        };

        window.clearError = function(element) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
            if ($el.attr('name') === 'image') {
                $el.closest('.relative.border-2').removeClass('border-rose-500 bg-rose-50/30').addClass('border-slate-300');
            } else if ($el.attr('name') === 'content') {
                $el.closest('.border').removeClass('border-rose-500 ring-2 ring-rose-500/20').addClass('border-slate-300');
            } else {
                $el.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
                   .addClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
                $el.siblings('.pointer-events-none').find('i').removeClass('text-rose-500').addClass('text-slate-400');
            }
            
            $container.find('.error-msg').remove();
        };

        function validateSingleField(el) {
            const $el = $(el);
            const name = $el.attr('name') || $el.attr('id');
            const rule = validationRules[name];
            if (!rule) {
                clearError($el);
                return true;
            }

            if (name === 'image') {
                const hasFile = el.files && el.files.length > 0;
                if (rule.required && !hasFile) {
                    showError($el, rule.message);
                    return false;
                }
            } else if (name === 'content') {
                const isEmpty = $('#content_create').summernote('isEmpty');
                const html = $('#content_create').summernote('code');
                if (rule.required && (isEmpty || html === '<p><br></p>')) {
                    showError($el, rule.message);
                    return false;
                }
            } else {
                const val = ($el.val() || '').toString().trim();
                if (rule.required && !val) {
                    showError($el, rule.message);
                    return false;
                }
            }

            clearError($el);
            return true;
        }

        // Realtime validation trigger on input & change
        form.on('input change blur', 'input, select', function(e) {
            const $this = $(this);
            const hasError = $this.hasClass('border-rose-500') || $this.closest('.relative.border-2').hasClass('border-rose-500');
            const val = ($this.val() || '').toString().trim();
            
            if (e.type === 'blur' || val !== '' || hasError) {
                validateSingleField(this);
            }
        });

        // Form Submit Validation & Spinner
        form.on('submit', function(e) {
            let isValid = true;
            let firstInvalidEl = null;

            Object.keys(validationRules).forEach(function(fieldName) {
                const $el = form.find(`[name="${fieldName}"]`);
                if ($el.length > 0) {
                    const valid = validateSingleField($el[0]);
                    if (!valid) {
                        isValid = false;
                        if (!firstInvalidEl) {
                            firstInvalidEl = $el;
                        }
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidEl) {
                    if (firstInvalidEl.attr('name') === 'content') {
                        $('#content_create').summernote('focus');
                    } else {
                        firstInvalidEl.focus();
                    }
                }
                return false;
            }

            const submitBtn = form.find('#btnSubmitPost');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
