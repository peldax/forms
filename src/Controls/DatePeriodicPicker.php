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
class DatePeriodicPicker extends DatePicker
{
    protected CONST YEAR = 1112;

    protected function getDefaultParser()
    {
        return function($value) {
            if (!preg_match('#^(?P<dd>\d{1,2})[. -] *(?P<mm>\d{1,2})([. -] *(?P<yyyy>\d{4})?)?$#', $value, $matches)) {
                return null;
            }

            $dd = $matches['dd'];
            $mm = $matches['mm'];
            $yyyy = static::YEAR;

            if (!checkdate($mm, $dd, $yyyy)) {
                return null;
            }

            return (new DateTimeImmutable)
                ->setDate($yyyy, $mm, $dd)
                ->setTime(0, 0, 0);
        };
    }

    public function getControl(): Html
    {
        $element = parent::getControl();

        $element->addClass('date-periodic');

        return $element;
    }
}