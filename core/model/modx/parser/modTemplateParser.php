<?php

abstract class modTemplateParser
{

    /**
     * @var modX
     */
    protected $modx;
    protected $parentTag;
    protected $processUncacheable;
    protected $removeUnprocessed;
    protected $prefix;
    protected $suffix;
    protected $tokens;
    protected $depth;

    public function __construct(modX $modx)
    {
        $this->modx = $modx;
    }

    /**
     * @param $content
     * @return string content
     */
    abstract public function parse($content);

    /**
     * @param mixed $parentTag
     */
    public function setParentTag($parentTag)
    {
        $this->parentTag = $parentTag;
    }

    /**
     * @param mixed $processUncacheable
     */
    public function setProcessUncacheable($processUncacheable)
    {
        $this->processUncacheable = $processUncacheable;
    }

    /**
     * @param mixed $removeUnprocessed
     */
    public function setRemoveUnprocessed($removeUnprocessed)
    {
        $this->removeUnprocessed = $removeUnprocessed;
    }

    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @param mixed $suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * @param mixed $tokens
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @param mixed $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }
}