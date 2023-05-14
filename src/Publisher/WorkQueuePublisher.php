<?php

declare(strict_types=1);

namespace RabbitMQ\Publisher;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Interfaces\PublisherInterface;
use RabbitMQ\Service\RabbitMQService;

class WorkQueuePublisher implements PublisherInterface
{
    public function __construct(
        protected $queueName
    ) {
        $this->queueName = $queueName;
    }

    public function push(JobInterface $job, RabbitMQService $rabbitMQService): void
    {
        $table = $rabbitMQService->getTable();
        $channel = $rabbitMQService->getChannel();

        $channel->queue_declare($this->queueName, false, true, false, false, false, $table);

        $amqpMessage = new AMQPMessage($job->getJsonString(), [
            'delivery_mode' => RabbitMQService::DELIVERY_MODE,
        ]);

        $channel->basic_publish($amqpMessage, '', $this->queueName);
    }
}
