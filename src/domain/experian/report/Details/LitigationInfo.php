<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;

class LitigationInfo
{
    public ?string $legalSuitByRegno = null;
    public ?string $legalSuitProclamationByRegno = null;
    public ?string $othersCourtByRegno = null;
    public ?string $othersKnownLegalSuit = null;
    public ?array $othersKnownLegalSuitByPlaintiff = [];
    public ?string $legalSuitByPlaintiff = null;
    public ?array $windupPetitionDetails = [];
    public ?array $personBankruptcy = [];

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->legalSuitByRegno = (string) $xml->legal_suit_by_regno;
        $this->legalSuitProclamationByRegno = (string) $xml->legal_suit_proclamation_by_regno;
        $this->othersCourtByRegno = (string) $xml->others_court_by_regno;
        $this->othersKnownLegalSuit = (string) $xml->others_known_legal_suit;

        if (isset($xml->others_known_legal_suit_by_plaintiff)) {
            foreach ($xml->others_known_legal_suit_by_plaintiff->item as $other_known_legal_suit_by_plaintiff) {
                $item = [
                    'plaintiff_name' => (string) $other_known_legal_suit_by_plaintiff->plaintiff_name,
                    'suit_id' => (string) $other_known_legal_suit_by_plaintiff->suit_id,
                    'case_settled' => (string) $other_known_legal_suit_by_plaintiff->case_settled,
                    'case_withdrawn' => (string) $other_known_legal_suit_by_plaintiff->case_withdrawn,
                    'court' => (string) $other_known_legal_suit_by_plaintiff->court,
                    'local_no' => (string) $other_known_legal_suit_by_plaintiff->local_no,
                    'old_reg_no' => (string) $other_known_legal_suit_by_plaintiff->old_reg_no,
                    'new_reg_no' => (string) $other_known_legal_suit_by_plaintiff->new_reg_no,
                    'case_no' => (string) $other_known_legal_suit_by_plaintiff->case_no,
                    'suit_ref' => (string) $other_known_legal_suit_by_plaintiff->suit_ref,
                    'hearing_date' => (string) $other_known_legal_suit_by_plaintiff->hearing_date
                ];

                $defendant_details = [];
                foreach ($other_known_legal_suit_by_plaintiff->defendant_details->defendant_detail as $defendant_detail) {
                    $defendant_details[] = [
                        'defendant_name' => (string) $defendant_detail->defendant_name,
                        'defendant_id' => (string) $defendant_detail->defendant_id,
                        'defendant_type' => (string) $defendant_detail->defendant_type,
                        'defendant_regno' => (string) $defendant_detail->defendant_regno,
                        'old_reg_no' => (string) $defendant_detail->old_reg_no,
                        'new_reg_no' => (string) $defendant_detail->new_reg_no,
                    ];
                }

                $item['defendant_details'] = $defendant_details;

                $this->othersKnownLegalSuitByPlaintiff[] = $item;
            }
        }

        $this->legalSuitByPlaintiff = (string) $xml->legal_suit_by_plaintiff;

        if (isset($xml->windup_petition_details)) {
            foreach ($xml->windup_petition_details->windup_petition_detail as $windup_petition_detail) {
                $item = [
                    'status_court' => (string) $windup_petition_detail->status_court,
                    'defendant_name' => (string) $windup_petition_detail->defendant_name,
                    'local_no' => (string) $windup_petition_detail->local_no,
                    'old_reg_no' => (string) $windup_petition_detail->old_reg_no,
                    'new_reg_no' => (string) $windup_petition_detail->new_reg_no,
                    'case_no' => (string) $windup_petition_detail->case_no,
                    'court' => (string) $windup_petition_detail->court,
                    'petitioner' => (string) $windup_petition_detail->petitioner,
                    'case_settled' => (string) $windup_petition_detail->case_settled,
                    'case_withdrawn' => (string) $windup_petition_detail->case_withdrawn,
                    'petitioner_solicitor' => (string) $windup_petition_detail->petitioner_solicitor,
                    'solicitor_address' => (string) $windup_petition_detail->solicitor_address,
                    'solicitor_ref' => (string) $windup_petition_detail->solicitor_ref,
                    'petition_date' => (string) $windup_petition_detail->petition_date,
                    'petition_ref' => (string) $windup_petition_detail->petition_ref,
                    'hearing_date' => (string) $windup_petition_detail->hearing_date,
                    'status_group,' => (string) $windup_petition_detail->status_group,
                ];

                $this->windupPetitionDetails[] = $item;
            }
        }

