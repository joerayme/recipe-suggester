<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester;

/**
 *
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class CliTest extends PHPUnit_Framework_TestCase
{
    protected $container;
    protected $cli;

    public function setUp()
    {
        $this->container = new \Pimple;
        $this->cli       = new Cli($this->container);
    }
}