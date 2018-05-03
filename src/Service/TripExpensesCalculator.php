<?php

namespace App\Service;

class TripExpensesCalculator
{
    /**
     * Calculates the number of cents an employee will get for a trip
     */
    public function getExpenses(\DateTimeImmutable $start, \DateTimeImmutable $end): int
    {
        // Warning - finanzamt might disagree.
        return $end->getTimestamp() - $start->getTimestamp();
    }
}