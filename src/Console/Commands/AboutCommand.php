<?php

namespace Kodeingatan\Lodging\Console\Commands;

use Illuminate\Console\Command;

class AboutCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kilodging:about';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'About kodeingatan lodging module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("This kodeingatan lodging module");

        return Command::SUCCESS;
    }
}
