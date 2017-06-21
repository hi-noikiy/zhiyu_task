<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //银联，支付宝相关
        'pay/unionpay/return',
        'pay/alipay/return',
        'pay/alipay/notify',
        //微信支付相关
        'pay/wechatpay',
        'pay/wechatpay/notify',
        //财务相关请求
        'finance/pay/wechat/notify',
        'finance/pay/alipay/notify',
        //app接口相关请求
        'api/*',
    ];
}
