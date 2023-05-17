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
        $this->message->ack();
    }

    public function nack(): void
    {
        $this->message->nack();
    }
}
