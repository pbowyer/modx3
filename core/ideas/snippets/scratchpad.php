<?php
/**
 * Note an example snippet; rather where I play with how they can be used.
 */

/** @var modX $modx */
$modx->registerSnippet('TestClosure', function($scriptProperties) use (&$modx) {
    return $modx->makeUrl(3);
});

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

interface modxClassSnippet {
    // Self-doubt: interface a good thing? You can't change method signatures in an interface,
    // and I would like to define __construct() with the minimum arguments required - but still
    // allow dependency injection like in RatherMoreComplexTestClassSnippet below.
    //
    // Needs rethinking. Input from others very welcome.
    public function run($scriptProperties);
}

class TestClassSnippet implements modxClassSnippet
{
    private $modx;

    public function __construct($modx)
    {
        $this->modx = $modx;
    }

    public function run($scriptProperties)
    {

    }
}
// The class is instantiated only if the snippet is called
$modx->registerSnippet('TestClass', TestClassSnippet::class);

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

class RatherMoreComplexTestClassSnippet implements modxClassSnippet
{
    private $modx;
    /**
     * @var Foo
     */
    private $foo;
    /**
     * @var BarInterface
     */
    private $bar;
    private $baz;

    /**
     * In this example, we have more dependencies to inject into the constructor
     *
     * @param $modx
     * @param Foo $foo
     * @param BarInterface $bar
     * @param $baz
     */
    public function __construct($modx, Foo $foo, BarInterface $bar, $baz)
    {
        $this->modx = $modx;
        $this->foo = $foo;
        $this->bar = $bar;
        $this->baz = $baz;
    }

    public function run($scriptProperties)
    {

    }
}
// The class is instantiated by us, in order to inject the dependencies
// If a DIC was used, we could avoid this and lazy-load
$object = new RatherMoreComplexTestClassSnippet($modx, new Foo(), new Bar(), new Baz());
$modx->registerSnippet('RatherMoreComplexTestClass', $object);
