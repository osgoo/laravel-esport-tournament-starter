<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('game_title');
            $table->text('description')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('starts_at')->nullable();
            $table->unsignedInteger('max_teams')->default(16);
            $table->timestamps();
        });

        Schema::create('tournament_registrations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending')->index();
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->unique(['tournament_id', 'team_id']);
        });

        Schema::create('tournament_matches', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('round')->default(1);
            $table->foreignId('team_one_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->foreignId('team_two_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->unsignedInteger('team_one_score')->nullable();
            $table->unsignedInteger('team_two_score')->nullable();
            $table->foreignId('winner_team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->string('status')->default('scheduled')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
        Schema::dropIfExists('tournament_registrations');
        Schema::dropIfExists('tournaments');
    }
};
