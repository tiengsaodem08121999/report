
<script src="{{asset('flexy-bootstrap-lite-1.0.0/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('flexy-bootstrap-lite-1.0.0/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('flexy-bootstrap-lite-1.0.0/assets/js/sidebarmenu.js')}}"></script>
<script src="{{asset('flexy-bootstrap-lite-1.0.0/assets/js/app.min.js')}}"></script>
<script src="{{asset('flexy-bootstrap-lite-1.0.0/assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('flexy-bootstrap-lite-1.0.0/assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script src="{{asset('flexy-bootstrap-lite-1.0.0/assets/js/dashboard.js')}}"></script>
<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@stack('scripts')
<script>
    $(document).ready(function() {
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if(Session::has('info'))
                toastr.info("{{ Session::get('info') }}");
        @endif
    });
</script>
</body>

</html>