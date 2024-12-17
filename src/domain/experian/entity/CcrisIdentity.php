<?php

namespace Capsphere\PhpCore\Domain\Experian\Entity;

use SimpleXMLElement;

class CcrisIdentity
{
    public array $items = [];

    public function fromXML(SimpleXMLElement $xml): self
    {
        foreach ($xml->ccris_identity->item as $itemXml) {
            $item = new CcrisIdentityItem();
            $item->fromXML($itemXml);  
            $this->items[] = $item;   
        }
        return $this;
    }
    public function toJSON(): string
    {
        $itemsArray = array_map(function ($item) {
            return $item->toArray(); 
        }, $this->items);

        return json_encode(['items' => $itemsArray], JSON_PRETTY_PRINT);
    }
}