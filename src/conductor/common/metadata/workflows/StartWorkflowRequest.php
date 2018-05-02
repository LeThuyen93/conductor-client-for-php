<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:22 AM
 */
namespace conductor\common\metadata\workflows;
class StartWorkflowRequest
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $version;
    /**
     * @var string
     */
    public $correlationId;
    /**
     * @var array
     */
    public $input;
    /**
     * @var array
     */
    public $taskToDomain;

    public function withName(string $name) : StartWorkflowRequest
    {
        $this->name = $name;
        return $this;
    }

    public function withVersion(int $version) :StartWorkflowRequest
    {
        $this->version = $version;
        return $this;
    }

    public function withCorrelationId(string $correlationId) : StartWorkflowRequest
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function withInput(array $input) : StartWorkflowRequest
    {
        $this->input = $input;
        return $this;
    }

    public function withTaskToDomain(array $taskToDomain) : StartWorkflowRequest
    {
        $this->taskToDomain = $taskToDomain;
        return $this;
    }
}