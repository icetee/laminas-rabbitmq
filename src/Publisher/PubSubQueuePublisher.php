<?php

declare(strict_types=1);

namespace RabbitMQ\Publisher;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Service\RabbitMQService;

class PubSubQueuePublisher extends WorkQueuePublisher
{
    public function push(JobInterface $job, RabbitMQService $rabbitMQService)
    {
        $channel = $rabbitMQService->getChannel();

        $channel->exchange_declare($this->queueName, 'fanout', false, false, false);
        $msg = new AMQPMessage($job->getJsonString());

        $channel->basic_publish($msg, $this->queueName);
    }
}
