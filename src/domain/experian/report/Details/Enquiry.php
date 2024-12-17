<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;
use InvalidArgumentException;

class Enquiry
{
    public ?array $previousEnquiry = [];

    public function fromXML(SimpleXMLElement $xml): self
    {
        if (isset($xml->previous_enquiry)) {
            $this->previousEnquiry = [
                'finance' => $this->deserializeEnquiryItems($xml->previous_enquiry->finance),
                'commercial' => $this->deserializeEnquiryItems($xml->previous_enquiry->commercial)
            ];
        }

        return $this;
    }

    private function deserializeEnquiryItems(SimpleXMLElement $enquiryItems): array
    {
        $itemsList = [];
        foreach ($enquiryItems->item as $item) {
            $months = [];
            foreach ($item->month->item as $monthItem) {
                $months[] = (string) $monthItem;
            }

            $itemsList[] = [
                'year' => (int) $item->year,
                'yearly_count' => (int) $item->yearly_count,
                'month' => $months
            ];
        }

        return $itemsList;
    }

    public function toArray(): array
    {
        return [
            'previous_enquiry' => $this->previousEnquiry
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }



    public function convertToXml(): string
    {
        $xml = new SimpleXMLElement('<Enquiry></Enquiry>'); 
        $this->arrayToXmlStructure($this->previousEnquiry, $xml->addChild('previous_enquiry')); 

        return $xml->asXML(); 
    }
    
    private function arrayToXmlStructure(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (isset($value[0])) { 
                    foreach ($value as $item) {
                        $itemElement = $xml->addChild($key);
                        $this->arrayToXmlStructure($item, $itemElement); 
                    }
                } else {
                    $child = $xml->addChild($key);
                    $this->arrayToXmlStructure($value, $child);
                }
            } else {
                $xml->addChild($key, htmlspecialchars((string)$value)); 
            }
        }
    }

  
    public function fromJSON(string $json): self
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON: " . json_last_error_msg());
        }

       
        if (isset($data['previous_enquiry'])) {
            $this->previousEnquiry = [
                'finance' => $this->deserializeEnquiryItemsFromArray($data['previous_enquiry']['finance']),
                'commercial' => $this->deserializeEnquiryItemsFromArray($data['previous_enquiry']['commercial'])
            ];
        }

        return $this;
    }

  
    private function deserializeEnquiryItemsFromArray(array $enquiryItems): array
    {
        $itemsList = [];
        foreach ($enquiryItems as $item) {
            $months = [];
            foreach ($item['month'] as $monthItem) {
                $months[] = (string) $monthItem;
            }

            $itemsList[] = [
                'year' => (int) $item['year'],
                'yearly_count' => (int) $item['yearly_count'],
                'month' => $months
            ];
        }

        return $itemsList;
    }
}
