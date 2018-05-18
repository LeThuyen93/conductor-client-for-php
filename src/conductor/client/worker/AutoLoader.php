<?php
/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 5/17/18
 * Time: 3:30 PM
 */

namespace conductor\client\worker;


use Worker;

class AutoLoader extends Worker
{
    /** @var string Full path to the composer autoloader file. */
    protected $autoLoaderFile;

    /**
     * ComposerWorker constructor.
     *
     * @param string $autoLoaderFile
     */
    public function __construct($autoLoaderFile)
    {
        $this->autoLoaderFile = $autoLoaderFile;
    }

    public function run()
    {
        /** @noinspection PhpIncludeInspection */
        require_once($this->autoLoaderFile);
    }

    public function start(
        /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */
        int $options = null
    )
    {
        return parent::start(PTHREADS_INHERIT_NONE);
    }
}