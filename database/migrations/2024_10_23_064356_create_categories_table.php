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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique()->default('')->comment('标题');
            $table->text('description')->comment('描述')->nullable();
            $table->integer('count')->default(0)->comment('文章数量');
            $table->text('additional_params')->comment('附加参数');// 这里设置分类的附加参数，文章可以设置这些参数的值
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
