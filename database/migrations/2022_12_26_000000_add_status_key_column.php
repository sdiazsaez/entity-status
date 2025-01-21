<?php
/**
 * Copyright (c) 2022. Simon Diaz <sdiaz@sdshost.ml>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Larangular\Installable\Facades\InstallableConfig;
use Larangular\MigrationPackage\Migration\Schematics;

class AddStatusKeyColumn extends Migration {

    use Schematics;

    protected $name;
    private   $installableConfig;


    public function __construct() {
        $this->installableConfig = InstallableConfig::config('Larangular\EntityStatus\EntityStatusServiceProvider');
        $this->connection = $this->installableConfig->getConnection('entity_status');
        $this->name = $this->installableConfig->getName('entity_status');
    }

    public function up(): void {
        $this->alter(function (Blueprint $table) {
            $table->string('key')
                  ->after('entity_id');
            $table->unique([
                'entity_type',
                'entity_id',
                'key',
            ]);
        });
    }

    public function down(): void {
        $this->alter(function (Blueprint $table) {
            $table->dropUnique([
                'entity_type',
                'entity_id',
                'key',
            ]);
            $table->dropColumn('key');
        });
    }
}

