<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails;

use SimpleXMLElement;

class CcrisKeyStatistics
{
    public array $earlier_aprv_facility = [];
    public array $latest_aprv_facility = [];
    public ?array $secured_facility = null;
    public ?array $unsecured_facility = null;
    public ?array $average_utilize_months = null;
    public ?array $utilization_12months_chargecard = null;
    public ?int $no_of_facility_education_loan = null;
    public ?int $no_of_local_lenders = null;
    public ?int $no_of_foreign_lenders = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        foreach ($xml->earlier_aprv_facility->item as $item) {
            $this->earlier_aprv_facility[] = [
                'Date' => (string) $item->Date,
                'Facility' => (string) $item->Facility,
                'Total' => isset($item->Total) ? (int) $item->Total : null
            ];
        }

        $this->latest_aprv_facility = [];
        foreach (['facility_1', 'facility_2', 'facility_3'] as $facilityKey) {
            if (isset($xml->latest_aprv_facility->$facilityKey)) {
                $facility = $xml->latest_aprv_facility->$facilityKey;
                $this->latest_aprv_facility[$facilityKey] = [
                    'Date' => isset($facility->Date) ? (string) $facility->Date : null,
                    'Facility' => isset($facility->Facility) ? (string) $facility->Facility : null,
                ];
            }
        }

        $this->secured_facility = [
            'no_of_facility' => (int) $xml->secured_facility->no_of_facility,
            'total_outstanding_balance' => (float) $xml->secured_facility->total_outstanding_balance,
            'total_outstanding_against_ttllimit' => (float) $xml->secured_facility->total_outstanding_against_ttllimit,
            'max_iia_last_12months' => (int) $xml->secured_facility->max_iia_last_12months
        ];

        $this->unsecured_facility = [
            'no_of_facility' => (int) $xml->unsecured_facility->no_of_facility,
            'total_outstanding_balance' => (float) $xml->unsecured_facility->total_outstanding_balance,
            'total_outstanding_against_ttllimit' => (float) $xml->unsecured_facility->total_outstanding_against_ttllimit,
            'max_iia_last_12months' => (int) $xml->unsecured_facility->max_iia_last_12months
        ];

        $this->average_utilize_months = [
            'cc' => (float) $xml->average_utilize_months->cc,
            'others' => (float) $xml->average_utilize_months->others
        ];

        $this->utilization_12months_chargecard = [
            'min_utilization' => isset($xml->utilization_12months_chargecard->min_utilization) ? (string) $xml->utilization_12months_chargecard->min_utilization : null,
            'max_utilization' => isset($xml->utilization_12months_chargecard->max_utilization) ? (string) $xml->utilization_12months_chargecard->max_utilization : null
        ];

        $this->no_of_facility_education_loan = (int) $xml->no_of_facility_education_loan;
        $this->no_of_local_lenders = (int) $xml->no_of_local_lenders;
        $this->no_of_foreign_lenders = (int) $xml->no_of_foreign_lenders;

