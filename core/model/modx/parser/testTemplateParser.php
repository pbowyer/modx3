<?php

class testTemplateParser extends modTemplateParser
{

    public function parse($content)
    {
        if (strpos($content, '>') !== false && strpos($content, '<') !== false) {
            $content = preg_replace('/(<.+?>[^<>]*?)(a)([^<>]*?<.+?>)/', '$1aZ$3', $content);
            $content = preg_replace('/(<.+?>[^<>]*?)(E)([^<>]*?<.+?>)/', '$1Ez$3', $content);
            return $content; // . dump($this->modx->placeholders);
        } else {
            return $content;
        }
    }
}