<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester;

/**
 * Computes the intersection of the recipes and their ingredients against a list
 * of available ingredients and returns the suggested list of recipes ordered by
 * suitability.
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class RecipeIngredientIntersector
{
    protected $recipes;
    protected $ingredients;

    /**
     *
     * @param array $recipes
     * @param array $ingredients
     */
    public function __construct(array $recipes, array $ingredients)
    {
        $this->recipes     = $recipes;
        $this->ingredients = $ingredients;
    }

    /**
     *
     * @return array An array of recipes that are suitable for the given
     *               ingredients
     */
    public function getSuitableRecipes()
    {
        $suitableRecipes = array();

        foreach ($this->recipes as $recipe)
        {
            foreach ($this->ingredients as $ingredient)
            {
                if ($recipe->canUseIngredient($ingredient))
                {
                    $suitableRecipes[] = $recipe;
                    break;
                }
            }
        }

        return $suitableRecipes;
    }
}