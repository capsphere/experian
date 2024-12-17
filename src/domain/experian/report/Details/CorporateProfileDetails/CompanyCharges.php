<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails;

use SimpleXMLElement;

class CompanyCharges
{
    public ?string $dateCreated = null;
    public ?string $amount = null;
    public ?string $chargeStatus = null;
    public ?string $chargeeName = null;
    public ?string $chargeNo = null;

    // Method to deserialize XML data into PreviousCompanyInterest object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->dateCreated = (string) $xml->date_created;
        $this->amount = (string) $xml->amount;
        $this->chargeStatus = (string) $xml->charge_status;
        $this->chargeeName = (string) $xml->chargee_name;
        $this->chargeNo = (string) $xml->charge_no;

        return $this;
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);

        $this->dateCreated = (string) $data['date_created'];
        $this->amount = (string) $data['amount'];
        $this->chargeStatus = (string) $data['charge_status'];
        $this->chargeeName = (string) $data['chargee_name'];
        $this->chargeNo = (string) $data['charge_no'];

        return $this;
    }

    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<CompanyCharges/>');

        $xml->addChild('date_created', $this->dateCreated);
        $xml->addChild('amount', $this->amount);
        $xml->addChild('charge_status', $this->chargeStatus);
        $xml->addChild('chargee_name', $this->chargeeName);
        $xml->addChild('charge_no', $this->chargeNo);

        return $xml->asXML();
    }


    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'date_created' => $this->dateCreated,
            'amount' => $this->amount,
            'charge_status' => $this->chargeStatus,
            'chargee_name' => $this->chargeeName,
            'charge_no' => $this->chargeNo,
        ];
    }
}
