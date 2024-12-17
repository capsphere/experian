<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails;

use SimpleXMLElement;

class InputRequest
{
    public ?string $searchName = null;
    public ?string $searchId = null;
    public ?string $searchId2 = null;
    public ?string $oldIc = null;
    public ?string $newIc = null;
    public ?string $productCode = null;
    public ?string $nationality = null;
    public ?string $subscriberRefNo = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->searchName = (string) $xml->search_name;
        $this->searchId = (string) $xml->search_id;
        $this->searchId2 = (string) $xml->search_id2;
        $this->oldIc = (string) $xml->old_ic;
        $this->newIc = (string) $xml->new_ic;
        $this->productCode = (string) $xml->product_code;
        $this->nationality = (string) $xml->nationality;
        $this->subscriberRefNo = (string) $xml->subscriber_refno;

        return $this;
    }

    public function fromJSON(string $json): self{
        $data = json_decode($json, true);
        $this->searchName = (string) $data['search_name'] ?? null;
        $this->searchId = (string) $data['search_id'] ?? null;
        $this->searchId2 = (string) $data['search_id_2'] ?? null;
        $this->oldIc = (string) $data['old_ic'] ?? null;
        $this->newIc = (string) $data['new_ic'] ?? null;
        $this->productCode = (string) $data['product_code'] ?? null;
        $this->nationality = (string) $data['nationality'] ?? null;
        $this->subscriberRefNo = (string) $data['subscriber_refno'] ?? null;

        return $this;
    }

    public function convertToXml(SimpleXMLElement $xml): SimpleXMLElement{
        $xml->addChild('search_name', $this->searchName ?? '');
        $xml->addChild('search_id', $this->searchId ?? '');
        $xml->addChild('search_id2', $this->searchId2 ?? '');
        $xml->addChild('old_ic', $this->oldIc ?? '');
        $xml->addChild('new_ic', $this->newIc ?? '');
        $xml->addChild('product_code', $this->productCode ?? '');
        $xml->addChild('nationality', $this->nationality ?? '');
        $xml->addChild('subscriber_refno', $this->subscriberRefNo ?? '');

        return $xml;
    }

    public function toArray(): array
    {
        return [
            'search_name' => $this->searchName ? $this->searchName : null,
            'search_id' => $this->searchId ? $this->searchId : null,
            'search_id_2' => $this->searchId2 ? $this->searchId2 : null,
            'old_ic' => $this->oldIc ? $this->oldIc : null,
            'new_ic' => $this->newIc ? $this->newIc : null,
            'product_code' => $this->productCode ? $this->productCode : null,
            'nationality' => $this->nationality ? $this->nationality : null,
            'subscriber_refno' => $this->subscriberRefNo ? $this->subscriberRefNo : null,
        ];
    }
}
