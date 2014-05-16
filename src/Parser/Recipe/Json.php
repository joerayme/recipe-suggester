<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester\Parser\Recipe;

/**
 *
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class Json extends \RecipeSuggester\Parser\Recipe
{
    /**
     *
     * @param string $string
     */
    public function parse($string)
    {
        $return  = array();
        $recipes = json_decode($string, false);

        if (!$recipes) {
            throw new \RecipeSuggester\Parser\InvalidFormatException('Invalid JSON in recipe list');
        }

        if (!is_array($recipes) || empty($recipes)) {
            throw new \RecipeSuggester\Parser\InvalidFormatException('No recpies provided in JSON');
        }

        foreach ($recipes as $recipeRaw) {
            $return[] = self::createRecipeFromDataObject($recipeRaw);
        }

        return $return;
    }
}
