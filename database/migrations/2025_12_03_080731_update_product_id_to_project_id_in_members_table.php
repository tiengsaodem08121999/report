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
        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('product_id', 'project_id');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->integer('project_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Đổi lại tên cũ
            $table->renameColumn('project_id', 'product_id');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->integer('product_id')->nullable(false)->change();
        });
    }
};
