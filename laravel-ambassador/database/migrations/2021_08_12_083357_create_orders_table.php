
    <?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateOrdersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create("orders", function (Blueprint $table) {
                $table->id();
                $table->string('transaction_id')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->string('code');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->nullable();
                $table->string('zip')->nullable();
                $table->tinyInteger('complete')->default(0);
                $table->timestamps();

                $table->foreign("user_id")->references("id")->on("users");
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists("orders");
        }
    }