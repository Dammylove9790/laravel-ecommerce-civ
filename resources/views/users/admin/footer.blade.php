
</div>
{{-- close wrapper --}}

<script>
    let locale_price = document.querySelectorAll(".localePrice");
    for(let loc = 0; loc < locale_price.length; loc++){
        locale_price[loc].innerHTML = Number(locale_price[loc].innerHTML).toLocaleString()
    }
</script>

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

@yield('js')
</body>
</html>