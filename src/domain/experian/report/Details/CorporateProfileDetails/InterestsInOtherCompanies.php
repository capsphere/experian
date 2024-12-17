<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails;

use SimpleXMLElement;

class InterestsInOtherCompanies
{
    public ?string $localNo = null;
    public ?string $oldRegNo = null;
    public ?string $newRegNo = null;
    public ?string $displayId = null;
    public ?string $companyName = null;
    public ?string $shareholding = null;
    public ?string $sharePercentage = null;
    public ?string $asAt = null;

    // Method to deserialize XML data into PreviousCompanyInterest object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->localNo = (string) $xml->local_no;
        $this->oldRegNo = (string) $xml->old_reg_no;
        $this->newRegNo = (string) $xml->new_reg_no;
        $this->displayId = (string) $xml->display_id;
        $this->companyName = (string) $xml->company_name;
        $this->shareholding = (float) $xml->shareholding;
        $this->sharePercentage = (float) $xml->share_percentage;
        $this->asAt = (string) $xml->as_at;

        return $this;
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);

        $this->localNo = (string) $data['local_no'];
        $this->oldRegNo = (string) $data['old_reg_no'];
        $this->newRegNo = (string) $data['new_reg_no'];
        $this->displayId = (string) $data['display_id'];
        $this->companyName = (string) $data['company_name'];
        $this->shareholding = (float) $data['shareholding'];
        $this->sharePercentage = (float) $data['share_percentage'];
        $this->asAt = (string) $data['as_at'];

        return $this;
    }


    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<InterestsInOtherCompanies/>');

        $xml->addChild('local_no', $this->localNo);
        $xml->addChild('old_reg_no', $this->oldRegNo);
        $xml->addChild('new_reg_no', $this->newRegNo);
        $xml->addChild('display_id', $this->displayId);
        $xml->addChild('company_name', $this->companyName);
        $xml->addChild('shareholding', (string)$this->shareholding);
        $xml->addChild('share_percentage', (string)$this->sharePercentage);
        $xml->addChild('as_at', $this->asAt);

        return $xml->asXML();
    }


    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'local_no' => $this->localNo,
            'old_reg_no' => $this->oldRegNo,
            'new_reg_no' => $this->newRegNo,
            'display_id' => $this->displayId,
            'company_name' => $this->companyName,
            'shareholding' => $this->shareholding,
            'share_percentage' => $this->sharePercentage,
            'as_at' => $this->asAt,
        ];
    }
}
