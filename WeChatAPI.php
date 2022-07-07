<?php

class WeChatAPI
{
    public function __construct()
    {
        //
    }

    public function easywechatV5($job)
    {
        $app = null;
        try {
            foreach ($job as $key=>$value) {
                if ($key === 0) {
                    $function = $value->function;
                    $param = $value->param ?? [];
                    $param = json_decode(json_encode($param), 1);
                    if (count($param) >= 1) {
                        $init_function = '\EasyWeChat\Factory::'.$function;
                        $app = call_user_func_array($init_function, $param);
                    } else {
                        return false;
                    }
                } else {
                    if (!is_null($app)) {
                        if (is_string($value)) {
                            $app = $app->$value;
                        } else {
                            $function = $value->function;
                            $param = $value->param ?? null;
                            $param = json_decode(json_encode($param), 1);
                            $app = call_user_func_array([$app,$function], $param);
                        }
                    }
                }
            }
        } catch (Throwable $exception) {
            return false;
        }
        return $app;
    }
}
