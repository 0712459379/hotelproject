<?php 
$JSON_STRING = '{"Body":{"stkCallback":
    {"MerchantRequestID":"46431-19418583-1","CheckoutRequestID":"ws_CO_070520211100282805",
        "ResultCode":0,"ResultDesc":"The service request is processed successfully.",
        "CallbackMetadata":{"Item":[{"Name":"Amount","Value":1.00},
        {"Name":"MpesaReceiptNumber","Value":"PE71NZSURN"},{"Name":"TransactionDate","Value":20210507110056},
        {"Name":"PhoneNumber","Value":254796268817}]}}}}';
$json_response=json_decode($JSON_STRING,true); // decode json file to readable
//echo $json_response["Body"]->ResultCode;
echo $json_response["Body"]["stkCallback"]["CallbackMetadata"]["Item"][3]["Value"];

$key = array_search('Body', $json_response);

$varname = "hey";
$logfile = "mpesaresponse.json";
$mpesajson = json_decode($varname, true);
$log = fopen($logfile, "a");
fwrite($log,$varname);
fclose($log);
