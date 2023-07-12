<?php

namespace App\Http\Controllers;

use App\Facades\Common;
use App\Http\Livewire\Page;
use App\Models\Application;
use App\Models\Borrowed;
use App\Models\Fee;
use App\Models\Semester;
use App\Models\Course;
use App\Models\Student;
use App\Facades\Util;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PayPal\Api\Amount;
use PayPal\Api\Capture;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Refund;
use PayPal\Api\RefundRequest;

class GatewayController extends Controller
{

    protected $apiContext;
    protected $paypal_client_id;
    protected $paypal_client_secret;
    protected $paypal_sandbox;

    //
    function __construct(Request $request)
    {
        $this->paypal_client_id = Util::fallBack(Common::getSiteSettings("PAYPAL_CLIENT_ID"), config("app.PAYPAL_CLIENT_ID"));
        $this->paypal_client_secret = Util::fallBack(Common::getSiteSettings("PAYPAL_CLIENT_SECRET"), config("app.PAYPAL_CLIENT_SECRET"));
        $this->paypal_sandbox = Util::fallBack(Common::getSiteSettings("enable_PAYPAL_SANDBOX"), config("app.PAYPAL_SANDBOX"));
        if (empty($this->paypal_client_id) && empty($this->paypal_client_secret) && empty($this->paypal_sandbox)) {
            return json_encode(["message" => __("common.paypal_config_err"),
                "title" => __("common.err"), "type" => "error"]);
        }
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->paypal_client_id,
                $this->paypal_client_secret
            )
        );
        if (!empty($this->paypal_sandbox) && $this->paypal_sandbox) {
            $this->apiContext->setConfig(
                array(
                    'mode' => 'live'
                )
            );
        }
    }

    public function refundFine()
    {
        if (!request()->has("payment_id")) {
            return response()->json(["error" => __("common.data_missing")]);
        }
        $send_to = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
        if (!empty($this->paypal_sandbox) && $this->paypal_sandbox) {
            $send_to = "https://api.paypal.com/v1/oauth2/token";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $send_to);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Language: en_US'
        ));
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypal_client_id . ':' . $this->paypal_client_secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $json = json_decode($output);
        $token = $json->access_token;
        $header = Array(
            "Content-Type: application/json",
            "Authorization: Bearer $token",
        );
        $p_obj = \App\Models\Payment::find(\request()->get("payment_id"));
        if ($p_obj && $p_obj->refund_url) {
            $ch = curl_init($p_obj->refund_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            if (\request()->has("amount") && is_numeric(request()->get("amount"))) {
                $post = '{"amount": {"total": "' . request()->get("amount") . '","currency": "' . Common::getSiteSettings("currency_code", "USD") . '"}}';
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $res = json_decode(curl_exec($ch));
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if (isset($res->state)) {
                $state = $res->state;
            } else {
                $state = NULL; // otherwise, set to NULL
            }
            $ref_status = $state;


            $mode = "refund";
            if ($state == 'completed') {
                // the refund was successful
                if ($p_obj) {
                    $p_obj->refund_amount = intval($res->amount->total);
                    $p_obj->refund_status = strval($state);
                    $p_obj->refund_id = strval($res->id);
                    $p_obj->save();
                    $parent_pay_id = $res->parent_payment;
                    $sale_id = $res->sale_id;
                    $invoice_id = $res->id;
                    $amt_refund = strval($res->amount->total);
                    return view("templates.payment_receipt", compact("mode", "ref_status", "parent_pay_id", "sale_id", "invoice_id", "amt_refund", "res"));
                }

            } else {
                if ($res) {
                    // the refund failed
                    $errorName = $res->name; // ex. 'Transaction Refused.'
                    $errorReason = $res->message; // ex. 'The requested transaction has already been fully refunded.'
                    return view("templates.payment_receipt", compact("mode", "errorName", "errorReason"));
                } else {
                    return response()->json(["status" => __("common.critical_msg")]);
                }

            }
        }

    }

    public function finePay(Request $request)
    {
        if (Session::has("current_req")) {
            $tmp_req = Session::get("current_req");
            $r_amount = $tmp_req["late_fee"];
            $r_item_name = __("common.late_fine_msg") . " | " . $tmp_req["book_name"];
            $r_currency_code = Common::getSiteSettings("currency_code");
            $r_order_id = Util::generateRandomString(15);
            //Session::put('my_request', $tmp_req);
            //Session::save();
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');
            $amount = new \PayPal\Api\Amount();
            $amount->setTotal($r_amount);
            $amount->setCurrency($r_currency_code);
            $item_name = trim($r_item_name);
            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount)->setDescription($item_name)->setInvoiceNumber($r_order_id);
            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl(config("app.APP_URL") . "/fine-receipt?do=success")
                ->setCancelUrl(config("app.APP_URL") . "/fine-receipt?do=cancel");
            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);
            //dd($this->apiContext);
            try {
                $payment->create($this->apiContext);
                header("Location: " . $payment->getApprovalLink());
                exit;
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                // This will print the detailed information on the exception.
                //REALLY HELPFUL FOR DEBUGGING
                echo $ex->getData();
                die();
            }
        } else {
            abort(405);
        }
    }

    public function fineReceipt(Request $request)
    {
        $message = "";
        $user_id = "";
        $mode = "payment_receipt";
        $req = Session::get('current_req');
        if (isset($_GET["do"]) && $_GET["do"] == "success") {
            $paymentId = $_GET['paymentId'];
            $payment = Payment::get($paymentId, $this->apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($_GET['PayerID']);
            $payment_obj = new \App\Models\Payment();
            try {
                $payment->execute($execution, $this->apiContext);
                try {
                    $payment = Payment::get($paymentId, $this->apiContext);
                    $payer_name = $payment->payer->payer_info->first_name . ' ' . $payment->payer->payer_info->last_name;
                    $payer_id = $payment->payer->payer_info->payer_id;
                    $payer_email = $payment->payer->payer_info->email;
                    $payer_phone = $payment->payer->payer_info->phone;
                    $payment_status = $payment->payer->status;
                    //$country_code = $payment->payer->payer_info->country_code;
                    $payed_amount = $payment->transactions[0]->amount->total;
                    $currency = $payment->transactions[0]->amount->currency;
                    $invoice_id = $payment->transactions[0]->invoice_number;
                    $payment_mode = "PayPal";
                    $payment_id = $payment->id; //payment_id
                    $refund_url = $payment->transactions[0]->related_resources[0]->sale->links[1]->href;
                    $payment_obj->invoice_no = $invoice_id;
                    $payment_obj->currency = $currency;
                    $payment_obj->payer_id = $payer_id;
                    $payment_obj->payer_phone = $payer_phone;
                    $payment_obj->payer_name = $payer_name;
                    $payment_obj->payer_email = $payer_email;
                    $payment_obj->refund_url = $refund_url;
                    $payment_obj->payment_status = $payment_status;
                    $payment_obj->payer_id = $payer_id;
                    $payment_obj->payed_amount = $payed_amount;
                    $payment_obj->payment_mode = $payment_mode;
                    $payment_obj->payment_id = $payment_id;
                    $payment_obj->raw_frontend_request = serialize($req);
                    //$req = serialize($req);
                    //$req["uid"] = 2;
                    $payment_obj->uid = $req["uid"] ? $req["uid"] : null;
                    $user_id = $req["uid"] ? $req["uid"] : null;
                    $payment_obj->course_id = isset($req["uid"]) ? (new User)->get_course($req["uid"]) : null;
                    $payment_obj->course_year_id = isset($req["uid"]) ? (new User)->get_year($req["uid"]) : null;
                    $payment_obj->working_year = Common::getWorkingYear();
                    $payment_obj->borrowed_id = isset($req["borr_id"]) ? $req["borr_id"] : null;
                    $payment_obj->paid_for = 'fine';
                    if (!\App\Models\Payment::where("payment_id", $payment_id)->exists()) {
                        $payment_obj->save();
                    }
                    $order_status = "Success";
                } catch (Exception $ex) {
                    $order_status = "Error";
                    //return json_encode(["message" => $ex->getMessage(), "title" => "Error", "type" => "errror"]);
                }
            } catch (Exception $ex) {
                $order_status = "Error";
                //return json_encode(["message" => $ex->getMessage(), "title" => "Error", "type" => "errror"]);
            }
        } else {
            // We are in cancel section
            $order_status = "Aborted";
        }

        //$homepage = $_ENV["APP_URL"];
        //$student = Student::where("roll_no", $req["roll_no"])->where("std_id", $req["std_id"])
        //     ->where("div_id", $req["div_id"])->where("working_year", $common::$working_year)->first();
        $req["payment_mode"] = 0;
        if ($order_status == "Success") {
            $req["payment_mode"] = 1;
            Util::flashToOldSession($req);
            return view("templates.payment_receipt", compact("payer_name", "payer_id", "payer_email", "payer_phone", "payment_status",
                "payed_amount", "currency", "invoice_id", "payment_mode", "payment_id", "order_status", "message", "user_id", "req", "mode"
            ));
        } else {
            $message = __("common.there_was_an_error");
            if ($order_status == "Aborted") {
                $message = __("common.trans_aborted");
            }
            Session::flash("error-message", $message);
            //$request->flash($req);
            Util::flashToOldSession($req);
        }
        return view("templates.payment_receipt", compact("order_status", "message", "req", "mode"
        ));
    }


}
