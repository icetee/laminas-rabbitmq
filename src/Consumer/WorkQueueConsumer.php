<?php

declare(strict_types=1);

namespace RabbitMQ\Consumer;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\ConsumerInterface;
use RabbitMQ\Service\RabbitMQService;

class WorkQueueConsumer implements ConsumerInterface
{
    public function __construct(
        protected $queueName
    )
    {
        $this->queueName = $queueName;
    }

    public function receive(Callable $callback, RabbitMQService $rabbitMQService): void
    {
        $channel = $rabbitMQService->getChannel();

        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->basic_qos(null, 1, null);

        $channel->basic_consume($this->queueName, '', false, false, false, false, function (AMQPMessage $msg) use ($callback) {
            $message = new Message($msg);

            $callback($message);
        });

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }
}
