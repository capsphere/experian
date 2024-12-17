<?php

namespace Capsphere\PhpCore\Domain\Experian\Entity;

use SimpleXMLElement;

class CcrisIdentityItem
{
    public ?string $CRefId = null;
    public ?string $EntityKey = null;
    public ?string $EntityId = null;
    public ?string $EntityId2 = null;
    public ?string $EntityName = null;
    public ?string $EntityDOBDOC = null;
    public ?string $EntityGroupCode = null;
    public ?string $EntityState = null;
    public ?string $EntityNationality = null;
    public ?string $CcrisNote = null;

    // Method to deserialize XML data into CcrisIdentityItem object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->CRefId = (string) $xml->CRefId;
        $this->EntityKey = (string) $xml->EntityKey;
        $this->EntityId = (string) $xml->EntityId;
        $this->EntityId2 = (string) $xml->EntityId2;
        $this->EntityName = (string) $xml->EntityName;
        $this->EntityDOBDOC = (string) $xml->EntityDOBDOC;
        $this->EntityGroupCode = (string) $xml->EntityGroupCode;
        $this->EntityState = (string) $xml->EntityState;
        $this->EntityNationality = (string) $xml->EntityNationality;
        $this->CcrisNote = (string) $xml->CcrisNote;

        return $this;
    }
    public function toArray(): array
    {
        return [
            'CRefId' => $this->CRefId,
            'EntityKey' => $this->EntityKey,
            'EntityId' => $this->EntityId,
            'EntityId2' => $this->EntityId2,
            'EntityName' => $this->EntityName,
            'EntityDOBDOC' => $this->EntityDOBDOC,
            'EntityGroupCode' => $this->EntityGroupCode,
            'EntityState' => $this->EntityState,
            'EntityNationality' => $this->EntityNationality,
            'CcrisNote' => $this->CcrisNote,
        ];
    }
}
