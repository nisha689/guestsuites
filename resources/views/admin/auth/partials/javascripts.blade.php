<script type="text/javascript" src="{{url('common/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('admin/js/script.js')}}"></script>

<!--Validation Js-->
<script type="text/javascript" src="{{url('common/js/parsley.min.js')}}"></script>

<!--Mask Js-->
<script type="text/javascript" src="{{url('common/js/jquery.mask.js')}}"></script>

<script>
    window.baseURI = "{{ url('/') }}";
    window._token = "{{ csrf_token() }}";
</script>

<!--Common Js-->
<script type="text/javascript" src="{{url('common/js/common.js')}}"></script>

@yield('javascript')