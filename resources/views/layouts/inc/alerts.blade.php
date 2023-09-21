<script>
    $(function() {
        toastr.options.timeOut = "true";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';

        @if (session('success'))
            toastr['success']("{{ session('success') }}");
        @elseif (session('error'))
            toastr['danger']("{{ session('error') }}");
        @elseif (session('warning'))
            toastr['warning']("{{ session('warning') }}");
        @endif
    });
</script>
