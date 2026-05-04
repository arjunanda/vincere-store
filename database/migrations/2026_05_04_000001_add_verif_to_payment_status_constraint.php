<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For PostgreSQL, we need to drop the check constraint and re-add it 
        // since Laravel's change() on enum doesn't always handle check constraints perfectly in Postgres.
        
        DB::statement("ALTER TABLE transactions DROP CONSTRAINT IF EXISTS transactions_payment_status_check");
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT transactions_payment_status_check CHECK (payment_status IN ('pending', 'verif', 'paid', 'failed', 'expired'))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions DROP CONSTRAINT IF EXISTS transactions_payment_status_check");
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT transactions_payment_status_check CHECK (payment_status IN ('pending', 'paid', 'failed', 'expired'))");
    }
};
