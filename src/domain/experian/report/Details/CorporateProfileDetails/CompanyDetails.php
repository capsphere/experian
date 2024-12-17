<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails;

use SimpleXMLElement;

class CompanyDetails
{
    public ?string $localNo = null;
    public ?string $oldRegNo = null;
    public ?string $newRegNo = null;
    public ?string $companyName = null;
    public ?string $incorporationDate = null;
    public ?string $companyType = null;
    public ?string $companyStatus = null;
    public ?string $businessAddress = null;
    public ?string $registeredAddress = null;
    public ?string $currency = null;
    public ?string $currencyRoundBracket = null;
    public ?string $totalAuthorisedCapital = null;
    public ?string $totalPaidUpCapital = null;
    public ?string $natureBusiness = null;
    public ?string $lastRamciUpdate = null;
    public array $summaryShareCapitalAuthorised = [];
    public array $summaryShareCapitalIssued = [];

    // Method to deserialize XML data into PreviousCompanyInterest object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->localNo = (string) $xml->local_no;
        $this->oldRegNo = (string) $xml->old_reg_no;
        $this->newRegNo = (string) $xml->new_reg_no;
        $this->companyName = (string) $xml->company_name;
        $this->incorporationDate = (string) $xml->incorporation_date;
        $this->companyType = (string) $xml->company_type;
        $this->companyStatus = (string) $xml->company_status;
        $this->businessAddress = (string) $xml->addresses->business_address;
        $this->registeredAddress = (string) $xml->addresses->registered_address;
        $this->currency = (string) $xml->addresses->currency;
        $this->currencyRoundBracket = (string) $xml->addresses->currency_round_bracket;
        $this->totalAuthorisedCapital = (string) $xml->total_authorised_capital;
        $this->totalPaidUpCapital = (string) $xml->total_paid_up_capital;
        $this->natureBusiness = (string) $xml->nature_businesses->nature_business;
        $this->lastRamciUpdate = (string) $xml->last_ramci_update;

        $this->summaryShareCapitalAuthorised = [
            'total' => (float) $xml->summary_share_capital->authorised->total,
            'ordinary_amount' => (float) $xml->summary_share_capital->authorised->ordinary->amount,
            'ordinary_divided_into' => (float) $xml->summary_share_capital->authorised->ordinary->divided_into,
            'ordinary_normal_value_sen' => (float) $xml->summary_share_capital->authorised->ordinary->normal_value_sen,
            'preference_amount' => (float) $xml->summary_share_capital->authorised->preference->amount,
            'preference_divided_into' => (float) $xml->summary_share_capital->authorised->preference->divided_into,
            'preference_normal_value_sen' => (float) $xml->summary_share_capital->authorised->preference->normal_value_sen,
            'others_amount' => (float) $xml->summary_share_capital->authorised->others->amount,
            'others_divided_into' => (float) $xml->summary_share_capital->authorised->others->divided_into,
            'others_normal_value_sen' => (float) $xml->summary_share_capital->authorised->others->normal_value_sen,
        ];

        $this->summaryShareCapitalIssued = [
            'total' => (float) $xml->summary_share_capital->issued_paid_up->total,
            'ordinary_cash' => (float) $xml->summary_share_capital->issued_paid_up->ordinary->cash,
            'ordinary_non_cash' => (float) $xml->summary_share_capital->issued_paid_up->ordinary->{'non-cash'},
            'ordinary_normal_value_sen' => (float) $xml->summary_share_capital->issued_paid_up->ordinary->normal_value_sen,
            'preference_cash' => (float) $xml->summary_share_capital->issued_paid_up->preference->cash,
            'preference_non_cash' => (float) $xml->summary_share_capital->issued_paid_up->preference->{'non-cash'},
            'preference_normal_value_sen' => (float) $xml->summary_share_capital->issued_paid_up->preference->normal_value_sen,
            'others_cash' => (float) $xml->summary_share_capital->issued_paid_up->others->cash,
            'others_non_cash' => (float) $xml->summary_share_capital->issued_paid_up->others->{'non-cash'},
            'others_normal_value_sen' => (float) $xml->summary_share_capital->issued_paid_up->others->normal_value_sen,
        ];

