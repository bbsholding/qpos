<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration: create_cash_movements_table.php
class CreateCashMovementsTable extends Migration
{
    public function up()
    {
        Schema::create('mouvement_caisses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_caisse_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['entree', 'sortie', 'vente', 'remboursement']);
            $table->decimal('montant', 10, 2);
            $table->decimal('montant_a_paye_mobile_money', 10, 2)->default(0);
            $table->decimal('montant_recu', 10, 2);
            $table->decimal('monnaie_rendue', 10, 2);
            $table->string('methode_paiement')->default('espece');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mouvements_caisse');
    }
}
