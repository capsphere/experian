<?php

namespace Capsphere\PhpCore\Domain\Experian\Report;

use Capsphere\PhpCore\Domain\Experian\Report\Details\AmlSanction;
use Capsphere\PhpCore\Domain\Experian\Report\Details\BankingInfo;
use Capsphere\PhpCore\Domain\Experian\Report\Details\CorporateProfile;
use Capsphere\PhpCore\Domain\Experian\Report\Details\Enquiry;
use Capsphere\PhpCore\Domain\Experian\Report\Details\LegendGen2;
use Capsphere\PhpCore\Domain\Experian\Report\Details\LitigationInfo;
use Capsphere\PhpCore\Domain\Experian\Report\Details\Subscriber;
use Capsphere\PhpCore\Domain\Experian\Report\Details\Summary;
use Capsphere\PhpCore\Domain\Experian\Report\Details\TradeBureau;
use InvalidArgumentException;
use SimpleXMLElement;

class CreditReport
{
    public ?String $reportDate = null;
    public ?Summary $summary = null;
    public ?BankingInfo $bankingInfo = null;
    public ?CorporateProfile $corporateProfile = null;
    public ?LitigationInfo $litigationInfo = null;
    public ?TradeBureau $tradeBureau = null;
    public ?LegendGen2 $legendGen2 = null;
    public ?Enquiry $enquiry = null;
    public ?AmlSanction $amlSanction = null;
    public ?Subscriber $subscriber = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        // #1 report date
        if (isset($xml->report_date) && !empty($xml->report_date)) {
            $this->reportDate = (string) $xml->report_date;
        }

        // #2 summary or executive summary
        if (isset($xml->summary) && !empty($xml->summary)) {
            $this->summary = (new Summary())->fromXML($xml->summary);
        } else if (isset($xml->executive_summary) && !empty($xml->executive_summary)) {
            $this->summary = (new Summary())->fromXML($xml->executive_summary);
        }

        // #3 corporate profile
        if (isset($xml->corporate_profile) && !empty($xml->corporate_profile)) {
            $this->corporateProfile = (new CorporateProfile())->fromXML($xml->corporate_profile);
        }

        // #4 banking info
        if (isset($xml->banking_info) && !empty($xml->banking_info)) {
            $this->bankingInfo = (new BankingInfo())->fromXML($xml->banking_info);
        }

        // #5 litigation info
        if (isset($xml->litigation_info) && !empty($xml->litigation_info)) {
            $this->litigationInfo = (new LitigationInfo())->fromXML($xml->litigation_info);
        }

        // #6 trade bureau
        if (isset($xml->trade_bureau) && !empty($xml->trade_bureau)) {
            $this->tradeBureau = (new TradeBureau())->fromXML($xml->trade_bureau);
        }

        // #7 aml sanction
        if (isset($xml->aml_sanction) && !empty($xml->aml_sanction)) {
            $this->amlSanction = (new AmlSanction())->fromXML($xml->aml_sanction);
        }

        // #8 enquiry
        if (isset($xml->enquiry) && !empty($xml->enquiry)) {
            $this->enquiry = (new Enquiry())->fromXML($xml->enquiry);
        }

        // #9 end (subscriber)
        if (isset($xml->end) && !empty($xml->end)) {
            $this->subscriber = (new Subscriber())->fromXML($xml->end);
        }

        return $this;
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function fromJSON(string $json): self{
        // TODO implement
        $decoded = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON: " . json_last_error_msg());
        }


        if (isset($decoded['report_date']) && !empty($decoded['report_date'])) {
            $this->reportDate = (string)$decoded['report_date'];
        }


        if (isset($decoded['summary']) && !empty($decoded['summary'])) {
            $this->summary = (new Summary())->fromJSON(json_encode($decoded['summary']));
        } elseif (isset($decoded['executive_summary']) && !empty($decoded['executive_summary'])) {
            $this->summary = (new Summary())->fromJSON(json_encode($decoded['executive_summary']));
        }

        
        if (isset($decoded['corporate_profile']) && !empty($decoded['corporate_profile'])) {
            $this->corporateProfile = (new CorporateProfile())->fromJSON(json_encode($decoded['corporate_profile']));
        }

        
        if (isset($decoded['banking_info']) && !empty($decoded['banking_info'])) {
            $this->bankingInfo = (new BankingInfo())->fromJSON(json_encode($decoded['banking_info']));
        }

        
        if (isset($decoded['litigation_info']) && !empty($decoded['litigation_info'])) {
            $this->litigationInfo = (new LitigationInfo())->fromJSON(json_encode($decoded['litigation_info']));
        }

        
        if (isset($decoded['trade_bureau']) && !empty($decoded['trade_bureau'])) {
            $this->tradeBureau = (new TradeBureau())->fromJSON(json_encode($decoded['trade_bureau']));
        }

        
        if (isset($decoded['aml_sanction']) && !empty($decoded['aml_sanction'])) {
            $this->amlSanction = (new AmlSanction())->fromJSON(json_encode($decoded['aml_sanction']));
        }

        
        if (isset($decoded['enquiry']) && !empty($decoded['enquiry'])) {
            $this->enquiry = (new Enquiry())->fromJSON(json_encode($decoded['enquiry']));
        }

        
        if (isset($decoded['end']) && !empty($decoded['end'])) {
            $this->subscriber = (new Subscriber())->fromJSON(json_encode($decoded['end']));
        }


        return $this;
    }


    public function convertToXml(SimpleXMLElement $parent = null): SimpleXMLElement
    {

        if ($parent === null) {
            $parent = new SimpleXMLElement('<summary></summary>');
        }

        // Use the existing toArray() method to get the data
        $data = $this->toArray();

        // Recursively convert the array to XML
        $this->arrayToXmlStructure($data, $parent);

        return $parent;
    }


    public function arrayToXmlStructure(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item'; // Handle numeric keys, defaulting to 'item'
            }

            if (is_array($value)) {
                // Add a child element and recursively process nested arrays
                $child = $xml->addChild($key);
                $this->arrayToXmlStructure($value, $child);
            } elseif (is_object($value)) {
                if (method_exists($value, 'toArray')) {
                    $child = $xml->addChild($key);
                    $this->arrayToXmlStructure($value->toArray(), $child);
                } else {
                    throw new InvalidArgumentException("Need to have toArray() method to be converted to XML.");
                }
            } elseif ($value !== null) {
                // Add scalar values directly to the XML
                $xml->addChild($key, htmlspecialchars((string)$value));
            }
        }
    }

    

    public function toArray(): array
    {
        return [
            'report_date' => $this->reportDate,
            'summary' => $this->summary ? $this->summary->toArray() : null,
            'corporate_profile' => $this->corporateProfile ? $this->corporateProfile->toArray() : null,
            'banking_info' => $this->bankingInfo ? $this->bankingInfo->toArray() : null,
            'litigation_info' => $this->litigationInfo ? $this->litigationInfo->toArray() : null,
            'trade_bureau' => $this->tradeBureau ? $this->tradeBureau->toArray() : null,
            'aml_sanction' => $this->amlSanction ? $this->amlSanction->toArray() : null,
            'enquiry' => $this->enquiry ? $this->enquiry->toArray() : null,
            'end' => $this->subscriber ? $this->subscriber->toArray() : null,
        ];
    }
}
