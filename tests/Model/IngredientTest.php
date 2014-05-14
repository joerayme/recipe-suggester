<?php
namespace RecipeSuggester\Model;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-05-14 at 00:54:25.
 */
class IngredientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Ingredient
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Ingredient('cheese', 500, 'grams');
    }

    /**
     * @covers RecipeSuggester\Model\Ingredient::isPastUseBy
     * @todo   Implement testIsPastUseBy().
     */
    public function testIsPastUseBy()
    {
        $useByDate = new \DateTime('2014-01-01');

        // Can't be past its use by if one hasn't been set yet
        $this->assertFalse($this->object->isPastUseBy(new \DateTime('2013-01-01')));

        $this->object->setUseBy($useByDate);
        $this->assertFalse($this->object->isPastUseBy(new \DateTime('2013-01-01')));
        $this->assertTrue($this->object->isPastUseBy(new \DateTime('2014-02-01')));
        $this->assertTrue($this->object->isPastUseBy(new \DateTime('2014-01-01')));

        $this->object->setUseBy(new \DateTime('today'));
        $this->assertFalse($this->object->isPastUseBy(new \DateTime('yesterday')));
        $this->assertTrue($this->object->isPastUseBy(new \DateTime('today')));
        $this->assertTrue($this->object->isPastUseBy());
    }
}