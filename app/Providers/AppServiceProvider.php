<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use DB;
use Illuminate\Support\Facades\Log;
use App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('run', function($attribute, $value, $parameters, $validator) {
                $tmp = explode("-", $value);

                if (count($tmp) != 2) return false;

                $tmp[0] = str_replace(".", "", $tmp[0]);

                if (!is_numeric($tmp[0])) return false;

                return dv($tmp[0]) == $tmp[1];
            });
		if (App::environment('local')) {
			DB::listen(function ($query) {
				// $query->sql
				// $query->bindings
				// $query->time
				Log::info($query->sql);
				Log::info($query->bindings);
			});
		}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
