<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comment', function(Blueprint $table) {
            $table->increments('comment_id'); 
            $table->string('name', 40);
            $table->string('comment', 255);
            $table->integer('parent_id')->unsigned();   
            $table->index('comment_id');          
            $table->foreign('parent_id')->references('comment_id')->on('comment')->onUpdate('cascade')->onDelete('cascade');            
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        Schema::table('comment', function(Blueprint $table)
        {
            $table->dropForeign('comment_parent_id_foreign');
            $table->dropIndex('comment_comment_id_index');
        });
        Schema::drop('comment');
    }
};
