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
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     *
     * @param array           $ingredients
     * @param \Monolog\Logger $logger      Optionally can report on out of date
     *                                     food
     */
    public function __construct(array $ingredients, \Monolog\Logger $logger = null)
    {
        $this->ingredients = $ingredients;
        usort($this->ingredients, array('\\RecipeSuggester\\Model\\Pantry', 'compareIngredients'));
        $this->logger      = $logger;
    }

    /**
     *
     * @param \RecipeSuggester\Model\Recipe $recipe
     */
    public function hasIngredientsForRecipe(Recipe $recipe)
    {
        foreach ($recipe->getIngredients() as $ingredient) {
            if (!$this->hasIngredient($ingredient)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks to see if we have enough of the recipe's ingredient
     *
     * @param  \RecipeSuggester\Model\Ingredient $ingredient
     * @return boolean
     */
    protected function hasIngredient(Ingredient $ingredient)
    {
        foreach ($this->ingredients as $myIngredient) {
            // Ensure we compare like with like - the ingredient name as well as
            // the unit it's measured in
            if ($myIngredient->getItem() == $ingredient->getItem()
                && $myIngredient->getUnit() == $ingredient->getUnit()
            ) {
                if ($myIngredient->isPastUseBy()) {
                    if ($this->logger) {
                        $message = $myIngredient->getItem() . ' is past its use by date!';
                        $this->logger->addNotice($message);
                    }

                    return false;
                }

                return $myIngredient->getAmount() >= $ingredient->getAmount();
            }
        }

        return false;
    }

    /**
     * Gets the ingredients that are in date ordered by their use-by date
     *
     * @return array
     */
    public function getInDateIngredients()
    {
        return array_values(array_filter($this->ingredients, function (Ingredient $i) {
            return !$i->isPastUseBy();
        }));
    }

    /**
     * Comparator function for usort
     *
     * @param \RecipeSuggester\Model\Ingredient $a
     * @param \RecipeSuggester\Model\Ingredient $b
     */
    public static function compareIngredients(Ingredient $a, Ingredient $b)
    {
        if ($a->getUseBy() == $b->getUseBy()) {
            return 0;
        }

        return $a->getUseBy() > $b->getUseBy() ? 1 : -1;
    }
}
