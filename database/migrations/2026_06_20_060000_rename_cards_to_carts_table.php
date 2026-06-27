<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('cart_items', 'cart_id')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropForeign(['card_id']);
            });

            Schema::table('cart_items', function (Blueprint $table) {
                $table->renameColumn('card_id', 'cart_id');
            });
        }

        if (Schema::hasTable('cards')) {
            Schema::rename('cards', 'carts');
        }

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('cart_id')->references('id')->on('carts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
        });

        Schema::rename('carts', 'cards');

        Schema::table('cart_items', function (Blueprint $table) {
            $table->renameColumn('cart_id', 'card_id');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('card_id')->references('id')->on('cards')->cascadeOnDelete();
        });
    }
};
