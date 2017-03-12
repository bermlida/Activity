<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Payum\Core\GatewayInterface;
use Payum\Core\PayumBuilder;
use PayumTW\Allpay\AllpayGatewayFactory;

class AllpayPayumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('allpay.payum', function() {
            $payum = (new PayumBuilder)
                        ->addDefaultStorages()
                        ->addGatewayFactory('allpay', function(array $config, $coreGatewayFactory) {
                            return new AllpayGatewayFactory($config, $coreGatewayFactory);
                        })
                        ->addGateway('allpay', [
                            'factory'     => 'allpay',
                            'MerchantID'  => '2000132',
                            'HashKey'     => '5294y06JbISpM5x9',
                            'HashIV'      => 'v77hoKGq4kWxNNIS',
                            'sandbox'     => true,
                        ])
                        ->getPayum();
            
            return $payum->getGateway('allpay');
        });
    }
}
