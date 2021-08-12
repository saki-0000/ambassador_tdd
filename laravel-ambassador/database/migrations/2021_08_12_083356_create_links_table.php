
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

						$table->increments('id');
						$table->string('code',255);
						$table->unsignedBigInteger('user_id')->nullable()->unsigned(); //ユーザーID
						

                    //*********************************
                    // Foreign KEY [ Uncomment if you want to use!! ]
                    //*********************************
                        //$table->foreign("user_id")->references("id")->on("users");



						// ----------------------------------------------------
						// -- SELECT [links]--
						// ----------------------------------------------------
						// $query = DB::table("links")
						// ->leftJoin("users","users.id", "=", "links.user_id")
						// ->get();
						// dd($query); //For checking



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
    