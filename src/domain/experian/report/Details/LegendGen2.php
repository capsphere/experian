<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;

class LegendGen2
{
    public ?string $naIscoreLegend = null;

    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->naIscoreLegend = (string) $xml->na_iscore_legend;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'na_iscore_legend' => $this->naIscoreLegend
        ];
    }

    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
