
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('first_name');  // First Name field
            $table->string('last_name');   // Last Name field
            $table->string('email')->unique();  // Email field, unique constraint
            $table->timestamp('email_verified_at')->nullable();  // Email verification timestamp
            $table->string('password');  // Password field
            $table->rememberToken();  // For "remember me" functionality
            $table->timestamps();  // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');  // Drop the users table if the migration is rolled back
    }
}
