<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\SummaryDetails;

use SimpleXMLElement;

class IScore
{
    public ?int $iScore = null;
    public ?int $riskGrade = null;
    public array $keyFactors = [];
    public ?string $naIsScoreLegend = null;
    public ?string $errorMessage = null;
    public ?string $gradeFormat = null;
    public ?string $iScoreRiskGradeFormatConsumer = null;

    // Method to deserialize XML data into IScore object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->iScore = (int) $xml->i_score;
        $this->riskGrade = (int) $xml->risk_grade;

        // Handle key factors, assuming it can contain multiple items
        foreach ($xml->key_factor->item as $item) {
            $this->keyFactors[] = (string) $item;
        }

        $this->naIsScoreLegend = (string) $xml->na_iscore_legend;
        $this->errorMessage = (string) $xml->error_message;
        $this->gradeFormat = (string) $xml->grade_format;
        $this->iScoreRiskGradeFormatConsumer = (string) $xml->i_score_risk_grade_format_consumer;

        return $this;
    }

    public function fromJSON(string $json): self{
        $data = json_decode($json, true);

        $this->iScore = isset($data['i_score']) ? (int) $data['i_score'] : null;
        $this->riskGrade = isset($data['risk_grade']) ? (int) $data['risk_grade'] : null;

        if (isset($data['key_factors']) && is_array($data['key_factors'])) {
            // print_r($data['key_factors']);
            foreach ($data['key_factors'] as $item) {
                if (is_array($item)) {
                    $this->keyFactors[] = json_encode($item);
                } else {
                    $this->keyFactors[] = (string) $item;
                }
            }
        } else {
            echo "key_factors is not an array.";
        }

        $this->naIsScoreLegend = isset($data['na_iscore_legend']) ? (string) $data['na_iscore_legend'] : null;
        $this->errorMessage = isset($data['error_message']) ? (string) $data['error_message'] : null;
        $this->gradeFormat = isset($data['grade_format']) ? (string) $data['grade_format'] : null;
        $this->iScoreRiskGradeFormatConsumer = isset($data['i_score_risk_grade_format_consumer']) ? (string) $data['i_score_risk_grade_format_consumer'] : null;

        return $this;
    }


    public function convertToXml(SimpleXMLElement $xml): SimpleXMLElement{
        $xml->addChild('i_score', (string) $this->iScore ?? '');
        $xml->addChild('risk_grade', (string) $this->riskGrade ?? '');

        $keyFactorsElement = $xml->addChild('key_factor');
        foreach ($this->keyFactors as $factor) {
            $keyFactorsElement->addChild('item', $factor);
        }
        $xml->addChild('na_iscore_legend', $this->naIsScoreLegend ?? '');
        $xml->addChild('error_message', $this->errorMessage ?? '');
        $xml->addChild('grade_format', $this->gradeFormat ?? '');
        $xml->addChild('i_score_risk_grade_format_consumer', $this->iScoreRiskGradeFormatConsumer ?? '');

        return $xml;
    }

    // Convert the object to an associative array
    public function toArray(): array
    {
        return [
            'i_score' => $this->iScore,
            'risk_grade' => $this->riskGrade,
            'key_factors' => $this->keyFactors,
            'na_iscore_legend' => $this->naIsScoreLegend,
            'error_message' => $this->errorMessage,
            'grade_format' => $this->gradeFormat,
            'i_score_risk_grade_format_consumer' => $this->iScoreRiskGradeFormatConsumer,
        ];
    }
}
