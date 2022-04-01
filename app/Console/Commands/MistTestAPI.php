<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MistTestAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mist:testapi';

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
     * @return int
     */
    public function handle()
    {
        //Build a new MIST object to interact with Mist
        $baseurl = env('MIST_URL');
        $org_id = env('MIST_ORG_ID');
        $token = env('MIST_TOKEN'); 

        $mist = new \Ohtarr\Mist($baseurl, $org_id, $token);  //Create the new Mist Object.

        $mistsites = $mist->getOrgSites();

        print_r($mistsites); 
    }
}
