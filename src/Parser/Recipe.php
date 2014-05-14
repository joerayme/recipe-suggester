<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester\Parser;

/**
 *
 * @author Joseph Ray <joe@joeray.me>
 */
abstract class Recipe implements \RecipeSuggester\Parser
{
    /**
     * 
     * @param \stdClass $object
     * @return \RecipeSuggester\Model\Recipe
     */
    protected static function createRecipeFromDataObject(\stdClass $object)
    {
        if (!isset($object->name))
        {
            throw new InvalidFormatException('Invalid recipe list: recipe name was not provided');
        }

        if (!isset($object->ingredients) || !is_array($object->ingredients)
            || empty($object->ingredients)
        ) {
            throw new InvalidFormatException('Invalid recipe list: no ingredients for recipe "' . $object->name . '"');
        }

        return new \RecipeSuggester\Model\Recipe(
            $object->name,
            self::createIngredientsFromDataObjects($object->name, $object->ingredients)
        );
    }

    /**
     *
     * @param string $name
     * @param array  $ingredients
     * @return array
     */
    protected static function createIngredientsFromDataObjects($name, array $ingredients)
    {
        $return = array();

        foreach ($ingredients as $ingredient)
        {
            if (!isset($ingredient->item, $ingredient->amount, $ingredient->unit)
                || !is_numeric($ingredient->amount)
                || !in_array($ingredient->unit, \RecipeSuggester\Model\Ingredient::$validUnits))
            {
                throw new InvalidFormatException('Invalid ingredients list for recipe "' . $name . '"');
            }

            $return[] = new \RecipeSuggester\Model\Ingredient(
                $ingredient->item,
                intval($ingredient->amount),
                $ingredient->unit
            );
        }

        return $return;
    }
}