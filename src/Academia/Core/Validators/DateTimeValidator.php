<?php

namespace Academia\Core\Validators;

use Academia\Core\Exceptions\ValidationException;
use Academia\Core\Helpers\DateTime;

class DateTimeValidator
{
    /**
     * @throws ValidationException
     */
    public static function dateTimeIsValidOrException(
        $field_description, 
        $date_string, 
        $fomat = ''
    )
    {
        if (empty($date_string)) {
            throw new ValidationException("$field_description: Formato da data é inválido.");
        }
        if (empty($fomat)) {
            try {
                DateTime::createDateTimeObjFromDateString($date_string); 
            } catch (\Exception $e) {
                throw new ValidationException("$field_description: Formato da data é inválido.");
            }
        }
        else {
            $date = \DateTime::createFromFormat($fomat, $date_string);
            if (! $date) {
                throw new ValidationException("$field_description: Formato da data é inválido.");
            }
        }
    }
}