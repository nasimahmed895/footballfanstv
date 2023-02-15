@extends('layouts.app')
@section('css-stylesheet')

@endsection
@section('content')

<div class="row">
    <div class="col-md-12 mb-2 text-right">
        <h2 class="card-title d-none">{{ _lang('Send Notifications List') }}</h2>
        <a class="btn btn-danger btn-sm btn-remove" href="{{ url('notifications/deleteall') }}">
            {{ _lang('Delete All') }}
        </a>
        <a class="btn btn-primary btn-sm" href="{{ route('notifications.create') }}" data-title="{{ _lang('Add New') }}">
            <i class="fas fa-plus mr-1"></i>
            {{ _lang('Add New') }}
        </a>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="data-table">
                    <thead>
                        <tr>
                            
                            <th style=" white-space: nowrap; ">{{ _lang('Title') }}</th>
                            <th style=" white-space: nowrap; ">{{ _lang('Body') }}</th>
                            <th style=" white-space: nowrap; ">{{ _lang('Body') }}</th>

                            <th class="text-center">{{ _lang('Action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-script')
<script type="text/javascript">
    $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: _url + "/notifications",
        "columns" : [

        { data : "title", name : "title", className: 'details-control', responsivePriority: 1 },
        { data : "message", name : "message", className : "message" },
        { data : "created_at", name : "created_at", className : "created_at" },
        { data : "action", name : "action", orderable : false, searchable : false, className : "text-center" }

        ],
        responsive: true,
        "bStateSave": true,
        "bAutoWidth":false, 
        "ordering": false
    });
</script>
@endsection