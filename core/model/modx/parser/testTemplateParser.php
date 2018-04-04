<?php

class testTemplateParser implements modTemplateParser
{

    /**
     * @var modX
     */
    private $modx;
    private $parentTag;
    private $processUncacheable;
    private $removeUnprocessed;
    private $prefix;
    private $suffix;
    private $tokens;
    private $depth;

    public function __construct(modX $modx)
    {
        $this->modx = $modx;
    }

    public function parse($content)
    {
        if (strpos($content, '>') !== false && strpos($content, '<') !== false) {
            $content = preg_replace('/(<.+?>[^<>]*?)(a)([^<>]*?<.+?>)/', '$1aZ$3', $content);
            $content = preg_replace('/(<.+?>[^<>]*?)(E)([^<>]*?<.+?>)/', '$1Ez$3', $content);
            return $content;
        } else {
            return $content;
        }
    }

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