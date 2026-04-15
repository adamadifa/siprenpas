 <!-- Core CSS -->
 <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />

 <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-semi-dark.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

 <!-- Vendors CSS -->
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
 <link rel="stylesheet"
     href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper-bundle.min.css') }}" />
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

 <!-- Page CSS -->
 <style>
     .cardswiper .swiper-wrapper .swiper-slide:first-child {
         padding-left: var(--fimobile-padding);
     }

     .cardswiper .swiper-wrapper .swiper-slide {
         width: 270px;
         padding: 0 5px 10px 15px;
     }

     .form-group {
         margin-bottom: 5px !important;
     }

     .swal2-container {
         z-index: 9999 !important;
     }

     .swal2-confirm {
         background-color: #1a6bd1 !important;
     }

     .noborder-form {
         width: 100%;
         border: 0px;
     }

     .noborder-form:focus {
         outline: none;
     }

     #users-table_filter {
         margin-bottom: 10px;
     }

     .btn-group {
         cursor: pointer;
     }

     /* Select2 Green Theme Override */
     .select2-container--default .select2-results__option--highlighted[aria-selected] {
         background-color: #1B5E20 !important;
         color: #fff !important;
     }

     .select2-container--default .select2-selection--focus {
         border-color: #1B5E20 !important;
     }

     /* Green Theme Utilities */
     .btn-primary {
         background-color: #104e30 !important;
         border-color: #104e30 !important;
     }

     .btn-primary:hover {
         background-color: #0b3d24 !important;
         border-color: #0b3d24 !important;
     }

     .text-primary {
         color: #104e30 !important;
     }

     .bg-label-primary {
         background-color: #e8f5e9 !important;
         color: #104e30 !important;
     }

     /* Ensure icon is centered and use correct green */
     .avatar.bg-label-primary {
         background-color: #e8f5e9 !important;
         display: flex !important;
         align-items: center !important;
         justify-content: center !important;
     }

     .avatar.bg-label-primary i {
         color: #104e30 !important;
         margin: 0 !important;
     }

     /* Breadcrumb Customization */
     .breadcrumb-style1 .breadcrumb-item a {
         color: #8592a3 !important;
     }

     .breadcrumb-style1 .breadcrumb-item.active {
         color: #104e30 !important;
         font-weight: 600;
     }
 </style>
