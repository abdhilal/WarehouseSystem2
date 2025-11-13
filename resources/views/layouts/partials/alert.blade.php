{{-- رسالة نجاح --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-check icli"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif

{{-- رسالة الخطأ --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-xmark icli"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif

{{-- رسالة تنبيه --}}
@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-exclamation icli"></i>
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif

{{-- رسالة معلومات --}}
@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-info icli"></i>
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif
    <style>
        .alert {
            position: fixed ;
            top: 10px ;
            left: 90%;
            min-width: 300px;
            transform: translateX(-50%) ;
            z-index: 9999 ;
        }
    </style>
@push('scripts')
    <script>
        $(document).ready(function() {
            // إظهار الرسائل بعد تحميل الصفحة
            $('.alert').delay(5000).fadeOut('slow');
        });
    </script>
@endpush