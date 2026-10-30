<?php
if (PHP_SAPI !== 'cli') exit(1);
require_once __DIR__ . '/../fungsi/rasio_inheren.php';

$cases = [
    ['Assets not entered', [100, 0, 100], 0.0],
    ['Missing denominator', [100, null, 100], 0.0],
    ['Empty denominator', [100, '', 100], 0.0],
    ['String zero', ['100', '0.00', 100], 0.0],
    ['Zero numerator', [0, 200, 100], 0.0],
    ['Ordinary percentage', [25, 200, 100], 12.5],
    ['Rounded percentage', [1, 3, 100], 33.33],
    ['Plain liquidity ratio', [1, 3], 0.33],
    ['Negative cash flow', [-25, 200, 100], -12.5],
    ['Negative denominator', [25, -200, 100], -12.5],
    ['Unrounded intermediate growth', [1, 3, 100, null], 100 / 3],
    ['Non-finite denominator', [100, INF, 100], 0.0],
    ['Non-finite numerator', [INF, 100, 100], 0.0],
];
foreach ($cases as [$label, $arguments, $expected]) {
    $actual = inheren_safe_ratio(...$arguments);
    if (!is_finite($actual) || abs($actual - $expected) > 0.000000001) {
        throw new RuntimeException($label . ': unexpected ratio ' . $actual);
    }
}
$creditGrowth = inheren_safe_ratio(120 - 100, 100, 100, null);
$depositGrowth = inheren_safe_ratio(110 - 100, 100, 100, null);
if (inheren_safe_ratio($creditGrowth, $depositGrowth, 100) !== 200.0) {
    throw new RuntimeException('Credit/deposit growth ratio changed');
}
if (inheren_safe_ratio($creditGrowth, 0, 100) !== 0.0) {
    throw new RuntimeException('Zero deposit growth is unsafe');
}
echo 'PASS: ', count($cases) + 2, ' inherent credit/liquidity ratio cases', PHP_EOL;
