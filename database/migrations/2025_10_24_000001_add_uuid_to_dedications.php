<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * We'll add a nullable uuid column, backfill existing records, then make it NOT NULL.
     * We use a raw ALTER TABLE to avoid requiring doctrine/dbal for the ->change() call.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dedications', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        // Backfill existing rows in chunks to avoid memory issues
        DB::table('dedications')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $r) {
                DB::table('dedications')->where('id', $r->id)->update(['uuid' => (string) Str::uuid()]);
            }
        });

        // Make column non-nullable. Use raw statement to modify column type/nullable without requiring DBAL.
        // CHAR(36) is a safe storage for UUID strings.
        DB::statement('ALTER TABLE `dedications` MODIFY `uuid` CHAR(36) NOT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dedications', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
