<?php

namespace NetLinker\WideStore\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\Browser;
use NetLinker\FairQueue\HorizonManager;
use NetLinker\FairQueue\Queues\QueueConfiguration;
use NetLinker\FairQueue\Sections\Horizons\Models\Horizon;
use NetLinker\FairQueue\Sections\Queues\Models\Queue;
use NetLinker\FairQueue\Sections\Supervisors\Models\Supervisor;
use NetLinker\LeadAllegro\Sections\Accounts\Models\Account;
use NetLinker\LeadAllegro\Sections\Applications\Models\Application;
use NetLinker\WideStore\Sections\Relations\Jobs\SaveRelatedAuctionsJob;
use NetLinker\WideStore\Sections\Relations\Jobs\SearchRelationsProductsJob;
use NetLinker\WideStore\Sections\Relations\Models\Relation;
use NetLinker\WideStore\Tests\Stubs\Owner;
use NetLinker\WideStore\Tests\Stubs\User;

class WatchBrowser extends BrowserTestCase
{


    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/netlinker/fair-queue/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/netlinker/lead-allegro/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->withFactories(__DIR__ . '/database/factories');
        $this->withFactories(__DIR__ . '/../vendor/netlinker/fair-queue/database/factories');
        $this->loadLaravelMigrations();

        Artisan::call('cache:clear');
        Redis::command('flushdb');
    }

    /**
     * Refresh the application instance.
     *
     * @return void
     */
    protected function refreshApplication()
    {
        parent::refreshApplication();

        if (Schema::hasTable('users_test')) {
            Auth::login(User::all()->first());

            Event::listen('NetLinker\LeadAllegro\Sections\Accounts\Events\TokenBundleDownloaded*', function ($eventName, array $data) {

                $tokenBundle = $data[0]->tokenBundle;

                dump('save' . json_encode($tokenBundle));

                TestHelper::setEnvironmentValue([
                    'ALLEGRO_ACCESS_TOKEN' => (string) $tokenBundle->getAccessToken(),
                    'ALLEGRO_REFRESH_TOKEN' =>(string) $tokenBundle->getRefreshToken()
                ], __DIR__ . '/../.env');
            });
        }

    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function watch()
    {
        $owner = factory(Owner::class)->create();
        factory(User::class)->create(['owner_uuid' => $owner->uuid,]);
        Auth::login(User::all()->first());

        $this->browse(function (Browser $browser) {
            TestHelper::maximizeBrowserToScreen($browser);
            $browser->visit('wide-store/settings');
            TestHelper::browserWatch($browser, false);
        });


        $this->assertTrue(true);
    }
}
