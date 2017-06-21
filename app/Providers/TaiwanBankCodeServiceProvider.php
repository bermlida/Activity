<?php

namespace App\Providers;

use TaiwanBankCode;
use Illuminate\Support\ServiceProvider;

class TaiwanBankCodeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('TaiwanBankCode', function ($app) {
            $taiwan_bank_code = new TaiwanBankCode();

            $taiwan_bank_code->updateXmlFromFisc();

            $taiwan_bank_code->convertJsonFromXml();

            return $taiwan_bank_code;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
