<?php

use App\Helpers\DateHelper;
use App\Model\User;

if (! function_exists('format_date')) {
    /**
     * Formata uma data
     *
     * @param Date|string $date Date to format.
     * @param string $format Format.
     * @param string $fromFormat Origin format.
     * @return string
     */
    function format_date($date, $format = null, $fromFormat = null)
    {
        return DateHelper::formatDate($date, $format, $fromFormat);
    }
}

/**
 * Retorna uma instância do usuário corrente.
 *
 * @return User
 */
function current_user()
{
    return auth()->user();
}