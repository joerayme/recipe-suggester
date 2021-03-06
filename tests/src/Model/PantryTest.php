<?php
namespace RecipeSuggester\Model;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-05-14 at 02:36:18.
 */
class PantryTest extends \PHPUnit_Framework_TestCase
{
    protected $pantry;

    public function setUp()
    {
        $this->pantry = new Pantry(array(
            new Ingredient('bread', 10, 'slices', new \DateTime('tomorrow')),
            new Ingredient('salad', 500, 'grams', new \DateTime('+2 days')),
            new Ingredient('cheese', 10, 'slices', new \DateTime('tomorrow')),
            new Ingredient('ham', 300, 'grams', new \DateTime('yesterday'))
        ));
    }

    public function hasIngredientsForRecipeProvider()
    {
        return array(
            array(
                'Cheese sandwich',
                array(
                    new Ingredient('bread', 2, 'slices'),
                    new Ingredient('cheese', 2, 'slices')
                ),
                true
            ),
            array(
                'Salad sandwich',
                array(
                    new Ingredient('bread', 2, 'slices'),
                    new Ingredient('salad', 200, 'grams')
                ),
                true
            ),
            array(
                'Ham salad sandwich',
                array(
                    new Ingredient('bread', 2, 'slices'),
                    new Ingredient('ham', 100, 'grams'),
                    new Ingredient('salad', 100, 'grams'),
                ),
                false
            ),
            array(
                'Peanut butter sandwich',
                array(
                    new Ingredient('bread', 2, 'slices'),
                    new Ingredient('peanut butter', 100, 'grams')
                ),
                false
            )
        );
    }

    /**
     * @covers RecipeSuggester\Model\Pantry::hasIngredientsForRecipe
     * @dataProvider hasIngredientsForRecipeProvider
     */
    public function testHasIngredientsForRecipe($name, array $ingredients, $expectedResult)
    {
        $message = 'Pantry should ' . ($expectedResult ? '' : 'not ') . 'have ';
        $message .= 'ingredients for ' . $name;
        $this->assertEquals($expectedResult,
            $this->pantry->hasIngredientsForRecipe(
                new Recipe($name, $ingredients)
            ),
            $message
        );
    }

    /**
     * @covers RecipeSuggester\Model\Pantry::getInDateIngredients
     */
    public function testGetInDateIngredients()
    {
        $ingredients = $this->pantry->getInDateIngredients();

        $this->assertEquals(3, sizeof($ingredients), 'There should only be 3 in date ingredients');
        $this->assertEquals('salad', $ingredients[2]->getItem());
    }
}
