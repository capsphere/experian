<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails;

use SimpleXMLElement;

class CcrisBankingSummary
{
    public ?array $summary_credit_report = null;
    public ?array $summary_liabilities = null;

    // Method to deserialize XML into the CcrisBankingSummary object
    public function fromXML(SimpleXMLElement $xml): self
    {
        // Deserialize summary_credit_report
        $this->summary_credit_report = [
            'approved_count' => (int) $xml->summary_credit_report->approved_count,
            'approved_amount' => (int) $xml->summary_credit_report->approved_amount,
            'pending_count' => (int) $xml->summary_credit_report->pending_count,
            'pending_amount' => (int) $xml->summary_credit_report->pending_amount,
        ];

        // Deserialize summary_liabilities
        $this->summary_liabilities = [
            'borrower' => [
                'outstanding' => (float) $xml->summary_liabilities->borrower->outstanding,
                'total_limit' => (float) $xml->summary_liabilities->borrower->total_limit,
                'fec_limit' => (float) $xml->summary_liabilities->borrower->fec_limit
            ],
            'legal_action_taken' => (string) $xml->summary_liabilities->legal_action_taken,
            'special_attention_account' => (string) $xml->summary_liabilities->special_attention_account
        ];

        return $this;
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);

        $this->summary_credit_report = [
            'approved_count' => (int) $data['summary_credit_report']['approved_count'],
            'approved_amount' => (int) $data['summary_credit_report']['approved_amount'],
            'pending_count' => (int) $data['summary_credit_report']['pending_count'],
            'pending_amount' => (int) $data['summary_credit_report']['pending_amount'],
        ];

        $this->summary_liabilities = [
            'borrower' => [
                'outstanding' => (float) $data['summary_liabilities']['borrower']['outstanding'],
                'total_limit' => (float) $data['summary_liabilities']['borrower']['total_limit'],
                'fec_limit' => (float) $data['summary_liabilities']['borrower']['fec_limit']
            ],
            'legal_action_taken' => (string) $data['summary_liabilities']['legal_action_taken'],
            'special_attention_account' => (string) $data['summary_liabilities']['special_attention_account']
        ];

        return $this;
    }

    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<CcrisKeyStatistics/>');

        $creditReport = $xml->addChild('summary_credit_report');
        $creditReport->addChild('approved_count', (string) $this->summary_credit_report['approved_count']);
        $creditReport->addChild('approved_amount', (string) $this->summary_credit_report['approved_amount']);
        $creditReport->addChild('pending_count', (string) $this->summary_credit_report['pending_count']);
        $creditReport->addChild('pending_amount', (string) $this->summary_credit_report['pending_amount']);

        $liabilities = $xml->addChild('summary_liabilities');
        $borrower = $liabilities->addChild('borrower');
        $borrower->addChild('outstanding', (string) $this->summary_liabilities['borrower']['outstanding']);
        $borrower->addChild('total_limit', (string) $this->summary_liabilities['borrower']['total_limit']);
        $borrower->addChild('fec_limit', (string) $this->summary_liabilities['borrower']['fec_limit']);
        
        $liabilities->addChild('legal_action_taken', (string) $this->summary_liabilities['legal_action_taken']);
        $liabilities->addChild('special_attention_account', (string) $this->summary_liabilities['special_attention_account']);

        return $xml->asXML();
    }

    // Convert the object to an associative array with snake_case keys
    public function toArray(): array
    {
        return [
            'summary_credit_report' => $this->summary_credit_report,
            'summary_liabilities' => $this->summary_liabilities
        ];
    }

    // Convert the object to a JSON string with snake_case keys
    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
