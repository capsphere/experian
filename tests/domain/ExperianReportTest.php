<?php

use Capsphere\PhpCore\Domain\Experian\Report\Details\Summary;
use Capsphere\PhpCore\Domain\Experian\CCrisTokenCredentials;
use Capsphere\PhpCore\Service\Xml\CcrisIdentityDeserializer;
use Capsphere\PhpCore\Service\Xml\TokenCredentialsDeserializer;
use Capsphere\PhpCore\Domain\Experian\Entity\CcrisIdentity;
use Capsphere\PhpCore\Domain\Experian\Entity\CcrisIdentityItem;
use Capsphere\PhpCore\Service\Xml\SimpleXMLMapper;
use Capsphere\PhpCore\Domain\Experian\CcrisRequest;
use Capsphere\PhpCore\Domain\Experian\Report\CreditReport;
use Capsphere\PhpCore\Domain\Experian\Report\Details\Profile;
use PHPUnit\Framework\TestCase;

use JMS\Serializer\SerializerBuilder;

class ExperianReportTest extends TestCase
{
    public function testCreditReportDeserialization(){

        $xmlString = file_get_contents(__DIR__ . '/credit_report.xml');
        // $xmlString = file_get_contents(__DIR__ . '/dyna.xml');
        // $xmlString = file_get_contents(__DIR__ . '/borneo.xml');
        // $xmlString = file_get_contents(__DIR__ . '/honglim.xml');

        // var_dump($xmlString);

        $xmlObject = new SimpleXMLElement($xmlString);

        // var_dump($xmlObject);

        $creditReport = new CreditReport();

        $creditReport->fromXML($xmlObject);
        echo $creditReport->toJSON();
    }

    public function testCreditReportDeserializationSaveJSONFile(){
        $xmlString = file_get_contents(__DIR__ . '/credit_report.xml');

        $xmlObject = new SimpleXMLElement($xmlString);

        $creditReport = new CreditReport();
        $creditReport->fromXML($xmlObject);

        $jsonData = $creditReport->toJSON();
        $jsonFileName = __DIR__ . '/credit_report.json';
        file_put_contents($jsonFileName, $jsonData);
        echo "JSON File saved as: " . $jsonFileName;

    }

}