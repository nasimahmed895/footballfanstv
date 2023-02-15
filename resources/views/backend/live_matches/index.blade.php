@extends('layouts.app')
@section('css-stylesheet')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-2 text-right">
            <h2 class="card-title d-none">{{ _lang('Live Matches List') }}</h2>
            <a class="btn btn-primary btn-sm" href="{{ route('live_matches.create') }}" data-title="{{ _lang('Add New') }}">
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
                                <th style=" white-space: nowrap; ">{{ _lang('Match Title') }}</th>
                                <th style=" white-space: nowrap; ">{{ _lang('Team One') }}</th>
                                <th style=" white-space: nowrap; ">{{ _lang('Team Two') }}</th>
                                <th style=" white-space: nowrap; ">{{ _lang('Time') }}</th>
                                {{-- <th style=" white-space: nowrap; ">{{ _lang('Apps') }}</th> --}}
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
            ajax: _url + "/live_matches",
            "columns": [

                {
                    data: "match_title",
                    name: "match_title",
                    className: 'details-control',
                    responsivePriority: 1
                },
                {
                    data: "team_one",
                    name: "team_one",
                    className: 'details-control',
                    responsivePriority: 1
                },
                {
                    data: "team_two",
                    name: "team_two",
                    className: "team_two"
                },
                {
                    data: "match_time",
                    name: "match_time",
                    className: "match_time"
                },
                // {
                //     data: "apps",
                //     name: "apps",
                //     className: "apps"
                // },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    className: "text-center"
                }

            ],
            responsive: true,
            "bStateSave": true,
            "bAutoWidth": false,
            "ordering": false
        });
    </script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#data-table tbody").sortable({
                update: function(event, ui) {
                    var matches = [];
                    var matchOrder = 1;
                    $("#data-table tbody > tr").each(function() {
                        var id = $(this).data('id');
                        matches.push({
                            id: id,
                            position: matchOrder
                        });
                        matchOrder++;
                    });

                    var matches = JSON.stringify(matches);

                    console.log(matches);
                    $.ajax({
                        method: "POST",
                        url: '{{ url('live_matches/reorder') }}',
                        data: {
                            _token: $('[name=csrf-token]').attr('content'),
                            matches
                        },
                        cache: false,
                        success: function(data) {


                            toast('success', data['message']);

                        }
                    });
                }
            });
        });
    </script>
@endsection
