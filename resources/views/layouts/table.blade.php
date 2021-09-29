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
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-2">
                            <input type="text" id="searchinput" class="form-control" placeholder="Search..">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control _filter" id="w_filter">
                                <option value="">All User</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-default">Clear Search</button>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;">
                            @isset($buttons)
                                @foreach($buttons as $button)
                                <button type="button" id="{{ $button['id'] }}" class="btn {{ $button['class'] }}">{{ $button['label'] }}</button>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="maintable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                @foreach($columns as $column)
                                <th>{{ $column['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('footerScripts')

    <script>
        $(document).ready(function() {
            var table = $("#maintable").DataTable({
                "dom": '<"top">rt<"bottom"ip><"clear">',
                'iDisplayLength': 25,
                'searching': false,
                'processing': true,
                'serverSide': true,
                'autoWidth': false,
                'ajax': {
                    'url': "{{ $datatable_route }}",
                    'type': 'POST',
                    'data': function(d) {
                        d._token = "{{ csrf_token() }}";
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
                    }
                }],
                'select': {
                    'style': 'multi'
                },
                'columns': [
                    @foreach($columns as $column)
                    {
                        data: "{{ $column['dt'] }}",
                        name: "{{ $column['dt'] }}"
                    },
                    @endforeach
                ]
            });
        });

        $.fn.dataTable.ext.errMode = 'none';

        // $('#maintable').on('error.dt', function(e, settings, techNote, message) {
        //     console.log('An error has been reported by DataTables: ', message);
        // }).DataTable();

        function updateSelectedRows() {
            var rows_selected = $('#maintable').DataTable().column(0).checkboxes.selected();
            var rows_text = rows_selected.join(",");
            // $('#selectedrows').val(rows_text);
            // if (rows_text == '') $('#action').css('display', 'none');
            // else $('#action').css('display', 'block');
        };
    </script>

@endsection