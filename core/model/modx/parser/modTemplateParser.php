<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 03/04/2018
 * Time: 18:35
 */

interface modTemplateParser
{
    public function __construct(modX $modx);

    public function setParentTag($parentTag);
    public function setProcessUncacheable($processUncacheable);
    public function setRemoveUnprocessed($removeUnprocessed);
    public function setPrefix($prefix);
    public function setSuffix($suffix);
    public function setTokens($tokens);
    public function setDepth($depth);
    public function parse($content);
}