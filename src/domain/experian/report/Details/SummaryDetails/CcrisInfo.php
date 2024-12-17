<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails;

use SimpleXMLElement;

class CcrisInfo
{
    public ?string $name = null;
    public ?string $id = null;
    public ?string $oldRegNo = null;
    public ?string $newRegNo = null;
    public ?string $oldIc = null;
    public ?string $newIc = null;
    public ?string $note = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->name = (string) $xml->name;
        $this->id = (string) $xml->id;
        $this->oldRegNo = (string) $xml->old_reg_no;
        $this->newRegNo = (string) $xml->new_reg_no;
        $this->oldIc = (string) $xml->old_ic;
        $this->newIc = (string) $xml->new_ic;
        $this->note = (string) $xml->note;

        return $this;
    }

    public function fromJSON(string $json): self{
        $data = json_decode($json, true);
        $this->name = (string) $data['name'] ?? '';
        $this->id = (string) $data['id'] ?? '';
        $this->oldRegNo = (string) $data['old_reg_no'] ?? '';
        $this->newRegNo = (string) $data['new_reg_no'] ?? '';
        $this->oldIc = (string) $data['old_ic'] ?? '';
        $this->newIc = (string) $data['new_ic'] ?? '';
        $this->note = (string) $data['note'] ?? '';

        return $this;
    }

    public function convertToXml(SimpleXMLElement $xml): SimpleXMLElement{
        $xml->addChild('name', $this->name ?? '');
        $xml->addChild('id', $this->id ?? '');
        $xml->addChild('old_reg_no', $this->oldRegNo ?? '');
        $xml->addChild('new_reg_no', $this->newRegNo ?? '');
        $xml->addChild('old_ic', $this->oldIc ?? '');
        $xml->addChild('new_ic', $this->newIc ?? '');
        $xml->addChild('note', $this->note ?? '');

        return $xml;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name ? $this->name : null,
            'id' => $this->id ? $this->id : null,
            'old_reg_no' => $this->oldRegNo ? $this->oldRegNo : null,
            'new_reg_no' => $this->newRegNo ? $this->newRegNo : null,
            'old_ic' => $this->oldIc ? $this->oldIc : null,
            'new_ic' => $this->newIc ? $this->newIc : null,
            'note' => $this->note ? $this->note : null,
        ];
    }
}
