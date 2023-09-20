<?php

namespace Kodeingatan\Lodging\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class KiAdminLodgingPermissionCommand extends Command
{
    const COMMAND = 'kiadmin.lodging:permission';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::COMMAND . " {--email=admin@admin.com} {--role=admin}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $role_name  = $this->option('role');

        \App\Console\Commands\KiAdminPermissionCommand::make($email, $role_name, 'customer,room_type,room,reservation,additional_service,service_usage,payment_transaction');
    }

    static function make($email, $role_name)
    {
        \Artisan::call(self::COMMAND, [
            '--email' => $email,
            '--role' => $role_name,
        ]);
    }
}
