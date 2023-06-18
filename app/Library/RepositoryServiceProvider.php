<?php namespace Velent;

use Velent\Repositories\User\UserEloquent;
use Velent\Repositories\User\UserInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {

        $bindings = [
            [UserInterface::class, UserEloquent::class],
        ];
        $this->bindImplementations($bindings);
    }

    public function bindImplementations($bindings)
    {
        foreach ($bindings as $binding) {
            $this->app->bind($binding[0], $binding[1]);
        }

    }
}
