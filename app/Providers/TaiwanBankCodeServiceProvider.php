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

            ob_start();

            $taiwan_bank_code->updateXmlFromFisc();

            $taiwan_bank_code->convertJsonFromXml();

            ob_end_clean();

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
