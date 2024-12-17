<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use InvalidArgumentException;
use SimpleXMLElement;

class TradeBureau
{
    public ?array $tradeBureauEntityDetails = [];

    public function fromXML(SimpleXMLElement $xml): self
    {
        // Deserialize trade_bureau_entity_details
        if (isset($xml->trade_bureau_entity_details)) {
            $this->tradeBureauEntityDetails = [
                'credit_references' => $this->deserializeCreditReferences($xml->trade_bureau_entity_details->tb_credit_reference),
                'tb_payment' => $this->deserializeTbPayment($xml->trade_bureau_entity_details->tb_payment)
            ];
        }

        return $this;
    }

    private function deserializeCreditReferences(SimpleXMLElement $creditReferences): array
    {
        $creditReferenceList = [];
        foreach ($creditReferences->item as $referenceItem) {
            $guarantorDetails = [];
            if (isset($referenceItem->guarantor_details)) {
                foreach ($referenceItem->guarantor_details->guarantor_detail as $guarantorDetail) {
                    $guarantorDetails[] = [
                        'guarantor_ic' => (string) $guarantorDetail->guarantor_ic,
                        'guarantor_name' => (string) $guarantorDetail->guarantor_name,
                    ];
                }
            }

            $creditReferenceList[] = [
                'subject' => (string) $referenceItem->subject,
                'new_ic' => (string) $referenceItem->new_ic,
                'creditor_name' => (string) $referenceItem->creditor_name,
                'creditor_telno' => (string) $referenceItem->creditor_telno,
                'ref_no' => (string) $referenceItem->ref_no,
                'status' => (string) $referenceItem->status,
                'debt_type' => (string) $referenceItem->debt_type,
                'payment_aging' => (string) $referenceItem->payment_aging,
                'remark' => (string) $referenceItem->remark,
                'status_date' => (string) $referenceItem->status_date,
                'amount' => (string) $referenceItem->amount,
                'industry' => (string) $referenceItem->industry,
                'guarantor_details' => $guarantorDetails
            ];
        }

        return $creditReferenceList;
    }

    private function deserializeTbPayment(SimpleXMLElement $tbPayment): array
    {
        return [
            'payment_profile' => (string) $tbPayment->payment_profile,
            'payment_trend' => (string) $tbPayment->payment_trend->trend,
            'p2p_fintech' => $this->deserializeP2PFintech($tbPayment->p2p_fintech),
            'show_note' => (string) $tbPayment->show_note,
            'show_note_fintect' => (string) $tbPayment->show_note_fintect
        ];
    }

    private function deserializeP2PFintech(SimpleXMLElement $p2pFintech): array
    {
        $months = [];
        foreach ($p2pFintech->month->item as $monthItem) {
            $months[] = (string) $monthItem;
        }

        return [
            'start_year' => (int) $p2pFintech->start_year,
            'end_year' => (int) $p2pFintech->end_year,
            'months' => $months,
            'count_fintect' => (int) $p2pFintech->count_fintect,
            'show_note_fintect' => (int) $p2pFintech->show_note_fintect,
            'legend' => [
                'capacity' => isset($p2pFintech->legend->capacity->item) ? $this->deserializeLegendItems($p2pFintech->legend->capacity->item) : null,
                'acc_status' => isset($p2pFintech->legend->acc_status->item) ? $this->deserializeLegendItems($p2pFintech->legend->acc_status->item) : null,
                'lender_type' => isset($p2pFintech->legend->lender_type->item) ? $this->deserializeLegendItems($p2pFintech->legend->lender_type->item) : null,
                'facility' => isset($p2pFintech->legend->facility->item) ? $this->deserializeLegendItems($p2pFintech->legend->facility->item) : null,
                'repayment_term' => isset($p2pFintech->legend->repayment_term->item) ? $this->deserializeLegendItems($p2pFintech->legend->repayment_term->item) : null,
                'collateral_type' => isset($p2pFintech->legend->collateral_type->item) ? $this->deserializeLegendItems($p2pFintech->legend->collateral_type->item) : null,
                'status' => isset($p2pFintech->legend->status->item) ? $this->deserializeLegendItems($p2pFintech->legend->status->item) : null,
                'sub_code' => isset($p2pFintech->legend->sub_code->item) ? $this->deserializeLegendItems($p2pFintech->legend->sub_code->item) : null
            ],
            'details' => isset($p2pFintech->details->OUT) ? $this->deserializeP2PFintechDetailItems($p2pFintech->details->OUT->item) : null
        ];
    }

