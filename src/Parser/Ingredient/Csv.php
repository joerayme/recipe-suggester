<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester\Parser\Ingredient;

/**
 *
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class Csv implements \RecipeSuggester\Parser\Ingredient
{
    /**
     * @inheritDoc
     */
    public function parse($string)
    {
        $ingredients = array();
        $lines = explode("\n", $string);

        foreach ($lines as $lineNumber => $line)
        {
            $fields = str_getcsv($line);

            $ingredients[] = self::validateLine($fields, $lineNumber);
        }

        return $ingredients;
    }

    /**
     *
     * @param array $fields
     */
    protected static function validateLine(array $fields, $lineNumber)
    {
        $message = 'Invalid format for ingredient CSV on line %d: ';
        if (sizeof($fields) != 4)
        {
            $message .= 'expected 4 fields, got %d';
            throw new \RecipeSuggester\Parser\InvalidFormatException(
                sprintf($message, $lineNumber + 1, sizeof($fields))
            );
        }

        if (!is_numeric($fields[1]))
        {
            $message .= 'expected quantity (2nd field) to be numeric. Got \'%s\' instead.';
            throw new \RecipeSuggester\Parser\InvalidFormatException(
                sprintf($message, $lineNumber + 1, $fields[1])
            );
        }

        if (!in_array($fields[2], \RecipeSuggester\Model\Ingredient::$validUnits))
        {
            $message .= 'unit field did not contain valid unit';
            throw new \RecipeSuggester\Parser\InvalidFormatException(
                sprintf($message, $lineNumber + 1)
            );
        }

        $useBy = \DateTime::createFromFormat('d/m/Y', $fields[3]);

        if (!$useBy)
        {
            $message .= 'use by date (4th field) is not in required format DD/MM/YYYY';
            throw new \RecipeSuggester\Parser\InvalidFormatException(
                sprintf($message, $lineNumber + 1)
            );
        }

        return new \RecipeSuggester\Model\Ingredient(
            $fields[0], floatval($fields[1]), $fields[2], $useBy
        );
    }
}