        if (isset($xml->person_bankruptcy)) {
            $this->personBankruptcy = [
                'remark' => (string) $xml->person_bankruptcy->remark,
                'cases' => $this->deserializeCases($xml->person_bankruptcy->case)
            ];
        }

        return $this;
    }

    public function fromJSON(string $json): self
    {
        $data = json_decode($json, true);

        $this->legalSuitByRegno = isset($data['legal_suit_by_regno']) ? (string) $data['legal_suit_by_regno'] : null;
        $this->legalSuitProclamationByRegno = isset($data['legal_suit_proclamation_by_regno']) ? (string) $data['legal_suit_proclamation_by_regno'] : null;
        $this->othersCourtByRegno = isset($data['others_court_by_regno']) ? (string) $data['others_court_by_regno'] : null;
        $this->othersKnownLegalSuit = isset($data['others_known_legal_suit']) ? (string) $data['others_known_legal_suit'] : null;

        if (isset($data['others_known_legal_suit_by_plaintiff'])) {
            foreach ($data['others_known_legal_suit_by_plaintiff'] as $other_known_legal_suit_by_plaintiff) {
                $item = [
                    'plaintiff_name' => (string) $other_known_legal_suit_by_plaintiff->plaintiff_name,
                    'suit_id' => (string) $other_known_legal_suit_by_plaintiff->suit_id,
                    'case_settled' => (string) $other_known_legal_suit_by_plaintiff->case_settled,
                    'case_withdrawn' => (string) $other_known_legal_suit_by_plaintiff->case_withdrawn,
                    'court' => (string) $other_known_legal_suit_by_plaintiff->court,
                    'local_no' => (string) $other_known_legal_suit_by_plaintiff->local_no,
                    'old_reg_no' => (string) $other_known_legal_suit_by_plaintiff->old_reg_no,
                    'new_reg_no' => (string) $other_known_legal_suit_by_plaintiff->new_reg_no,
                    'case_no' => (string) $other_known_legal_suit_by_plaintiff->case_no,
                    'suit_ref' => (string) $other_known_legal_suit_by_plaintiff->suit_ref,
                    'hearing_date' => (string) $other_known_legal_suit_by_plaintiff->hearing_date
                ];

                $defendant_details = [];
                foreach ($other_known_legal_suit_by_plaintiff->defendant_details->defendant_detail as $defendant_detail) {
                    $defendant_details[] = [
                        'defendant_name' => (string) $defendant_detail->defendant_name,
                        'defendant_id' => (string) $defendant_detail->defendant_id,
                        'defendant_type' => (string) $defendant_detail->defendant_type,
                        'defendant_regno' => (string) $defendant_detail->defendant_regno,
                        'old_reg_no' => (string) $defendant_detail->old_reg_no,
                        'new_reg_no' => (string) $defendant_detail->new_reg_no,
                    ];
                }

                $item['defendant_details'] = $defendant_details;

                $this->othersKnownLegalSuitByPlaintiff[] = $item;
            }
        }

        $this->legalSuitByPlaintiff = (string) $data['legal_suit_by_plaintiff'];

        if (isset($data['windup_petition_details'])) {
            foreach ($data['windup_petition_details'] as $windup_petition_detail) {
                $item = [
                    'status_court' => (string) $windup_petition_detail->status_court,
                    'defendant_name' => (string) $windup_petition_detail->defendant_name,
                    'local_no' => (string) $windup_petition_detail->local_no,
                    'old_reg_no' => (string) $windup_petition_detail->old_reg_no,
                    'new_reg_no' => (string) $windup_petition_detail->new_reg_no,
                    'case_no' => (string) $windup_petition_detail->case_no,
                    'court' => (string) $windup_petition_detail->court,
                    'petitioner' => (string) $windup_petition_detail->petitioner,
                    'case_settled' => (string) $windup_petition_detail->case_settled,
                    'case_withdrawn' => (string) $windup_petition_detail->case_withdrawn,
                    'petitioner_solicitor' => (string) $windup_petition_detail->petitioner_solicitor,
                    'solicitor_address' => (string) $windup_petition_detail->solicitor_address,
                    'solicitor_ref' => (string) $windup_petition_detail->solicitor_ref,
                    'petition_date' => (string) $windup_petition_detail->petition_date,
                    'petition_ref' => (string) $windup_petition_detail->petition_ref,
                    'hearing_date' => (string) $windup_petition_detail->hearing_date,
                    'status_group,' => (string) $windup_petition_detail->status_group,
                ];

                $this->windupPetitionDetails[] = $item;
            }
        }

        if (isset($data['person_bankruptcy'])) {
            $this->personBankruptcy = [
                'remark' => $data['person_bankruptcy']['remark'] ?? '',
                'cases' => $data['person_bankruptcy']['cases'] ?? '',
                
            ];
            // print_r($data);
        }
                

        return $this;
    }

    private function deserializeCases(SimpleXMLElement $cases): array
    {
        $caseList = [];
        foreach ($cases->item as $caseItem) {
            $caseList[] = [
                'status_group' => (string) $caseItem->status_group,
                'defendant_name' => (string) $caseItem->defendant_name,
                'old_ic' => (string) $caseItem->old_ic,
                'new_ic' => (string) $caseItem->new_ic,
                'defendant_address' => isset($caseItem->defendant_address) ? (string) $caseItem->defendant_address : null,
                'case_no' => (string) $caseItem->case_no,
                'notice_date' => (string) $caseItem->notice_date,
                'petition_date' => isset($caseItem->petition_date) ? (string) $caseItem->petition_date : null,
                'hearing_date' => isset($caseItem->hearing_date) ? (string) $caseItem->hearing_date : null,
                'adjudication_order_date' => isset($caseItem->adjudication_order_date) ? (string) $caseItem->adjudication_order_date : null,
                'case_settled' => (string) $caseItem->case_settled,
                'case_withdrawn' => (string) $caseItem->case_withdrawn,
                'amountclaimed' => (string) $caseItem->amountclaimed,
                'solicitor_code' => isset($caseItem->solicitor_code) ? (string) $caseItem->solicitor_code : null,
                'solicitor' => isset($caseItem->solicitor) ? (string) $caseItem->solicitor : null,
                'solicitor_address' => isset($caseItem->solicitor_address) ? (string) $caseItem->solicitor_address : null,
                'solicitor_tel' => isset($caseItem->solicitor_tel) ? (string) $caseItem->solicitor_tel : null,
                'solicitor_fax' => isset($caseItem->solicitor_fax) ? (string) $caseItem->solicitor_fax : null,
                'solicitor_email' => isset($caseItem->solicitor_email) ? (string) $caseItem->solicitor_email : null,
                'solicitor_ref' => isset($caseItem->solicitor_ref) ? (string) $caseItem->solicitor_ref : null,
                'notice_ref' => isset($caseItem->notice_ref) ? (string) $caseItem->notice_ref : null,
                'adjudication_order_ref' => isset($caseItem->adjudication_order_ref) ? (string) $caseItem->adjudication_order_ref : null
            ];
        }

        return $caseList;
    }

    public function toArray(): array
    {
        return [
            'legal_suit_by_regno' => $this->legalSuitByRegno,
            'legal_suit_proclamation_by_regno' => $this->legalSuitProclamationByRegno,
            'others_known_legal_suit' => $this->othersKnownLegalSuit,
            'others_known_legal_suit_by_plaintiff' => $this->othersKnownLegalSuitByPlaintiff,
            'legal_suit_by_plaintiff' => $this->legalSuitByPlaintiff,
            'windup_petition_details' => $this->windupPetitionDetails,
            'person_bankruptcy' => $this->personBankruptcy
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
