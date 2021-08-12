
    <?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateLinkProductsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create("link_products", function (Blueprint $table) {

                $table->increments('id');
                $table->integer('link_id')->nullable()->unsigned();
                $table->integer('product_id')->nullable()->unsigned();
                //$table->foreign("link_id")->references("id")->on("links");
                //$table->foreign("product_id")->references("id")->on("products");



                // ----------------------------------------------------
                // -- SELECT [link_products]--
                // ----------------------------------------------------
                // $query = DB::table("link_products")
                // ->leftJoin("links","links.id", "=", "link_products.link_id")
                // ->leftJoin("products","products.id", "=", "link_products.product_id")
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
            Schema::dropIfExists("link_products");
        }
    }
