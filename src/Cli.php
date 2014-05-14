<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester;

/**
 * Provides the argument parsing and routing for the command line interface
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class Cli
{
    const VERSION = 'beta1';

    /**
     *
     * @var Pimple
     */
    protected $container;

    /**
     *
     */
    public function __construct(\Pimple $container)
    {
        $this->container = $container;
    }

    /**
     * Runs the CLI program
     */
    public function run(array $arguments)
    {
        $this->log(\Monolog\Logger::INFO, 'RecipeSuggester Version ' . self::VERSION);
        $this->log(\Monolog\Logger::INFO, '');

        if (sizeof($arguments) != 3)
        {
            return $this->displayUsage();
        }

        try
        {
            $recipes = $this->getRecipes($arguments[1]);
            $ingredients = $this->getIngredients($arguments[2]);
        }
        catch (\RecipeSuggester\Parser\InvalidFormatException $e)
        {
            $this->log(\Monolog\Logger::ERROR, $e->getMessage());
            return $this->displayUsage();
        }

        $intersector = new RecipeIngredientIntersector(
            $recipes, new Model\Pantry($ingredients, $this->container['logger'])
        );

        $suggestedRecipe = $intersector->getBestRecipe();

        if (empty($suggestedRecipe))
        {
            $this->log(\Monolog\Logger::INFO, 'Order Takeout');
        }
        else
        {
            $this->log(\Monolog\Logger::INFO, 'You should cook ' . $suggestedRecipe->getName());
        }

        return 0;
    }

    /**
     * Displays CLI usage text
     */
    protected function displayUsage()
    {
        $message = "Usage: php recipesuggest.php <recipe file> <ingredients file>";
        $this->log(\Monolog\Logger::INFO, $message);
        $this->log(\Monolog\Logger::INFO, '');

        return 1;
    }

    /**
     *
     * @param string $recipeFile The filename of the recipes file
     * @return array
     */
    protected function getRecipes($recipeFile)
    {
        $contents = file_get_contents($recipeFile);
        return $this->container['recipe.parser']->parse($contents);
    }

    /**
     *
     * @param array $ingredientsFile
     * @return array
     */
    protected function getIngredients($ingredientsFile)
    {
        $contents = file_get_contents($ingredientsFile);
        return $this->container['ingredient.parser']->parse($contents);
    }

    /**
     *
     * @param mixed  $level
     * @param string $message
     * @throws \InvalidArgumentException
     */
    protected function log($level, $message)
    {
        $logger = $this->container['logger'];

        if (!isset($logger) || !is_object($logger) || !method_exists($logger, 'log'))
        {
            throw new \InvalidArgumentException('Logger incorrectly configured');
        }

        $logger->log($level, $message);
    }
}