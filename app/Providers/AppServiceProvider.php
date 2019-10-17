<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        if (Schema::hasTable('categories')) {
            $categories = Category::select(['name', 'slug'])->where('category_id', null)->get();

            view()->share('categories', $categories);
        }
    }
}
