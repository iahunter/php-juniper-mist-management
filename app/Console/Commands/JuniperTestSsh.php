<?php

namespace App\Console\Commands;

use Carbon\Carbon;

use Illuminate\Console\Command;

class JuniperTestSsh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'juniper:test-ssh';

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

        $gateway = "10.151.48.50"; 

        $params = [
            'host'     => $gateway,
            'username' => env('LDAP_USER'),
            'password' => env('LDAP_PASS'),
        ];

        /*
        // Json
        print_r($this->getConfigJson($params)); 

        // Array
        print_r(json_decode($this->getConfigJson($params), true)); 

        // CLI
        print_r($this->getConfigCli($params)); 
        */

        print_r($this->getPoeController($params)); 

    }

    public function getPoeController($params)
    {
        $ssh = new \Metaclassing\SSH($params);

        $ssh->connect()->exec("set cli screen-width 0");

        $command = 'show poe controller';
        $output = $ssh->exec($command);

        $arr = explode("\n", $output);
        //print_r($arr); 
        
        array_shift($arr); //removes first line
        array_pop($arr); //removes last line
        array_pop($arr); //removes last line

        $json = implode("\n", $arr);

        return $json;  

    }

    public function getConfigJson($params)
    {
        $ssh = new \Metaclassing\SSH($params);

        $ssh->connect()->exec("set cli screen-width 0");

        $command = 'show configuration | display json | no-more';
        $output = $ssh->exec($command);

        $arr = explode("\n", $output);
        //print_r($arr); 
        
        array_shift($arr); //removes first line
        array_pop($arr); //removes last line
        array_pop($arr); //removes last line

        $json = implode("\n", $arr);

        return $json;  

    }

    public function getConfigCli($params)
    {
        $ssh = new \Metaclassing\SSH($params);

        $ssh->connect()->exec("set cli screen-width 0");

        $command = 'show configuration | display set | no-more';
        $output = $ssh->exec($command);

        $arr = explode("\n", $output);
        //print_r($arr); 
        
        array_shift($arr); //removes first line
        array_pop($arr); //removes last line
        array_pop($arr); //removes last line

        $config = implode("\n", $arr);

        return $config;  

    }
}
