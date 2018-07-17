<?php

try {
    $url = 'https://datastoretest.ceidg.gov.pl/CEIDG.DataStore/services/DataStoreProvider.svc?wsdl';
    $api_key = 'tajny klucz który otrzymałem po zalogowaniu';
    $nip = '7121848951';
    $client = new SoapClient($url, array("trace" => 1, "exception" => 0));
    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
            xmlns:tem="http://tempuri.org/"
            xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
            <soapenv:Header/>         
            <soapenv:Body>
            <tem:GetMigrationDataExtendedInfo>
            <tem:AuthToken>'.$api_key.'</tem:AuthToken>
            <tem:NIP>
            <arr:string>'.$nip.'</arr:string>
            </tem:NIP>
            </tem:GetMigrationDataExtendedInfo>
            </soapenv:Body>
            </soapenv:Envelope>';
    $soapBody = new \SoapVar($xml, \XSD_ANYXML);
    $result = $client->__soapCall('GetMigrationDataExtendedInfo', array($soapBody));
    var_dump($result, $client->__getFunctions(), $soapBody);
} catch (SoapFault $exception) {
    echo $exception->getMessage();
}