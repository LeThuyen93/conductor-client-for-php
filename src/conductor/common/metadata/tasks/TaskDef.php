<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:19 AM
 */

namespace conductor\common\metadata\tasks;

class TaskDef
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $retryCount = 0;

    /**
     * @var int
     */
    public $timeoutSeconds = 60;

    /**
     * @var array
     */
    public $inputKeys;

    /**
     * @var array
     */
    public $outputKeys;

    /**
     * @var string
     */
    public $timeoutPolicy = TimeoutPolicy::TIME_OUT_WF;

    /**
     * @var string
     */
    public $retryLogic = RetryLogic::FIXED;

    /**
     * @var int
     */
    public $retryDelaySeconds = 0;

    /**
     * @var int
     */
    public $responseTimeoutSeconds = 60;

    /**
     * @var int
     */
    public $concurrentExecLimit;

    /**
     * @var array
     */
    public $inputTemplate;
}

class TimeoutPolicy
{
    const RETRY = 'RETRY',
        TIME_OUT_WF = 'TIME_OUT_WF',
        ALERT_ONLY = 'ALERT_ONLY';
}

class RetryLogic
{
    const FIXED = 'FIXED',
        EXPONENTIAL_BACKOFF = 'EXPONENTIAL_BACKOFF';
}