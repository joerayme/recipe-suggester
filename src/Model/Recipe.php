<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester\Model;

/**
 * Encapsulates a recipe
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class Recipe
{
    protected $name;

    protected $ingredients;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }
}