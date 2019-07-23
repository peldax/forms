<?php

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms
 */

namespace Nextras\Forms\Controls;

use DateTimeImmutable;
use Nette\Utils\Html;

/**
 * Form control for selecting date.
 */
class DatePeriodicPicker extends DateTimePickerPrototype
{
    /** @var string */
    protected $htmlFormat = 'Y-m-d';

    /** @var string */
    protected $htmlType = 'date';


    protected function getDefaultParser()
    {
        return function($value) {
            if (!preg_match('#^(?P<dd>\d{1,2})[. -] *(?P<mm>\d{1,2})([. -] *(?P<yyyy>\d{4})?)?$#', $value, $matches)) {
                return null;
            }

            $dd = $matches['dd'];
            $mm = $matches['mm'];
            $yyyy = 1112;//isset($matches['yyyy']) ? $matches['yyyy'] : date('Y');

            if (!checkdate($mm, $dd, $yyyy)) {
                return null;
            }

            return (new DateTimeImmutable)
                ->setDate($yyyy, $mm, $dd)
                ->setTime(0, 0, 0);
        };
    }


    /**
     * @return DateTimeImmutable|NULL
     */
    public function getValue()
    {
        $val = parent::getValue();
        // set midnight so the limit dates (min & max) pass the :RANGE validation rule
        if ($val !== null) {
            return $val->setTime(0, 0, 0);
        }
        return $val;
    }

    public function getControl(): Html
    {
        $element = parent::getControl();

        $element->addClass('date-periodic');

        return $element;
    }
}
