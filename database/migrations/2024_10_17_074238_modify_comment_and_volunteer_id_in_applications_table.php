<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCommentAndVolunteerIdInApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            // Робимо поле comment nullable
            $table->text('comment')->nullable()->change();

            // Робимо поле volunteer_id nullable
            $table->unsignedBigInteger('volunteer_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            // Повертаємо поле comment до not null
            $table->text('comment')->nullable(false)->change();

            // Повертаємо поле volunteer_id до not null
            $table->unsignedBigInteger('volunteer_id')->nullable(false)->change();
        });
    }
}
