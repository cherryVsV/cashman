<?php

namespace App\Http\Controllers;

use App\Models\HistoryUsersCompany;
use App\Models\Invoice;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\ExpressCheckout;


class PaypalController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    public function expressCheckout(Request $request)
    {
        $invoice_id = Invoice::count() + 1;

        $cart = $this->getCart($request->price, $invoice_id);

        $invoice = new Invoice();
        $invoice->title = $cart['invoice_description'];
        $invoice->price = $cart['total'];
        $invoice->user_id = Auth::id();
        $invoice->save();

        $response = $this->provider->setExpressCheckout($cart, false);

        if (!$response['paypal_link']) {
            return redirect('/')->with(['code' => 'danger', 'message' => 'Something went wrong with PayPal']);
        }

        return redirect($response['paypal_link']);
    }

    private function getCart($price, $invoice_id)
    {

        return [
            'items' => [
                [
                    'name' => 'Пополнение баланса ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                    'price' => $price,
                    'qty' => 1,
                ],
            ],

            'return_url' => url('/paypal/express-checkout-success?recurring=1'),
            'subscription_desc' => 'Пополнение баланса ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
            'invoice_id' => config('paypal.invoice_prefix') . '_' . $invoice_id,
            'invoice_description' => "Транзакция #" . $invoice_id . " Пополнение баланса",
            'cancel_url' => url('/'),
            'total' => $price,
        ];
    }

    public function expressCheckoutSuccess(Request $request)
    {

        $token = $request->get('token');

        $PayerID = $request->get('PayerID');

        $response = $this->provider->getExpressCheckoutDetails($token);

        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return redirect('/')->with(['code' => 'danger', 'message' => 'Error processing PayPal payment']);
        }

        $invoice_id = explode('_', $response['INVNUM'])[1];
        $invoice = Invoice::find($invoice_id);
        $cart = $this->getCart($invoice->price, $invoice_id);

        $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
        $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

        $invoice->payment_status = $status;

        $invoice->save();

        if ($invoice->paid) {
            HistoryUsersCompany::create([
                'user_id' => Auth::id(),
                'value' => $invoice->price,
                'description' => 'Пополнение суммарного кэшбека',
                'type' => 'Начисление'
            ]);
            Notification::create([
                'title' => 'Пополнение суммарного кэшбека прошло успешно!',
                'description' => "Вы пополнили счет на $ " . $invoice->price,
                'user_id' => Auth::id(),
                'notification_type' => 'Начисление',
                'object_id' => Auth::id(),
                'object_type' => 'user'
            ]);
            return redirect('/user-profile')->with(['status' => 'success', 'message' => 'Order ' . $invoice->id . ' has been paid successfully!']);
        }

        return redirect('/user-profile')->with(['status' => 'error', 'message' => 'Error processing PayPal payment for Order ' . $invoice->id . '!']);
    }

    public function payoutCashback(Request $request)
    {
        $score = HistoryUsersCompany::where(['user_id' => Auth::id(), 'type->ru' => 'Начисление'])->sum('value');
        $offs = HistoryUsersCompany::where(['user_id' => Auth::id(), 'type->ru' => 'Списание'])->sum('value');
        if ($score - $offs < $request->amount) {
            return response()->json(['status'=>'error' ]);
        }
        $provider = \PayPal::setProvider('adaptive_payments');
        $data = [
            'receivers'  => [
                [
                    'email' => $request->to,
                    'amount' => $request->amount,
                    'primary' => false,
                ]
            ],
            'payer' => 'EACHRECEIVER', // (Optional) Describes who pays PayPal fees. Allowed values are: 'SENDER', 'PRIMARYRECEIVER', 'EACHRECEIVER' (Default), 'SECONDARYONLY'
            'return_url' => url('/'),
            'cancel_url' => url('/'),
        ];
        $response = $provider->createPayRequest($data);
        if($response['responseEnvelope']['ack'] == 'Success'){
            $invoice = new Invoice();
            $invoice->title = 'Вывод кэшбека';
            $invoice->price = $request->amount;
            $invoice->user_id = Auth::id();
            $invoice->save();

            HistoryUsersCompany::create([
                'user_id' => Auth::id(),
                'value' => $request->amount,
                'description' => 'Вывод кэшбека',
                'type' => 'Списание'
            ]);
            HistoryUsersCompany::create([
                'user_id' => Auth::id(),
                'value' => $request->amount,
                'description' => 'Вывод кэшбека',
                'type' => 'Вывод'
            ]);
            Notification::create([
                'title' => 'Вывод кэшбека',
                'description' => 'Успешный вывод суммы - $ '.$request->amount,
                'user_id' => Auth::id(),
                'notification_type' => 'Списание',
                'object_id' => Auth::id(),
                'object_type' => 'user'
            ]);
            return response()->json(['status'=>'success' ]);
        }else{
            return response()->json(['status'=>'error' ]);
        }
    }
}
