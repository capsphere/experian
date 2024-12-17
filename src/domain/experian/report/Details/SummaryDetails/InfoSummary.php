<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails;

use SimpleXMLElement;

class InfoSummary
{
    public ?int $creditApprovalCount = null;
    public ?int $creditPendingCount = null;
    public ?int $specialAttentionAccountCount = null;
    public ?int $legalActionBankingCount = null;
    public ?int $existingFacilityCount = null;
    public ?int $windingUpCount = null;
    public ?int $bankruptcyCount = null;
    public ?int $legalSuitCount = null;
    public ?int $tradeBureauCount = null;
    public ?int $enquiryCount = null;
    public ?int $interestCount = null;

    // Method to deserialize XML data into InfoSummary object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->creditApprovalCount = (int) $xml->credit_approval_count;
        $this->creditPendingCount = (int) $xml->credit_pending_count;
        $this->specialAttentionAccountCount = (int) $xml->special_attention_account_count;
        $this->legalActionBankingCount = (int) $xml->legal_action_banking_count;
        $this->existingFacilityCount = (int) $xml->existing_facility_count;
        $this->windingUpCount = (int) $xml->winding_up_count;
        $this->bankruptcyCount = (int) $xml->bankruptcy_count;
        $this->legalSuitCount = (int) $xml->legal_suit_count;
        $this->tradeBureauCount = (int) $xml->trade_bureau_count;
        $this->enquiryCount = (int) $xml->enquiry_count;
        $this->interestCount = (int) $xml->interest_count;

        return $this;
    }

    public function fromJSON(string $json): self{
        $data = json_decode($json, true);
        $this->creditApprovalCount = (int) $data['credit_approval_count'];
        $this->creditPendingCount = (int) $data['credit_pending_count'];
        $this->specialAttentionAccountCount = (int) $data['special_attention_account_count'];
        $this->legalActionBankingCount = (int) $data['legal_action_banking_count'];
        $this->existingFacilityCount = (int) $data['existing_facility_count'];
        $this->windingUpCount = (int) $data['winding_up_count'];
        $this->bankruptcyCount = (int) $data['bankruptcy_count'];
        $this->legalSuitCount = (int) $data['legal_suit_count'];
        $this->tradeBureauCount = (int) $data['trade_bureau_count'];
        $this->enquiryCount = (int) $data['enquiry_count'];
        $this->interestCount = (int) $data['interest_count'];

        return $this;
    }

    public function convertToXml(SimpleXMLElement $xml): SimpleXMLElement{
        $xml->addChild('credit_approval_count', (string) $this->creditApprovalCount ?? '');
        $xml->addChild('credit_pending_count', (string) $this->creditPendingCount ?? '');
        $xml->addChild('special_attention_account_count', (string) $this->specialAttentionAccountCount ?? '');
        $xml->addChild('legal_action_banking_count', (string) $this->legalActionBankingCount ?? '');
        $xml->addChild('existing_facility_count', (string) $this->existingFacilityCount ?? '');
        $xml->addChild('winding_up_count', (string) $this->windingUpCount ?? '');
        $xml->addChild('bankruptcy_count', (string) $this->bankruptcyCount ?? '');
        $xml->addChild('legal_suit_count', (string) $this->legalSuitCount ?? '');
        $xml->addChild('trade_bureau_count', (string) $this->tradeBureauCount ?? '');
        $xml->addChild('enquiry_count', (string) $this->enquiryCount ?? '');
        $xml->addChild('interest_count', (string) $this->interestCount ?? '');
    
        return $xml;
    }

    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'credit_approval_count' => $this->creditApprovalCount ? $this->creditApprovalCount : null,
            'credit_pending_count' => $this->creditPendingCount ? $this->creditPendingCount : null,
            'special_attention_account_count' => $this->specialAttentionAccountCount ? $this->specialAttentionAccountCount : null,
            'legal_action_banking_count' => $this->legalActionBankingCount ? $this->legalActionBankingCount : null,
            'existing_facility_count' => $this->existingFacilityCount ? $this->existingFacilityCount : null,
            'winding_up_count' => $this->windingUpCount ? $this->windingUpCount : null,
            'bankruptcy_count' => $this->bankruptcyCount ? $this->bankruptcyCount : null,
            'legal_suit_count' => $this->legalSuitCount ? $this->legalSuitCount : null,
            'trade_bureau_count' => $this->tradeBureauCount ? $this->tradeBureauCount : null,
            'enquiry_count' => $this->enquiryCount ? $this->enquiryCount : null,
            'interest_count' => $this->interestCount ? $this->interestCount : null,
        ];
    }
}
