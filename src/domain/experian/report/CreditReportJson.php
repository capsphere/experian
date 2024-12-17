<?php

namespace Capsphere\PhpCore\Domain\Experian;

use Capsphere\PhpCore\Domain\Core\Report;

class CreditReportJson extends Report
{
    public ?string $reportDate;
    public array $executiveSummary;
    public array $corporateProfile;
    public array $financialStatements;
    public array $bankingInfo;
    public array $litigationInfo;
    public array $companyCharges;

    public function __construct(
        ?string $reportDate,
        array $executiveSummary,
        array $corporateProfile,
        array $financialStatements,
        array $bankingInfo,
        array $litigationInfo,
        array $companyCharges
    ) {
        $this->reportDate = $reportDate;
        $this->executiveSummary = $executiveSummary;
        $this->corporateProfile = $corporateProfile;
        $this->financialStatements = $financialStatements;
        $this->bankingInfo = $bankingInfo;
        $this->litigationInfo = $litigationInfo;
        $this->companyCharges = $companyCharges;
    }

    public static function fromJson(array $data): self
    {
        return new self(
            $data['report_date'] ?? null,
            $data['executive_summary'] ?? [],
            $data['corporate_profile'] ?? [],
            $data['financial_statement'] ?? [],
            $data['banking_info'] ?? [],
            $data['litigation_info'] ?? [],
            $data['company_charges'] ?? []
        );
    }
}
