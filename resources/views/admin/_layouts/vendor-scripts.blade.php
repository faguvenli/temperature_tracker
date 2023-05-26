<!-- JAVASCRIPT -->
<script src="{{ asset('admin_assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('admin_assets/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ asset('admin_assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ asset('admin_assets/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ asset('admin_assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ asset('admin_assets/libs/datatables/plugins/buttons/buttons.min.js') }}"></script>
<script src="{{ asset('admin_assets/libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('admin_assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

@yield('script')

<!-- App js -->
<script src="{{ asset('admin_assets/js/app.min.js')}}"></script>

<script>
    @if(session()->get('success'))
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'İşlem Başarılı',
        showConfirmButton: false,
        timer: 1500
    })
    @endif
</script>
@yield('script-bottom')

@stack('stacked_scripts')
