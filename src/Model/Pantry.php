<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester\Model;

/**
 * A list of ingredients in the pantry
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class Pantry
{
    protected $ingredients;

    /**
     *
     * @param array $ingredients
     */
    public function __construct(array $ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     *
     * @param \RecipeSuggester\Model\Recipe $recipe
     */
    public function hasIngredientsForRecipe(Recipe $recipe)
    {
        foreach($recipe->getIngredients() as $ingredient)
        {
            if (!$this->hasIngredient($ingredient))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks to see if we have enough of the recipe's ingredient
     *
     * @param \RecipeSuggester\Model\Ingredient $ingredient
     * @return boolean
     */
    protected function hasIngredient(Ingredient $ingredient)
    {
        foreach ($this->ingredients as $myIngredient)
        {
            if ($myIngredient->isPastUseBy())
            {
                return false;
            }

            // Ensure we compare like with like - the ingredient name as well as
            // the unit it's measured in
            if ($myIngredient->getItem() == $ingredient->getItem()
                && $myIngredient->getUnit() == $ingredient->getUnit()
            ) {
                return $myIngredient->getAmount() >= $ingredient->getAmount();
            }
        }

        return false;
    }
}