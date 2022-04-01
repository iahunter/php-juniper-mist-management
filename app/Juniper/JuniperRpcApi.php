<?php

namespace App\Juniper;

use \GuzzleHttp\Client as GuzzleClient;
use \GuzzleHttp\Cookie\CookieJar as GuzzleCookieJar;

class JuniperRpcApi
{
    public $cookiejar;
    public $baseurl;
    private $username;
    private $password;
    private $auth; 

    public function __construct($settings, $username, $password)
    {
        $this->cookiejar = new GuzzleCookieJar;
        $this->baseurl = "";
        $this->username = $username;
        $this->password = $password;
        
        $this->auth = [
            $this->username, 
            $this->password
        ]; 

        if(isset($settings['device']))
        {
            $device = $settings['device']; 
            $this->baseurl = $device; 
        }
        if(isset($settings['port']))
        {
            $port = $settings['port']; 
            $this->baseurl = $this->baseurl .":". $port; 
        }
        if(isset($settings['protocol']))
        {
            $protocol = $settings['protocol']; 
            $this->baseurl = $protocol."://".$this->baseurl; 
        }

    }

    public static function wrapapi($verb, $url, $auth, $data = '')
    {
        $client = new GuzzleClient(); 

        $headers = [
            'auth'    => $auth,
            'verify'  => false,
            'headers' => [
                'Content-Type'     => 'application/json',
                'Accept'           => 'application/json',
            ],
        ];
        if ($verb == 'POST') {
            $headers['data'] = $data;
        }

        /*
        if (isset($data['Accept'])) {
            $headers['headers']['Accept'] = $data['Accept'];
        }
        */
       

        try {
            $apiRequest = $client->request($verb, $url, $headers);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        /*
        // Sonus is not supporting JSON at this time so we have to use XML - they are limiting the return on JSON to 100 records.
        $xml = $apiRequest->getBody()->getContents();

        // Try to convert the xml into an array.
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);

        */
        $json = $apiRequest->getBody()->getContents();
        return $json;

    }

    public function showChassisHardware()
    {

        $verb = 'GET';
        $url = "{$this->baseurl}/rpc/get-chassis-inventory";
        $auth = $this->auth; 

        $result = self::wrapapi($verb, $url, $auth);

        return $result;
    }

    public function showSoftwareInforamation()
    {

        $verb = 'GET';
        $url = "{$this->baseurl}/rpc/get-software-information";
        $auth = $this->auth; 

        $result = self::wrapapi($verb, $url, $auth);

        return $result;
    }

    public function showPoeController()
    {

        $verb = 'GET';
        $url = "{$this->baseurl}/rpc/get-poe-controller-information";
        $auth = $this->auth; 

        $result = self::wrapapi($verb, $url, $auth);

        return $result;
    }
}