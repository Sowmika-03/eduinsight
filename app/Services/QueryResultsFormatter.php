<?php

namespace App\Services;

use Illuminate\Support\Collection;

class QueryResultsFormatter
{
    /**
     * Format query results for display in tables/charts
     */
    public static function format($results)
    {
        if (empty($results)) {
            return [
                'columns' => [],
                'rows' => [],
                'count' => 0,
            ];
        }

        $results = collect($results);
        $firstRow = $results->first();

        if (is_object($firstRow)) {
            $firstRow = (array)$firstRow;
        }

        $columns = array_keys($firstRow);

        return [
            'columns' => $columns,
            'rows' => $results->map(function ($row) {
                return is_object($row) ? (array)$row : $row;
            })->toArray(),
            'count' => count($results),
        ];
    }

    /**
     * Detect if results are suitable for chart visualization
     */
    public static function detectChartType($columns, $rows)
    {
        if (empty($rows) || count($rows) < 2) {
            return null;
        }

        $numericCols = [];
        $stringCols = [];

        foreach ($columns as $col) {
            $firstVal = $rows[0][$col] ?? null;
            if (is_numeric($firstVal)) {
                $numericCols[] = $col;
            } else {
                $stringCols[] = $col;
            }
        }

        // Bar chart: 1 string column + 1 numeric column
        if (count($stringCols) >= 1 && count($numericCols) >= 1) {
            return [
                'type' => 'bar',
                'labelColumn' => $stringCols[0],
                'valueColumn' => $numericCols[0],
            ];
        }

        // Pie/Donut: limited labels and single numeric value
        if (count($rows) <= 10 && count($stringCols) >= 1 && count($numericCols) >= 1) {
            return [
                'type' => 'pie',
                'labelColumn' => $stringCols[0],
                'valueColumn' => $numericCols[0],
            ];
        }

        return null;
    }

    /**
     * Prepare data for Chart.js
     */
    public static function prepareChartData($rows, $chartConfig)
    {
        $labels = [];
        $values = [];

        foreach ($rows as $row) {
            $labels[] = $row[$chartConfig['labelColumn']];
            $values[] = (float)$row[$chartConfig['valueColumn']];
        }

        return [
            'labels' => $labels,
            'values' => $values,
            'type' => $chartConfig['type'],
        ];
    }
}
