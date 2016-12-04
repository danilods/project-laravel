<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CodeProjectRepositoryProvider extends ServiceProvider
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

        $this->app->bind(
            '\App\Repositories\InterfaceRepository',
            '\App\Repositories\ClientRepositoryEloquent'
            );

        $this->app->bind(
            '\App\Repositories\ProjectRepository',
            '\App\Repositories\ProjectRepositoryEloquent'
            );

         $this->app->bind(
            '\App\Repositories\ProjectNoteRepository',
            '\App\Repositories\ProjectNoteRepositoryEloquent'
            );

         $this->app->bind(
            '\App\Repositories\UserProjectRepository',
            '\App\Repositories\UserProjectRepositoryEloquent'
            );


    }
}
