<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;
use InvalidArgumentException;
use Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails\Directors;
use Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails\Shareholders;
use Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails\CompanyCharges;
use Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails\CompanyDetails;
use Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfileDetails\InterestsInOtherCompanies;

class CorporateProfile
{
    public ?CompanyDetails $companyDetails = null;
    public array $directors = [];
    public array $shareholders = [];
    public array $companyCharges = [];
    public array $interestsInOtherCompanies = [];

    // Method to deserialize XML data into Profile object
    public function fromXML(SimpleXMLElement $xml): self
    {
        if (isset($xml->company_details) && !empty($xml->company_details)) {
            $this->companyDetails = (new CompanyDetails())->fromXML($xml->company_details);
        }

        if (isset($xml->directors) && !empty($xml->directors)) {
            foreach ($xml->directors->director as $director) {
                $director = (new Directors())->fromXML($director);
                $this->directors[] = $director;
            }
        }

        if (isset($xml->shareholders) && !empty($xml->shareholders)) {
            foreach ($xml->shareholders->shareholder->item as $shareholder) {
                $shareholder = (new Shareholders())->fromXML($shareholder);
                $this->shareholders[] = $shareholder;
            }
        }

        if (isset($xml->company_charges) && !empty($xml->company_charges)) {
            foreach ($xml->company_charges->company_charge as $company_charge) {
                $company_charge = (new CompanyCharges())->fromXML($company_charge);
                $this->companyCharges[] = $company_charge;
            }
        }

        if (isset($xml->interests_in_other_company) && !empty($xml->interests_in_other_company)) {
            foreach ($xml->interests_in_other_company->item as $interest_in_other_company) {
                $interest_in_other_company = (new InterestsInOtherCompanies())->fromXML($interest_in_other_company);
                $this->interestsInOtherCompanies[] = $interest_in_other_company;
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'company_details' => $this->companyDetails ? $this->companyDetails->toArray() : null,
            'directors' => array_map(fn($directors) => $directors->toArray(), $this->directors),
            'shareholders' => array_map(fn($shareholders) => $shareholders->toArray(), $this->shareholders),
            'company_charges' => array_map(fn($companyCharges) => $companyCharges->toArray(), $this->companyCharges),
            'interests_in_other_companies' => array_map(fn($interestsInOtherCompanies) => $interestsInOtherCompanies->toArray(), $this->interestsInOtherCompanies),
        ];
    }
    
    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);
        if(json_last_error() !== JSON_ERROR_NONE){
            throw new InvalidArgumentException("Invalid JSON: ".json_last_error_msg());
        }
        

        if (isset($data['company_details']) && !empty($data['company_details'])) {
            $this->companyDetails = (new CompanyDetails())->fromJSON(json_encode($data['company_details']));
        }

        
        if (isset($data['directors']) && !empty($data['directors'])) {
            foreach($data['directors'] as $director){
                $director = (new Directors())-> fromJSON(json_encode($director));
                $this-> directors[] = $director;
            }
        }    

       
        if (isset($data['shareholders']) && !empty($data['shareholders'])) {
            foreach($data['shareholders'] as $shareholder){
                $shareholder = (new Shareholders())-> fromJSON(json_encode($shareholder));
                $this->shareholders[] = $shareholder;
            }
        }

        

        if (isset($data['company_charges']) && !empty($data['company_charges'])) {
            foreach ($data['company_charges'] as $company_charge) {
                $company_charge = (new CompanyCharges())->fromJSON(json_encode($company_charge));
                $this->companyCharges[] = $company_charge;
            }
        }

        if (isset($data['interests_in_other_company']) && !empty($data['interests_in_other_company'])) {
            foreach ($data['interests_in_other_company'] as $interest_in_other_company) {
                $interest_in_other_company = (new InterestsInOtherCompanies())->fromJSON(json_encode($interest_in_other_company));
                $this->interestsInOtherCompanies[] = $interest_in_other_company;
            }
        }
        // print_r($data);

        return $this;
    }


    public function convertToXml(SimpleXMLElement $parent = null): SimpleXMLElement
    {
        if ($parent === null) {
            $parent = new SimpleXMLElement('<corporate_profile></corporate_profile>');
        }

        $data = $this->toArray();
        $this->arrayToXmlStructure($data, $parent);
        // if ($parent === null) {
        //     $parent = new SimpleXMLElement('<CorporateProfile></CorporateProfile>');
        // }

        
        // if ($this->companyDetails !== null) {
        //     $companyDetailsXml = $parent->addChild('company_details');
        //     $this->companyDetails->convertToXml($companyDetailsXml); 
        // }

        // if ($this->directors !== null) {
        //     $directorsXml = $parent->addChild('directors');
        //     foreach ($this->directors as $director) {
        //         $directorXml = $directorsXml->addChild('director');
        //         $director->convertToXml($directorXml);
        //     }
        // }
    
        // if ($this->shareholders !== null) {
        //     $shareholdersXml = $parent->addChild('shareholders');
        //     foreach ($this->shareholders as $shareholder) {
        //         $shareholderXml = $shareholdersXml->addChild('shareholder');
        //         $shareholder->convertToXml($shareholderXml);
        //     }
        // }
    
        // if ($this->companyCharges !== null) {
        //     $companyChargesXml = $parent->addChild('company_charges');
        //     foreach ($this->companyCharges as $companyCharge) {
        //         $companyChargeXml = $companyChargesXml->addChild('company_charge');
        //         $companyCharge->convertToXml($companyChargeXml);
        //     }
        // }
    
        // if (!empty($this->interestsInOtherCompanies)) {
        //     $interestsXml = $parent->addChild('interests_in_other_company');
        //     foreach ($this->interestsInOtherCompanies as $interestInOtherCompany) {
        //         $interestInOtherCompanyXml = $interestsXml->addChild('item');
        //         $interestInOtherCompany->convertToXml($interestInOtherCompanyXml);
        //     }
        // }
    
        return $parent;
    }

    private function arrayToXmlStructure(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            $xml->addChild($key, htmlspecialchars((string)$value));
        }
    }
}
