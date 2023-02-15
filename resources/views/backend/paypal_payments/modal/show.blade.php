<table class="table table-bordered">
    <tr>
        <td>{{ _lang('User') }}</td>
        <td>{{ $payment->user->name }}</td>
    </tr>
    <tr>
        <td>{{ _lang('Subscription') }}</td>
        <td>{{ $payment->subscription->name }}</td>
    </tr>
    <tr>
        <td>{{ _lang('Payment ID') }}</td>
        <td>{{ $payment->payment_id }}</td>
    </tr>
    <tr>
        <td>{{ _lang('Amount') }}</td>
        <td>{{ $payment->amount }}$</td>
    </tr>
    <tr>
        <td>{{ _lang('Payer ID') }}</td>
        <td>{{ $payment->payer_id }}</td>
    </tr>
    <tr>
        <td>{{ _lang('Payment Email') }}</td>
        <td>{{ $payment->payer_email }}</td>
    </tr>
    <tr>
        <td>{{ _lang('Payment Status') }}</td>
        <td><span class="badge badge-success">{{ \Illuminate\Support\Str::title($payment->payment_status) }}</span></td>
    </tr>
    <tr>
        <td>{{ _lang('Date') }}</td>
        <td>{{ $payment->created_at }}</td>
    </tr>
</table>
