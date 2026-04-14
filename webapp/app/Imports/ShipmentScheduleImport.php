<?php

declare(strict_types=1);

namespace App\Imports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

/**
 * Import class for reading schedule Excel files (SHIPPING LINE, VESSEL NAME, VOY NO., POL, ETD, POD, ETA, COMMENT).
 * Use Excel::toArray($this, $path) to get rows keyed by first-row headers.
 * Map raw rows to canonical keys via mapRowToCanonical(). CY CUT and BOOKING CUT are ignored.
 */
class ShipmentScheduleImport implements WithHeadingRow
{
    /**
     * Map Excel header names (slugged by Maatwebsite) to canonical keys.
     * Omit cy_cut and booking_cut so they are never imported.
     */
    public const EXCEL_TO_CANONICAL = [
        'shipping_line' => 'shipping_line',
        'shipping line' => 'shipping_line',
        'vessel_name' => 'vessel_name',
        'vessel name' => 'vessel_name',
        'voy_no' => 'voyage_no',
        'voy-no' => 'voyage_no',
        'voy no' => 'voyage_no',
        'voyage_no' => 'voyage_no',
        'voyage no' => 'voyage_no',
        'pol' => 'pol',
        'etd' => 'etd',
        'pod' => 'pod',
        'eta' => 'eta',
        'comment' => 'comment',
        'comments' => 'comment',
        // Legacy/alternate names
        'vessel' => 'vessel_name',
        'voyage' => 'voyage_no',
        'start_port' => 'pol',
        'start port' => 'pol',
        'origin' => 'pol',
        'end_port' => 'pod',
        'end port' => 'pod',
        'destination' => 'pod',
    ];

    /**
     * Canonical keys for group key: (shipping_line, vessel_name, voyage_no, pol, etd).
     */
    public const GROUP_KEYS = ['shipping_line', 'vessel_name', 'voyage_no', 'pol', 'etd'];

    /**
     * Normalize Excel row to canonical keys. Dates (eta, etd) normalized to Y-m-d when present.
     *
     * @param  array<string, mixed>  $row
     * @return array<string, string>
     */
    public static function mapRowToCanonical(array $row): array
    {
        $canonical = [
            'shipping_line' => '',
            'vessel_name' => '',
            'voyage_no' => '',
            'pol' => '',
            'etd' => '',
            'pod' => '',
            'eta' => '',
            'comment' => '',
        ];

        foreach ($row as $excelKey => $value) {
            $key = is_string($excelKey) ? strtolower(trim(preg_replace('/\s+/', ' ', (string) preg_replace('/-/', '_', $excelKey)))) : null;
            if ($key === null) {
                continue;
            }
            if (isset(self::EXCEL_TO_CANONICAL[$key])) {
                $canonicalKey = self::EXCEL_TO_CANONICAL[$key];
                if ($canonicalKey === 'eta') {
                    $canonical[$canonicalKey] = self::normalizeEtaValue($value);
                } elseif ($canonicalKey === 'etd') {
                    $canonical[$canonicalKey] = self::normalizeDateValue($value);
                } else {
                    $canonical[$canonicalKey] = self::normalizeTextValue($value);
                }
            }
        }

        return $canonical;
    }

    /**
     * Normalize text that may come from Excel as formula (e.g. ="087") to plain value (087).
     */
    public static function normalizeTextValue(mixed $value): string
    {
        $val = trim((string) $value);
        if ($val === '') {
            return '';
        }
        if (preg_match('/^="(.*)"\s*$/s', $val, $m)) {
            return trim($m[1]);
        }
        if (str_starts_with($val, '="') && str_ends_with($val, '"')) {
            return trim(substr($val, 2, -1));
        }

        return $val;
    }

    /**
     * Normalize date: Excel serial (e.g. 46050) to Y-m-d, or parse string dates.
     */
    public static function normalizeDateValue(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        $val = is_string($value) ? trim($value) : $value;
        if ($val === '') {
            return '';
        }
        if (is_numeric($val)) {
            $num = (float) $val;
            if ($num >= 1 && $num <= 2958465) {
                try {
                    $dt = ExcelDate::excelToDateTimeObject($num);

                    return $dt->format('Y-m-d');
                } catch (\Throwable) {
                    return (string) $value;
                }
            }
        }
        if (is_string($val)) {
            try {
                return Carbon::parse($val)->format('Y-m-d');
            } catch (\Throwable) {
                return $val;
            }
        }

        return (string) $value;
    }

    /**
     * Normalize ETA values. Any non-empty invalid value (e.g. TBA) becomes 0000-00-00.
     */
    public static function normalizeEtaValue(mixed $value): string
    {
        $raw = is_string($value) ? trim($value) : trim((string) $value);
        if ($raw === '') {
            return '';
        }

        if (strtoupper($raw) === 'TBA') {
            return '0000-00-00';
        }

        $normalized = self::normalizeDateValue($value);
        if (self::isValidYmdDate($normalized)) {
            return $normalized;
        }

        return '0000-00-00';
    }

    protected static function isValidYmdDate(string $value): bool
    {
        try {
            $dt = Carbon::createFromFormat('Y-m-d', $value);

            return $dt !== false && $dt->format('Y-m-d') === $value;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Build stable group key from a canonical row for grouping.
     */
    public static function groupKeyForRow(array $row): string
    {
        $parts = [];
        foreach (self::GROUP_KEYS as $k) {
            $parts[] = trim((string) ($row[$k] ?? ''));
        }

        return implode("\0", $parts);
    }
}
