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
        'sign-up/\d+/payment/deal-info',
        'sign-up/\d+/payment/deal-result'
    ];

    /**
     * 確定請求是否具有應通過 CSRF 驗證的 URI 。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            $pattern = '/' . str_replace('/', '\/', $except) . '/';

            $path = urldecode($request->path());

            if ((bool) preg_match($pattern, $path)) {
                return true;
            }
        }

        return parent::shouldPassThrough($request);
    }
}
