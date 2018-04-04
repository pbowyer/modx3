# RFC: Support multiple template engines in MODX 3

# Aim

To allow other template engines to be used in MODX, in addition to the built-in snippets/chunks and templates model. A successful outcome is measured against these criteria:

* New templating engines should be _complimentary_ to MODX, that is not replace the existing templating approach.
* TBC

# Why?

My driver for this project is to be able to use Twig within MODX. Twig is widely used, and when working with multiple frameworks it's handy to have as few template syntaxs to remember as possible. The author has to know 4 templating languages for everyday work, and does not want to introduce another syntax to remember.

Also, the approach taken by MODX (similar to pull-style XSLT in my mind) is less common than a push-templating system, where data is passed to the template and iterated over.

# Prior work

### [pdoTools]
The best known and most polished is Fenom, part of the excellent [pdoTools] package. It functions by subclassing `modParser` as `pdoParser` and adjusting the MODX system settings `parser_class` and `parser_class_path` so MODX instantiates the new, custom parser.

## Previous attempts using Twig

### [modxTwigTemplateEngine](https://github.com/Codenator81/modxTwigTemplateEngine)

This loaded Twig and provided a few helper functions to link it and MODX, but did not let Twig be used in MODX templates.

### [twiggy](https://github.com/vgrish/twiggy/)

Like [pdoTools] it subclasses `modParser` to provide its own parsing. Its code was based on pdoTools, and uses its namespace in places.

# The need for a different approach

The approach taken for Fenom in [pdoTools] works well.

It has one serious drawback: you can only have one custom `parser_class` set. Want to use twiggy and pdoTools at the same time? You can't<sup>[1](#f1)</sup>.

You could stick to using just one parser extension in every MODX site, but MODX is about creative freedom.

# Possible solutions

## Chain of responsibilities pattern

Allow multiple template engines to be registered with MODX. The internal template engine is treated the same as any other.

Pseudocode:
```php
class modX
{
    public function __construct()
    {
        $this->addTemplateParser(new \modxTemplateParser());
    }
    
    public function addTemplateParser(abstractTemplateParser $parser)
    {
        // @TODO Allow parsers to be reordered
        $this->parsers[] = $parser;
    }
}
```

```php
interface iTemplateParser
{
    public function process($string);
}
```

```php
class modxTemplateParser implements iTemplateParser
{
    public function process($string)
    {
        return $string . ' MODX';
    }
}
```
```php
class twigTemplateParser implements iTemplateParser
{
    public function process($string)
    {
        return $string . ' TWIG';
    }
}
```

And in a MODX plugin:
```php
$modx->addTemplateParser(new \twigTemplateParser());
```

Then when MODX renders a chunk containing the text `Hello`, it will output
 ```
 Hello MODX TWIG
 ```

## Events and event listeners (Observer pattern)
A similar in concept approach, which is already widely used in MODX for plugin calls. MODX would define new events (example: an event called `ProcessTemplate`) and the new template engine(s) would listen for this event to be triggered, processing the payload.

# Choice of approach

There may be performance implications; otherwise I believe it's very much down to a style choice. (Contradict me! Teach me!)

<p>&nbsp;</p>
<p>&nbsp;</p>
<hr>

<sup><b id="f1">1</b></sup>Actually you can, because twiggy requires pdoTools to be installed. But supposing it didn't. You'd need to modify twiggy so `twigParser`  extends `pdoParser`, which in turn extends `modParser`. That makes your install of `twigParser` non-standard, so you can't update the extra when updates are released. And when you add a third (or fourth) script that wants to subclass `modParser`, you have to do all this again. And then those scripts conflict and overwrite each other's output. So it's easier to say "No you can't"


[pdoTools]: https://modx.com/extras/package/pdotools