<?php

use App\Models\User;
use App\Models\Variant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coordinators', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Variant::class);
            $table->timestamps();

            $table->unique(['user_id', 'variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coordinators');
    }
};
