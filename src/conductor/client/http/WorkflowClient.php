<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:08 AM
 */
namespace conductor\client\http;

use conductor\common\metadata\workflows\StartWorkflowRequest;

class WorkflowClient extends ClientBase
{
    public function startWorkflow(StartWorkflowRequest $startWorkflowRequest) : string
    {
        return $this->postForEntity("workflow", $startWorkflowRequest);
    }
}