<?php

namespace App\Console\Commands;

use App\Juniper\JuniperRpcApi; 
use Illuminate\Console\Command;

class JuniperTestRpcApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'juniper:rpcapi-test';

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
        $username = env('LDAP_USER'); 
        $password = env('LDAP_PASS'); 
        $settings = [
            //'device'    => "10.151.48.50", 
            //'device'    => "10.148.224.50", 
            'device'    => "10.151.48.50", 
            'port'      => "3443", 
            'protocol'  => "https"
        ]; 

        $client = new JuniperRpcApi($settings, $username, $password);  //Create the new Mist Object.

        $result = $client->showPoeController(); 

        print_r($result); 

        $object = json_decode($result); 

        print_r($object->poe); 

        /*
        $array = json_decode($result); 

        $array = json_decode(json_encode($array)); 

        $inventory = $array->{'chassis-inventory'}; 

        print_r($inventory[0]); 

        foreach($inventory as $chassis)
        {
            print_r($chassis->chassis); 
        }
        */


    }
}
