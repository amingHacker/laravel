<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplingRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampling_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('urgent',10);
            $table->dateTime('sampling_date')->nullable()->default(null);
            $table->string('product_name',100);
            $table->string('level',100);
            $table->string('bottle_number',100);
            $table->string('batch_number', 100);
            $table->string('sampler',100);
            $table->string('sample_source', 100);
            $table->string('analytical_item', 100);
            $table->string('analyst',100);
            $table->dateTime('completion_date')->nullable()->default(null);
            $table->string('determination', 100);
            $table->string('remarks', 255);
            $table->string('MeO', 50);
            $table->string('Assay', 50);
            $table->string('HC', 50);
            $table->string('Si', 50);
            $table->string('Sn', 50);
            $table->string('Al', 50);
            $table->string('I', 50);
            $table->string('Fe', 50);
            $table->string('Zn', 50);
            $table->string('Ag', 50);
            $table->string('As', 50);
            $table->string('Au', 50);
            $table->string('B', 50);
            $table->string('Ba', 50);
            $table->string('Be', 50);
            $table->string('Bi', 50);
            $table->string('Ca', 50);
            $table->string('Cd', 50);
            $table->string('Ce', 50);
            $table->string('Co', 50);
            $table->string('Cr', 50);
            $table->string('Cs', 50);
            $table->string('Cu', 50);
            $table->string('Ga', 50);
            $table->string('Ge', 50);
            $table->string('Hg', 50);
            $table->string('In', 50);
            $table->string('K', 50);
            $table->string('La', 50);
            $table->string('Li', 50);
            $table->string('Mg', 50);
            $table->string('Mn', 50);
            $table->string('Mo', 50);
            $table->string('Na', 50);
            $table->string('Nb', 50);
            $table->string('Ni', 50);
            $table->string('P', 50);
            $table->string('Pb', 50);
            $table->string('Pd', 50);
            $table->string('Pt', 50);
            $table->string('Rb', 50);
            $table->string('Re', 50);
            $table->string('Rh', 50);
            $table->string('Ru', 50);
            $table->string('S', 50);
            $table->string('Sb', 50);
            $table->string('Se', 50);
            $table->string('Sr', 50);
            $table->string('Ta', 50);
            $table->string('Tb', 50);
            $table->string('Te', 50);
            $table->string('Th', 50);
            $table->string('Ti', 50);
            $table->string('Tl', 50);
            $table->string('U', 50);
            $table->string('V', 50);
            $table->string('W', 50);
            $table->string('Y', 50);
            $table->string('Zr', 50);
            $table->string('F', 50);
            $table->string('Cl', 50);
            $table->string('Parameter_A', 50);
            $table->string('Impurity_A', 50);
            $table->string('Impurity_B', 50);
            $table->string('Impurity_C', 50);
            $table->string('Impurity_D', 50);
            $table->string('Impurity_E', 50);
            $table->string('Impurity_F', 50);
            $table->string('1H_NMR', 50);
            $table->string('Other_Metals', 50);
            $table->string('Parameter_B', 50);
            $table->string('Parameter_C', 50);
            $table->string('Parameter_D', 50);
            $table->string('Organic_impurity', 50);           
            $table->string('2_2ppm', 50);  //此欄資料因字元符號關係需要額外建立
            $table->string('3_8ppm', 50);
            $table->string('4_0ppm', 50);
            $table->string('Sum223840', 50);
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
        Schema::dropIfExists('sampling_records');
    }
}
