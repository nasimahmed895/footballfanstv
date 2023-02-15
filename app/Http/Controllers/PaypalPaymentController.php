<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaypalPayment;
use Omnipay\Omnipay;
use Illuminate\Support\Str;
use DataTables;

class PaypalPaymentController extends Controller
{
    private $gateway;

    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function index(Request $request)
    {
        $paypal_payments = PaypalPayment::with('user', 'subscription')->orderBy('id', 'DESC')->get();

        if ($request->ajax()) {
            return DataTables::of($paypal_payments)
                ->editColumn('subscription', function ($payment) {
                    return strtoupper($payment->subscription->name);
                })
                ->editColumn('user', function ($payment) {
                    return Str::title($payment->user->name);
                })
                ->editColumn('payment_date', function ($payment) {
                    return date('d-m-Y h:i:s', strtotime($payment->created_at));
                })
                ->addColumn('action', function($payment){

                    $action = '<div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        ' . _lang('Action') . '
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                    $action .= '<a href="' . route('paypal_payments.modal.show', $payment->id) . '" class="dropdown-item ajax-modal" data-title="' . _lang('Paypal Payment Details') . '">
                                        <i class="fas fa-eye"></i>
                                        ' . _lang('Details') . '
                                    </a>';
                    $action .= '</div>
                            </div>';
                    return $action;
                })
                ->rawColumns(['action', 'subscription', 'user', 'payment_date'])
                ->make(true);
        }

        return view('backend.paypal_payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $payment = PaypalPayment::find($id);

        if (!$request->ajax()) {
            return view('backend.paypal_payments.show', compact('payment'));
        } else {
            return view('backend.paypal_payments.modal.show', compact('payment'));
        }
    }

    public function pay(Request $request)
    {
        // dd($request->all());
        $request->session()->put('subscription', $request->subscription_id);
        try {

            $response = $this->gateway->purchase(array(
                'amount' => $request->amount,
                'subscription_id' => session('subscription'),
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            }
            else{
                return $response->getMessage();
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful())
            {
                $arr = $response->getData();
                $payment = new PaypalPayment();
                $payment->user_id = auth()->user()->id;
                $payment->subscription_id = session('subscription');
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['state'];

                $payment->save();

                return redirect()->route('index')->with('success', 'Payment is Successfull. Your Transaction Id is : ' . $arr['id'] );
                // return "Payment is Successfull. Your Transaction Id is : " . $arr['id'];

            }
            else{
                return $response->getMessage();
            }
        }
        else{
            return redirect()->route('index')->with('error', 'Payment declined!!');
        }
    }

    public function error()
    {
        return redirect()->route('index')->with('error', 'User declined the payment!');
    }
}
