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

     /* =========================================================
        FLATPICKR ULTRA-CLEAN MODERN TAILWIND DESIGN SYSTEM
        ========================================================= */
     .flatpickr-calendar {
         z-index: 999999 !important;
         width: 320px !important;
         background: #ffffff !important;
         border: 1px solid #e2e8f0 !important;
         border-radius: 1.25rem !important;
         box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.18), 0 0 0 1px rgba(15, 23, 42, 0.04) !important;
         font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
         padding: 1rem !important;
         box-sizing: border-box !important;
         margin-top: 6px !important;
     }

     .flatpickr-calendar::before,
     .flatpickr-calendar::after {
         display: none !important;
     }

     .flatpickr-calendar.open {
         display: block !important;
         visibility: visible !important;
         opacity: 1 !important;
     }

     /* Top Month / Year Navigation Header */
     .flatpickr-months {
         display: flex !important;
         align-items: center !important;
         justify-content: space-between !important;
         position: relative !important;
         background: transparent !important;
         padding: 0 0 0.75rem 0 !important;
         border-bottom: 1px solid #f1f5f9 !important;
         margin-bottom: 0.75rem !important;
         height: auto !important;
     }

     .flatpickr-months .flatpickr-month {
         height: auto !important;
         background: transparent !important;
         color: #0f172a !important;
         fill: #0f172a !important;
         line-height: 1 !important;
         display: flex !important;
         align-items: center !important;
         justify-content: center !important;
         overflow: visible !important;
     }

     .flatpickr-current-month {
         position: static !important;
         width: auto !important;
         height: auto !important;
         display: flex !important;
         align-items: center !important;
         justify-content: center !important;
         gap: 0.35rem !important;
         padding: 0 !important;
         font-size: 0.95rem !important;
         font-weight: 800 !important;
         color: #0f172a !important;
         transform: none !important;
         left: auto !important;
     }

     .flatpickr-current-month .cur-month {
         font-weight: 800 !important;
         color: #0f172a !important;
     }

     .flatpickr-current-month .flatpickr-monthDropdown-months {
         appearance: none !important;
         -webkit-appearance: none !important;
         background: #f8fafc !important;
         border: 1px solid #e2e8f0 !important;
         border-radius: 0.5rem !important;
         color: #0f172a !important;
         font-weight: 700 !important;
         font-size: 0.875rem !important;
         padding: 0.35rem 0.65rem !important;
         cursor: pointer !important;
         outline: none !important;
         transition: all 0.15s ease !important;
     }

     .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
         background: #f1f5f9 !important;
         border-color: #cbd5e1 !important;
     }

     .flatpickr-current-month .flatpickr-monthDropdown-months option {
         background: #ffffff !important;
         color: #0f172a !important;
         font-weight: 600 !important;
     }

     .flatpickr-current-month .numInputWrapper {
         width: 72px !important;
         display: inline-flex !important;
         align-items: center !important;
     }

     .flatpickr-current-month input.cur-year {
         background: #f8fafc !important;
         border: 1px solid #e2e8f0 !important;
         border-radius: 0.5rem !important;
         color: #0f172a !important;
         font-weight: 700 !important;
         font-size: 0.875rem !important;
         padding: 0.35rem 0.5rem !important;
         text-align: center !important;
         outline: none !important;
         transition: all 0.15s ease !important;
     }

     .flatpickr-current-month input.cur-year:hover,
     .flatpickr-current-month input.cur-year:focus {
         background: #f1f5f9 !important;
         border-color: #cbd5e1 !important;
     }

     .flatpickr-current-month .numInputWrapper span.arrowUp,
     .flatpickr-current-month .numInputWrapper span.arrowDown {
         display: none !important;
     }

     /* Prev / Next Navigation Arrows */
     .flatpickr-months .flatpickr-prev-month,
     .flatpickr-months .flatpickr-next-month {
         position: static !important;
         width: 32px !important;
         height: 32px !important;
         padding: 0 !important;
         display: flex !important;
         align-items: center !important;
         justify-content: center !important;
         background: #f8fafc !important;
         border: 1px solid #e2e8f0 !important;
         border-radius: 0.5rem !important;
         color: #475569 !important;
         cursor: pointer !important;
         transition: all 0.15s ease-in-out !important;
         z-index: 10 !important;
     }

     .flatpickr-months .flatpickr-prev-month:hover,
     .flatpickr-months .flatpickr-next-month:hover {
         background: #ecfdf5 !important;
         border-color: #a7f3d0 !important;
         color: #059669 !important;
     }

     .flatpickr-months .flatpickr-prev-month svg,
     .flatpickr-months .flatpickr-next-month svg {
         width: 14px !important;
         height: 14px !important;
         stroke-width: 2 !important;
         fill: currentColor !important;
     }

     /* Days & Inner Container */
     .flatpickr-innerContainer {
         display: block !important;
         width: 100% !important;
     }

     .flatpickr-rContainer {
         width: 100% !important;
         display: block !important;
     }

     /* Weekdays Header */
     .flatpickr-weekdays {
         display: flex !important;
         width: 100% !important;
         background: transparent !important;
         margin-bottom: 0.35rem !important;
         height: auto !important;
         overflow: hidden !important;
     }

     .flatpickr-weekdaycontainer {
         display: flex !important;
         width: 100% !important;
         justify-content: space-between !important;
     }

     span.flatpickr-weekday {
         display: flex !important;
         align-items: center !important;
         justify-content: center !important;
         flex: 1 1 0% !important;
         width: 14.28% !important;
         height: 28px !important;
         color: #94a3b8 !important;
         font-size: 0.725rem !important;
         font-weight: 700 !important;
         text-transform: uppercase !important;
         letter-spacing: 0.025em !important;
         background: transparent !important;
     }

     /* Days Grid */
     .flatpickr-days {
         width: 100% !important;
         display: block !important;
     }

     .dayContainer {
         width: 100% !important;
         min-width: 100% !important;
         max-width: 100% !important;
         display: flex !important;
         flex-wrap: wrap !important;
         justify-content: space-between !important;
         box-sizing: border-box !important;
         padding: 0 !important;
         outline: 0 !important;
     }

     .flatpickr-day {
         display: inline-flex !important;
         align-items: center !important;
         justify-content: center !important;
         width: 38px !important;
         height: 38px !important;
         max-width: 38px !important;
         flex-basis: 14.28% !important;
         margin: 2px 0 !important;
         font-size: 0.8125rem !important;
         font-weight: 600 !important;
         color: #1e293b !important;
         border-radius: 0.625rem !important;
         border: 1px solid transparent !important;
         background: transparent !important;
         cursor: pointer !important;
         transition: all 0.12s ease-in-out !important;
         line-height: 1 !important;
         box-sizing: border-box !important;
     }

     .flatpickr-day:hover {
         background: #f1f5f9 !important;
         color: #0f172a !important;
         border-color: #e2e8f0 !important;
     }

     /* Today's Day */
     .flatpickr-day.today {
         border-color: #059669 !important;
         background: #ecfdf5 !important;
         color: #059669 !important;
         font-weight: 800 !important;
     }

     .flatpickr-day.today:hover {
         background: #d1fae5 !important;
         color: #047857 !important;
     }

     /* Selected Day */
     .flatpickr-day.selected,
     .flatpickr-day.startRange,
     .flatpickr-day.endRange,
     .flatpickr-day.selected:hover,
     .flatpickr-day.selected:focus {
         background: #059669 !important;
         border-color: #059669 !important;
         color: #ffffff !important;
         font-weight: 800 !important;
         box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.3) !important;
     }

     /* In Range Days */
     .flatpickr-day.inRange {
         background: #ecfdf5 !important;
         border-color: #d1fae5 !important;
         color: #065f46 !important;
         border-radius: 0 !important;
     }

     /* Outside Month Days */
     .flatpickr-day.prevMonthDay,
     .flatpickr-day.nextMonthDay {
         color: #cbd5e1 !important;
         background: transparent !important;
         font-weight: 400 !important;
     }

     .flatpickr-day.prevMonthDay:hover,
     .flatpickr-day.nextMonthDay:hover {
         background: #f8fafc !important;
         color: #94a3b8 !important;
     }

     /* Disabled Days */
     .flatpickr-day.flatpickr-disabled,
     .flatpickr-day.flatpickr-disabled:hover {
         color: #e2e8f0 !important;
         cursor: not-allowed !important;
         background: transparent !important;
     }

     .flatpickr-wrapper {
         width: 100%;
         display: block;
     }

     .swal2-container {
         z-index: 99999 !important;
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

     /* =========================================================
        SELECT2 ULTRA-CLEAN MODERN TAILWIND DESIGN SYSTEM
        ========================================================= */
     .select2-container {
         width: 100% !important;
         font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
     }

     /* Single Selection Container */
     .select2-container--default .select2-selection--single {
         position: relative !important;
         height: 42px !important;
         padding: 0.5rem 3.25rem 0.5rem 0.875rem !important;
         background-color: #ffffff !important;
         border: 1px solid #cbd5e1 !important;
         border-radius: 0.75rem !important;
         display: flex !important;
         align-items: center !important;
         transition: all 0.2s ease-in-out !important;
         box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
         outline: none !important;
     }

     /* If inside an icon wrapper or relative container with pointer-events-none icon */
     .relative .select2-container--default .select2-selection--single,
     .select2-with-icon .select2-container--default .select2-selection--single {
         padding-left: 2.6rem !important;
         padding-right: 3.25rem !important;
     }

     /* Focus & Open States */
     .select2-container--default.select2-container--open .select2-selection--single,
     .select2-container--default.select2-container--focus .select2-selection--single,
     .select2-container--default.select2-container--focus .select2-selection--multiple,
     .select2-container--default.select2-container--open .select2-selection--multiple {
         border-color: #059669 !important;
         box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.2) !important;
         outline: none !important;
     }

     /* Rendered Text */
     .select2-container--default .select2-selection--single .select2-selection__rendered {
         color: #1e293b !important;
         font-size: 0.875rem !important;
         font-weight: 600 !important;
         line-height: normal !important;
         padding-left: 0 !important;
         padding-right: 0 !important;
         display: block !important;
         width: 100% !important;
         white-space: nowrap !important;
         overflow: hidden !important;
         text-overflow: ellipsis !important;
     }

     /* Placeholder */
     .select2-container--default .select2-selection--single .select2-selection__placeholder {
         color: #94a3b8 !important;
         font-weight: 500 !important;
     }

     /* Clear Button (Badge placed cleanly to the left of the chevron arrow) */
     .select2-container--default .select2-selection--single .select2-selection__clear {
         position: absolute !important;
         right: 2.1rem !important;
         top: 50% !important;
         transform: translateY(-50%) !important;
         width: 20px !important;
         height: 20px !important;
         display: inline-flex !important;
         align-items: center !important;
         justify-content: center !important;
         font-size: 14px !important;
         font-weight: 700 !important;
         line-height: 1 !important;
         color: #94a3b8 !important;
         background-color: #f1f5f9 !important;
         border-radius: 9999px !important;
         cursor: pointer !important;
         margin: 0 !important;
         float: none !important;
         transition: all 0.15s ease-in-out !important;
         z-index: 2 !important;
     }

     .select2-container--default .select2-selection--single .select2-selection__clear:hover {
         background-color: #fee2e2 !important;
         color: #ef4444 !important;
         transform: translateY(-50%) scale(1.1) !important;
     }

     /* Custom Right Chevron Arrow */
     .select2-container--default .select2-selection--single .select2-selection__arrow {
         position: absolute !important;
         height: 100% !important;
         top: 0 !important;
         right: 0.75rem !important;
         width: 18px !important;
         display: flex !important;
         align-items: center !important;
         justify-content: center !important;
         pointer-events: none !important;
     }

     .select2-container--default .select2-selection--single .select2-selection__arrow b {
         border: none !important;
         width: 14px !important;
         height: 14px !important;
         margin: 0 !important;
         position: static !important;
         background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
         background-size: contain !important;
         background-repeat: no-repeat !important;
         background-position: center !important;
         transition: transform 0.2s ease !important;
     }

     .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
         transform: rotate(180deg) !important;
         background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23059669' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
     }

     /* Multiple Selection */
     .select2-container--default .select2-selection--multiple {
         min-height: 40px !important;
         background-color: #ffffff !important;
         border: 1px solid #cbd5e1 !important;
         border-radius: 0.75rem !important;
         padding: 0.25rem 0.5rem !important;
         box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
     }

     .select2-container--default .select2-selection--multiple .select2-selection__choice {
         background-color: #ecfdf5 !important;
         border: 1px solid #a7f3d0 !important;
         border-radius: 0.5rem !important;
         color: #065f46 !important;
         font-size: 0.75rem !important;
         font-weight: 700 !important;
         padding: 2px 8px !important;
         margin-top: 4px !important;
         margin-right: 4px !important;
     }

     .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
         color: #059669 !important;
         margin-right: 4px !important;
         border: none !important;
     }

     .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
         color: #e11d48 !important;
         background: transparent !important;
     }

     /* Dropdown Panel */
     .select2-dropdown {
         background-color: #ffffff !important;
         border: 1px solid #e2e8f0 !important;
         border-radius: 0.875rem !important;
         box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
         z-index: 9999999 !important;
         overflow: hidden !important;
         margin-top: 4px !important;
         padding: 4px !important;
     }

     /* Search Box in Dropdown */
     .select2-search--dropdown {
         padding: 6px !important;
     }

     .select2-search--dropdown .select2-search__field {
         background-color: #f8fafc !important;
         border: 1px solid #e2e8f0 !important;
         border-radius: 0.625rem !important;
         padding: 0.5rem 0.75rem !important;
         font-size: 0.8125rem !important;
         font-weight: 500 !important;
         color: #1e293b !important;
         outline: none !important;
         transition: all 0.15s ease !important;
         box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02) !important;
     }

     .select2-search--dropdown .select2-search__field:focus {
         background-color: #ffffff !important;
         border-color: #059669 !important;
         box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
     }

     /* Results List */
     .select2-results__options {
         padding: 2px !important;
         max-height: 240px !important;
     }

     .select2-results__option {
         padding: 0.5rem 0.75rem !important;
         font-size: 0.8125rem !important;
         font-weight: 500 !important;
         color: #334155 !important;
         border-radius: 0.5rem !important;
         margin-bottom: 2px !important;
         transition: all 0.1s ease !important;
         cursor: pointer !important;
     }

     /* Option Highlighted (Hover) */
     .select2-container--default .select2-results__option--highlighted[aria-selected] {
         background-color: #ecfdf5 !important;
         color: #065f46 !important;
         font-weight: 600 !important;
     }

     /* Option Selected */
     .select2-container--default .select2-results__option[aria-selected=true] {
         background-color: #059669 !important;
         color: #ffffff !important;
         font-weight: 700 !important;
     }

     /* Option Disabled */
     .select2-container--default .select2-results__option[aria-disabled=true] {
         color: #94a3b8 !important;
         cursor: not-allowed !important;
         background: transparent !important;
     }

     /* Results Message (No results found) */
     .select2-results__message {
         color: #94a3b8 !important;
         font-size: 0.75rem !important;
         font-style: italic !important;
         padding: 0.75rem !important;
         text-align: center !important;
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

     /* =========================================================
        SAKLAR / TOGGLE SWITCH COMPONENT
        ========================================================= */
     .switch-toggle {
         position: relative;
         display: inline-flex;
         align-items: center;
         cursor: pointer;
         user-select: none;
     }
     .switch-toggle-input {
         position: absolute !important;
         opacity: 0 !important;
         width: 0 !important;
         height: 0 !important;
         margin: 0 !important;
         pointer-events: none !important;
     }
     .switch-toggle-slider {
         position: relative;
         display: inline-block;
         width: 38px;
         height: 20px;
         background-color: #cbd5e1;
         border-radius: 9999px;
         transition: background-color 0.25s ease;
         box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
         flex-shrink: 0;
     }
     .switch-toggle-slider::before {
         content: "";
         position: absolute;
         height: 16px;
         width: 16px;
         left: 2px;
         bottom: 2px;
         background-color: #ffffff;
         border-radius: 50%;
         transition: transform 0.25s ease;
         box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
     }
     .switch-toggle-input:checked + .switch-toggle-slider {
         background-color: #059669 !important; /* Hijau Emerald */
     }
     .switch-toggle-input:checked + .switch-toggle-slider::before {
         transform: translateX(18px);
     }
 </style>
