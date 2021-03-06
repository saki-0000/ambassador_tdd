
    <?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateLinksTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create("links", function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->unsignedBigInteger('user_id');
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
            Schema::dropIfExists("links");
        }
    }
