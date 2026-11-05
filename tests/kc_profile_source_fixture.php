<?php
/** Run only original profile calculation functions, without rendering/saving a form. */
function kc_profile_fixture_result(mysqli $db, int $id, string $risk): array
{
    static $loaded = false;
    if (!$loaded) {
        $directory = __DIR__ . '/../admin/kc/';
        $source = file_get_contents($directory.'profil_risiko_stratejik/stratejik_profil.php');
        $extract = static function(string $source, string $name): string {
            $start = strpos($source, 'function '.$name.'(');
            if ($start === false) throw new RuntimeException('Missing original calculator '.$name);
            // Each standalone function ends with a closing brace at column zero.
            $end = strpos($source, "\n}", $start);
            return substr($source, $start, $end-$start+2);
        };
        foreach (['db_one','table_exists','avg','max','min','label_inheren','label_kpmr','fallback_result','find_frame_perumusan','risk_mode_label','pilar_perumusan_map','dynamic_method'] as $name) {
            eval(str_replace('op_', 'fixture_op_', $extract($source, 'op_'.$name)));
        }
        foreach (['operasional','kepatuhan','reputasi','stratejik'] as $key) {
            $original = file_get_contents($directory.'profil_risiko_'.$key.'/'.$key.'_profil.php');
            eval(str_replace('op_', 'fixture_op_', $extract($original, 'op_compute_inheren2_'.$key)));
        }
        $loaded = true;
    }
    $function = 'fixture_op_compute_inheren2_'.$risk;
    return $function($db, $id);
}
