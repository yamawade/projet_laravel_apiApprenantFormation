<?php

use App\Models\User;
use App\Models\Formation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('utilisateur_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Formation::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('statut',['accepter','refuser'])->default('accepter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateur_formations');
    }
};
