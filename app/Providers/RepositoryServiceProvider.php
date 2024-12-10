<?php

namespace App\Providers;

use App\Services\Repository\RepositoryFinder;
use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RepositoryFinder::class, RepositoryFinder::class);

        $this->registerRepositories();
    }

    public function boot(): void
    {

    }

    private function registerRepositories(): void
    {
        foreach (app(RepositoryFinder::class)->getContractsToRepository() as $contract => $repository) {
            $this->app->singleton($contract, $repository);
        }
    }
}
