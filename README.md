# API-Executor
API调用器
## 背景
调用第三方系统的API时，有些系统（比如微信）需要设置可信IP；或者某些系统会限制1个客户使用多个IP（即多端）调用。   
本项目部署到一台服务器A，其他地方（B、C、D)调用第三方API时，
不要直接在B、C、D调用第三方API，而是调用部署在A的本项目，只让A去调用API，解决IP限制、多端调用导致先前的调用凭证失效等问题。

## 用法
### 部署本项目
用你喜欢的方式部署，
### 调用
1. 调用微信API  
（目前只包含微信）  
请求体：
```json
{
    "platform":"wechat",
    "version":"V5",
    "job":[
        {
            "function":"work",
            "param":[
                {
                "corp_id":"ww12345678",
                "agent_id":"agent_id",
                "secret":"secret"
                }
            ]
        },
        "department",
        {
            "function":"list",
            "param":[
                2
            ]
        }
    ]
}
```
说明：请求使用json格式交互，主要分3块，分别为"platform"，"version"，"job"。  

|  请求体参数   | 类型  |                  示例                   |
|:--------:|:---:|:-------------------------------------:|
| platform | 字符串 |                wechat                 |
| version  | 字符串 |                  V5                   |
|   job    | 数组  |       ```["department",{}]  ```       |
| job里面的对象 | 对象  | ```{"function":"list",param:[2]}  ``` |
2. 调用其他API
```json
{
    "method":"GET",
    "url":"https://XXXXXX",
    "req_options":{
        "headers":{
          "Authorization":"Bearer XXXXXX",
          "Accept":"application/json", 
          "Accept-Charset":"utf-8",
          "Accept-Encoding":"application/gzip"
        },
        "query":{
            "foo":"bar"
        },
        "json":{
            "key":"val"
        },
      "http_errors":false
    }
}
```
说明：请求使用json格式交互，使用GuzzleHttp\client()发出请求。请求体主要分3块，分别为"method"，"url"，"req_options"。

|    请求体参数    | 类型  |                           示例                           |
|:-----------:|:---:|:------------------------------------------------------:|
|   method    | 字符串 |                          GET                           |
|     url     | 字符串 | https://api.sandbox.ebay.com/sell/fulfillment/v1/order |
| req_options | 对象  |    GuzzleHttp\client()->request()  <br/>的options参数     |
## License

MIT
