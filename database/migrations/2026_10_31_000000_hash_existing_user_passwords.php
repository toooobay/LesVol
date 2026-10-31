<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->select('id', 'password')->chunkById(100, function ($users) {
            foreach ($users as $user) {
                if (! Hash::isHashed($user->password)) {
                    DB::table('users')->where('id', $user->id)->update([
                        'password' => Hash::make($user->password),
                    ]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
