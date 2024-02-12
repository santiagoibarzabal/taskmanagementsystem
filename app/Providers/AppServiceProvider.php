<?php

namespace App\Providers;

use App\Contexts\Status\Domain\Interfaces\StatusRepository;
use App\Contexts\Status\Infrastructure\MySqlStatusRepository;
use App\Contexts\Task\Domain\Interfaces\TaskRepositoryInterface;
use App\Contexts\Task\Infrastructure\Repositories\MySqlTaskRepository;
use App\Contexts\User\Domain\Interfaces\UserRepository;
use App\Contexts\User\Infrastructure\Repositories\MySqlUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(StatusRepository::class, MySqlStatusRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, MySqlTaskRepository::class);
        $this->app->bind(UserRepository::class, MySqlUserRepository::class);
    }
}
