@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-2 text-right">
            <h2 class="card-title d-none">{{ _lang('Paypal Payments List') }}</h2>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="data-table">
                        <thead>
                            <tr>

                                <th>{{ _lang('User') }}</th>
                                <th>{{ _lang('Subscription') }}</th>
                                <th>{{ _lang('Payment ID') }}</th>
                                <th>{{ _lang('Amount($)') }}</th>
                                <th>{{ _lang('Payment Date') }}</th>

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
            ajax: _url + "/paypal-payments/index",
            "columns": [

                {
                    data: "user",
                    name: "user",
                    className: "user"
                },
                {
                    data: "subscription",
                    name: "subscription",
                    className: "subscription text-center"
                },
                {
                    data: "payment_id",
                    name: "payment_id",
                    className: "payment_id text-center"
                },
                {
                    data: "amount",
                    name: "amount",
                    className: "amount text-center"
                },
                {
                    data: "payment_date",
                    name: "payment_date",
                    className: "payment_date text-center"
                },
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
@endsection
