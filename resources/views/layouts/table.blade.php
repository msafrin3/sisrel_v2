@extends('layouts.main')
@section('title', $title)
@section('content')

    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $breadcrumb)
                @isset($breadcrumb['active'])
                <li class="active">{{ $breadcrumb['label'] }}</li>
                @else
                <li><a href="{{ url($breadcrumb['link']) }}">{{ $breadcrumb['label'] }}</a></li>
                @endisset
            @endforeach
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-body">
                <form id="formfilter">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-2">
                            <input type="text" id="searchinput" class="form-control" placeholder="Search..">
                        </div>
                        @foreach($columns as $column)
                            @isset($column['filter'])
                            <div class="{{ $column['filter']['class'] }}">
                                <select class="form-control _filter" id="{{ $column['dt'] }}_filter">
                                    @foreach($column['filter']['value'] as $option)
                                    <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endisset
                        @endforeach
                        <div class="col-md-2">
                            <button type="button" id="btn_reset" class="btn btn-default">Padam carian</button>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;">
                            @isset($buttons)
                                @foreach($buttons as $button)
                                <button type="button" id="{{ $button['id'] }}" class="btn {{ $button['class'] }} pull-left" style="margin-right:10px">
                                    @isset($button['icon'])
                                    <i class="fa {{ $button['icon'] }} fa-fw"></i>
                                    @endisset
                                    {{ $button['label'] }}
                                </button>
                                @endforeach
                            @endisset
                            <input type="hidden" id="selectedrows" name="selectedrows" value="">
                            <select name="action" class="form-control pull-left" id="action" style="display:none; width: auto; min-width: 150px;">
                                <option value="" selected="selected">Select Action</option>
                                @foreach ($actions as $action)
                                    <option value="{{ $action['id'] }}">{{ $action['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="maintable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                @foreach($columns as $column)
                                <th @isset($column['width']) width="{{ $column['width'] }}" @endisset>{{ $column['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal_display">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>

@endsection

@section('footerScripts')

    <script>
        // ======= TABLE OF CONTENT ========
        // 1. datatable configuration
        // 2. buttons trigger function
        // 3. rows option trigger function
        // 4. debug datatable error
        // trigger search input
        // trigger filter change
        // reset filter
        // rows action trigger
        // =========== FUNCTIONS ===========
        // updateSelectedRows
        // delay
        // row_info
        // ============= END ===============

        $(document).ready(function() {
            // 1. datatable configuration
            var table = $("#maintable").DataTable({
                "dom": '<"top">rt<"bottom"ip><"clear">',
                'iDisplayLength': 25,
                'searching': true,
                'processing': true,
                'serverSide': true,
                'autoWidth': false,
                'ajax': {
                    'url': "{{ $datatable_route }}",
                    'type': 'POST',
                    'data': function(d) {
                        d._token = "{{ csrf_token() }}";
                        @foreach($columns as $column)
                            @isset($column['filter'])
                                d.{{ $column['dt'] }} = $("#{{ $column['dt'] }}_filter").val();
                            @endisset
                        @endforeach
                    }
                },
                'columnDefs': [{
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllPages': true,
                        'selectCallback': function() {
                            updateSelectedRows();
                        }
                    },
                    'className': 'select-checkbox',
                }],
                'select': {
                    'style': 'multi'
                },
                'columns': [
                    @foreach($columns as $column)
                    {
                        data: '{{ $column['dt'] }}', name: '{{ $column['dt'] }}' ,
                        visible : {{ isset($column['visible']) && $column['visible'] == false ? 'false' : 'true' }},
                        searchable : {{ isset($column['searchable']) ? 'false' : 'true' }} ,
                        orderable : {{ isset($column['orderable']) ? 'false' : 'true' }} ,
                    },
                    @endforeach
                ]
            });

            // 4. debug datatable error
            $('#maintable').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            }).DataTable();

            // trigger search input
            $("#searchinput").on('keyup', delay(function() {
                var input = $("#searchinput").val();
                table.search(input, true, true).draw();
            }, 500));

            // trigger filter change
            $("._filter").change(function() {
                $("#maintable").DataTable().ajax.reload(null, false);
            });

            // reset filter
            $('#btn_reset').on('click', function() {
                $('#formfilter').get(0).reset();
                var table = $('#maintable').DataTable();
                table.search('').columns().search('').draw();
            });
        });

        $.fn.dataTable.ext.errMode = 'none';

        // 2. buttons trigger function
        @isset($buttons)
            @foreach($buttons as $button)
            $("#{{ $button['id'] }}").click(function() {
                @isset($button['modal'])
                $("#modal_display").removeData('bs.modal');
                $("#modal_display").modal({ remote: "{{ $button['link'] }}" });
                $("#modal_display").modal('show');
                @else
                window.location.href = "{{ $button['link'] }}";
                @endisset
            });
            @endforeach
        @endisset

        // 3. rows option trigger function
        $(document).on('click', '.displayModal', function(){
            $('#modal_display').removeData('bs.modal');
            $('#modal_display').modal({remote: $(this).attr('data-modal_url')});
            $('#modal_display').modal('show');
        });

        // rows action trigger
        $("#action").change(function() {
            var action = $(this).val();
            var msg = '';
            @foreach($actions as $action)
                if(action == "{{ $action['id'] }}") {
                    msg = "{{ $action['msg'] }}";
                }
            @endforeach
            if(confirm(msg)) {
                $.ajax({
                    url: "{{ url($url.'/batch') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: action,
                        ids: $("#selectedrows").val().split(','),
                        row_info: row_info()
                    },
                    success: function(response) {
                        if(response.success) {
                            //
                        }
                    }
                });
            }
        });
    </script>
    <script>
        // FUNCTIONS
        function updateSelectedRows() {
            var rows_selected = $('#maintable').DataTable().column(0).checkboxes.selected();
            var rows_text = rows_selected.join(",");
            $('#selectedrows').val(rows_text);
            if (rows_text == '') $('#action').css('display', 'none');
            else $('#action').css('display', 'block');
        };

        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        function row_info() {
            var row = [];
            var data = $('#example').DataTable().rows('.selected').data();
            $.each(data, function(index, value) {
                row.push(value);
            });
            return row;
        };
    </script>

@endsection