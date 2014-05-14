<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester;

/**
 *
 * @author Joseph Ray <joe@joeray.me>
 */
interface Parser
{
    /**
     * Takes a string of data and parses it
     *
     * @param string $string The string representation of the data to be parsed
     */
    public function parse($string);
}