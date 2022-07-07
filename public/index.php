<?php

use GuzzleHttp\Client;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../WeChatAPI.php';
class index
{
    protected array $response = [
        'result_code'=>0,
        'result_message' => '',
        'response_status_code' => 0,
        'response_header' => '',
        'response_body' => '',
    ];
    public function handle(): array
    {
        $req_body = file_get_contents("php://input");
        $payload = json_decode($req_body) ?? null;
        if (!$payload) {
            $this->response['result_code'] = 1;
            $this->response['result_message'] = 'Request body format error.';
            return $this->response;
        }
        if (($payload->platform ?? '') === 'wechat' && ($payload->version ?? '') === 'V5') {
            if (empty($payload->job)) {
                $this->response['result_code'] = 1;
                $this->response['result_message'] = 'Request body Missing [job]';
                return $this->response;
            }
            $wechat = new WeChatAPI();
            $response = $wechat->easywechatV5($payload->job);
            $this->response['response_body'] = $response;
            return $this->response;
        }
        if (($payload->method ?? '') != '' && ($payload->url ?? '') != '') {
            try {
                $client = new Client();
                $req_options = json_decode(json_encode($payload->req_options), 1);
                $response = $client->request($payload->method, $payload->url, $req_options);
                $this->response['response_body'] = $response->getBody()->getContents();
                $this->response['response_status_code'] = $response->getStatusCode();
                $this->response['response_header'] = $response->getHeaders();
                return $this->response;
            } catch (Throwable $exception) {
                $this->response['result_code'] = 1;
                $this->response['result_message'] = $exception->getMessage();
            }
        }
        return $this->response;
    }
}
$app = new index();
header('Content-Type:application/json');
echo json_encode($app->handle());
