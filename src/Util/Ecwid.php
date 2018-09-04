<?php
/**
 * Created by PhpStorm.
 * User: zoltanbogar
 * Date: 2018. 07. 03.
 * Time: 14:58
 */

class Ecwid {
    private $strSecret;
    private $strStoreID;

    public function __construct(){
        $this->strSecret = "secret_SPuzPcYRFffBh41AyVJ4Hf1Uv2gy5F5j";
        $this->strStoreID = "14262098";
    }

    private function runCurl($rowParams){
        $strURL = "https://app.ecwid.com/api/v3/{$this->strStoreID}/";
        foreach($rowParams as $key => $strParam){
            if($key == 0) $strURL .= $strParam . "?";
            else $strURL .= $strParam . "&";
        }
        $strURL .= "token={$this->strSecret}";

        $ch = curl_init($strURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    private function uploadProductPicture($numProductID, $strFilename){
        $file = file_get_contents($strFilename);
        $url = 'https://app.ecwid.com/api/v3/{$this->strStoreID}/products/{$numProductID}/image?token={$this->strSecret}';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: image/jpeg;'));

        $result = curl_exec($ch);
        curl_close ($ch);
    }

    private function createCustomer()
    {
        /*$tblCustomer = (object)[
            "email" => "example@example.com"
            , "password" => "ecwidiscool"
            , "customerGroupId" => 12345
            , "billingPerson" => (object) [
                "name" => "John Smith"
                , "companyName" => "Imaginary Company"
                , "street" => "Hedgehog Street, 1"
                , "city" => "Bucket"
                , "countryCode" => "US"
                , "postalCode" => "90002"
                , "stateOrProvinceCode" => "CA"
                , "phone" => "11111111111"
            ]
            , "shippingAddresses" => [
                (object) [
                    "name" => "John Smith"
                    , "companyName" => "Imaginary Company"
                    , "street" => "W 3d st"
                    , "city" => "New York"
                    , "countryCode" => "US"
                    , "postalCode" => "10001"
                    , "stateOrProvinceCode" => "NY"
                    , "phone" => "11111111111"
                ]
            ]
            , "taxId" => "GB999 9999 73"
            , "taxExempt" => true
            , "taxIdValid" => true
        ];

        $tblCustomer = json_decode("{
            \"email\": \"example@example.com\"
        }");
        //var_dump($tblCustomer);
        $url = 'https://app.ecwid.com/api/v3/' . $this->strStoreID . '/customers?token=' . $this->strSecret;
        var_dump($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, array('json' => json_encode($tblCustomer)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'json='.urlencode("{\"email\": \"example@example.com\"}"));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

//var_dump('json='.urlencode(json_encode($tblCustomer)));
        $result = curl_exec($ch);
        var_dump($result);*/

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.ecwid.com/api/v3/14262098/customers?token=secret_SPuzPcYRFffBh41AyVJ4Hf1Uv2gy5F5j",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"email\": \"example@example.com\",\n    \"password\": \"ecwidiscool\",\n    \"customerGroupId\": 0,\n    \"billingPerson\": {\n        \"name\": \"John Smith\",\n        \"companyName\": \"Imaginary Company\",\n        \"street\": \"Hedgehog Street, 1\",\n        \"city\": \"Bucket\",\n        \"countryCode\": \"US\",\n        \"postalCode\": \"90002\",\n        \"stateOrProvinceCode\": \"CA\",\n        \"phone\": \"11111111111\"\n    },\n    \"shippingAddresses\": [\n        {\n            \"name\": \"John Smith\",\n            \"companyName\": \"Imaginary Company\",\n            \"street\": \"W 3d st\",\n            \"city\": \"New York\",\n            \"countryCode\": \"US\",\n            \"postalCode\": \"10001\",\n            \"stateOrProvinceCode\": \"NY\",\n            \"phone\": \"11111111111\"\n        }\n      ],\n    \"taxId\": \"GB999 9999 73\",\n    \"taxExempt\": true,\n    \"taxIdValid\": true\n}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: fde828d7-afd2-ae9e-d72f-41c386fe19b3"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        switch (curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
            case 400:
                var_dump("Request parameters are malformed");
                break;
            case 409:
                var_dump("The customer with the given email already exists");
                break;
            case 415:
                var_dump("Unsupported content-type: expected application/json or text/json");
                break;
            case 500:
                var_dump("The creation request failed because of an error on the server");
                break;
            case 200:
                var_dump("Customer created");
                break;
            case 404:
                var_dump("404");
                break;
            default:
                var_dump("Default");
        }
        //var_dump(curl_getinfo($curl));
        if (curl_errno($curl)) {
            var_dump($err);
        } else {
            curl_close($curl);
        }

        var_dump($response);
    }

    public function run(){
        //getProducts
        $tblProducts = $this->runCurl(array("products", "sortBy=ADDED_TIME_ASC"));
        var_dump(json_decode($tblProducts));

        //$this->uploadProductPicture(110008801, "https://www.autonavigator.hu/wp-content/uploads/2017/01/199880_source.jpg");

        //$tblCustomers = $this->runCurl(array("customers"));
        //var_dump(json_decode($tblCustomers));

        //$this->createCustomer();
    }
}

$objEcwidDemo = new Ecwid();
$objEcwidDemo->run();