<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;
use Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails\InputRequest;
use Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails\CcrisInfo;
use Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails\CcrisAddress;
use Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails\InfoSummary;
use Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails\IScore;
use Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails\PreviousCompanyInterest;
use InvalidArgumentException;

class Summary
{
    public ?InputRequest $inputRequest = null;
    public ?CcrisInfo $ccrisInfo = null;
    public array $ccrisAddress = [];
    public ?InfoSummary $infoSummary = null;
    public ?IScore $iScore = null;
    public array $previousCompanyInterests = [];

    public function fromXML(SimpleXMLElement $xml): self
    {
        // #1 input request 
        if (isset($xml->input_request) && !empty($xml->input_request)) {
            $this->inputRequest = (new InputRequest())->fromXML($xml->input_request);
        }

        // #2 ccris info (individual or corporate)
        if (isset($xml->ccris_individual_info) && !empty($xml->ccris_individual_info)) {
            $this->ccrisInfo = (new CcrisInfo())->fromXML($xml->ccris_individual_info);
        } else if (isset($xml->ccris_corporate_info) && !empty($xml->ccris_corporate_info)) {
            $this->ccrisInfo = (new CcrisInfo())->fromXML($xml->ccris_corporate_info);
        }

        // #3 ccris address (individual or corporate)
        if (isset($xml->ccris_individual_addresses) && !empty($xml->ccris_individual_addresses)) {
            foreach ($xml->ccris_individual_addresses->ccris_individual_address as $addressXml) {
                $address = (new CcrisAddress())->fromXML($addressXml);
                $this->ccrisAddress[] = $address;
            }
        } else if (isset($xml->ccris_corporate_addresses) && !empty($xml->ccris_corporate_addresses)) {
            foreach ($xml->ccris_corporate_addresses->ccris_corporate_address as $addressXml) {
                $address = (new CcrisAddress())->fromXML($addressXml);
                $this->ccrisAddress[] = $address;
            }
        }

        // #4 info summary
        $this->infoSummary = (new InfoSummary())->fromXML($xml->info_summary);

        // #5 iscore
        $this->iScore = (new IScore())->fromXML($xml->i_score);

        // #6 previous company interest
        if (isset($xml->previous_company_interests) && !empty($xml->previous_company_interests)) {
            foreach ($xml->previous_company_interests->previous_company_interest as $interestXml) {
                $interest = (new PreviousCompanyInterest())->fromXML($interestXml);
                $this->previousCompanyInterests[] = $interest;
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'input_request' => $this->inputRequest ? $this->inputRequest->toArray() : null,
            'ccris_info' => $this->ccrisInfo ? $this->ccrisInfo->toArray() : null,
            'ccris_addresses' => array_map(fn($address) => $address->toArray(), $this->ccrisAddress),
            'info_summary' => $this->infoSummary ? $this->infoSummary->toArray() : null,
            'i_score' => $this->iScore ? $this->iScore->toArray() : null,
            'previous_company_interests' => array_map(fn($interest) => $interest->toArray(), $this->previousCompanyInterests),
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


        if (isset($data['input_request']) && !empty($data['input_request'])) {
            $this->inputRequest = (new InputRequest())->fromJSON(json_encode($data['input_request']));
            // print_r($this->inputRequest);
        }


        $this->ccrisInfo = (new CcrisInfo())->fromJSON(json_encode($data['ccris_info']));

        
        if (is_array($data['ccris_addresses'])) {
            foreach ($data['ccris_addresses'] as $addressData) {
                $this->ccrisAddress[] = (new CcrisAddress())->fromJSON(json_encode($addressData));
            }
            // print_r($this->ccrisAddress); 
        } else {
            echo "ccris_addresses is not an array.";
        }
        // print_r($this->ccrisAddress); 


        $this->infoSummary = (new InfoSummary())->fromJSON(json_encode($data['info_summary']));
        // print_r($this->infoSummary);
        
        
        $this->iScore = (new IScore())->fromJSON(json_encode($data['i_score']));
        // print_r($this->iScore);

        
        if (isset($data['previous_company_interests']) && !empty($data['previous_company_interests'])) {
            foreach ($data['previous_company_interests'] as $interestJson) {
                $interest = (new PreviousCompanyInterest())->fromJSON(json_encode($interestJson));
                $this->previousCompanyInterests[] = $interest;
            }
        }

        return $this;
    }

    public function convertToXml(SimpleXMLElement $parent = null): SimpleXMLElement{
        if ($parent === null) {
            $parent = new SimpleXMLElement('<summary></summary>');
        }

        if ($this->inputRequest) {
            $this->inputRequest->convertToXml($parent->addChild('input_request'));
        }

        if ($this->ccrisInfo) {
            $this->ccrisInfo->convertToXml($parent->addChild('ccris_individual_info'));
        }

        if (!empty($this->ccrisAddress)) {
            $addressesElement = $parent->addChild('ccris_individual_addresses');
            foreach ($this->ccrisAddress as $address) {
                $address->convertToXml($addressesElement->addChild('ccris_individual_address'));
            }
        }

        if ($this->infoSummary) {
            $this->infoSummary->convertToXml($parent->addChild('info_summary'));
        }

        if ($this->iScore) {
            $this->iScore->convertToXml($parent->addChild('i_score'));
        }

        if (!empty($this->previousCompanyInterests)) {
            $interestsElement = $parent->addChild('previous_company_interests');
            foreach ($this->previousCompanyInterests as $interest) {
                $interest->convertToXml($interestsElement->addChild('previous_company_interest'));
            }
        }

        return $parent;
    }


}
