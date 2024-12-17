<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details\BankingDetails;

use SimpleXMLElement;
use InvalidArgumentException;

class CcrisSelectedByYou
{
    public ?string $entityName = null;
    public ?string $entityId2 = null;
    public ?string $entityId = null;
    public ?string $entityKey = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->entityName = (string) $xml->entity_name;
        $this->entityId2 = (string) $xml->entity_id2;
        $this->entityId = (string) $xml->entity_id;
        $this->entityKey = (string) $xml->entity_key;
        return $this;
    }

    public function fromJSON(string $json):self{
        $data = json_decode($json, true);
        // print_r($data);
        // if (!isset($data['entity_name'], $data['entity_id2'], $data['entity_id'], $data['entity_key'])) {
        //     throw new InvalidArgumentException("Missing required keys in the provided JSON: " . $json);
        // }
    
        // $this->entityName = (string) $data['entity_name'];
        // $this->entityId2 = (string) $data['entity_id2'];
        // $this->entityId = (string) $data['entity_id'];
        // $this->entityKey = (string) $data['entity_key'];
        $this->entityName = $data['entityName'] ?? $data['entity_name'] ?? null;
        $this->entityId2 = $data['entityId2'] ?? $data['entity_id2'] ?? null;
        $this->entityId = $data['entityId'] ?? $data['entity_id'] ?? null;
        $this->entityKey = $data['entityKey'] ?? $data['entity_key'] ?? null;

        if ($this->entityName === null || $this->entityId === null || $this->entityKey === null) {
            throw new InvalidArgumentException(
                "Missing required keys in the provided JSON. Expected keys: entityName, entityId, entityKey. Input: " . $json
            );
        }

        return $this;
    }

    public function convertToXml(SimpleXMLElement $xml): SimpleXMLElement
    {
        $ccrisSelectedByYou = $xml->addChild('ccris_selected_by_you');
        $ccrisSelectedByYou->addChild('entity_name', $this->entityName ?? '');
        $ccrisSelectedByYou->addChild('entity_id2', $this->entityId2 ?? '');
        $ccrisSelectedByYou->addChild('entity_id', $this->entityId ?? '');
        $ccrisSelectedByYou->addChild('entity_key', $this->entityKey ?? '');
        return $xml;
    }

    public function toArray(): array
    {
        return [
            'entityName' => $this->entityName,
            'entityId' => $this->entityId,
            'entityId2' => $this->entityId2,
            'entityKey' => $this->entityKey
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
