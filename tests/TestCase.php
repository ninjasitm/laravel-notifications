<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nitm\Notifications\Models\User;
use Nitm\Content\NitmContent;
use Nitm\Content\NitmContentServiceProvider;
use Nitm\Notifications\NotificationsServiceProvider;
use Nitm\Testing\ApiTestTrait;
use Nitm\Testing\PackageTestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use ApiTestTrait, RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            NitmContentServiceProvider::class,
            NotificationsServiceProvider::class,
        ];
    }
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // $config = include $_SERVER['PWD'] . '/vendor/cloudcreativity/laravel-stripe/config/stripe.php';
        // if (!is_array($config)) {
        //     dump($_SERVER['PWD'] . '/vendor/cloudcreativity/laravel-stripe/config/stripe.php');
        //     dd($config);
        // }
        // $config['currencies'] = Arr::get($config, 'currencies', []);
        // array_push($config['currencies'], 'usd');
        // config(['stripe' => $config]);
        NitmContent::useUserModel(User::class);
    }
}