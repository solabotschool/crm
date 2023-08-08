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
        Schema::create('invoice', function (Blueprint $table) {

            $table->id();
            //日付
            $table->string('見積書日付')->nullable();            
            $table->string('請求書日付')->nullable();            
            $table->string('納品書日付')->nullable();            
            $table->string('報告書日付')->nullable();    

            //自社名/登録番号
            $table->string('自社名')->nullable();
            $table->string('登録番号')->nullable();
            $table->string('登録番号13')->nullable();

            //代表（姓/名）
            $table->string('代表姓')->nullable();
            $table->string('代表名')->nullable();

            //自社住所/連絡先
            $table->string('自社住所')->nullable();
            $table->string('連絡先TEL')->nullable();
            $table->string('連絡先FAX')->nullable();
            $table->string('連絡先EMAIL')->nullable();

            //お客様名
            $table->string('お客様名')->nullable();

            //お客様住所/連絡先など
            $table->string('お客様住所')->nullable();
            $table->string('お客様連絡先')->nullable();
            
            //案件名
            $table->string('案件名')->nullable();
            
            //請求月
            $table->string('請求月')->nullable();

            //支払い予定日
            $table->string('支払い予定日')->nullable();
            
            //税率A
            $table->string('税率A')->nullable();
            //税率B
            $table->string('税率B')->nullable();
            
            //取引詳細項目
            $table->longText('取引詳細項目')->nullable();
            
            $table->longText('備考補助金')->nullable();
            $table->longText('諸項目')->nullable();
            $table->longText('お振込先')->nullable();
            
            $table->longText('備考1')->nullable();            
            $table->longText('備考2')->nullable();            
            $table->longText('備考3')->nullable();            
            $table->longText('備考4')->nullable();            
            
            $table->integer('created_by_userid');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
