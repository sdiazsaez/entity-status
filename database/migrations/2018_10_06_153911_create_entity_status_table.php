<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Larangular\Installable\Facades\InstallableConfig;
use Larangular\MigrationPackage\Migration\Schematics;

class CreateEntityStatusTable extends Migration {

    use Schematics;

    protected $name;
    private   $installableConfig;


    public function __construct() {
        $this->installableConfig = InstallableConfig::config('Larangular\EntityStatus\EntityStatusServiceProvider');
        $this->connection = $this->installableConfig->getConnection('entity_status');
        $this->name = $this->installableConfig->getName('entity_status');
    }

    public function up(): void {
        $this->create(function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('entity');

            $table->integer('status');
            $table->string('description');
            $table->longText('message')->nullable();

            if ($this->installableConfig->getTimestamp('entity_status')) {
                $table->softDeletes();
                $table->timestamps();
            }
        });
    }

    public function down(): void {
        $this->drop();
    }
}

