<?php

use App\Models\Application;
use App\Models\Qualification;
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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Application::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Qualification::class)->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->string('score');
            $table->timestamps();

            $table->unique(
                [
                    'application_id',
                    'qualification_id',
                    'subject'
                ],
                'idx_application_qualification'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
