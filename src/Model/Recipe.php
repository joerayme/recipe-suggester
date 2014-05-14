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

    public function setIngredients(array $ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * Given an ingredient, determines whether it can be used in this recipe
     *
     */
    public function canUseIngredient(Ingredient $ingredient)
    {
        if ($ingredient->isPastUseBy())
        {
            return false;
        }

        foreach ($this->ingredients as $myIngredient)
        {
            // Ensure we compare like with like - the ingredient name as well as
            // the unit it's measured in
            if ($myIngredient->getItem() == $ingredient->getItem()
                && $myIngredient->getUnit() == $ingredient->getUnit()
            ) {
                return $myIngredient->getAmount() <= $ingredient->getAmount();
            }
        }

        return false;
    }
}