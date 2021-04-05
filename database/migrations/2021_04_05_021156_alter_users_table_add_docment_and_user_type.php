<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddDocmentAndUserType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('document', 30)->unique();
            $table->unsignedBigInteger('user_type_id');

            $table->foreign('user_type_id')->references('id')->on('user_types');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            
            $table->dropForeign('users_user_type_id_foreign');
            
            $table->dropColumn(['document', 'user_type_id']);
        });
    }
}
