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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            // unique()は対象のカラムにUNIQUE制約（値の重複を禁止する）を付与するメソッドです。
            // vendor_codeカラムは後ほど外部キーの参照先として指定しますが、外部キーの参照先には必ずUNIQUE制約を付与しなければなりません。
            $table->integer('vendor_code')->unique();
            $table->string('vendor_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
