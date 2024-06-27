<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class SearchController extends Controller
{
    public function search(Request $request){
        $data = $request->all();
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $properties = Property::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description','LIKE', "%{$search}%")
            ->orWhere('address','LIKE', "%{$search}%")
            ->orWhere('estate_name','LIKE', "%{$search}%")
            ->orWhere('location','LIKE', "%{$search}%")
            ->orWhere('description','LIKE', "%{$search}%")
            ->orWhere('category_id', $categoryId)
            ->get();

        return response()->json([
            'status' => 'success',
            'properties' => $properties
        ]);
    }

    public function sendSms(Request $request)
    {
        $token = $request->token;
        $tenantName = $request->tenantName;        
        $dueAmount = $request->dueAmount;        
        $dueWater = $request->dueWater;        
        $number = $request->number;

        // // Clean the phone number and ensure it has the 254 prefix
        // if (substr($number, 0, 1) === '0') {
        //     // Remove the leading zero and add the 254 prefix
        //     $number = '254' . substr($number, 1);
        // } elseif (substr($number, 0, 3) !== '254') {
        //     // If the number is not already prefixed with 254, add it
        //     $number = '254' . $number;
        // }

        // Create the personalized message
        $message = "Hello $tenantName, your invoice is ready. Amount due: $dueAmount, including water charges of $dueWater. Please make the payment by the due date. Thank you.";
       
        $data = json_encode(array (
            array (
                'number' => array($number),
                'senderID' => 'Uwazii',
                'text' => $message,
                'type' => 'sms'
            ),
        ));
        var_dump($data);
        
        $url = "https://restapi.uwaziimobile.com/v1/send";
        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "X-Access-Token: ".$token;  
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);
       
        $result = json_decode($response,true);
        print_r($result);
    }

    public function sendTenantSms(Request $request)
    {
        $token = $request->token;
        $message = $request->message;        
        $number = $request->number;
       
        $data = json_encode(array (
            array (
                'number' => array($number),
                'senderID' => 'Uwazii',
                'text' => $message,
                'type' => 'sms'
            ),
        ));
        var_dump($data);
        
        $url = "https://restapi.uwaziimobile.com/v1/send";
        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "X-Access-Token: ".$token;  
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);
       
        $result = json_decode($response,true);
        print_r($result);
    }

    public function sendLandlordSms(Request $request)
    {
        $token = $request->token;
        $message = $request->message;        
        $number = $request->number;
       
        $data = json_encode(array (
            array (
                'number' => array($number),
                'senderID' => 'Uwazii',
                'text' => $message,
                'type' => 'sms'
            ),
        ));
        var_dump($data);
        
        $url = "https://restapi.uwaziimobile.com/v1/send";
        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "X-Access-Token: ".$token;  
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);
       
        $result = json_decode($response,true);
        print_r($result);
    }
}
