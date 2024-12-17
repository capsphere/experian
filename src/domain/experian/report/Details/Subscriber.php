<?php

namespace Capsphere\PhpCore\Domain\Experian\Report\Details;

use SimpleXMLElement;
use InvalidArgumentException;

class Subscriber
{
    public ?string $subscriberName = null;
    public ?string $username = null;
    public ?string $orderDate = null;
    public ?string $orderTime = null;
    public ?string $userId = null;
    public ?string $orderId = null;

    // Method to deserialize XML data into Profile object
    public function fromXML(SimpleXMLElement $xml): self
    {
        $this->subscriberName = (string) $xml->subscriber_name;
        $this->username = (string) $xml->username;
        $this->orderDate = (string) $xml->order_date;
        $this->orderTime = (string) $xml->order_time;
        $this->userId = (string) $xml->userid;
        $this->orderId = (string) $xml->order_id;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'subscriber_name' => $this->subscriberName,
            'username' => $this->username,
            'order_date' => $this->orderDate,
            'order_time' => $this->orderTime,
            'userid' => $this->userId,
            'order_id' => $this->orderId,
        ];
    }
    
    public function toJSON(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }


    public function fromJSON(string $json): self
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON: " . json_last_error_msg());
        }

        $this->subscriberName = $data['subscriber_name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->orderDate = $data['order_date'] ?? null;
        $this->orderTime = $data['order_time'] ?? null;
        $this->userId = $data['userid'] ?? null;
        $this->orderId = $data['order_id'] ?? null;

        return $this;
    }


    public function convertToXml(): string
    {
        $xml = new SimpleXMLElement('<Subscriber></Subscriber>'); 
        $this->arrayToXmlStructure($this->toArray(), $xml); 

        return $xml->asXML(); 
    }

    
    private function arrayToXmlStructure(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $itemElement = $xml->addChild($key);
                    $this->arrayToXmlStructure($item, $itemElement); 
                }
            } else {
                $xml->addChild($key, htmlspecialchars((string)$value));
            }
        }
    }


}
