<?php

declare(strict_types=1);

namespace RabbitMQ\Publisher;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Service\RabbitMQService;

class PriorityQueuePublisher extends WorkQueuePublisher
{
    protected $priority;

    public function __construct($queueName, $priority)
    {
        parent::__construct($queueName);

        $this->priority = $priority;
    }

    public function push(JobInterface $job, RabbitMQService $rabbitMQService)
    {
        $table = $rabbitMQService->getTable();
        $channel = $rabbitMQService->getChannel();

        $table->set('x-max-priority', RabbitMQService::PRIORITY_SUPER_HIGH);
        $channel->queue_declare($this->queueName, false, true, false, false, false, $table);

        $amqpMessage = new AMQPMessage($job->getJson(), [
            'delivery_mode' => RabbitMQService::DELIVERY_MODE,
            'priority' => $this->priority,
        ]);

        $channel->basic_publish($amqpMessage, '', $this->queueName);
    }
}
