<?php
/**
 * Guard ratio calculations when master data is still empty.
 * A null precision preserves unrounded intermediate values (e.g. growth rates).
 */
function inheren_safe_ratio($numerator, $denominator, float $scale = 1.0, ?int $precision = 2): float
{
    if (!is_numeric($numerator) || !is_numeric($denominator)) return 0.0;
    $denominator = (float)$denominator;
    if ($denominator == 0.0 || !is_finite($denominator)) return 0.0;
    $result = ((float)$numerator / $denominator) * $scale;
    if (!is_finite($result)) return 0.0;
    return $precision === null ? $result : round($result, $precision);
}
