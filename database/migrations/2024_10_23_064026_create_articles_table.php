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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('标题')->default('');
            $table->text('content')->comment('内容');
            $table->integer('category_id')->comment('分类 id')->default(0);
            $table->string('cover')->comment('封面')->default('')->nullable();
            $table->text('additional_params')->comment('附加参数')->nullable();// 这个就是通过 category 绑定的参数设置的
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
