<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

namespace RecipeSuggester\Model;

/**
 * Encapsulates a recipe ingredient
 *
 * @author Joseph Ray <joe@joeray.me>
 */
class Ingredient
{
    public static $validUnits = array(
        'of', 'grams', 'ml', 'slices'
    );

    protected $item;
    protected $amount;
    protected $unit;
    protected $useBy;

    /**
     *
     * @param string   $item
     * @param int      $amount
     * @param string   $unit
     * @param DateTime $useBy
     */
    public function __construct($item, $amount, $unit, $useBy = null)
    {
        $this->setItem($item);
        $this->setAmount($amount);
        $this->setUnit($unit);
        if ($useBy)
        {
            $this->setUseBy($useBy);
        }
    }

    public function getItem()
    {
        return $this->item;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    public function getUseBy()
    {
        return $this->useBy;
    }

    public function setUseBy(\DateTime $useBy)
    {
        $this->useBy = $useBy;
    }

    /**
     *
     * @param \DateTime $comparator The DateTime to compare to. If none is
     *                              provided, defaults to today.
     * @return boolean
     */
    public function isPastUseBy(\DateTime $comparator = null)
    {
        if ($this->useBy === null)
        {
            return false;
        }

        if ($comparator === null)
        {
            $comparator = new \DateTime('today');
        }

        return $this->useBy <= $comparator;
    }
}