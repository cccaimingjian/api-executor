<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \GuzzleHttp\Client();


//Calling WeChat API, via easywechat SDK V5.X
try {
    $platform = '';
    $job = [];

    $platform = 'wechat';
    $job[] = [
        'function' => 'work',
        'param'=>[
            [
            'corp_id'   => 'CORP_ID_HERE',
            'agent_id'  => 'AGENT_ID_HERE',
            'secret'    => 'SECRET_HERE'
            ]
        ]
    ];
    $job[] = 'department';
    $job[] = [
        'function'=>'list',
        'param' => null
    ];
    $options = [
        'json' => [
            'platform' => $platform,
            'version' => 'V5',
            'job' => $job
        ]
    ];
    //or
    $job = [];
    $response = $client->post('THIS_EXECUTOR_URL', $options);
    $res_body =  $response->getBody()->getContents();
    $res_body = json_decode($res_body);
    $api_body = $res_body->response_body;
    var_dump($api_body);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    echo $e->getMessage();
}


//Calling Other API
try {
    $req_options = [
        'headers'=>[
            'Authorization' => 'Bearer XXXXXXX'
        ],
        'query'=>[
            'foo'=>'bar'
        ]
    ];
    $options = [
        'json'=>[
            'method'=>'GET',
            'url'=>'https://api.sandbox.ebay.com/sell/fulfillment/v1/order',
            'req_options'=>$req_options
        ]
    ];
    $response = $client->post('THIS_EXECUTOR_URL', $options);
    $demo_response = $response->getBody()->getContents();
    $res_body = json_decode($demo_response);
    $api_body = $res_body->response_body;
    var_dump($api_body);
    var_dump($res_body->response_header);
    var_dump($res_body->response_status_code);
} catch (Throwable $e) {
    echo $e->getMessage();
}
