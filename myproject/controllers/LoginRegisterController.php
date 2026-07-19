<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\models\Otp;
use app\models\User;
use yii\base\Security;
use yii\web\Controller;
use app\models\SignupForm;
use yii\httpclient\Client;
use yii\mail\MailerInterface;

class LoginRegisterController extends Controller
{
    protected $token = '24d0cc68956ee9def1c8e8972515710f';

        public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        private readonly Security $security,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }


    public function actionIndex(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new SignupForm();
        $model->scenario = 'signup';
        if(Yii::$app->request->isPost){
            
            if($model->load(Yii::$app->request->post()) ){
                if($model->validate()){
                    $mobile = '+98' . ltrim($model->mobile , '0');
                    $user = User::find()->where(['mobile' => $mobile])->one();
                    if(!$user){
                        $user = $model->signup();
                    } 
                    $otpCode = random_int(111111 , 999999);
                    $token = Yii::$app->security->generateRandomString(60);

                    $this->sendSms([$mobile] , $otpCode);
                    $otp = new Otp;
                    $otp->user_id = $user->id;
                    $otp->token = $token;
                    $otp->opt_code = $otpCode;
                    $otp->expired_at = date('Y-m-d H:i:s', strtotime('+2 minutes'));
                    if($otp->save()){
                    }else{
                        dd($otp->errors);
                    }


                    $this->redirect(['/login-register/confirm-otp' , 'token' => $token]);

                }
            }

        }

        return $this->render('/auth/signUp' , [
            'model' =>  $model,
        ]);
    }

    public function actionConfirmOtp($token){
        $otp = Otp::find()->where(['token' => $token , 'used' => 0])->andWhere(['>' ,'expired_at' , date('Y-m-d H:i:s')])->one();
        if(!$otp){
            Yii::$app->session->setFlash('erorr' , 'ادرس وارد شده معتبر نمیباشد');
            $this->redirect('/login-register');
        }
        if(Yii::$app->request->isPost){
            if( $otp->opt_code == Yii::$app->request->post('otp')){
                $user = $otp->user;
                Yii::$app->user->login($user);
                $otp->used = 1;
                $otp->save(false);
                if($otp->user->username){
                    return $this->goHome();
                }else{
                    return $this->redirect('/userpanel/user-info/update');
                }
            }else{
                Yii::$app->session->setFlash('erorr' , 'کد وارد شده صحیح نمیباشد');
                $this->refresh();
            }
        }

        return $this->render('/auth/confirm-otp');
    }
    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function getToken(){
        $client = new Client();

        $response =
         $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://edge.ippanel.com/v1/api/acl/auth/login')
            ->addHeaders([
                'Content-Type' =>'application/json',
            ])
            ->setContent(json_encode([
                'username' => 'afradade003',
                'password' => 'hosseiny003',
            ]))
            ->send();

            $result = json_decode($response->content);
            dd($result);
            
            // if ($response->isOk) {
            //     if($result->meta->message_code == 200-1){
            //         Yii::$app->cache->set('ippanel_token' , $response->data->token , 60 * 60 * 10 );
            //     }
            // }

        }

        public function sendSms(array $recipients , $code){
            $client = new Client();

            $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://edge.ippanel.com/v1/api/send')
            ->addHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json'
            ])
            ->setContent(json_encode([
                'sending_type' => 'pattern',
                "from_number" => "+983000505",
                "code" => "1hv13p1q7t7a0zd",
                "recipients" => $recipients,
                "params" => [
                    'password' => $code
                ],
            ]))
            ->send();
            $result = json_decode($response->content);
        }

}
