<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name');
            $table->unsignedBigInteger('designation_id')->index();
            $table->foreign('designation_id')
                ->references('id')
                ->on('designations');
            $table->date('dob');
            $table->string('gender', 1);
            $table->string('contact_no');
            $table->string('avatar')->default('default.png');
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
            $table->dropColumn('last_name');
            $table->dropIndex('users_designation_id_index');
            $table->dropForeign('users_designation_id_foreign');
            $table->dropColumn('designation_id');
            $table->dropColumn('dob');
            $table->dropColumn('gender');
            $table->dropColumn('contact_no');
            $table->dropColumn('avatar');
        });
    }
}