        return $this;
    }

    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'local_no' => $this->localNo,
            'old_reg_no' => $this->oldRegNo,
            'new_reg_no' => $this->newRegNo,
            'company_name' => $this->companyName,
            'incorporation_date' => $this->incorporationDate,
            'company_type' => $this->companyType,
            'company_status' => $this->companyStatus,
            'business_address' => $this->businessAddress,
            'registered_address' => $this->registeredAddress,
            'currency' => $this->currency,
            'currency_round_bracket' => $this->currencyRoundBracket,
            'total_authorised_capital' => $this->totalAuthorisedCapital,
            'total_paid_up_capital' => $this->totalPaidUpCapital,
            'nature_business' => $this->natureBusiness,
            'last_ramci_update' => $this->lastRamciUpdate,
            'summary_share_capital_authorised' => $this->summaryShareCapitalAuthorised,
            'summary_share_capital_issued' => $this->summaryShareCapitalIssued,
        ];
    }

    public function toJSON(): string{
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);
        
        $this->localNo = (string) $data['local_no'];
        $this->oldRegNo = (string) $data['old_reg_no'];
        $this->newRegNo = (string) $data['new_reg_no'];
        $this->companyName = (string) $data['company_name'];
        $this->incorporationDate = (string) $data['incorporation_date'];
        $this->companyType = (string) $data['company_type'];
        $this->companyStatus = (string) $data['company_status'];
        $this->businessAddress = (string) $data['addresses']['business_address'];
        $this->registeredAddress = (string) $data['addresses']['registered_address'];
        $this->currency = (string) $data['addresses']['currency'];
        $this->currencyRoundBracket = (string) $data['addresses']['currency_round_bracket'];
        $this->totalAuthorisedCapital = (string) $data['total_authorised_capital'];
        $this->totalPaidUpCapital = (string) $data['total_paid_up_capital'];
        $this->natureBusiness = (string) $data['nature_businesses']['nature_business'];
        $this->lastRamciUpdate = (string) $data['last_ramci_update'];

        $this->summaryShareCapitalAuthorised = [
            'total' => (float) $data['summary_share_capital']['authorised']['total'],
            'ordinary_amount' => (float) $data['summary_share_capital']['authorised']['ordinary']['amount'],
            'ordinary_divided_into' => (float) $data['summary_share_capital']['authorised']['ordinary']['divided_into'],
            'ordinary_normal_value_sen' => (float) $data['summary_share_capital']['authorised']['ordinary']['normal_value_sen'],
            'preference_amount' => (float) $data['summary_share_capital']['authorised']['preference']['amount'],
            'preference_divided_into' => (float) $data['summary_share_capital']['authorised']['preference']['divided_into'],
            'preference_normal_value_sen' => (float) $data['summary_share_capital']['authorised']['preference']['normal_value_sen'],
            'others_amount' => (float) $data['summary_share_capital']['authorised']['others']['amount'],
            'others_divided_into' => (float) $data['summary_share_capital']['authorised']['others']['divided_into'],
            'others_normal_value_sen' => (float) $data['summary_share_capital']['authorised']['others']['normal_value_sen'],
        ];

        $this->summaryShareCapitalIssued = [
            'total' => (float) $data['summary_share_capital']['issued_paid_up']['total'],
            'ordinary_cash' => (float) $data['summary_share_capital']['issued_paid_up']['ordinary']['cash'],
            'ordinary_non_cash' => (float) $data['summary_share_capital']['issued_paid_up']['ordinary']['non-cash'],
            'ordinary_normal_value_sen' => (float) $data['summary_share_capital']['issued_paid_up']['ordinary']['normal_value_sen'],
            'preference_cash' => (float) $data['summary_share_capital']['issued_paid_up']['preference']['cash'],
            'preference_non_cash' => (float) $data['summary_share_capital']['issued_paid_up']['preference']['non-cash'],
            'preference_normal_value_sen' => (float) $data['summary_share_capital']['issued_paid_up']['preference']['normal_value_sen'],
            'others_cash' => (float) $data['summary_share_capital']['issued_paid_up']['others']['cash'],
            'others_non_cash' => (float) $data['summary_share_capital']['issued_paid_up']['others']['non-cash'],
            'others_normal_value_sen' => (float) $data['summary_share_capital']['issued_paid_up']['others']['normal_value_sen'],
        ];




        return $this;
    }



    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<CompanyDetails/>');

        $xml->addChild('local_no', $this->localNo);
        $xml->addChild('old_reg_no', $this->oldRegNo);
        $xml->addChild('new_reg_no', $this->newRegNo);
        $xml->addChild('company_name', $this->companyName);
        $xml->addChild('incorporation_date', $this->incorporationDate);
        $xml->addChild('company_type', $this->companyType);
        $xml->addChild('company_status', $this->companyStatus);

        $addresses = $xml->addChild('addresses');
        $addresses->addChild('business_address', $this->businessAddress);
        $addresses->addChild('registered_address', $this->registeredAddress);
        $addresses->addChild('currency', $this->currency);
        $addresses->addChild('currency_round_bracket', $this->currencyRoundBracket);

        $xml->addChild('total_authorised_capital', $this->totalAuthorisedCapital);
        $xml->addChild('total_paid_up_capital', $this->totalPaidUpCapital);
        $xml->addChild('nature_business', $this->natureBusiness);
        $xml->addChild('last_ramci_update', $this->lastRamciUpdate);

        $authorised = $xml->addChild('summary_share_capital')->addChild('authorised');
        foreach ($this->summaryShareCapitalAuthorised as $key => $value) {
            $authorised->addChild($key, (string)$value);
        }

        $issued = $xml->addChild('summary_share_capital')->addChild('issued_paid_up');
        foreach ($this->summaryShareCapitalIssued as $key => $value) {
            $issued->addChild($key, (string)$value);
        }

        return $xml->asXML();
    }
}
