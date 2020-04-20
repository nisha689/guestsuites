<script type="text/javascript" src="{{url('common/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/jquery.datetimepicker.full.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{url('admin/js/script.js')}}"></script>

<script type="text/javascript" src="{{url('common/js/jquery.multiselect.js')}}"></script>

<!--Validation Js-->
<script type="text/javascript" src="{{url('common/js/parsley.min.js')}}"></script>

<!--Mask Js-->
<script type="text/javascript" src="{{url('common/js/jquery.mask.js')}}"></script>

<!-- Tinymce -->
<script type="text/javascript" src="{{url('tinymce/js/tinymce/tinymce.js')}}"></script>

<!-- Time Pikcer -->
<script type="text/javascript" src="{{url('common/js/timepicki.js')}}"></script>

<!-- Chart -->
<script type="text/javascript" src="{{url('common/js/chart.min.js')}}"></script>


<script>
    window.baseURI = "{{ url('/') }}";
    window._token = "{{ csrf_token() }}";
    window.getStateDropDownUrl = "{{ url('/getstatedropdown') }}";
    window.getCityDropDownUrl = "{{ url('/getcitydropdown') }}";
    
	$(document).ready(function () {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 4048,
        });
    });
</script>

<!--Common Js-->
<script type="text/javascript" src="{{url('common/js/common.js')}}"></script>

@yield('javascript')