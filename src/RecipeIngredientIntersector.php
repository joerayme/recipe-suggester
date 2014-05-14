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
    protected $pantry;

    /**
     *
     * @param array $recipes
     * @param array $ingredients
     */
    public function __construct(array $recipes, Model\Pantry $pantry)
    {
        $this->recipes = $recipes;
        $this->pantry  = $pantry;
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
            if ($this->pantry->hasIngredientsForRecipe($recipe))
            {
                $suitableRecipes[] = $recipe;
            }
        }

        return $suitableRecipes;
    }

    /**
     *
     * @return \RecipeSuggester\Model\Recipe
     */
    public function getBestRecipe()
    {
        $recipes = $this->getSuitableRecipes();

        if (sizeof($recipes) === 1)
        {
            return $recipes[0];
        }

        if (empty($recipes))
        {
            return null;
        }

        foreach ($this->pantry->getInDateIngredients() as $ingredient)
        {
            foreach ($recipes as $recipe)
            {
                if ($recipe->canUseIngredient($ingredient))
                {
                    return $recipe;
                }
            }
        }

        return $recipes[0];
    }
}