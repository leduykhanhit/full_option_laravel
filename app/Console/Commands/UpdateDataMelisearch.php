<?php

namespace App\Console\Commands;

use App\Models\Melisearch\Province;
use Illuminate\Console\Command;

class UpdateDataMelisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-data-melisearch';

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
        $province = new Province();
        $data = $province::where('id','=',1)->firstOrFail();
        $data->type = '44444';
        $data->save();
        //
    }
}
