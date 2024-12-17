<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails;

use SimpleXMLElement;

class CcrisAddress
{
    public ?string $address = null;
    public ?string $dateCapture = null;
    public ?string $sourceFrom = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->address = (string) $xml->address;
        $this->dateCapture = (string) $xml->date_capture;
        $this->sourceFrom = (string) $xml->source_from;

        return $this;
    }

    public function fromJSON(string $json): self{
        $data = json_decode($json, true);
        // print_r($data);
        $this->address = (string) $data['address'] ?? '';
        $this->dateCapture = (string) $data['date_capture'] ?? '';
        $this->sourceFrom = (string) $data['source_from'] ?? '';

        return $this;
    }

    public function convertToXml(SimpleXMLElement $addressElement): SimpleXMLElement{
        $addressElement ->addChild('address', $this->address ?? '');
        $addressElement->addChild('date_capture', $this->dateCapture ?? '');
        $addressElement->addChild('source_from', $this->sourceFrom ?? '');

        return $addressElement;
    }

    public function toArray(): array
    {
        return [
            'address' => $this->address,
            'date_capture' => $this->dateCapture,
            'source_from' => $this->sourceFrom,
        ];
    }
}
