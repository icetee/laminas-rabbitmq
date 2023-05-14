<?php

declare(strict_types=1);

namespace RabbitMQ\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    public function __construct(
        protected AMQPMessage $message
    ) {
        $this->message = $message;
    }

    public function getBody(): string
    {
        return $this->message->body;
    }

    public function ack(): void
    {
        $this->message->delivery_info['channel']->basic_ack(
            $this->message->delivery_info['delivery_tag']
        );
    }
}
