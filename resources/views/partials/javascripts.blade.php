<script src="{{ url('js/jquery.js')}}" type="text/javascript"></script>
<script src="{{ url('js/popper.min.js')}}" type="text/javascript"></script>
<script src="{{ url('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{ url('js/jquery.tablesorter.min.js')}}" type="text/javascript"></script>
<script src="{{ url('js/datepicker.min.js')}}" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 4048,
        });

        $("#riders-table").tablesorter({
            headers: {
                2: {
                    sorter: false
                },
                3: {
                    sorter: false
                },
                4: {
                    sorter: false
                },
                5: {
                    sorter: false
                }
            }
        });
    });

    window.baseURI = "{{ url('/') }}";

    /* _token */
    window._token = "{{ csrf_token() }}";
</script>

<script src="{{ url('js/common.js')}}" type="text/javascript"></script>

@yield('javascript')