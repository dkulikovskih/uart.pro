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
        Schema::table('reviews', function (Blueprint $table) {
            $table->text('response')->nullable()->after('comment');
            $table->json('photos')->nullable()->after('response');
            $table->integer('likes_count')->default(0)->after('photos');
            $table->integer('dislikes_count')->default(0)->after('likes_count');
            $table->boolean('is_moderated')->default(false)->after('dislikes_count');
            $table->timestamp('moderated_at')->nullable()->after('is_moderated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'response',
                'photos',
                'likes_count',
                'dislikes_count',
                'is_moderated',
                'moderated_at'
            ]);
        });
    }
};
