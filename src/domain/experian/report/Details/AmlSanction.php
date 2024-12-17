<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;
use InvalidArgumentException;

class AmlSanction
{
    public ?string $KDN = null;
    public ?string $UN = null;
    public ?array $amlSanctionList = [];

    public function fromXML(SimpleXMLElement $xml): self
    {
        if (isset($xml->aml_sanction_list_individual)) {
            $this->KDN = (string) $xml->aml_sanction_list_individual->KDN;
            $this->UN = (string) $xml->aml_sanction_list_individual->UN;

            if (isset($xml->aml_sanction_list_individual->amlSanctionList)) {
                $this->amlSanctionList = $this->deserializeAmlSanctionList($xml->aml_sanction_list_individual->amlSanctionList);
            }
        }

        return $this;
    }

    private function deserializeAmlSanctionList(SimpleXMLElement $sanctionList): array
    {
        $sanctionListArray = [];
        foreach ($sanctionList->item as $sanctionItem) {
            $sanctionListArray[] = [
                'No' => (int) $sanctionItem->No,
                'ICPP' => (string) $sanctionItem->ICPP,
                'IndividualName' => (string) $sanctionItem->IndividualName,
                'TraceCase' => (string) $sanctionItem->TraceCase,
                'CompanyName' => (string) $sanctionItem->CompanyName,
                'LastUpdated' => (string) $sanctionItem->LastUpdated,
                'NameMatched' => (string) $sanctionItem->NameMatched
            ];
        }

        return $sanctionListArray;
    }

    public function toArray(): array
    {
        return [
            'KDN' => $this->KDN,
            'UN' => $this->UN,
            'aml_sanction_list' => $this->amlSanctionList
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }


    public function fromJSON(string $json): self
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON: " . json_last_error_msg());
        }

        if (isset($data['KDN'])) {
            $this->KDN = $data['KDN'];
        }

        if (isset($data['UN'])) {
            $this->UN = $data['UN'];
        }

        if (isset($data['aml_sanction_list'])) {
            $this->amlSanctionList = $data['aml_sanction_list'];
        }

        return $this;
    }

    
    public function convertToXml(): string
    {
        $xml = new SimpleXMLElement('<AmlSanction/>');
        $this->arrayToXmlStructure($this->toArray(), $xml->addChild('aml_sanction_list_individual'));
        return $xml->asXML();
    }

    
    private function arrayToXmlStructure(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (isset($value[0])) {  
                    $itemXml = $xml->addChild($key);
                    foreach ($value as $item) {
                        $this->arrayToXmlStructure($item, $itemXml->addChild('item'));
                    }
                } else {
                    $this->arrayToXmlStructure($value, $xml->addChild($key));
                }
            } else {
                $xml->addChild($key, htmlspecialchars((string) $value));
            }
        }
    }
}
