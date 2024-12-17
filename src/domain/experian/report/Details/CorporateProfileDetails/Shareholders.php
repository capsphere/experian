<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails;

use SimpleXMLElement;

class Shareholders
{
    public ?string $type = null;
    public ?string $oldIc = null;
    public ?string $newIc = null;
    public ?string $name = null;
    public ?string $address = null;
    public ?string $shareholding = null;
    public ?string $sharePercentage = null;
    public ?string $dob = null;

    // Method to deserialize XML data into PreviousCompanyInterest object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->type = (string) $xml->type;
        $this->oldIc = (string) $xml->old_ic;
        $this->newIc = (string) $xml->new_ic;
        $this->name = (string) $xml->name;
        $this->address = (string) $xml->address;
        $this->shareholding = (float) $xml->shareholding;
        $this->sharePercentage = (float) $xml->share_percentage;
        $this->dob = (string) $xml->dob;

        return $this;
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);

        $this->type = (string) $data['type'];
        $this->oldIc = (string) $data['old_ic'];
        $this->newIc = (string) $data['new_ic'];
        $this->name = (string) $data['name'];
        $this->address = (string) $data['address'];
        $this->shareholding = (float) $data['shareholding'];
        $this->sharePercentage = (float) $data['share_percentage'];
        $this->dob = (string) $data['dob'];
        return $this;
    }


    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<Shareholders/>');

        $xml->addChild('type', $this->type);
        $xml->addChild('old_ic', $this->oldIc);
        $xml->addChild('new_ic', $this->newIc);
        $xml->addChild('name', $this->name);
        $xml->addChild('address', $this->address);
        $xml->addChild('shareholding', (string)$this->shareholding);
        $xml->addChild('share_percentage', (string)$this->sharePercentage);
        $xml->addChild('dob', $this->dob);

        return $xml->asXML();
    }


    
    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'old_ic' => $this->oldIc,
            'new_ic' => $this->newIc,
            'name' => $this->name,
            'address' => $this->address,
            'shareholding' => $this->shareholding,
            'share_percentage' => $this->sharePercentage,
            'dob' => $this->dob,
        ];
    }
}
