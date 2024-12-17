<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails;

use SimpleXMLElement;
use InvalidArgumentException;

class CcrisBankingDetails
{
    public ?int $start_year = null;
    public ?int $end_year = null;
    public array $months = [];
    public array $outstanding_credit = [];
    public array $credit_application = [];
    public array $facilities_remark = [];
    public array $status_remark = [];
    public ?string $special_attention_account = null;
    public ?string $legal_remark = null;

    // Method to deserialize XML into CcrisBankingDetails object
    public function fromXML(SimpleXMLElement $xml): self
    {
        // Deserializing start_year and end_year
        $this->start_year = (int) $xml->start_year;
        $this->end_year = (int) $xml->end_year;

        // Deserializing months
        foreach ($xml->month->item as $monthItem) {
            $this->months[] = (string) $monthItem;
        }

        // Deserializing outstanding_credit (master and sub_account)
        foreach ($xml->outstanding_credit->item as $creditItem) {
            $master = [];
            foreach ($creditItem->master->item as $masterItem) {
                $master[] = [
                    'master_id' => (int) $masterItem->master_id,
                    'date' => (string) $masterItem->date,
                    'capacity' => (string) $masterItem->capacity,
                    'lender_type' => (string) $masterItem->lender_type,
                    'limit' => (float) $masterItem->limit,
                    'legal_status' => (string) $masterItem->legal_status,
                    'legal_status_date' => (string) $masterItem->legal_status_date,
                    'collateral_type' => (string) $masterItem->collateral_type,
                    'financial_group_resident_status' => (string) $masterItem->financial_group_resident_status,
                    'collateral_type_code' => (string) $masterItem->collateral_type_code
                ];
            }

            $subAccount = [];
            foreach ($creditItem->sub_account->item->item as $subItem) {
                $subAccount[] = [
                    'status' => (string) $subItem->status,
                    'restructure_reschedule_date' => (string) $subItem->restructure_reschedule_date,
                    'facility' => (string) $subItem->facility,
                    'total_outstanding_balance' => (float) $subItem->total_outstanding_balance,
                    'total_outstanding_balance_bnm' => (float) $subItem->total_outstanding_balance_bnm,
                    'balance_updated_date' => (string) $subItem->balance_updated_date,
                    'installment_amount' => (float) $subItem->installment_amount,
                    'principle_repayment_term' => (string) $subItem->principle_repayment_term,
                    'collateral_type' => (string) $subItem->collateral_type,
                    'credit_position' => array_map('intval', (array) $subItem->credit_position->item),
                    'collateral_type_code' => (string) $subItem->collateral_type_code
                ];
            }

            $this->outstanding_credit[] = [
                'master' => $master,
                'sub_account' => $subAccount
            ];
        }

        // Deserializing credit_application
        foreach ($xml->credit_application->item as $applicationItem) {
            $this->credit_application[] = [
                'application_id' => (int) $applicationItem->application_id,
                'application_date' => (string) $applicationItem->application_date,
                'status' => (string) $applicationItem->status,
                'application_type' => (string) $applicationItem->application_type,
                'capacity' => (string) $applicationItem->capacity,
                'lender_type' => (string) $applicationItem->lender_type,
                'facility' => (string) $applicationItem->facility,
                'amount_applied' => (float) $applicationItem->amount_applied,
                'financial_group_resident_status' => (string) $applicationItem->financial_group_resident_status
            ];
        }

        // Deserializing facilities_remark
        foreach ($xml->facilities_remark->item as $facilityRemark) {
            $this->facilities_remark[] = [
                'code' => (string) $facilityRemark->code,
                'desc' => (string) $facilityRemark->desc
            ];
        }

        // Deserializing status_remark
        foreach ($xml->status_remark->item as $status_remark) {
            $this->status_remark[] = [
                'code' => (string) $status_remark->code,
                'desc' => (string) $status_remark->desc
            ];
        }

        // Special attention account and legal remark (empty elements)
        $this->special_attention_account = (string) $xml->special_attention_account;
        $this->legal_remark = (string) $xml->legal_remark;

        return $this;
    }


    public function fromJSON(string $json): self{
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON: " . json_last_error_msg());
        }

        $this->start_year = $data['start_year'] ?? null;
        $this->end_year = $data['end_year'] ?? null;

        if (!empty($data['months']) && is_array($data['months'])) {
            foreach ($data['months'] as $monthItem) {
                $this->months[] = (string) $monthItem;
            }
        } else {
            $this->months = []; 
        }



