<?php

class twigTemplateParser implements modTemplateParser
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
        $this->twig = $this->initTwig();
    }

    private function initTwig()
    {
        $loader = new Twig_Loader_Array();
        $twig   = new Twig_Environment($loader, array(
            'cache' => MODX_CORE_PATH . '/cache/twig_cache',
            'debug' => true,
        ));
        //$twig->addExtension(new Twig_Extensions_Extension_Text());
        $twig->addExtension(new Twig_Extension_Debug());
        $twig->addExtension(new \Symfony\Bridge\Twig\Extension\DumpExtension(new \Symfony\Component\VarDumper\Cloner\VarCloner()));

        // Uncomment manually when needed. Package is in composer's 'require-dev' settings
        //$twig->addExtension(new Ajgl\Twig\Extension\BreakpointExtension());
        $twig->addGlobal('_post', $_POST);
        $twig->addGlobal('_get', $_GET);
        $twig->addGlobal('_server', $_SERVER);
        $twig->addGlobal('modx', $this->modx);

        return $twig;
    }

    public function parse($content)
    {
        // If there aren't any Twig template vars, skip running it
        if (strpos($content, '{{') !== false || strpos($content, '{%') !== false) {
            $template = $this->twig->createTemplate($content);
            return $template->render(array_merge($this->modx->resource->toArray(), $this->modx->placeholders));
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