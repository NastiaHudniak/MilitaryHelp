<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('volunteer_id')->constrained('users', 'ID')->onDelete('cascade');
            $table->foreignId('millitary_id')->constrained('users', 'ID')->onDelete('cascade');
            $table->string('title');
            $table->string('description', 1000);
            $table->string('status');
            $table->string('comment' , 1000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['volunteer_id']);
            $table->dropForeign(['millitary_id']);
            $table->dropColumn(['title', 'description', 'created_at', 'status', 'comment']);
        });
    }
};
