<?php

declare(strict_types=1);

namespace RabbitMQ\Publisher;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Service\RabbitMQService;

class RoutingQueuePublisher extends WorkQueuePublisher
{
    protected $serenity;

    public function __construct($queueName, $serenity)
    {
        parent::__construct($queueName);

        $this->serenity = $serenity;
    }

    public function push(JobInterface $job, RabbitMQService $rabbitMQService)
    {
        $channel = $rabbitMQService->getChannel();

        $channel->exchange_declare($this->queueName, 'direct', false, true, false);
        $msg = new AMQPMessage($job->getJsonString());

        $channel->basic_publish($msg, $this->queueName, $this->serenity);
    }
}
