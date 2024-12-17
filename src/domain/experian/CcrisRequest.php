<?php

namespace Capsphere\PhpCore\Domain\Experian;

use SimpleXMLElement;

class CcrisRequest
{
    public ?string $token1 = null;
    public ?string $token2 = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->token1 = (string) $xml->request->token1;
        $this->token2 = (string) $xml->request->token2;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'token1' => $this->token1,
            'token2' => $this->token2,
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
