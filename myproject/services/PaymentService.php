<?php 

namespace app\services;

use Yii;
use yii\helpers\Url;
use App\Models\Market\OnlinePayment;
use Illuminate\Support\Facades\Config;


class PaymentService {

  public function zarinPal($amount , $order_id , $payment_id){
    


      $merchentID = '7e854bb2-38d1-11e8-85ac-005056a205be';

      $data = [
        'merchant_id' => $merchentID,
        'amount' => (int)$amount,
        'callback_url' => Url::to(['/payment/payment-callback' , 'order_id' => $order_id ,'payment_id' => $payment_id] , true),
        'description' => 'Transaction description.',
        'currency' => "IRT",
      ];

      $jsonData = json_encode($data);



      $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/request.json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',  
  CURLOPT_POSTFIELDS => $jsonData,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$response = json_decode($response , true);
// dd($response);
  $code = $response['data']['code'] ?? $response['errors']['code'];
  $message = $response['data']['message'] ?? $response['errors']['message'];

  return ['code' => $code , 'message' => $message , 'response' => $response];

  }

  public function zarinPalVerify($amount , $payment){


    $merchentID = '7e854bb2-38d1-11e8-85ac-005056a205be';

    $authority = Yii::$app->request->get('Authority');

      $data = [
        'authority' => $authority,
        'merchant_id' => $merchentID,
        'amount' => (int)$amount,
      ];

      $jsonData = json_encode($data);


      
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$jsonData,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Accept: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $response = json_decode($response, true);


      $payment->bank_second_responce = json_encode($response);
      $payment->gateway = 'zarinpal';
      $payment->save();



      

      if(count($response['errors']) == 0){
        $code = $response['data']['code'];
      }else{
        $code = $response['errors']['code'];
      }


      $message = $this->resultCodes($code);

          return ['message' => $message];

    }





    function resultCodes($code)
    {
        switch ($code) {
            case 100:
                return ['success' , "پرداخت شما با موفقیت تایید شد"];

            case -9:
                return ['error' , "خطای اعتبار سنجی"];

            case -10:
                return ['error' ,"ای پی یا مرچنت كد پذیرنده صحیح نیست."];

            case -11:
                return ['error' ,"مرچنت کد فعال نیست، پذیرنده مشکل خود را به امور مشتریان زرین‌پال ارجاع دهد."];

            case -12:
                return ['error' ,"تلاش بیش از دفعات مجاز در یک بازه زمانی کوتاه به امور مشتریان زرین پال اطلاع دهید"];

            case -15:
                return ['error' ,"درگاه پرداخت به حالت تعلیق در آمده است، پذیرنده مشکل خود را به امور مشتریان زرین‌پال ارجاع دهد."];

            case -16:
                return ['error' ,"سطح تایید پذیرنده پایین تر از سطح نقره ای است."];

            case -17:
                return ['error' ,"محدودیت پذیرنده در سطح آبی"];

            case -18:
                return ['error' ,"امکان استف کد درگاه اختصاصی خود بر روی سایت یا جای دیگری را ندارید"];

            case -19:
                return ['error' ,"امکان ایجاد تراکنش برای این ترمینال امکان پذیر نیست"];

            case -30:
                return ['error' ,"پذیرنده اجازه دسترسی به سرویس تسویه اشتراکی شناور را ندارد."];

            case -31:
                return ['error' ,"حساب بانکی تسویه را به پنل اضافه کنید. مقادیر وارد شده برای تسهیم درست نیست. پذیرنده جهت استفاده از خدمات سرویس تسویه اشتراکی شناور، باید حساب بانکی معتبری به پنل کاربری خود اضافه نماید."];
            case -32:
                return ['error' ,"مبلغ وارد شده از مبلغ کل تراکنش بیشتر است. "];

            case -33:
                return ['error' ,"درصدهای وارد شده صحیح نیست."];

            case -34:
                return ['error' ,"مبلغ وارد شده از مبلغ کل تراکنش بیشتر است."];

            case -35:
                return ['error' ,"تعداد افراد دریافت کننده تسهیم بیش از حد مجاز است."];

            case -36:
                return ['error' , "حداقل مبلغ جهت تسهیم باید ۱۰۰۰۰ ریال باشد"];

            case -37:
                return ['error' ," یک یا چند شماره شبای وارد شده برای تسهیم از سمت بانک غیر فعال است. "];

            case -38:
                return ['error' ," خطا٬عدم تعریف صحیح شبا٬لطفا دقایقی دیگر تلاش کنید."];

            case -39:
                return ['error' ," خطایی رخ داده است به امور مشتریان زرین پال اطلاع دهید"];

            case -41:
                return ['error' ," حداکثر مبلغ پرداختی ۱۰۰ میلیون تومان است"];

            case -50:
                return ['error' ," مبلغ پرداخت شده با مقدار مبلغ ارسالی در متد وریفای متفاوت است."];

            case -51:
                return ['error' ," پرداخت انجام نشد"];

            case -52:
                return ['error' ," خطای غیر منتظره‌ای رخ داده است. پذیرنده مشکل خود را به امور مشتریان زرین‌پال ارجاع دهد."];

            case -53:
                return ['error' ," پرداخت متعلق به این مرچنت کد نیست."];

            case -54:
                return ['error' ,"اتوریتی نامعتبر است."];

            case -55:
                return ['error' ,"تراکنش مورد نظر یافت نشد"];

            case -60:
                return ['error' ,"امکان ریورس کردن تراکنش با بانک وجود ندارد"];

            case -61:
                return ['error' ,"تراکنش موفق نیست یا قبلا ریورس شده است"];

            case -62:
                return ['error' ,"آی پی درگاه ست نشده است"];

            case -63:
                return ['error' ,"حداکثر زمان (۳۰ دقیقه) برای ریورس کردن این تراکنش منقضی شده است"];

            case 101:
                return ['error' ,"تراکنش وریفای شده است."];


            default:
                return ['error' ,"تراکنش وریفای شده است."];

        }
    }


}