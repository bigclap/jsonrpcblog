<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*
     * CREATE TABLE `Items` (
    `item_id` int(10) unsigned NOT NULL,
    `user_id` int(10) unsigned NOT NULL,
    `order_id` int(10) NOT NULL DEFAULT '0',
    `is_development_mode` tinyint(1) NOT NULL,
    `class` varchar(255) NOT NULL,
    `props_json` mediumtext,
    `created_ts` timestamp NOT NULL DEFAULT '1970-01-01 00:00:01',
    `updated_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_ts` datetime(6) DEFAULT NULL,
    PRIMARY KEY (`user_id`,`item_id`,`is_development_mode`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='2';
    */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('item_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('order_id')->default(0);
            $table->boolean('is_development_mode')->default(0);
            $table->string('class')->default('');
            $table->mediumText('props_json');
            $table->timestamp('created_at')->default('1970-01-01 00:00:01');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable();
        });
        DB::statement('ALTER TABLE  `items` DROP PRIMARY KEY , ADD PRIMARY KEY (  `item_id` ,  `user_id` ,  `is_development_mode`) ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
