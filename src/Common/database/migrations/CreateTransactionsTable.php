<?php

namespace Corals\Modules\Payment\Common\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();

            $table->morphs('owner');


            $table->unsignedInteger('invoice_id')->nullable();

            $table->nullableMorphs('sourcable');
            $table->float('amount')->default(0);
            $table->string('paid_currency')->nullable();
            $table->float('paid_amount')->nullable();
            $table->string('type')->nullable();
            $table->string('method')->nullable();
            $table->timestamp('transaction_date')->nullable();
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('completed');

            $table->text('notes')->nullable();
            $table->text('extra')->nullable();
            $table->string('reference')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')
                ->on('invoices')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
}
