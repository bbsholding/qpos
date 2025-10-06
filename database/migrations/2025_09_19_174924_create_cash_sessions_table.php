<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration: create_cash_sessions_table.php
class CreateCashSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('session_caisses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caisse_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('solde_ouverture', 10, 2);
            $table->decimal('solde_fermeture', 10, 2)->nullable();
            $table->decimal('solde_attendu', 10, 2)->nullable();
            $table->decimal('difference', 10, 2)->nullable();
            $table->timestamp('ouverture_at');
            $table->timestamp('fermeture_at')->nullable();
            $table->enum('status', ['ouvert', 'ferme'])->default('ouvert');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions_caisse');
    }
}