        return $this;
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);

        foreach ($data['earlier_aprv_facility'] as $item) {
            $this->earlier_aprv_facility[] = [
                'Date' => (string) $item['Date'],
                'Facility' => (string) $item['Facility'],
                'Total' => isset($item['Total']) ? (int) $item['Total'] : null
            ];
        }

        $this->latest_aprv_facility = [];
        foreach (['facility_1', 'facility_2', 'facility_3'] as $facilityKey) {
            if (isset($data['latest_aprv_facility'][$facilityKey])) {
                $facility = $data['latest_aprv_facility'][$facilityKey];
                $this->latest_aprv_facility[$facilityKey] = [
                    'Date' => isset($facility['Date']) ? (string) $facility['Date'] : null,
                    'Facility' => isset($facility['Facility']) ? (string) $facility['Facility'] : null,
                ];
            }
        }

        $this->secured_facility = [
            'no_of_facility' => (int) $data['secured_facility']['no_of_facility'],
            'total_outstanding_balance' => (float) $data['secured_facility']['total_outstanding_balance'],
            'total_outstanding_against_ttllimit' => (float) $data['secured_facility']['total_outstanding_against_ttllimit'],
            'max_iia_last_12months' => (int) $data['secured_facility']['max_iia_last_12months']
        ];

        $this->unsecured_facility = [
            'no_of_facility' => (int) $data['unsecured_facility']['no_of_facility'],
            'total_outstanding_balance' => (float) $data['unsecured_facility']['total_outstanding_balance'],
            'total_outstanding_against_ttllimit' => (float) $data['unsecured_facility']['total_outstanding_against_ttllimit'],
            'max_iia_last_12months' => (int) $data['unsecured_facility']['max_iia_last_12months']
        ];

        $this->average_utilize_months = [
            'cc' => (float) $data['average_utilize_months']['cc'],
            'others' => (float) $data['average_utilize_months']['others']
        ];

        $this->utilization_12months_chargecard = [
            'min_utilization' => isset($data['utilization_12months_chargecard']['min_utilization']) ? (string) $data['utilization_12months_chargecard']['min_utilization'] : null,
            'max_utilization' => isset($data['utilization_12months_chargecard']['max_utilization']) ? (string) $data['utilization_12months_chargecard']['max_utilization'] : null
        ];

        $this->no_of_facility_education_loan = (int) $data['no_of_facility_education_loan'];
        $this->no_of_local_lenders = (int) $data['no_of_local_lenders'];
        $this->no_of_foreign_lenders = (int) $data['no_of_foreign_lenders'];


        return $this;
    }



    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<CcrisKeyStatistics/>');

        $earlierFacility = $xml->addChild('earlier_aprv_facility');
        foreach ($this->earlier_aprv_facility as $facility) {
            $item = $earlierFacility->addChild('item');
            $item->addChild('Date', $facility['Date']);
            $item->addChild('Facility', $facility['Facility']);
            $item->addChild('Total', $facility['Total']);
        }

        
        $latestFacility = $xml->addChild('latest_aprv_facility');
        foreach ($this->latest_aprv_facility as $key => $facility) {
            $child = $latestFacility->addChild($key);
            $child->addChild('Date', $facility['Date']);
            $child->addChild('Facility', $facility['Facility']);
        }

        
        if ($this->secured_facility) {
            $secured = $xml->addChild('secured_facility');
            foreach ($this->secured_facility as $key => $value) {
                $secured->addChild($key, (string) $value);
            }
        }

        
        if ($this->unsecured_facility) {
            $unsecured = $xml->addChild('unsecured_facility');
            foreach ($this->unsecured_facility as $key => $value) {
                $unsecured->addChild($key, (string) $value);
            }
        }

    
        if ($this->average_utilize_months) {
            $averageUtilization = $xml->addChild('average_utilize_months');
            foreach ($this->average_utilize_months as $key => $value) {
                $averageUtilization->addChild($key, (string) $value);
            }
        }

        
        if ($this->utilization_12months_chargecard) {
            $utilization = $xml->addChild('utilization_12months_chargecard');
            foreach ($this->utilization_12months_chargecard as $key => $value) {
                $utilization->addChild($key, (string) $value);
            }
        }

        
        $xml->addChild('no_of_facility_education_loan', (string) $this->no_of_facility_education_loan);
        $xml->addChild('no_of_local_lenders', (string) $this->no_of_local_lenders);
        $xml->addChild('no_of_foreign_lenders', (string) $this->no_of_foreign_lenders);

        return $xml->asXML();
    }

    public function toArray(): array
    {
        return [
            'earlier_aprv_facility' => $this->earlier_aprv_facility,
            'latest_aprv_facility' => $this->latest_aprv_facility,
            'secured_facility' => $this->secured_facility,
            'unsecured_facility' => $this->unsecured_facility,
            'average_utilize_months' => $this->average_utilize_months,
            'utilization_12months_chargecard' => $this->utilization_12months_chargecard,
            'no_of_facility_education_loan' => $this->no_of_facility_education_loan,
            'no_of_local_lenders' => $this->no_of_local_lenders,
            'no_of_foreign_lenders' => $this->no_of_foreign_lenders
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
