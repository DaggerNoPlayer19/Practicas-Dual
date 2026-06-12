<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table): void {
            $table->index('categoria_id');
            $table->index('precio');
            $table->index(['nombre', 'precio']);
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table): void {
            $table->dropIndex(['categoria_id']);
            $table->dropIndex(['precio']);
            $table->dropIndex(['nombre', 'precio']);
        });
    }
};
