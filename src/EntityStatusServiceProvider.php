<?php

namespace Larangular\EntityStatus;

use Larangular\EntityStatus\Models\EntityStatus;
use Larangular\EntityStatus\Observers\EntityStatusObserver;
use Larangular\Installable\{Contracts\HasInstallable, Contracts\Installable, Installer\Installer};
use Larangular\Installable\Support\{InstallableServiceProvider as ServiceProvider, PublisableGroups};

class EntityStatusServiceProvider extends ServiceProvider implements HasInstallable {

    protected $defer = false;

    public function boot(): void {
        EntityStatus::observe(EntityStatusObserver::class);
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom([
            __DIR__ . '/database/migrations',
            database_path('migrations/entity-status'),
        ]);

        $this->declareMigrationGlobal();
        $this->declareMigrationEntityStatus();
    }

    public function installer(): Installable {
        return new Installer(__CLASS__);
    }

    private function declareMigrationGlobal(): void {
        $this->declareMigration([
            'connection'   => 'mysql',
            'migrations'   => [
                'local_path' => base_path() . '/vendor/larangular/entity-status/database/migrations',
            ],
            'seeds'        => [
                'local_path' => __DIR__ . '/../database/seeds',
            ],
            'seed_classes' => [],
        ]);
    }

    private function declareMigrationEntityStatus(): void {
        $this->declareMigration([
            'name'      => 'entity_status',
            'timestamp' => true,
        ]);
    }
}
