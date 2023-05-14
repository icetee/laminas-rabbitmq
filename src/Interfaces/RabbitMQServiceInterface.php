<?php

declare(strict_types=1);

namespace RabbitMQ\Interfaces;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMQ\Interfaces\ConsumerInterface;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Interfaces\PublisherInterface;

interface RabbitMQServiceInterface
{
    const DELIVERY_MODE = 2;

    const PRIORITY_SUPER_LOW  = 1;
    const PRIORITY_LOW        = 2;
    const PRIORITY_NORMAL     = 3;
    const PRIORITY_HIGH       = 4;
    const PRIORITY_SUPER_HIGH = 5;

    public function push(JobInterface $job): void;

    public function receive(Callable $callback): void;

    public function setPublisher(PublisherInterface $publisher): void;

    public function setConsumer(ConsumerInterface $consumer): void;

    public function getTable(): AMQPTable;

    public function getChannel(): AMQPChannel;

    public function getConnection(): AMQPStreamConnection;

    public function __destruct(): void
}
