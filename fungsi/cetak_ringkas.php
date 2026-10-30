<?php
/** Keep the assessment summaries used by the compact complete report. */
function cetak_ringkas_sections(array $sections, bool $isCabang = false): array
{
    return array_values(array_filter($sections, static function(array $section) use ($isCabang): bool {
        $title = (string)($section['title'] ?? '');
        if ($isCabang && preg_match('/\bKPMR\b/i', $title)) return false;
        return !preg_match('/-\s*(?:KPMR\s*1|Inheren\s*1)\s*$/i', $title)
            && !preg_match('/\bProfil\s+(?:Nilai\s+Konsolidasi|Peringkat)\s*$/i', $title);
    }));
}

/** Reuse the saved overall profile narrative shown on the Nilai Profil form. */
function cetak_ringkas_cover_uraian($conn, int $id): string
{
    if ($id <= 0 || !pdf_table_exists($conn, 'nilai_profil')) return '';
    $row = pdf_one($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko='".$id."' LIMIT 1");
    $text = trim((string)($row['ket_nilai_risiko'] ?? ''));
    if ($text === '') return '';
    return '<section class="cover-narrative"><h2>URAIAN PROFIL RISIKO</h2><div class="cover-narrative-text">'
        .htmlspecialchars($text, ENT_QUOTES, 'UTF-8').'</div></section>';
}

/** Separate scores and grades into two visible rows in each per-risk profile. */
function cetak_ringkas_profile_table(array $row, string $caption, bool $isCabang): string
{
    $esc = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    $scores = $isCabang ? ['in' => 'Tingkat Risiko Inheren'] : [
        'in' => 'Tingkat Risiko Inheren', 'kp' => 'Tingkat KPMR', 't' => 'Tingkat Risiko'
    ];
    $html = '<table class="pdf-profile-single profile-score-rows'.($isCabang ? ' profil-cabang-only' : '').'"><thead>'
        .'<tr><th colspan="'.($isCabang ? 2 : 5).'">'.$esc($caption).'</th></tr><tr><th>Jenis Risiko</th>';
    foreach ($scores as $heading) $html .= '<th>'.$esc($heading).'</th>';
    if (!$isCabang) $html .= '<th>Tingkat Kualitas Manajemen Risiko</th>';
    $html .= '</tr></thead><tbody><tr class="profile-score-values"><td rowspan="2"><b>'.$esc($row['label'] ?? '').'</b></td>';
    foreach ($scores as $key => $heading) $html .= '<td class="valrank">'.$esc(pdf_num($row['nilai_'.$key] ?? 0)).'</td>';
    if (!$isCabang) $html .= '<td rowspan="2" class="quality-cell">'.$esc($row['kualitas'] ?? '').'</td>';
    $html .= '</tr><tr class="profile-score-ranks">';
    foreach ($scores as $key => $heading) $html .= '<td class="valrank"><b>'.$esc($row['rank_'.$key] ?? '').'</b></td>';
    return $html.'</tr></tbody></table>';
}
