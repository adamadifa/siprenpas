(function () {
    // Tambahkan CSS untuk animasi spin jika belum ada
    if (!document.querySelector('#pengumuman-spin-style')) {
        const style = document.createElement('style');
        style.id = 'pengumuman-spin-style';
        style.textContent = `
            .btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }
            .btn.disabled {
                pointer-events: none;
            }
            .ti-spin {
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }

    const formPengumuman = document.querySelector('#formPengumuman');
    // Form validation for Add new record
    if (formPengumuman) {
        const btnSubmit = document.querySelector('#btnSubmit');
        const fv = FormValidation.formValidation(formPengumuman, {
            fields: {
                judul: {
                    validators: {
                        notEmpty: {
                            message: 'Judul Pengumuman Harus Diisi'
                        },
                        stringLength: {
                            max: 255,
                            message: 'Judul Pengumuman Maksimal 255 Karakter'
                        }
                    }
                },
                kategori_id: {
                    validators: {
                        notEmpty: {
                            message: 'Kategori Harus Dipilih'
                        }
                    }
                },
                tanggal: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal Harus Diisi'
                        }
                    }
                },
                isi: {
                    validators: {
                        notEmpty: {
                            message: 'Isi Pengumuman Harus Diisi'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.mb-3'
                }),
                submitButton: new FormValidation.plugins.SubmitButton({
                    text: {
                        submit: '<i class="ti ti-send me-1"></i>Submit',
                        submitting: '<i class="ti ti-loader ti-spin me-1"></i>Menyimpan...'
                    }
                }),
                defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            },
            init: instance => {
                instance.on('plugins.message.placed', function (e) {
                    if (e.element.parentElement.classList.contains('input-group')) {
                        e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                    }
                });
            }
        });


    }
})();
