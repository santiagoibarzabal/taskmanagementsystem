<?php

namespace App\Providers;

use App\TaskManagementSystem\Status\Domain\Interfaces\StatusRepository;
use App\TaskManagementSystem\Status\Infrastructure\MySqlStatusRepository;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Infrastructure\Repositories\MySqlTaskRepository;
use App\TaskManagementSystem\User\Domain\Interfaces\UserRepository;
use App\TaskManagementSystem\User\Infrastructure\Repositories\MySqlUserRepository;
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
        $this->app->bind(TaskRepository::class, MySqlTaskRepository::class);
        $this->app->bind(UserRepository::class, MySqlUserRepository::class);
    }
}
