<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;
use InvalidArgumentException;
use Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails\CcrisKeyStatistics;
use Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails\CcrisSelectedByYou;
use Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails\CcrisBankingDetails;
use Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails\CcrisBankingSummary;

class BankingInfo
{
    public ?CcrisSelectedByYou $ccrisSelectedByYou = null;
    public ?CcrisKeyStatistics $ccrisKeyStatistics = null;
    public ?CcrisBankingSummary $ccrisBankingSummary = null;
    public ?CcrisBankingDetails $ccrisBankingDetails = null;
    public ?string $ccrisBankingWarning = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->ccrisSelectedByYou = (new CcrisSelectedByYou())->fromXML($xml->ccris_selected_by_you);
        $this->ccrisKeyStatistics = (new CcrisKeyStatistics())->fromXML($xml->ccris_key_statistics);
        $this->ccrisBankingSummary = (new CcrisBankingSummary())->fromXML($xml->ccris_banking_summary);
        $this->ccrisBankingDetails = (new CcrisBankingDetails())->fromXML($xml->ccris_banking_details);
        $this->ccrisBankingWarning  = (string) $xml->ccris_banking_warning;
        return $this;
    }

    public function fromJSON(string $json): self{
        $data = json_decode($json, true);
        if(json_last_error() !== JSON_ERROR_NONE){
            throw new InvalidArgumentException("Invalid JSON: ".json_last_error_msg());
        }
        
        $this->ccrisSelectedByYou = (new CcrisSelectedByYou())->fromJSON(json_encode($data['ccris_selected_by_you']));
        $this->ccrisKeyStatistics = (new CcrisKeyStatistics())->fromJSON(json_encode($data['ccris_key_statistics']));
        $this->ccrisBankingSummary = (new CcrisBankingSummary())->fromJSON(json_encode($data['ccris_banking_summary']));
        $this->ccrisBankingDetails = (new CcrisBankingDetails())->fromJSON(json_encode($data['ccris_banking_details'])); //TODO change this
        $this->ccrisBankingWarning  = (string) json_encode($data['ccris_banking_warning']);
        // print_r($data);
        return $this;
    }

    public function convertToXml(SimpleXMLElement $parent = null): SimpleXMLElement{

        if($parent === null){
            $parent = new SimpleXMLElement('<BankingInfo></BankingInfo>');
        }

        $data = $this->toArray();
        $this->arrayToXmlStructure($data, $parent);   

        return $parent;
    }

    private function arrayToXmlStructure(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            $xml->addChild($key, htmlspecialchars((string)$value));
        }
    }

    public function toArray(): array
    {
        return [
            'ccris_banking_warning' => $this->ccrisBankingWarning,
            'ccris_selected_by_you' => $this->ccrisSelectedByYou,
            'ccris_key_statistics' => $this->ccrisKeyStatistics,
            'ccris_banking_summary' => $this->ccrisBankingSummary,
            'ccris_banking_details' => $this->ccrisBankingDetails
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
