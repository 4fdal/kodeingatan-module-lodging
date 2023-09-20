<?php

namespace Kodeingatan\Lodging\Console\Commands;

use Illuminate\Console\Command;
use Kodeingatan\AdminPanel\Provider\AdminPanelServiceProvider;

class InstallationCommand extends Command
{

    private bool $force = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kiadmin.lodging:install {--force=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install kodeingatan admin panel';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->initCommandParams();
        $this->publishConfigs();
        $this->migrationTable();
        $this->generateAdminPermission();

        $this->info('finish installation module');
        return Command::SUCCESS;
    }


    public function initCommandParams()
    {
        $this->force = $this->options()['force'] == 'true' || $this->options()['force'] == null;
    }

    public function migrationTable()
    {
        \Artisan::call('migrate');
        $this->info('Migrate table success');
    }

    public function generateAdminPermission()
    {
        $role_name = 'admin';
        $users = \App\Models\User::role($role_name)->get();
        foreach ($users as $key => $user) {
            KiAdminLodgingPermissionCommand::make($user->email, $role_name);
        }
        $this->info('Generate admin permission success');
    }

    public function publishConfigs()
    {
        $command_params = [
            '--provider' => AdminPanelServiceProvider::class,
            '--tag' => 'lodging-configs',
            '--force' => $this->force,
        ];
        $this->call('vendor:publish', $command_params);
        $this->info('Publish lodging configs success');
    }
}
