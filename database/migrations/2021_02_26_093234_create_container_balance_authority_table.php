<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerBalanceAuthorityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   
        Schema::connection('mysqlbalance')->create('container_balance_authority', function (Blueprint $table) {
            $table->increments('id');  
            $table->string('Group_Name',100);
            $table->string('User_Account',100);
            $table->string('User_Name',100);
            $table->string("User_Email", 50);
            $table->string("Container_Group", 50);
            $table->string('Add',50);
            $table->string('Edit',50);
            $table->string('Delete',50);
            $table->string('Import',50);
            $table->string('Export',50);
            $table->string('Admin',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_balance_authority');
    }
}
