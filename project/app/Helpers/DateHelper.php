<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
    * Retorna o formato atual para o tipo 'date'.
    *
    * @return string
    */
    public static function getDateFormat()
    {
        return 'd/m/Y';
    }

    /**
    * Retorna o formato atual para o tipo 'datetime'.
    *
    * @return string
    */
    public static function getDateTimeFormat()
    {
        return 'd/m/Y H:i';
    }

    /**
     * Formata uma data para o formato indicado
     *
     * @param Carbon|string $date Date to format.
     * @param string $toFormat Format.
     * @param string $fromFormat Origin format.
     * @return string
     */
    public static function formatDate($date, $toFormat = null, $fromFormat = null)
    {
        if ($toFormat === null) {
            $toFormat = static::getDateTimeFormat();
        }

        if ($date instanceof Carbon) {
            return $date->format($toFormat);
        }

        $date = ((bool) $fromFormat && !empty($date))
            ? Carbon::createFromFormat($fromFormat, $date)
            : Carbon::parse($date);

        return $date->format($toFormat);
    }

    /**
    * Retorna inicio e fim de um período passado por argumento.
    *
    * @param string $periodName Nome do período.
    * @return array
    */
    public static function getPeriod(string $periodName)
    {
        $periods = [
            'morning' => [
                'begin' => [
                    'hour' => 6,
                    'minute' => 0,
                    'second' => 0,
                ],
                'end' => [
                    'hour' => 12,
                    'minute' => 0,
                    'second' => 0,
                ],
            ],
            'afternoon' => [
                'begin' => [
                    'hour' => 12,
                    'minute' => 0,
                    'second' => 1,
                ],
                'end' => [
                    'hour' => 18,
                    'minute' => 0,
                    'second' => 0,
                ],
            ]
        ];

        if (isset($periods[$periodName])) {
            return $periods[$periodName];
        }

        throw new \InvalidArgumentException('Period "'.$periodName.'" is not configured.');
    }

    /**
     *  Calcula a data limite a partir de uma data inicial e a quantidade de
     * períodos a serem somados.
     *
     * @param Carbon\Carbon $initialDate Data inicial para base do cálculo.
     * @param int $periods Períodos a serem somados à data inicial.
     * @param array $ignoredDates Datas que serão 'puladas' durante a soma de períodos.
     * @return Carbon\Carbon $datePlusPeriods
     */
    public static function sumPeriodsAndGetDeadline(
        Carbon $initialDate,
        int $periods,
        array $ignoredDates = []
    ) {
        if ($periods < 1) {
            throw new \InvalidArgumentException('Periods must be at least 1');
        }

        $datePlusPeriods = clone $initialDate;

        for ($i = 0; $i < $periods; $i++) {
            $datePlusPeriods = static::nextEndPeriod($datePlusPeriods, $ignoredDates);
        }

        return $datePlusPeriods;
    }

    /**
     *  Calcula a data limite a partir de uma data inicial e a quantidade de
     * períodos a serem somados.
     *
     * @param Carbon\Carbon $initialDate Data inicial para base do cálculo.
     * @param int $periods Períodos a serem somados à data inicial.
     * @param array $ignoredDates Datas que serão 'puladas' durante a soma de períodos.
     * @return Carbon\Carbon $dateSubtractPeriods
     */
    public static function subtractPeriodsAndGetDeadline(
        Carbon $initialDate,
        int $periods,
        array $ignoredDates = []
    ) {
        if ($periods < 1) {
            throw new \InvalidArgumentException('Periods must be at least 1');
        }

        $date = clone $initialDate;

        for ($i = 0; $i < $periods; $i++) {
            $date = static::previousEndPeriod($date, $ignoredDates);
        }

        return $date;
    }

    /**
     * Retorna o final do próximo período
     *
     * @param Carbon\Carbon $initialDate Data inicial para base do cálculo.
     * @param array $ignoredDates Datas que serão 'puladas' durante a soma de períodos.
     * @return Carbon\Carbon
     */
    public static function nextEndPeriod(Carbon $initialDate, array $ignoredDates = [])
    {
        if (static::inMorningPeriod($initialDate)) {
            $initialDate = static::getEndOfPeriod('afternoon', $initialDate);
        } else {
            $initialDate->addDay();
            $initialDate = static::getEndOfPeriod('morning', $initialDate);
        }

        $isWeekend = $initialDate->isWeekend();
        if ($isWeekend || static::sameDayInArrayOfDates($initialDate, $ignoredDates)) {
            $initialDate = static::nextEndPeriod($initialDate, $ignoredDates);
        }

        return $initialDate;
    }

    /**
     * Retorna o final do anterior período
     *
     * @param Carbon\Carbon $initialDate Data inicial para base do cálculo.
     * @param array $ignoredDates Datas que serão 'puladas' durante a soma de períodos.
     * @return array Carbon\Carbon initialDate Carbon\Carbon endDate
     */
    public static function previousEndPeriod(Carbon $initialDate, array $ignoredDates = [])
    {
        if (static::inMorningPeriod($initialDate)) {
            $initialDate->subDay();
            $initialDate = static::getEndOfPeriod('afternoon', $initialDate);
        } else {
            $initialDate = static::getEndOfPeriod('morning', $initialDate);
        }

        $isWeekend = $initialDate->isWeekend();
        if ($isWeekend || static::sameDayInArrayOfDates($initialDate, $ignoredDates)) {
            $initialDate = static::previousEndPeriod($initialDate, $ignoredDates);
        }

        return $initialDate;
    }

    /**
     *  Verifica se um determinado dia está dentro de uma lista de datas.
     * @param  Carbon $needle
     * @param  array  $hayStack
     * @return boolean
     */
    public static function sameDayInArrayOfDates(Carbon $needle, array $hayStack)
    {
        foreach ($hayStack as $date) {
            if ($date->isSameDay($needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retorna o início do período dado uma data inicial e o nome do período
     *
     * @param string $period Nome do período.
     * @param Carbon\Carbon $initialDate Data inicial para base do cálculo.
     * @return Carbon\Carbon
     */
    public static function getBeginOfPeriod(string $period, Carbon $initialDate)
    {
        $period = static::getPeriod($period);

        $beginPeriod = clone $initialDate;
        $beginPeriod->hour($period['begin']['hour'])
            ->minute($period['begin']['minute'])
            ->second($period['begin']['second']);

        return $beginPeriod;
    }

    /**
     * Retorna o final do período dado uma data inicial e o nome do período
     *
     * @param string $period Nome do período.
     * @param Carbon\Carbon $initialDate Data inicial para base do cálculo.
     * @return Carbon\Carbon
     */
    public static function getEndOfPeriod(string $period, Carbon $initialDate)
    {
        $period = static::getPeriod($period);

        $beginPeriod = clone $initialDate;
        $beginPeriod->hour($period['end']['hour'])
            ->minute($period['end']['minute'])
            ->second($period['end']['second']);

        return $beginPeriod;
    }

    /**
     * Dado uma data, retorna se está no período da manhã ou não.
     *
     * @param Carbon\Carbon $date Data inicial.
     * @return bool
     */
    public static function inMorningPeriod(Carbon $date)
    {
        $beginPeriod = static::getBeginOfPeriod('morning', $date);
        $endPeriod = static::getEndOfPeriod('morning', $date);

        return $date->between($beginPeriod, $endPeriod);
    }

    /**
     * Dado uma data, retorna se está no período da tarde ou não.
     *
     * @param Carbon\Carbon $date Data.
     * @return bool
     */
    public static function inAfternoonPeriod(Carbon $date)
    {
        $beginPeriod = static::getBeginOfPeriod('afternoon', $date);
        $endPeriod = static::getEndOfPeriod('afternoon', $date);

        return $date->between($beginPeriod, $endPeriod);
    }

    /**
     * Dado uma data inicial e uma final, retorna todos os dias entre elas
     * @param  Carbon $startDate Data inicial
     * @param  Carbon $end_date   Data final
     * @return array
     */
    public static function generateDateRange(Carbon $startDate, Carbon $endDate)
    {
        if ($startDate->gt($endDate)) {
            list($startDate, $endDate) = [$endDate, $startDate];
        }

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[] = clone $date;
        }
        return $dates ?? [];
    }

    /**
     * Dado um intervalo em string, converte para uma array com os devidos formatos
     *  para o banco de dados
     * @param string $period
     * @param string $periodSeparator
     * @return array
     */
    public static function convertDateInterval(string $period, string $periodSeparator = '-')
    {
        $dateInterval = explode($periodSeparator, $period);

        if (sizeof($dateInterval) > 2) {
            throw new \RuntimeException("Invalid period [{$period}]");
        }

        $dateInterval[0] = static::formatDate(
            trim($dateInterval[0]),
            'Y-m-d 00:00:00',
            static::getDateFormat()
        );

        $dateInterval[1] = static::formatDate(
            trim($dateInterval[1] ?? $period),
            'Y-m-d 23:59:59',
            static::getDateFormat()
        );

        return $dateInterval;
    }
}
