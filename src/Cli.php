<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester;

/**
 * Provides the argument parsing and routing for the command line interface
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class Cli
{
    /**
     *
     * @var Pimple
     */
    protected $container;

    /**
     *
     */
    public function __construct(\Pimple $container)
    {
        $this->container = $container;
    }

    /**
     * Runs the CLI program
     */
    public function run(array $arguments)
    {}
}