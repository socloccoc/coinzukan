<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PriceHistorical;
use Carbon\Carbon;
class DeletePriceHistory7DCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeletePriceHistory7DCommand:DeletePriceHistory7D';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      PriceHistorical::where('date','<',Carbon::now()->subDays(7)->timestamp)->delete();
    }
}