    private function deserializeLegendItems(SimpleXMLElement $legendItems): array
    {
        $items = [];
        foreach($legendItems as $legendItem)
        {
            $item = [];
            $item['code'] = (string) $legendItem->code;
            $item['desc'] = (string) $legendItem->desc;
            $items[] = $item;
        }

        return [
            'item' => $items,
        ];
    }

    private function deserializeP2PFintechDetailItems(SimpleXMLElement $p2pFintechDetailItems): array
    {
        $out_items = [];
        foreach($p2pFintechDetailItems as $p2pFintechDetailItem)
        {
            $conduction = [];
            foreach ($p2pFintechDetailItem->conduction->item as $conductionItem) {
                if ((string) $conductionItem === '')
                {
                    $conduction[] = null;
                } else {
                    $conduction[] = (int) $conductionItem;
                }
            }

            $item = [];
            $item['acc_status'] = (string) $p2pFintechDetailItem->acc_status;
            $item['fintech_id'] = (string) $p2pFintechDetailItem->fintech_id;
            $item['aprv_date'] = (string) $p2pFintechDetailItem->aprv_date;
            $item['capacity'] = (string) $p2pFintechDetailItem->capacity;
            $item['lender_type'] = (string) $p2pFintechDetailItem->lender_type;
            $item['facility'] = (string) $p2pFintechDetailItem->facility;
            $item['credit_limit'] = (float) $p2pFintechDetailItem->credit_limit;
            $item['instalment_amount'] = (float) $p2pFintechDetailItem->instalment_amount;
            $item['instalment_tenor'] = (int) $p2pFintechDetailItem->instalment_tenor;
            $item['date_balance_updated'] = (string) $p2pFintechDetailItem->date_balance_updated;
            $item['loan_outstanding'] = (float) $p2pFintechDetailItem->loan_outstanding;
            $item['repayment_term'] = (string) $p2pFintechDetailItem->repayment_term;
            $item['collateral_type'] = (string) $p2pFintechDetailItem->collateral_type;
            $item['status'] = (string) $p2pFintechDetailItem->status;
            $item['status_update_date'] = (string) $p2pFintechDetailItem->status_update_date;
            $item['conduction'] = $conduction;
            $out_items[] = $item;
        }

        return [
            'out' => [
                'item' => $out_items,  // Ensure "item" is an array of details
            ],
        ];
    }

    public function toArray(): array
    {
        return [
            'trade_bureau_entity_details' => $this->tradeBureauEntityDetails
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }


    public function fromJSON(string $json): self{
        $data = json_decode($json, true);

        if(json_last_error() !== JSON_ERROR_NONE){
            throw new InvalidArgumentException("Invalid JSON:".json_last_error_msg());
        }

        if(isset($data['trade_bureau_entity_details'])){
            $this->tradeBureauEntityDetails = $data['trade_bureau_entity_details'];
        }
        return $this;
    }

    public function convertToXml(): string
    {
        $xml = new SimpleXMLElement('<TradeBureau/>');
        if (isset($this->tradeBureauEntityDetails)) {
            $this->arrayToXmlStructure($this->tradeBureauEntityDetails, $xml->addChild('trade_bureau_entity_details'));
        }
        return $xml->asXML();
    }

    private function arrayToXmlStructure(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child = $xml->addChild($key);
                $this->arrayToXmlStructure($value, $child);
            } else {
                $xml->addChild($key, htmlspecialchars((string) $value));
            }
        }
    }
}
