<?php 

namespace app\services;

use Yii;
use yii\base\component;
use yii\httpclient\Client;

class FastSmsService extends component
{
        protected $token = 'YTI0ZjVkMzctOWJlZC00ZjMyLThiM2EtOTZjYTMxM2YyYjI4NDNkYjhiY2ZhMjE5NDgzYWRjYWQzM2Y0ZjQ2ZmIyNDM=';

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