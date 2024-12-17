<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails;

use SimpleXMLElement;

class PreviousCompanyInterest
{
    public ?string $type = null;
    public ?string $regNo = null;
    public ?string $oldRegNo = null;
    public ?string $newRegNo = null;
    public ?string $displayId = null;
    public ?string $name = null;
    public ?string $status = null;
    public ?string $position = null;
    public ?string $cessationDate = null;
    public ?string $incorporatedDate = null;
    public ?string $class = null;

    // Method to deserialize XML data into PreviousCompanyInterest object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->type = (string) $xml->type;
        $this->regNo = (string) $xml->reg_no;
        $this->oldRegNo = (string) $xml->old_reg_no;
        $this->newRegNo = (string) $xml->new_reg_no;
        $this->displayId = (string) $xml->display_id;
        $this->name = (string) $xml->name;
        $this->status = (string) $xml->status;
        $this->position = (string) $xml->position;
        $this->cessationDate = (string) $xml->cessation_date;  // Can be nullable
        $this->incorporatedDate = (string) $xml->incorporated_date;
        $this->class = (string) $xml->class;

        return $this;
    }

    public function fromJSON(string $json): self{
        $data = json_decode($json, true);
        $this->type = (string) $data['type'];
        $this->regNo = (string) $data['reg_no'];
        $this->oldRegNo = (string) $data['old_reg_no'];
        $this->newRegNo = (string) $data['new_reg_no'];
        $this->displayId = (string) $data['display_id'];
        $this->name = (string) $data['name'];
        $this->status = (string) $data['status'];
        $this->position = (string) $data['position'];
        $this->cessationDate = (string) $data['cessation_date'];
        $this->incorporatedDate = (string) $data['incorporated_date'];
        $this->class = (string) $data['class'];

        return $this;
    }

    public function convertToXml(SimpleXMLElement $xml): SimpleXMLElement{
        $interestElement = $xml->addChild('previous_company_interest');
        $interestElement->addChild('type', $this->type ?? '');
        $interestElement->addChild('reg_no', $this->regNo ?? '');
        $interestElement->addChild('old_reg_no', $this->oldRegNo ?? '');
        $interestElement->addChild('new_reg_no', $this->newRegNo ?? '');
        $interestElement->addChild('display_id', $this->displayId ?? '');
        $interestElement->addChild('name', $this->name ?? '');
        $interestElement->addChild('status', $this->status ?? '');
        $interestElement->addChild('position', $this->position ?? '');
        $interestElement->addChild('cessation_date', $this->cessationDate ?? '');
        $interestElement->addChild('incorporated_date', $this->incorporatedDate ?? '');
        $interestElement->addChild('class', $this->class ?? '');

        return $xml;
    }

    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'reg_no' => $this->regNo,
            'old_reg_no' => $this->oldRegNo,
            'new_reg_no' => $this->newRegNo,
            'display_id' => $this->displayId,
            'name' => $this->name,
            'status' => $this->status,
            'position' => $this->position,
            'cessation_date' => $this->cessationDate,
            'incorporated_date' => $this->incorporatedDate,
            'class' => $this->class,
        ];
    }
}