        foreach ($data['outstanding_credit'] as $creditItem) {
            $master = [];
            foreach ($creditItem['master'] as $masterItem) {
                $master[] = [
                    'master_id' => (int) $masterItem['master_id'],
                    'date' => (string) $masterItem['date'],
                    'capacity' => (string) $masterItem['capacity'],
                    'lender_type' => (string) $masterItem['lender_type'],
                    'limit' => (float) $masterItem['limit'],
                    'legal_status' => (string) $masterItem['legal_status'],
                    'legal_status_date' => (string) $masterItem['legal_status_date'],
                    'collateral_type' => (string) $masterItem['collateral_type'],
                    'financial_group_resident_status' => (string) $masterItem['financial_group_resident_status'],
                    'collateral_type_code' => (string) $masterItem['collateral_type_code']
                ];
            }

            $subAccount = [];
            foreach ($creditItem['sub_account'] as $subItem) {
                $subAccount[] = [
                    'status' => (string) $subItem['status'],
                    'restructure_reschedule_date' => (string) $subItem['restructure_reschedule_date'],
                    'facility' => (string) $subItem['facility'],
                    'total_outstanding_balance' => (float) $subItem['total_outstanding_balance'],
                    'total_outstanding_balance_bnm' => (float) $subItem['total_outstanding_balance_bnm'],
                    'balance_updated_date' => (string) $subItem['balance_updated_date'],
                    'installment_amount' => (float) $subItem['installment_amount'],
                    'principle_repayment_term' => (string) $subItem['principle_repayment_term'],
                    'collateral_type' => (string) $subItem['collateral_type'],
                    'credit_position' => array_map('intval', $subItem['credit_position']),
                    'collateral_type_code' => (string) $subItem['collateral_type_code']
                ];
            }

            $this->outstanding_credit[] = [
                'master' => $master,
                'sub_account' => $subAccount
            ];
        }

        
        foreach ($data['credit_application'] as $applicationItem) {
            $this->credit_application[] = [
                'application_id' => (int) $applicationItem['application_id'],
                'application_date' => (string) $applicationItem['application_date'],
                'status' => (string) $applicationItem['status'],
                'application_type' => (string) $applicationItem['application_type'],
                'capacity' => (string) $applicationItem['capacity'],
                'lender_type' => (string) $applicationItem['lender_type'],
                'facility' => (string) $applicationItem['facility'],
                'amount_applied' => (float) $applicationItem['amount_applied'],
                'financial_group_resident_status' => (string) $applicationItem['financial_group_resident_status']
            ];
        }

        
        foreach ($data['facilities_remark'] as $facilityRemark) {
            $this->facilities_remark[] = [
                'code' => (string) $facilityRemark['code'],
                'desc' => (string) $facilityRemark['desc']
            ];
        }

        
        foreach ($data['status_remark'] as $status_remark) {
            $this->status_remark[] = [
                'code' => (string) $status_remark['code'],
                'desc' => (string) $status_remark['desc']
            ];
        }

        
        $this->special_attention_account = (string) $data['special_attention_account'];
        $this->legal_remark = (string) $data['legal_remark'];

        return $this;

    }


    public function convertToXml(): string{
        $xml = new SimpleXMLElement('<CcrisKeyStatistics/>');

        $xml->addChild('start_year', (string) $this->start_year);
        $xml->addChild('end_year', (string) $this->end_year);

        $monthNode = $xml->addChild('months');
        foreach ($this->months as $month) {
            $monthNode->addChild('item', $month);
        }

        $creditNode = $xml->addChild('outstanding_credit');
        foreach ($this->outstanding_credit as $creditItem) {
            $creditItemNode = $creditNode->addChild('item');
            
            $masterNode = $creditItemNode->addChild('master');
            foreach ($creditItem['master'] as $masterItem) {
                $masterItemNode = $masterNode->addChild('item');
                foreach ($masterItem as $key => $value) {
                    $masterItemNode->addChild($key,  htmlspecialchars((string)$value));
                }
            }

            $subAccountNode = $creditItemNode->addChild('sub_account');
            foreach ($creditItem['sub_account'] as $subItem) {
                $subItemNode = $subAccountNode->addChild('item');
                foreach ($subItem as $key => $value) {
                    if (is_array($value)) {
                        $valueNode = $subItemNode->addChild($key);
                        foreach ($value as $subValue) {
                            $valueNode->addChild('item', (string) $subValue);
                        }
                    } else {
                        $subItemNode->addChild($key, htmlspecialchars((string)$value));
                    }
                }
            }
        }

        $applicationNode = $xml->addChild('credit_application');
        foreach ($this->credit_application as $applicationItem) {
            $applicationItemNode = $applicationNode->addChild('item');
            foreach ($applicationItem as $key => $value) {
                $applicationItemNode->addChild($key, htmlspecialchars((string)$value));
            }
        }

        $facilitiesRemarkNode = $xml->addChild('facilities_remark');
        foreach ($this->facilities_remark as $facilityRemark) {
            $facilityRemarkNode = $facilitiesRemarkNode->addChild('item');
            $facilityRemarkNode->addChild('code', htmlspecialchars((string)$facilityRemark['code']));
            $facilityRemarkNode->addChild('desc', htmlspecialchars((string)$facilityRemark['desc']));
        }

        $statusRemarkNode = $xml->addChild('status_remark');
        foreach ($this->status_remark as $statusRemark) {
            $statusRemarkNode = $statusRemarkNode->addChild('item');
            $statusRemarkNode->addChild('code', htmlspecialchars((string)$facilityRemark['code']));
            $statusRemarkNode->addChild('desc', htmlspecialchars((string)$facilityRemark['desc']));
        }

        $xml->addChild('special_attention_account', htmlspecialchars((string)$this->special_attention_account));
        $xml->addChild('legal_remark', htmlspecialchars((string)$this->legal_remark));

        return $xml->asXML();
    }

 

    
    // Convert the object to an associative array with snake_case keys
    public function toArray(): array
    {
        return [
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
            'months' => $this->months,
            'outstanding_credit' => $this->outstanding_credit,
            'credit_application' => $this->credit_application,
            'facilities_remark' => $this->facilities_remark,
            'status_remark' => $this->status_remark,
            'special_attention_account' => $this->special_attention_account,
            'legal_remark' => $this->legal_remark
        ];
    }

    // Convert the object to a JSON string with snake_case keys
    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
