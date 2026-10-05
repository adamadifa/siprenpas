<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa]">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titlepage', 'IT Admin Dashboard') - {{ $pengaturan->nama_aplikasi ?? 'SmartHR' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tabler Icons (Local Asset & CDN Webfont) -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <!-- Flatpickr Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <!-- Summernote Rich Text Editor CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Tailwind CSS (Vite / CDN Fallback) -->
    @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Alpine.js CDN Fallback (Only when Vite is not available) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                orange: '#f97316',
                                coral: '#ea580c',
                                teal: '#0f766e',
                                darkteal: '#134e4a',
                                navy: '#0f172a',
                                green: '#10b981',
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #1e293b;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Essential Modal Engine Styles (Tailwind Compatibility & Smooth Transitions) */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1055;
            display: none;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            outline: 0;
        }
        .modal.fade {
            transition: opacity 0.15s linear;
        }
        .modal.show {
            display: block !important;
        }
        .modal.fade .modal-dialog {
            transition: transform 0.2s ease-out;
            transform: translate(0, -20px);
        }
        .modal.show .modal-dialog {
            transform: none;
        }
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100vw;
            height: 100vh;
            background-color: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
        }
        .modal-backdrop.fade {
            opacity: 0;
            transition: opacity 0.15s linear;
        }
        .modal-backdrop.show {
            opacity: 1;
        }
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 1.75rem auto;
            pointer-events: none;
            max-width: 540px;
            padding: 0 1rem;
        }
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }
        .modal-dialog-scrollable {
            height: calc(100% - 3.5rem);
        }
        .modal-dialog-scrollable .modal-content {
            max-height: 100%;
            overflow: hidden;
        }
        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
        }
        .modal-lg { max-width: 800px; }
        .modal-xl { max-width: 1140px; }
        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #ffffff;
            background-clip: padding-box;
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
            outline: 0;
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
        }

        /* =========================================================
           SUMMERNOTE RICH TEXT EDITOR - EMERALD MODERN THEME
           ========================================================= */
        .note-editor.note-frame {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.875rem !important; /* rounded-xl */
            overflow: hidden !important;
            background-color: #ffffff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
        }
        .note-editor.note-frame.codeview {
            border-color: #059669 !important;
        }
        .note-editor.note-frame:focus-within {
            border-color: #059669 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
        }
        .note-toolbar {
            background-color: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 8px 10px !important;
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
        }
        .note-btn-group {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            padding: 2px !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02) !important;
        }
        .note-btn {
            border: none !important;
            background: transparent !important;
            color: #475569 !important;
            padding: 5px 8px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            border-radius: 0.375rem !important;
            transition: all 0.15s ease !important;
        }
        .note-btn:hover, .note-btn:focus, .note-btn.active {
            background-color: #ecfdf5 !important;
            color: #047857 !important;
        }
        .note-editable {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
            font-size: 0.875rem !important; /* text-sm */
            line-height: 1.625 !important;
            color: #1e293b !important;
            padding: 14px 16px !important;
            min-height: 220px !important;
            background-color: #ffffff !important;
        }
        .note-placeholder {
            color: #94a3b8 !important;
            font-size: 0.875rem !important;
            padding: 14px 16px !important;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
        }
        .note-statusbar {
            background-color: #f8fafc !important;
            border-top: 1px solid #f1f5f9 !important;
        }
        .note-modal .modal-dialog {
            z-index: 1060 !important;
        }
        .note-dropdown-menu {
            border-radius: 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
            padding: 6px !important;
            z-index: 1060 !important;
        }
        .note-dropdown-item {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            border-radius: 0.375rem !important;
            padding: 6px 10px !important;
            color: #334155 !important;
        }
        .note-dropdown-item:hover {
            background-color: #ecfdf5 !important;
            color: #047857 !important;
        }

        /* Simple & Clean Tooltips */
        .tooltip {
            position: absolute;
            z-index: 1080;
            display: block;
            margin: 0;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-style: normal;
            font-weight: 600;
            line-height: 1.25;
            text-align: left;
            text-decoration: none;
            font-size: 0.725rem;
            word-wrap: break-word;
            opacity: 0;
            transition: opacity 0.15s ease-in-out;
            pointer-events: none;
        }
        .tooltip.show {
            opacity: 1;
        }
        .tooltip .tooltip-inner {
            max-width: 220px;
            padding: 0.35rem 0.6rem;
            color: #ffffff;
            text-align: center;
            background-color: #0f172a;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }
        .tooltip .tooltip-arrow {
            position: absolute;
            display: block;
            width: 0.8rem;
            height: 0.4rem;
        }
        .tooltip .tooltip-arrow::before {
            position: absolute;
            content: "";
            border-color: transparent;
            border-style: solid;
        }
        .bs-tooltip-top .tooltip-arrow, .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow {
            bottom: -0.4rem;
        }
        .bs-tooltip-top .tooltip-arrow::before, .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before {
            top: 0;
            border-width: 0.4rem 0.4rem 0;
            border-top-color: #0f172a;
        }
        .bs-tooltip-bottom .tooltip-arrow, .bs-tooltip-auto[data-popper-placement^=bottom] .tooltip-arrow {
            top: -0.4rem;
        }
        .bs-tooltip-bottom .tooltip-arrow::before, .bs-tooltip-auto[data-popper-placement^=bottom] .tooltip-arrow::before {
            bottom: 0;
            border-width: 0 0.4rem 0.4rem;
            border-bottom-color: #0f172a;
        }
        .bs-tooltip-start .tooltip-arrow, .bs-tooltip-auto[data-popper-placement^=left] .tooltip-arrow {
            right: -0.4rem;
            width: 0.4rem;
            height: 0.8rem;
        }
        .bs-tooltip-start .tooltip-arrow::before, .bs-tooltip-auto[data-popper-placement^=left] .tooltip-arrow::before {
            left: 0;
            border-width: 0.4rem 0 0.4rem 0.4rem;
            border-left-color: #0f172a;
        }
        .bs-tooltip-end .tooltip-arrow, .bs-tooltip-auto[data-popper-placement^=right] .tooltip-arrow {
            left: -0.4rem;
            width: 0.4rem;
            height: 0.8rem;
        }
        .bs-tooltip-end .tooltip-arrow::before, .bs-tooltip-auto[data-popper-placement^=right] .tooltip-arrow::before {
            right: 0;
            border-width: 0.4rem 0.4rem 0.4rem 0;
            border-right-color: #0f172a;
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
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
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
            min-height: 42px !important;
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
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.15), 0 8px 10px -6px rgba(15, 23, 42, 0.1) !important;
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

        /* Results Message */
        .select2-results__message {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            font-style: italic !important;
            padding: 0.75rem !important;
            text-align: center !important;
        }

        /* =========================================================
           MODERN TOGGLE SAKLAR COMPONENT (iOS / Material Style)
           ========================================================= */
        .switch-toggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            margin: 0;
        }
        .switch-toggle-input {
            position: absolute !important;
            opacity: 0 !important;
            width: 0 !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
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
            transform: translateX(18px) !important;
        }

        /* =========================================================
           HANDCRAFTED MICRO-ANIMATED ALERT SYSTEM (Clean & Crisp, No Blur)
           ========================================================= */
        .swal2-popup.swal-modern-popup {
            border-radius: 1.25rem !important;
            padding: 1.75rem 1.5rem 1.5rem !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.2), 0 0 0 1px rgba(15, 23, 42, 0.04) !important;
        }
        .swal2-popup.swal-modern-popup.swal2-show {
            animation: swalPopupSpring 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }
        .swal2-popup.swal-modern-popup.swal2-hide {
            animation: swalPopupHide 0.15s ease-in forwards !important;
        }
        @keyframes swalPopupSpring {
            0% {
                opacity: 0;
                transform: scale(0.94) translateY(8px);
            }
            70% {
                opacity: 1;
                transform: scale(1.01) translateY(-1px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        @keyframes swalPopupHide {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            100% {
                opacity: 0;
                transform: scale(0.94);
            }
        }

        .swal2-popup.swal-modern-toast {
            border-radius: 0.75rem !important;
            padding: 0.65rem 1rem !important;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.15), 0 0 0 1px rgba(15, 23, 42, 0.05) !important;
        }
        .swal2-popup.swal-modern-toast.swal2-show {
            animation: swalToastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }
        .swal2-popup.swal-modern-toast.swal2-hide {
            animation: swalToastSlideOut 0.2s ease-in forwards !important;
        }
        @keyframes swalToastSlideIn {
            0% {
                opacity: 0;
                transform: translateX(30px) scale(0.96);
            }
            70% {
                opacity: 1;
                transform: translateX(-2px) scale(1.01);
            }
            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }
        @keyframes swalToastSlideOut {
            0% {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateX(30px) scale(0.96);
            }
        }

        /* SVG Micro-Animated Icon Badge */
        .swal-icon-wrapper {
            position: relative;
            width: 64px;
            height: 64px;
            margin: 0.25rem auto 1.25rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .swal-icon-body {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            transform: scale(0.6);
            opacity: 0;
            animation: swalIconPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.05s forwards;
        }
        @keyframes swalIconPop {
            0% { transform: scale(0.6); opacity: 0; }
            70% { transform: scale(1.06); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Ambient Wave Ripple (Single Natural Halo) */
        .swal-halo-ring {
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            z-index: 1;
            opacity: 0;
            pointer-events: none;
            animation: swalHaloPulse 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.15s forwards;
        }
        @keyframes swalHaloPulse {
            0% {
                transform: scale(0.85);
                opacity: 0.8;
            }
            50% {
                opacity: 0.35;
            }
            100% {
                transform: scale(1.45);
                opacity: 0;
            }
        }

        .swal-icon-svg {
            width: 38px;
            height: 38px;
            display: block;
        }

        /* Success Stroke Drawing */
        .swal-icon-success .swal-icon-body {
            background: #ecfdf5;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
        }
        .swal-icon-success .swal-halo-ring {
            border: 2px solid #10b981;
        }
        .swal-icon-success .swal-svg-circle {
            stroke: #10b981;
            stroke-dasharray: 152;
            stroke-dashoffset: 152;
            animation: swalStrokeCircle 0.42s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .swal-icon-success .swal-svg-check {
            stroke: #059669;
            stroke-dasharray: 42;
            stroke-dashoffset: 42;
            animation: swalStrokeCheck 0.32s cubic-bezier(0.25, 1, 0.5, 1) 0.22s forwards;
        }

        /* Error Stroke & Wobble */
        .swal-icon-error .swal-icon-body {
            background: #fff1f2;
            box-shadow: 0 4px 16px rgba(225, 29, 72, 0.2);
            animation: swalIconPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.05s forwards, swalShake 0.4s ease-in-out 0.25s;
        }
        .swal-icon-error .swal-halo-ring {
            border: 2px solid #f43f5e;
        }
        .swal-icon-error .swal-svg-circle {
            stroke: #f43f5e;
            stroke-dasharray: 152;
            stroke-dashoffset: 152;
            animation: swalStrokeCircle 0.42s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .swal-icon-error .swal-svg-cross1 {
            stroke: #e11d48;
            stroke-dasharray: 32;
            stroke-dashoffset: 32;
            animation: swalStrokeCheck 0.25s cubic-bezier(0.25, 1, 0.5, 1) 0.18s forwards;
        }
        .swal-icon-error .swal-svg-cross2 {
            stroke: #e11d48;
            stroke-dasharray: 32;
            stroke-dashoffset: 32;
            animation: swalStrokeCheck 0.25s cubic-bezier(0.25, 1, 0.5, 1) 0.3s forwards;
        }
        @keyframes swalShake {
            0%, 100% { transform: translateX(0) scale(1); }
            20%, 60% { transform: translateX(-4px) scale(1); }
            40%, 80% { transform: translateX(4px) scale(1); }
        }

        /* Warning */
        .swal-icon-warning .swal-icon-body {
            background: #fffbeb;
            box-shadow: 0 4px 16px rgba(217, 119, 6, 0.2);
        }
        .swal-icon-warning .swal-halo-ring {
            border: 2px solid #f59e0b;
        }
        .swal-icon-warning .swal-svg-circle {
            stroke: #f59e0b;
            stroke-dasharray: 152;
            stroke-dashoffset: 152;
            animation: swalStrokeCircle 0.42s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .swal-icon-warning .swal-svg-warn-line {
            stroke: #d97706;
            stroke-dasharray: 24;
            stroke-dashoffset: 24;
            animation: swalStrokeCheck 0.28s cubic-bezier(0.25, 1, 0.5, 1) 0.2s forwards;
        }
        .swal-icon-warning .swal-svg-warn-dot {
            fill: #d97706;
            transform-origin: 28px 38px;
            transform: scale(0);
            animation: swalDotPop 0.22s cubic-bezier(0.34, 1.56, 0.64, 1) 0.35s forwards;
        }

        /* Info */
        .swal-icon-info .swal-icon-body {
            background: #f0f9ff;
            box-shadow: 0 4px 16px rgba(2, 132, 199, 0.2);
        }
        .swal-icon-info .swal-halo-ring {
            border: 2px solid #0ea5e9;
        }
        .swal-icon-info .swal-svg-circle {
            stroke: #0ea5e9;
            stroke-dasharray: 152;
            stroke-dashoffset: 152;
            animation: swalStrokeCircle 0.42s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .swal-icon-info .swal-svg-info-line {
            stroke: #0284c7;
            stroke-dasharray: 24;
            stroke-dashoffset: 24;
            animation: swalStrokeCheck 0.28s cubic-bezier(0.25, 1, 0.5, 1) 0.2s forwards;
        }
        .swal-icon-info .swal-svg-info-dot {
            fill: #0284c7;
            transform-origin: 28px 18px;
            transform: scale(0);
            animation: swalDotPop 0.22s cubic-bezier(0.34, 1.56, 0.64, 1) 0.35s forwards;
        }

        @keyframes swalStrokeCircle {
            to { stroke-dashoffset: 0; }
        }
        @keyframes swalStrokeCheck {
            to { stroke-dashoffset: 0; }
        }
        @keyframes swalDotPop {
            to { transform: scale(1); }
        }

        /* Default SweetAlert2 Component Beautification (Crisp & Solid, No Blur) */
        .swal2-container {
            z-index: 9999999 !important;
        }
        .swal2-container.swal2-backdrop-show {
            background: rgba(15, 23, 42, 0.45) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        .swal2-popup {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            border-radius: 1.25rem !important;
        }
        .swal2-actions {
            margin-top: 1.25rem !important;
            gap: 0.5rem !important;
        }
        .swal2-confirm, .swal2-cancel {
            font-weight: 700 !important;
            font-size: 0.8125rem !important;
            border-radius: 0.75rem !important;
            padding: 0.55rem 1.25rem !important;
            transition: all 0.15s ease-in-out !important;
            box-shadow: none !important;
        }
        .swal2-confirm:active, .swal2-cancel:active {
            transform: scale(0.97) !important;
        }
    </style>

    @stack('styles')
</head>

<body class="h-full antialiased text-slate-800 bg-[#f8f9fa]" x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">

    <div class="min-h-screen flex flex-col">
        @if (session()->has('impersonator_id'))
            <!-- ================= IMPERSONATION / VIEW AS ACTIVE FLOATING TOP BANNER ================= -->
            <div class="sticky top-0 z-50 bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 text-white px-4 py-2.5 shadow-md shadow-amber-950/20 flex flex-wrap items-center justify-between gap-3 border-b border-amber-400/40 backdrop-blur-md">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center text-white shrink-0 border border-white/30 animate-pulse">
                        <i class="ti ti-eye-check text-base"></i>
                    </div>
                    <div class="text-xs">
                        <span class="font-extrabold uppercase tracking-wider bg-white/20 px-2 py-0.5 rounded text-[10px] mr-1.5 border border-white/25">
                            Mode View As Aktif
                        </span>
                        <span class="font-medium text-amber-50">
                            Anda sedang melihat sistem sebagai: <b class="text-white underline decoration-white/60 underline-offset-2">{{ auth()->user()->name }}</b> ({{ auth()->user()->email ?? auth()->user()->id_user ?? 'User' }})
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('users.stop-impersonate') }}" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white text-orange-700 hover:bg-amber-50 active:scale-95 text-xs font-bold shadow-sm transition duration-150 cursor-pointer border border-white/60">
                        <i class="ti ti-door-exit text-sm text-orange-600"></i>
                        <span>Keluar Mode View As</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Top Navbar -->
        @include('layouts.navbar')

        <div class="flex flex-1 relative">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Mobile Backdrop -->
            <div x-show="mobileSidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileSidebarOpen = false" 
                 class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden">
            </div>

            <!-- Main Content Area -->
            <main :class="sidebarOpen ? 'lg:pl-[260px]' : 'lg:pl-0'" class="flex-1 w-full transition-all duration-300 ease-in-out flex flex-col justify-between min-h-[calc(100vh-4rem)]">
                <div class="p-4 sm:p-6 lg:p-7 max-w-[1600px] w-full mx-auto">
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="px-6 py-4 border-t border-slate-200/80 bg-white text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-2 mt-auto">
                    <div>
                        2014-2026 © <span class="font-bold text-slate-700">{{ $pengaturan->nama_aplikasi ?? 'SmartHR' }}</span>.
                    </div>
                    <div class="flex items-center gap-4 text-slate-400">
                        <span>Designed & Developed By <b class="text-slate-600">Dreams</b></span>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Core JS (jQuery, Bootstrap 5, SweetAlert2 & Flatpickr) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/jquery.maskMoney.js') }}"></script>
    <!-- Summernote Rich Text Editor JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        // Flatpickr jQuery Bridge & Global Initializer
        if (typeof window.flatpickr !== 'undefined') {
            if (flatpickr.l10ns && flatpickr.l10ns.id) {
                flatpickr.localize(flatpickr.l10ns.id);
            }
            if (typeof $.fn.flatpickr === 'undefined') {
                $.fn.flatpickr = function(config) {
                    return this.each(function() {
                        flatpickr(this, config || {});
                    });
                };
            }
        }

        // Global Helper to Initialize Flatpickr Inputs (prevents native autocomplete overlay)
        window.initFlatpickr = function(context) {
            if (typeof flatpickr === 'undefined') return;
            const $scope = context ? $(context) : $(document);
            $scope.find('.flatpickr-date').each(function() {
                // Ensure native autocomplete does not pop over flatpickr calendar
                $(this).attr('autocomplete', 'off');

                if (!this._flatpickr) {
                    flatpickr(this, {
                        dateFormat: "Y-m-d",
                        allowInput: true,
                        disableMobile: "true"
                    });
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function () {
            window.initFlatpickr();

            // Auto-initialize Flatpickr in Bootstrap Modals when shown
            $(document).on('shown.bs.modal', '.modal', function () {
                window.initFlatpickr(this);
            });

            // Auto-initialize Flatpickr whenever AJAX finishes loading content (e.g. #loadmodal.load)
            $(document).ajaxComplete(function() {
                window.initFlatpickr();
            });
            // Bootstrap Tooltips Initialization
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        animation: true,
                        boundary: 'clippingParents'
                    });
                });
            }

            // Centralized multi-modal stacking & backdrop handler
            $(document).on('show.bs.modal', '.modal', function () {
                const visibleModals = $('.modal.show').length;
                const zIndex = 1055 + (20 * visibleModals);
                $(this).css('z-index', zIndex);
            });

            $(document).on('shown.bs.modal', '.modal', function () {
                $('.modal-backdrop').each(function (index) {
                    $(this).css('z-index', 1050 + (20 * index));
                });
            });

            $(document).on('hidden.bs.modal', '.modal', function () {
                if ($('.modal.show').length > 0) {
                    $('body').addClass('modal-open');
                }
            });
        });
    </script>

    {{-- Global Alert Helpers (Toast & Modal) --}}
    <script>
        window.showSuccessToast = function(message, timer = 2000) {
            if (typeof Swal === 'undefined') return;
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: timer || 2000,
                timerProgressBar: false,
                customClass: {
                    popup: 'swal-modern-toast'
                }
            });
            Toast.fire({
                html: `
                    <div class="flex items-center gap-2.5 text-left py-0.5">
                        <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200/80">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 leading-tight">${message || 'Operasi berhasil!'}</span>
                    </div>
                `
            });
        };

        window.showSuccessAlert = function(message, title, timer = 2000) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center text-center pt-1 pb-1">
                        <div class="swal-icon-wrapper swal-icon-success">
                            <div class="swal-halo-ring"></div>
                            <div class="swal-icon-body">
                                <svg class="swal-icon-svg" viewBox="0 0 56 56">
                                    <circle class="swal-svg-circle" cx="28" cy="28" r="24" fill="none" />
                                    <path class="swal-svg-check" d="M16 28.5 L24.5 37 L40 19" fill="none" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">${title || 'Aksi Berhasil!'}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 font-normal mt-1.5 leading-relaxed max-w-[320px]">${message || 'Operasi telah berhasil dilakukan.'}</p>
                    </div>
                `,
                timer: timer || 2000,
                timerProgressBar: false,
                showConfirmButton: false,
                allowOutsideClick: true,
                backdrop: `rgba(15, 23, 42, 0.45)`,
                didOpen: (popup) => {
                    $(popup).css('cursor', 'pointer').on('click', function() {
                        Swal.close();
                    });
                },
                customClass: {
                    popup: 'swal-modern-popup'
                }
            });
        };

        window.showErrorAlert = function(message, title) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center text-center pt-1 pb-1">
                        <div class="swal-icon-wrapper swal-icon-error">
                            <div class="swal-halo-ring"></div>
                            <div class="swal-icon-body">
                                <svg class="swal-icon-svg" viewBox="0 0 56 56">
                                    <circle class="swal-svg-circle" cx="28" cy="28" r="24" fill="none" />
                                    <path class="swal-svg-cross1" d="M18 18 L38 38" fill="none" />
                                    <path class="swal-svg-cross2" d="M38 18 L18 38" fill="none" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">${title || 'Terjadi Kesalahan!'}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 font-normal mt-1.5 leading-relaxed max-w-[320px]">${message || 'Gagal memproses permintaan.'}</p>
                    </div>
                `,
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'Tutup',
                backdrop: `rgba(15, 23, 42, 0.45)`,
                customClass: {
                    popup: 'swal-modern-popup',
                    confirmButton: 'px-6 py-2.5 bg-rose-600 hover:bg-rose-700 active:scale-[0.98] text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer mt-3'
                }
            });
        };

        window.showWarningAlert = function(message, title) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center text-center pt-1 pb-1">
                        <div class="swal-icon-wrapper swal-icon-warning">
                            <div class="swal-halo-ring"></div>
                            <div class="swal-icon-body">
                                <svg class="swal-icon-svg" viewBox="0 0 56 56">
                                    <circle class="swal-svg-circle" cx="28" cy="28" r="24" fill="none" />
                                    <line class="swal-svg-warn-line" x1="28" y1="16" x2="28" y2="30" stroke-width="3.5" stroke-linecap="round" fill="none" />
                                    <circle class="swal-svg-warn-dot" cx="28" cy="38" r="2.5" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">${title || 'Perhatian'}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 font-normal mt-1.5 leading-relaxed max-w-[320px]">${message || 'Harap periksa kembali tindakan Anda.'}</p>
                    </div>
                `,
                confirmButtonColor: '#d97706',
                confirmButtonText: 'Mengerti',
                backdrop: `rgba(15, 23, 42, 0.45)`,
                customClass: {
                    popup: 'swal-modern-popup',
                    confirmButton: 'px-6 py-2.5 bg-amber-600 hover:bg-amber-700 active:scale-[0.98] text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer mt-3'
                }
            });
        };

        window.showInfoAlert = function(message, title) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center text-center pt-1 pb-1">
                        <div class="swal-icon-wrapper swal-icon-info">
                            <div class="swal-halo-ring"></div>
                            <div class="swal-icon-body">
                                <svg class="swal-icon-svg" viewBox="0 0 56 56">
                                    <circle class="swal-svg-circle" cx="28" cy="28" r="24" fill="none" />
                                    <circle class="swal-svg-info-dot" cx="28" cy="18" r="2.5" />
                                    <line class="swal-svg-info-line" x1="28" y1="26" x2="28" y2="40" stroke-width="3.5" stroke-linecap="round" fill="none" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">${title || 'Informasi'}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 font-normal mt-1.5 leading-relaxed max-w-[320px]">${message || ''}</p>
                    </div>
                `,
                confirmButtonColor: '#0284c7',
                confirmButtonText: 'Tutup',
                backdrop: `rgba(15, 23, 42, 0.45)`,
                customClass: {
                    popup: 'swal-modern-popup',
                    confirmButton: 'px-6 py-2.5 bg-sky-600 hover:bg-sky-700 active:scale-[0.98] text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer mt-3'
                }
            });
        };
    </script>

    {{-- Global Flash Messages (SweetAlert2) --}}
    @if ($message = Session::get('success'))
        <script>
            $(function() {
                window.showSuccessAlert("{{ $message }}", "Aksi Berhasil!");
            });
        </script>
    @endif

    @if ($message = Session::get('error'))
        <script>
            $(function() {
                window.showErrorAlert("{{ $message }}", "Terjadi Kesalahan!");
            });
        </script>
    @endif

    @if ($message = Session::get('warning'))
        <script>
            $(function() {
                window.showWarningAlert("{{ $message }}", "Perhatian");
            });
        </script>
    @endif

    @if ($message = Session::get('info'))
        <script>
            $(function() {
                window.showInfoAlert("{{ $message }}", "Informasi");
            });
        </script>
    @endif

    {{-- Validation Errors Alert --}}
    @if ($errors->any())
        <script>
            $(function() {
                Swal.fire({
                    html: `
                        <div class="flex flex-col items-center text-center pt-1 pb-1">
                            <div class="swal-icon-wrapper swal-icon-error">
                                <div class="swal-halo-ring"></div>
                                <div class="swal-icon-body">
                                    <svg class="swal-icon-svg" viewBox="0 0 56 56">
                                        <circle class="swal-svg-circle" cx="28" cy="28" r="24" fill="none" />
                                        <path class="swal-svg-cross1" d="M18 18 L38 38" fill="none" />
                                        <path class="swal-svg-cross2" d="M38 18 L18 38" fill="none" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Gagal Menyimpan Data</h3>
                            <div class="text-left text-xs sm:text-sm text-slate-700 space-y-2 mt-3 p-3.5 bg-rose-50/80 border border-rose-200/80 rounded-xl w-full">
                                <p class="font-bold text-rose-700 flex items-center gap-1.5 mb-1">
                                    <i class="ti ti-alert-circle text-base shrink-0"></i>
                                    <span>Periksa kesalahan input berikut:</span>
                                </p>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 font-medium text-xs">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    `,
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Tutup',
                    backdrop: `rgba(15, 23, 42, 0.45)`,
                    customClass: {
                        popup: 'swal-modern-popup',
                        confirmButton: 'px-6 py-2.5 bg-rose-600 hover:bg-rose-700 active:scale-[0.98] text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer mt-3'
                    }
                });
            });
        </script>
    @endif

    @stack('scripts')
    @stack('myscript')
</body>

</html>
