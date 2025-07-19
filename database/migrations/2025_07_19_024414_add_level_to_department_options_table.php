<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('department_options', function (Blueprint $table) {
            $table->string('level')->after('name'); // Add level field after name
        });
    }

    public function down(): void
    {
        Schema::table('department_options', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};
