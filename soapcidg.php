<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$arrLocales = array('pl_PL', 'pl','Polish_Poland.28592');
setlocale( LC_ALL, $arrLocales );
date_default_timezone_set('Europe/Warsaw');
set_time_limit(0);

function XML2Array(SimpleXMLElement $parent) {
    $array = array();
    foreach ($parent as $name => $element) {
        ($node = & $array[$name])
        && (1 === count($node) ? $node = array($node) : 1)
        && $node = & $node[];
        $node = $element->count() ? XML2Array($element) : trim($element);
    }
    return $array;
}

$wsdl = 'https://datastore.ceidg.gov.pl/CEIDG.DataStore/services/NewDataStoreProvider.svc?singleWsdl';
$nip = array("1132589527");
$token = 'o041TbI8xTzHzvHyy3viZeWSMV5SJ4h7TIiKT5quqAVkkgo2gTssPEk7OACZJRY3';
$data = array(
    "AuthToken"  => $token,
    "NIP"        => $nip,
);

$soap = new SoapClient($wsdl);
$resp = $soap->__soapCall("GetMigrationDataExtendedAddressInfo",array($data));

$array = json_decode(json_encode($resp), true);
//
$wpis = $array['GetMigrationDataExtendedAddressInfoResult'];
$xml = simplexml_load_string($wpis);
$xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));
echo '<pre>';
print_R($xml_array);



//
//$wsdl = 'https://datastoretest.ceidg.gov.pl/CEIDG.DataStore/Services/NewDataStoreProvider.svc?singleWsdl';
//$data = array(
//    "AuthToken" => "xxx",
//    "NIP" => "6332212511"
//);
//$soap = new SoapClient($wsdl, array('trace' => true, 'exception' => true));
//
//$soap->__getTypes();
//$soap->__getFunctions();
//$response = $soap->__soapCall("GetMigrationDataExtendedAddressInfo", array($data));
//print_r($response);



//try {
//    $url = 'https://datastore.ceidg.gov.pl/CEIDG.DataStore/Services/DataStoreProvider.svc?Wsdl';
//
//    $api_key = 'tajny klucz który otrzymałem po zalogowaniu';
//    $nip = '5840778201';
//    $client = new SoapClient($url, array("trace" => 1, "exception" => 0));
//    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
//            xmlns:tem="http://tempuri.org/"
//            xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
//            <soapenv:Header/>
//            <soapenv:Body>
//            <tem:GetMigrationDataExtendedInfo>
//            <tem:AuthToken>'.$api_key.'</tem:AuthToken>
//            <tem:NIP>
//            <arr:string>'.$nip.'</arr:string>
//            </soapenv:Body>
//            </soapenv:Envelope>
//            ';
//    $soapBody = new \SoapVar($xml, \XSD_ANYXML);
//    $result = $client->__soapCall('GetMigrationDataExtendedInfo', array($soapBody));
//    var_dump($result, $client->__getFunctions(), $soapBody);
//} catch (SoapFault $exception) {
//    echo $exception->getMessage();
//
//    echo 'tutaj';
//}


//
//$client = new SoapClient("https://datastoretest.ceidg.gov.pl/CEIDG.DataStore/services/NewDataStoreProvider.svc?singleWsdl");
//
//
//echo '<pre>';
//var_dump($client->__getFunctions());
//
//echo 'typy<br>';
//var_dump($client->__getTypes());
//
//echo 'response<br>';
//var_dump($client->__getLastResponse());
//
//echo 'response<br>';
//var_dump($client->__getLastResponse());

