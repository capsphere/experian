<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails;

use SimpleXMLElement;

class Directors
{
    public ?string $designation = null;
    public ?string $oldIc = null;
    public ?string $name = null;
    public ?string $appDate = null;
    public ?string $address = null;
    public ?string $dob = null;

    // Method to deserialize XML data into PreviousCompanyInterest object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->designation = (string) $xml->designation;
        $this->oldIc = (string) $xml->old_ic;
        $this->name = (string) $xml->name;
        $this->appDate = (string) $xml->app_date;
        $this->address = (string) $xml->address;
        $this->dob = (string) $xml->dob;

        return $this;
    }

    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'designation' => $this->designation,
            'old_ic' => $this->oldIc,
            'name' => $this->name,
            'app_date' => $this->appDate,
            'address' => $this->address,
            'dob' => $this->dob,
        ];
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);

        $this->designation = (string) $data['designation'];
        $this->oldIc = (string) $data['old_ic'];
        $this->name = (string) $data['name'];
        $this->appDate = (string) $data['app_date'];
        $this->address = (string) $data['address'];
        $this->dob = (string) $data['dob'];

        return $this;
    }

    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<Directors/>');

        $xml->addChild('designation', $this->designation);
        $xml->addChild('old_ic', $this->oldIc);
        $xml->addChild('name', $this->name);
        $xml->addChild('app_date', $this->appDate);
        $xml->addChild('address', $this->address);
        $xml->addChild('dob', $this->dob);

        return $xml->asXML();
    }


}
