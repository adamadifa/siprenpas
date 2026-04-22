@props(['id' => '', 'size' => '', 'show' => '', 'title' => '', 'icon' => 'ti ti-file-text'])
<div class="modal fade" id="{{ $id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <div class="modal-dialog {{ $size }} modal-dialog-centered modal-dialog">
        <div class="modal-content overflow-hidden">
            <div class="modal-header py-3 d-flex align-items-center justify-content-between" style="background-color: #064e3b; border-bottom: none;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px; background-color: rgba(255, 255, 255, 0.15)">
                        <i class="{{ $icon }} text-white fs-3"></i>
                    </div>
                    <h5 class="modal-title shadow-none text-white mb-0 fw-bold" id="myModalLabel18">{{ $title }}</h5>
                </div>
                <button type="button" class="btn border-0 p-0 text-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="ti ti-x fs-5"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="{{ $show }}"></div>
            </div>
        </div>
    </div>
</div>
