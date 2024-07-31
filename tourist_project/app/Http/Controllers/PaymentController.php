<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\User;
use App\Notifications\NotificationTourDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentMomo;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function methodPayment(Request $request)
    {
        // dd($request->input('payment_method'));
        $method = $request->input('payment_method');
        switch ($method) {
            case 'vnpay_payment':
                return $this->createPayment($request);
            case 'momo_payment':
                return $this->qrPaymentMomo($request);
        }
    }

    public function createPayment(Request $request)
    {
        // dd($request->all());
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "41OO5FW2"; //Mã website tại VNPAY
        $vnp_HashSecret = "VUKS80LSN2EKF7ZDW03IP1ZP9PRRQSUN"; //Chuỗi bí mật
        // dd($request->amount);
        $vnp_TxnRef = Str::random(15); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
        $vnp_OrderInfo = $request->payment_content;
        $vnp_OrderType = 'thanh toán';
        $amountString = str_replace(',', '', $request->amount);
        $vnp_Amount = (int)$amountString * 100;
        // dd($vnp_Amount);
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bank;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            // 'vnp_ReturnDepositurl' => $vnp_ReturnDepositurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // dd($vnp_Url);
        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        if (session()->has('customer') && $request->vnp_ResponseCode == '00') {
            try {
                DB::beginTransaction();
                $vnpayData = $request->all();
                $dataOrder = session()->get('customer');
                // dd($vnpayData);

                $tour = Tour::find($dataOrder['customer']['tour_id']);
                $tour->update(
                    [
                        'participants' => $dataOrder['customer']['participants'],
                    ]
                );

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'tour_id' => $dataOrder['customer']['tour_id'],
                    'email' => $dataOrder['customer']['email'],
                    'phone' => $dataOrder['customer']['phone'],
                    'total_price' => $dataOrder['customer']['total_price'],
                    'total_deposit' => $dataOrder['customer']['total_deposit'],
                    'total_adult' => $dataOrder['customer']['total_adult'],
                    'total_child' => $dataOrder['customer']['total_child'],
                    'total_infant' => $dataOrder['customer']['total_infant'],
                    'total_person' => $dataOrder['customer']['total_person'],
                    'o_status' => $dataOrder['customer']['status'],
                ]);

                $payment_vnpay = Payment::create([
                    'p_user_id' => auth()->id(),
                    'p_order_id' => $order->id,
                    'p_price' => $vnpayData['vnp_Amount'] * 0.01,
                    'p_note' => $vnpayData['vnp_OrderInfo'],
                    'p_vnpay_response_code' => $vnpayData['vnp_ResponseCode'],
                    'p_code_vnpay' => $vnpayData['vnp_TransactionNo'],
                    'p_code_bank' => $vnpayData['vnp_BankTranNo'],
                    'p_time' => $vnpayData['vnp_PayDate']
                ]);

                $tran = Transaction::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                    'p_vnpay_id' => $payment_vnpay->id,
                    'total_tran' => $dataOrder['customer']['total_price'],
                ]);
                $order = Order::where('id', $order->id)->first();

                $order->notify(new NotificationTourDetail($order, $tran));
                DB::commit();
                return view('payment.return_vnpay', compact('vnpayData'))->with('ok', 'Thanh toán thành công!');
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::info('Lỗi', $exception->getMessage());
            }
        } else {
            return redirect()->route('home')->with('no', 'Xảy ra lỗi không thể thanh toán');
        }
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        // dd($ch);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post

        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        // echo ($result);

        $jsonResult = json_decode($result, true);
        // dd($jsonResult);
        if ($jsonResult['payUrl'] != null)
            header('Location: ' . $jsonResult['payUrl']);

        // dd($jsonResult['payUrl']);
        return $result;
    }
    public function qrPaymentMomo(Request $request)
    {
        $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
        $accessKey = 'F8BBA842ECF85';
        $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
        $orderInfo =   $request->payment_content;
        $partnerCode = 'MOMO';
        $redirectUrl = route('momo.return');
        $ipnUrl = 'https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b';
        $amount = str_replace(',', '', $request->amount);
        $orderId = time() . "";
        $requestId = time() . "";
        $extraData = '';
        $requestType = 'captureWallet';
        $partnerName = 'MoMo Payment';
        $storeId = 'Test Store';
        $orderGroupId = '';
        $autoCapture = True;
        $lang = 'vi';
        // dd($accessKey);
        if (!empty($_POST)) {
            $requestId = time() . '';
            $extraData = "";
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                'storeId' => 'MomoTestStore',
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'requestType' => $requestType,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'redirectUrl' => $redirectUrl,
                'autoCapture' => $autoCapture,
                'extraData' => $extraData,
                'orderGroupId' => $orderGroupId,
                'signature' => $signature
            );
            // dd($amount);
            $result = $this->execPostRequest($endpoint, json_encode($data));

            $jsonResult = json_decode($result, true);

            return redirect($jsonResult['payUrl']);
        }
    }

    public function momoReturn(Request $request)
    {

        if (session()->has('customer') && $request->resultCode == '0') {
            try {
                DB::beginTransaction();
                $momoData = $request->all();
                // dd($momoData);
                $dataOrder = session()->get('customer');

                $tour = Tour::find($dataOrder['customer']['tour_id']);
                $tour->update(
                    [
                        'participants' => $dataOrder['customer']['participants'],
                    ]
                );
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'tour_id' => $dataOrder['customer']['tour_id'],
                    'email' => $dataOrder['customer']['email'],
                    'phone' => $dataOrder['customer']['phone'],
                    'total_price' => $dataOrder['customer']['total_price'],
                    'total_deposit' => $dataOrder['customer']['total_deposit'],
                    'total_adult' => $dataOrder['customer']['total_adult'],
                    'total_child' => $dataOrder['customer']['total_child'],
                    'total_infant' => $dataOrder['customer']['total_infant'],
                    'total_person' => $dataOrder['customer']['total_person'],
                    'o_status' => $dataOrder['customer']['status']
                ]);


                $payment_momo = PaymentMomo::create([
                    'm_user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'm_order_id' => $momoData['orderId'],
                    'm_price' => $momoData['amount'],
                    'm_note' => $momoData['orderInfo'],
                    'm_code_trans' => $momoData['transId'],
                    'm_pay_type' => $momoData['payType'],
                ]);

                $tran = Transaction::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                    'p_momo_id' => $payment_momo->id,
                    'total_tran' => $dataOrder['customer']['total_price'],
                ]);


                $order = Order::where('id', $order->id)->first();

                $order->notify(new NotificationTourDetail($order, $tran));

                DB::commit();
                return view('payment.return_momo', compact('momoData'));
            } catch (\Exception $exception) {
                DB::rollBack();
                // Log::info('Lỗi', $exception->getMessage());
            }
        } else {
            return redirect()->route('home')->with('no', 'Xảy ra lỗi không thể thanh toán');
        }
    }

    public function createDepositPayment(Request $request, $orderId)
    {
        // dd($request->all());
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('deposit.return', $orderId);
        $vnp_TmnCode = "41OO5FW2"; //Mã website tại VNPAY
        $vnp_HashSecret = "VUKS80LSN2EKF7ZDW03IP1ZP9PRRQSUN"; //Chuỗi bí mật
        // dd($request->amount);
        $vnp_TxnRef = Str::random(15); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
        $vnp_OrderInfo = $request->payment_content;
        $vnp_OrderType = 'thanh toán';
        $vnp_Amount = str_replace(',', '', $request->amount) * 100;
        // dd($vnp_Amount);
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bank;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            // 'vnp_ReturnDepositurl' => $vnp_ReturnDepositurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // dd($vnp_Url);
        return redirect($vnp_Url);
    }
    public function depositVnpayReturn(Request $request, $orderId)
    {
        $vnpayData = $request->all();

        $order = Order::find($orderId);
        // dd($vnpayData['vnp_Amount'] * 0.01 * 2);
        $order->update([
            'total_price' => $vnpayData['vnp_Amount'] * 0.01 * 2
        ]);
        $paymentVnpayDeposite = Payment::create([
            'p_user_id' => auth()->id(),
            'p_order_id' => $orderId,
            'p_price' => $vnpayData['vnp_Amount'] * 0.01,
            'p_note' => $vnpayData['vnp_OrderInfo'],
            'p_vnpay_response_code' => $vnpayData['vnp_ResponseCode'],
            'p_code_vnpay' => $vnpayData['vnp_TransactionNo'],
            'p_code_bank' => $vnpayData['vnp_BankTranNo'],
            'p_time' => $vnpayData['vnp_PayDate']
        ]);
        Transaction::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'p_vnpay_id' => $paymentVnpayDeposite->id,
            'total_tran' => $vnpayData['vnp_Amount'] * 0.01,
        ]);
        return view('payment.return_vnpay', compact('vnpayData'));
    }
}
