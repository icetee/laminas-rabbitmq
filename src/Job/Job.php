<?php

declare(strict_types=1);

namespace RabbitMQ\Job;

use RabbitMQ\Interfaces\JobInterface;

use function is_array;
use function json_decode;
use function json_encode;
use function stripslashes;

class Job implements JobInterface
{
    protected $dataArray      = [];
    protected $dataJsonString = '';

    public function __construct(array|string $data)
    {
        if (is_array($data)) {
            $this->dataJsonString = json_encode($data);
            $this->dataArray = $data;
        } else {
            $this->dataJsonString = $data;
            $this->dataArray = json_decode(
                stripslashes($data), true
            );
        }
    }

    public function getJson(): array
    {
        return $this->dataArray;
    }

    public function getJsonString(): string|bool
    {
        return $this->dataJsonString;
    }
}
