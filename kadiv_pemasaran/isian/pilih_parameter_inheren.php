<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$CFG = [
    'title'              => 'Profil Risiko Inheren',
    'setting_table'      => 'pr_pilih_parameter',
    'setting_detail'     => 'pr_pilih_parameter_detail',
    'periode_table'      => 'pr_inheren_periode',
    'periode_fk'         => 'pr_inheren_periode_id',
    'jenis_table'        => 'pr_jenis_risiko',
    'pilar_table'        => 'pr_pilar',
    'parameter_table'    => 'pr_parameter',
    'sub_table'          => 'pr_sub_parameter',
    'periode_id_col'     => 'pr_inheren_periode_id',
];

$DIVISI_OPTIONS = [
    132 => 'Divisi Pemasaran',
    133 => 'Divisi Operasional',
    134 => 'Divisi SDM',
    135 => 'Satker Kepatuhan',
    136 => 'Sekretaris Perusahaan',
    137 => 'Divisi Litbang',
    140 => 'Divisi Penyelesaian Kredit',
    143 => 'SKAI',
];

$koneksi_candidates = [
    __DIR__ . '/../conn/conn.php',
    __DIR__ . '/conn/conn.php',
    '../conn/conn.php',
    './conn/conn.php'
];

$koneksi_loaded = false;
foreach ($koneksi_candidates as $kfile) {
    if (file_exists($kfile)) {
        include $kfile;
        $koneksi_loaded = true;
        break;
    }
}
if (!$koneksi_loaded || !isset($conn)) die('File koneksi tidak ditemukan / $conn belum terbentuk. Cek path conn.php');

function esc($str){ return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }
function q($conn, $sql){
    $res = mysqli_query($conn, $sql);
    if (!$res) die("SQL Error: ".mysqli_error($conn)."<hr><pre>".esc($sql)."</pre>");
    return $res;
}
function fetch_one($conn,$sql){ $res=q($conn,$sql); return mysqli_fetch_assoc($res); }
function post($k,$d=''){ return isset($_POST[$k]) ? trim($_POST[$k]) : $d; }
function getv($k,$d=''){ return isset($_GET[$k]) ? trim($_GET[$k]) : $d; }
function page_url($extra=[]){
    $self=$_SERVER['PHP_SELF'];
    $params=$_GET;
    unset($params['msg']);
    foreach($extra as $k=>$v){
        if($v===null) unset($params[$k]); else $params[$k]=$v;
    }
    return $self.(count($params)?'?'.http_build_query($params):'');
}
function redirect_with_msg($msg,$extra=[]){
    $extra['msg']=$msg;
    header('Location: '.page_url($extra));
    exit;
}
function toast($msg,$type='success'){
    echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">'
        .esc($msg).
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
function alphaIndex($i){
    $letters = range('a', 'z');
    return isset($letters[$i]) ? $letters[$i] : ($i + 1);
}
function formatJenisParameter($jenis){
    return strtolower((string)$jenis) === 'cabang' ? 'Cabang' : 'Konsolidasi';
}
function getUserKantorCabang($conn){
    return fetch_one($conn,"
        SELECT *
        FROM user_profil_risiko
        WHERE LOWER(tipe_user) LIKE '%kantor cabang%'
        ORDER BY id_user_profil_risiko ASC
        LIMIT 1
    ");
}

function getGroupedMatrixData($conn, $CFG, $setting_id, $namaRisiko, $keyword = '')
{
    $setting_id=(int)$setting_id;
    $namaRisiko=mysqli_real_escape_string($conn,$namaRisiko);
    $keywordSql='';

    if($keyword!==''){
        $keyword=mysqli_real_escape_string($conn,$keyword);
        $keywordSql=" AND (
            p.nama_pilar LIKE '%$keyword%' OR
            pm.nama_parameter LIKE '%$keyword%' OR
            sp.nama_sub_parameter LIKE '%$keyword%'
        ) ";
    }

    $sql="
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan,
            sp.id AS sub_id,
            sp.nama_sub_parameter,
            sp.urutan AS sub_urutan
        FROM {$CFG['jenis_table']} jr
        JOIN {$CFG['pilar_table']} p
            ON p.jenis_risiko_id = jr.id
           AND p.{$CFG['periode_id_col']} = '$setting_id'
        LEFT JOIN {$CFG['parameter_table']} pm
            ON pm.pilar_id = p.id
           AND pm.{$CFG['periode_id_col']} = '$setting_id'
        LEFT JOIN {$CFG['sub_table']} sp
            ON sp.parameter_id = pm.id
           AND sp.{$CFG['periode_id_col']} = '$setting_id'
        WHERE jr.nama_risiko = '$namaRisiko'
          AND jr.{$CFG['periode_id_col']} = '$setting_id'
          $keywordSql
        ORDER BY p.urutan,p.id,pm.urutan,pm.id,sp.urutan,sp.id
    ";

    $res=q($conn,$sql);
    $grouped=[];

    while($row=mysqli_fetch_assoc($res)){
        $pilarId=(int)$row['pilar_id'];
        $paramId=(int)$row['parameter_id'];
        $subId=(int)$row['sub_id'];

        if(!isset($grouped[$pilarId])){
            $grouped[$pilarId]=[
                'pilar_id'=>$pilarId,
                'nama_pilar'=>$row['nama_pilar'],
                'parameters'=>[]
            ];
        }

        if($paramId>0 && !isset($grouped[$pilarId]['parameters'][$paramId])){
            $grouped[$pilarId]['parameters'][$paramId]=[
                'parameter_id'=>$paramId,
                'nomor_parameter'=>$row['nomor_parameter'],
                'nama_parameter'=>$row['nama_parameter'],
                'subs'=>[]
            ];
        }

        if($paramId>0 && $subId>0 && !isset($grouped[$pilarId]['parameters'][$paramId]['subs'][$subId])){
            $grouped[$pilarId]['parameters'][$paramId]['subs'][$subId]=[
                'sub_id'=>$subId,
                'nama_sub_parameter'=>$row['nama_sub_parameter']
            ];
        }
    }

    return $grouped;
}

$view=getv('view','setting');
$id=(int)getv('id',0);
$tab=strtoupper(getv('tab','RISIKO KREDIT'));
$qsearch=getv('q','');
$msg=getv('msg','');
$selected_user_type = post('id_user_profil_risiko', getv('selected_user_type', ''));
$selected_divisi = (int)post('id_divisi_tetapan', getv('selected_divisi', 0));
$selected_periode_id = (int)post('pr_inheren_periode_id', getv('selected_periode_id', 0));

$allowed_tabs=['RISIKO KREDIT','RISIKO OPERASIONAL','RISIKO KEPATUHAN','RISIKO LIKUIDITAS','RISIKO REPUTASI','RISIKO STRATEJIK'];
if(!in_array($tab,$allowed_tabs)) $tab='RISIKO KREDIT';

$action=post('action');

if($action=='add_setting'){
    $pr_inheren_periode_id=(int)post('pr_inheren_periode_id');
    $id_user_profil_risiko=(int)post('id_user_profil_risiko');
    $id_divisi_tetapan=(int)post('id_divisi_tetapan',0);

    if($pr_inheren_periode_id<=0){
        redirect_with_msg('gagal_input',['view'=>'setting']);
    }

    $periode=fetch_one($conn,"
        SELECT p.*
        FROM {$CFG['periode_table']} p
        INNER JOIN {$CFG['parameter_table']} pm
            ON pm.{$CFG['periode_id_col']} = p.id
        WHERE p.id='$pr_inheren_periode_id'
        GROUP BY p.id
        LIMIT 1
    ");
    if(!$periode){
        redirect_with_msg('tahun_belum_ada',['view'=>'setting']);
    }

    $jenisParameter = strtolower(trim((string)($periode['jenis_parameter'] ?? '')));

    if($jenisParameter === 'cabang'){
        $userCabang = getUserKantorCabang($conn);
        if(!$userCabang){
            redirect_with_msg('user_cabang_tidak_ada',['view'=>'setting']);
        }
        $id_user_profil_risiko = (int)$userCabang['id_user_profil_risiko'];
        $id_divisi_tetapan = 0;
    } else {
        if($id_user_profil_risiko<=0){
            redirect_with_msg('gagal_input',['view'=>'setting']);
        }

        $cekUser=fetch_one($conn,"SELECT * FROM user_profil_risiko WHERE id_user_profil_risiko='$id_user_profil_risiko' LIMIT 1");
        $tipeUser=strtolower(trim($cekUser['tipe_user'] ?? ''));

        if(strpos($tipeUser,'divisi')!==false && $id_divisi_tetapan<=0){
            redirect_with_msg('divisi_wajib',['view'=>'setting']);
        }
        if(strpos($tipeUser,'divisi')===false){
            $id_divisi_tetapan=0;
        }
    }

    $periodeId=(int)$periode['id'];

    $cek=fetch_one($conn,"
        SELECT *
        FROM {$CFG['setting_table']}
        WHERE {$CFG['periode_fk']}='$periodeId'
          AND id_user_profil_risiko='$id_user_profil_risiko'
          AND ".($id_divisi_tetapan>0 ? "id_divisi_tetapan='$id_divisi_tetapan'" : "id_divisi_tetapan IS NULL")."
        LIMIT 1
    ");
    if($cek){
        redirect_with_msg('duplikat',['view'=>'setting']);
    }

    $divisiSql = $id_divisi_tetapan>0 ? "'$id_divisi_tetapan'" : "NULL";

    q($conn,"
        INSERT INTO {$CFG['setting_table']} ({$CFG['periode_fk']}, id_user_profil_risiko, id_divisi_tetapan)
        VALUES ('$periodeId','$id_user_profil_risiko',$divisiSql)
    ");
    $newId=mysqli_insert_id($conn);

    q($conn,"
        INSERT INTO {$CFG['setting_detail']} (pr_pilih_parameter_id, ref_tipe, ref_id)
        SELECT '$newId', 'parameter', pm.id
        FROM {$CFG['parameter_table']} pm
        WHERE pm.{$CFG['periode_id_col']} = '$periodeId'
    ");

    q($conn,"
        INSERT INTO {$CFG['setting_detail']} (pr_pilih_parameter_id, ref_tipe, ref_id)
        SELECT '$newId', 'sub_parameter', sp.id
        FROM {$CFG['sub_table']} sp
        WHERE sp.{$CFG['periode_id_col']} = '$periodeId'
    ");

    redirect_with_msg('berhasil_tambah',['view'=>'pilih','id'=>$newId,'tab'=>'RISIKO KREDIT']);
}

if($action=='hapus_setting'){
    $id_hapus=(int)post('id');
    q($conn,"DELETE FROM {$CFG['setting_detail']} WHERE pr_pilih_parameter_id='$id_hapus'");
    q($conn,"DELETE FROM {$CFG['setting_table']} WHERE id='$id_hapus'");
    redirect_with_msg('berhasil_hapus',['view'=>'setting']);
}

if($action=='simpan_checklist'){
    $id_header=(int)post('id');
    $checked_parameter=isset($_POST['check_parameter']) && is_array($_POST['check_parameter']) ? $_POST['check_parameter'] : [];
    $checked_sub=isset($_POST['check_sub']) && is_array($_POST['check_sub']) ? $_POST['check_sub'] : [];

    /*
      FIX BUG:
      Sebelumnya script menghapus SEMUA isi pr_pilih_parameter_detail untuk id header ini.
      Akibatnya saat menyimpan tab Risiko Kepatuhan, checklist Risiko Kredit/Operasional/dll hilang.
      Sekarang yang dihapus hanya detail untuk risiko/tab yang sedang dibuka saja.
    */
    $headerNow = fetch_one($conn,"
        SELECT hp.*, pr.id AS periode_id
        FROM {$CFG['setting_table']} hp
        JOIN {$CFG['periode_table']} pr ON pr.id = hp.{$CFG['periode_fk']}
        WHERE hp.id='$id_header'
        LIMIT 1
    ");

    if(!$headerNow){
        redirect_with_msg('data_tidak_ditemukan',['view'=>'setting']);
    }

    $periodeIdNow = (int)$headerNow['periode_id'];
    $tabEscDelete = mysqli_real_escape_string($conn, $tab);

    q($conn,"
        DELETE d
        FROM {$CFG['setting_detail']} d
        LEFT JOIN {$CFG['parameter_table']} pm_param
            ON d.ref_tipe = 'parameter'
           AND d.ref_id = pm_param.id
           AND pm_param.{$CFG['periode_id_col']} = '$periodeIdNow'
        LEFT JOIN {$CFG['sub_table']} sp
            ON d.ref_tipe = 'sub_parameter'
           AND d.ref_id = sp.id
           AND sp.{$CFG['periode_id_col']} = '$periodeIdNow'
        LEFT JOIN {$CFG['parameter_table']} pm_sub
            ON sp.parameter_id = pm_sub.id
           AND pm_sub.{$CFG['periode_id_col']} = '$periodeIdNow'
        INNER JOIN {$CFG['pilar_table']} p
            ON p.id = COALESCE(pm_param.pilar_id, pm_sub.pilar_id)
           AND p.{$CFG['periode_id_col']} = '$periodeIdNow'
        INNER JOIN {$CFG['jenis_table']} jr
            ON jr.id = p.jenis_risiko_id
           AND jr.{$CFG['periode_id_col']} = '$periodeIdNow'
        WHERE d.pr_pilih_parameter_id = '$id_header'
          AND UPPER(TRIM(jr.nama_risiko)) = UPPER(TRIM('$tabEscDelete'))
    ");

    $insertedParam = [];
    foreach($checked_parameter as $pid){
        $pid=(int)$pid;
        if($pid <= 0 || isset($insertedParam[$pid])) continue;
        $insertedParam[$pid] = true;

        $valid = fetch_one($conn,"
            SELECT pm.id
            FROM {$CFG['parameter_table']} pm
            JOIN {$CFG['pilar_table']} p
                ON p.id = pm.pilar_id
               AND p.{$CFG['periode_id_col']} = '$periodeIdNow'
            JOIN {$CFG['jenis_table']} jr
                ON jr.id = p.jenis_risiko_id
               AND jr.{$CFG['periode_id_col']} = '$periodeIdNow'
            WHERE pm.id = '$pid'
              AND pm.{$CFG['periode_id_col']} = '$periodeIdNow'
              AND UPPER(TRIM(jr.nama_risiko)) = UPPER(TRIM('$tabEscDelete'))
            LIMIT 1
        ");

        if($valid){
            q($conn,"
                INSERT INTO {$CFG['setting_detail']} (pr_pilih_parameter_id, ref_tipe, ref_id)
                SELECT '$id_header','parameter','$pid'
                FROM DUAL
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM {$CFG['setting_detail']}
                    WHERE pr_pilih_parameter_id = '$id_header'
                      AND ref_tipe = 'parameter'
                      AND ref_id = '$pid'
                    LIMIT 1
                )
            ");
        }
    }

    $insertedSub = [];
    foreach($checked_sub as $sid){
        $sid=(int)$sid;
        if($sid <= 0 || isset($insertedSub[$sid])) continue;
        $insertedSub[$sid] = true;

        $valid = fetch_one($conn,"
            SELECT sp.id
            FROM {$CFG['sub_table']} sp
            JOIN {$CFG['parameter_table']} pm
                ON pm.id = sp.parameter_id
               AND pm.{$CFG['periode_id_col']} = '$periodeIdNow'
            JOIN {$CFG['pilar_table']} p
                ON p.id = pm.pilar_id
               AND p.{$CFG['periode_id_col']} = '$periodeIdNow'
            JOIN {$CFG['jenis_table']} jr
                ON jr.id = p.jenis_risiko_id
               AND jr.{$CFG['periode_id_col']} = '$periodeIdNow'
            WHERE sp.id = '$sid'
              AND sp.{$CFG['periode_id_col']} = '$periodeIdNow'
              AND UPPER(TRIM(jr.nama_risiko)) = UPPER(TRIM('$tabEscDelete'))
            LIMIT 1
        ");

        if($valid){
            q($conn,"
                INSERT INTO {$CFG['setting_detail']} (pr_pilih_parameter_id, ref_tipe, ref_id)
                SELECT '$id_header','sub_parameter','$sid'
                FROM DUAL
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM {$CFG['setting_detail']}
                    WHERE pr_pilih_parameter_id = '$id_header'
                      AND ref_tipe = 'sub_parameter'
                      AND ref_id = '$sid'
                    LIMIT 1
                )
            ");
        }
    }

    redirect_with_msg('berhasil_simpan_checklist',['view'=>'pilih','id'=>$id_header,'tab'=>$tab]);
}

$dataHeader=null;
$setting_id=0;
$nama_user_setting='';
$nama_divisi_setting='';
$jenis_parameter_setting='';

if($id>0){
    $dataHeader=fetch_one($conn,"
        SELECT hp.*, pr.tahun, pr.jenis_parameter, upr.tipe_user
        FROM {$CFG['setting_table']} hp
        JOIN {$CFG['periode_table']} pr ON pr.id=hp.{$CFG['periode_fk']}
        JOIN user_profil_risiko upr ON upr.id_user_profil_risiko=hp.id_user_profil_risiko
        WHERE hp.id='$id'
        LIMIT 1
    ");
    if($dataHeader){
        $setting_id=(int)$dataHeader[$CFG['periode_fk']];
        $nama_user_setting=$dataHeader['tipe_user'];
        $jenis_parameter_setting = $dataHeader['jenis_parameter'];
        $idDiv=(int)($dataHeader['id_divisi_tetapan'] ?? 0);
        if($idDiv>0 && isset($DIVISI_OPTIONS[$idDiv])){
            $nama_divisi_setting=$DIVISI_OPTIONS[$idDiv];
        }
    }
}

$selectedMap=[];
if($id>0){
    $qSel=q($conn,"SELECT ref_tipe, ref_id FROM {$CFG['setting_detail']} WHERE pr_pilih_parameter_id='$id'");
    while($rSel=mysqli_fetch_assoc($qSel)){
        $selectedMap[$rSel['ref_tipe'].'_'.$rSel['ref_id']]=true;
    }
}

$matrixData=[];
if($setting_id>0){
    $matrixData=getGroupedMatrixData($conn,$CFG,$setting_id,$tab,$qsearch);
}

$listSetting=q($conn,"
    SELECT hp.id, pr.tahun, pr.jenis_parameter, upr.tipe_user, hp.created_at, hp.id_divisi_tetapan
    FROM {$CFG['setting_table']} hp
    JOIN {$CFG['periode_table']} pr ON pr.id=hp.{$CFG['periode_fk']}
    JOIN user_profil_risiko upr ON upr.id_user_profil_risiko=hp.id_user_profil_risiko
    INNER JOIN {$CFG['parameter_table']} pm ON pm.{$CFG['periode_id_col']} = pr.id
    GROUP BY hp.id, pr.tahun, pr.jenis_parameter, upr.tipe_user, hp.created_at, hp.id_divisi_tetapan
    ORDER BY CAST(pr.tahun AS UNSIGNED) DESC,
             FIELD(pr.jenis_parameter, 'konsolidasi', 'cabang'),
             hp.id DESC
");

$userOptionsRows = [];
$userOptions=q($conn,"
    SELECT *
    FROM user_profil_risiko
    ORDER BY
        CASE WHEN LOWER(tipe_user) LIKE '%kantor cabang%' THEN 0 ELSE 1 END,
        tipe_user ASC
");
while($usr=mysqli_fetch_assoc($userOptions)){
    $userOptionsRows[] = $usr;
}

$qTahunAktif = q($conn,"
    SELECT DISTINCT p.id, p.tahun, p.jenis_parameter
    FROM {$CFG['periode_table']} p
    INNER JOIN {$CFG['parameter_table']} pm
        ON pm.{$CFG['periode_id_col']} = p.id
    ORDER BY CAST(p.tahun AS UNSIGNED) DESC,
             FIELD(p.jenis_parameter, 'konsolidasi', 'cabang')
");
?>
<style>
body{background:#f5f6fa}
.title-soft{font-size:12px;color:#8b96a5;text-transform:uppercase;letter-spacing:.08em;font-weight:700}
.badge-soft{background:#eef4ff;color:#2563eb;padding:.4rem .65rem;border-radius:999px;font-size:.75rem;font-weight:700}
.card-clean{border:0;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,.05)}
.table-clean thead th{background:#eef2f7!important;color:#334155;font-weight:700;border-color:#e5e7eb!important}
.table-clean td{vertical-align:middle}
.tab-risk{overflow-x:auto;overflow-y:hidden;flex-wrap:nowrap;white-space:nowrap;padding-bottom:2px}
.tab-risk .nav-link{font-weight:700;border-radius:8px 8px 0 0}
.tab-risk .nav-link.active{background:#0d6efd;color:#fff;border-color:#0d6efd}
.matrix-wrap{overflow-x:auto}
.matrix-risk-table{min-width:1200px;margin-bottom:0}
.matrix-risk-table thead th{background:#1f252b!important;color:#fff!important;font-weight:700;border-color:#2b3138!important;padding:1rem .85rem}
.matrix-risk-table td{vertical-align:top;background:#f7f7f7;border-color:#e3e6ea!important;color:#616b75;padding:1rem .9rem}
.matrix-pilar-row td{background:#59d1d7!important;color:#5b6570!important;font-weight:800;font-size:1.03rem;padding:1rem 1.1rem!important;border-color:#59d1d7!important}
.matrix-sub-only{font-weight:700;color:#6b7280;padding-left:18px;position:relative}
.matrix-sub-only:before{content:'';position:absolute;left:6px;top:11px;width:6px;height:6px;border-radius:50%;background:#8b95a1}
.info-pill{display:inline-block;padding:.4rem .8rem;border-radius:999px;background:#f1f5f9;color:#0f172a;font-weight:600;margin-right:.35rem}
.check-big{width:18px;height:18px}
.lock-note{font-size:12px;color:#64748b;margin-top:6px}
</style>

<div class="content-page"><div class="content"><div class="container-fluid">

<?php if($view=='setting'){ ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 mt-3">
    <div>
        <div class="title-soft">Setting Awal</div>
        <h3 class="mb-0">Pilih Parameter Profil Risiko Inheren</h3>
    </div>
</div>

<?php
if($msg=='berhasil_tambah') toast('Data berhasil ditambahkan dan default checklist sudah terpilih semua');
if($msg=='berhasil_hapus') toast('Data berhasil dihapus','warning');
if($msg=='duplikat') toast('Tahun, user, dan divisi tersebut sudah ada','warning');
if($msg=='gagal_input') toast('Tahun dan user wajib dipilih','danger');
if($msg=='tahun_belum_ada') toast('Tahun tersebut belum ada di setting Profil Risiko Inheren','danger');
if($msg=='divisi_wajib') toast('Jika pilih user divisi, dropdown divisi wajib dipilih','danger');
if($msg=='user_cabang_tidak_ada') toast('User Profil Risiko Kantor Cabang tidak ditemukan','danger');
?>

<div class="card card-clean mb-3"><div class="card-body">
<form method="post" class="row g-3" id="form_setting_inheren">
    <input type="hidden" name="action" value="add_setting">

    <div class="col-md-4">
        <label class="form-label">Masukan tahun</label>
        <select name="pr_inheren_periode_id" id="pr_inheren_periode_id" class="form-select" required>
            <option value="">- pilih tahun -</option>
            <?php while($th=mysqli_fetch_assoc($qTahunAktif)){ ?>
                <option
                    value="<?= (int)$th['id'] ?>"
                    data-jenis="<?= esc(strtolower($th['jenis_parameter'])) ?>"
                    <?= ($selected_periode_id === (int)$th['id']) ? 'selected' : '' ?>>
                    <?= esc($th['tahun'].' - '.formatJenisParameter($th['jenis_parameter'])) ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Settingan ditetapkan untuk user :</label>

        <select id="id_user_profil_risiko_ui" class="form-select" required>
            <option value="">- pilih user -</option>
            <?php foreach($userOptionsRows as $usr){ ?>
                <option
                    value="<?= (int)$usr['id_user_profil_risiko'] ?>"
                    data-text="<?= esc(strtolower($usr['tipe_user'])) ?>"
                    <?= ((string)$selected_user_type === (string)$usr['id_user_profil_risiko']) ? 'selected' : '' ?>>
                    <?= esc(ucwords($usr['tipe_user'])) ?>
                </option>
            <?php } ?>
        </select>

        <input type="hidden" name="id_user_profil_risiko" id="id_user_profil_risiko" value="<?= esc($selected_user_type) ?>">
        <div class="lock-note" id="user_lock_note" style="display:none;">User otomatis dipilih dan dikunci untuk tahun kategori Cabang.</div>
    </div>

    <div class="col-md-4" id="divisi_wrapper" style="display:none;">
        <label class="form-label">Pilih divisi</label>
        <select name="id_divisi_tetapan" id="id_divisi_tetapan" class="form-select">
            <option value="">- pilih divisi -</option>
            <?php foreach($DIVISI_OPTIONS as $divId=>$divNama){ ?>
                <option value="<?= $divId ?>" <?= ($selected_divisi === (int)$divId) ? 'selected' : '' ?>>
                    <?= esc($divNama) ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Submit</button>
    </div>
</form>
</div></div>

<div class="card card-clean"><div class="card-body"><div class="table-responsive">
<table class="table table-bordered table-hover table-clean align-middle">
<thead>
<tr>
    <th style="width:70px;">No</th>
    <th style="width:180px;">Tahun</th>
    <th>Settingan Bobot</th>
    <th style="width:220px;">Divisi</th>
    <th style="width:180px;">Tanggal Ditetapkan</th>
    <th style="width:220px;">Pembuat</th>
    <th style="width:180px;">Isi Setting</th>
    <th style="width:120px;">Hapus</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
if(mysqli_num_rows($listSetting)==0){
    echo '<tr><td colspan="8" class="text-center text-muted">Belum ada data</td></tr>';
}else{
    while($row=mysqli_fetch_assoc($listSetting)){
        $namaDivisiTabel='-';
        $idDiv=(int)($row['id_divisi_tetapan'] ?? 0);
        if($idDiv>0 && isset($DIVISI_OPTIONS[$idDiv])) $namaDivisiTabel=$DIVISI_OPTIONS[$idDiv];

        echo '<tr>';
        echo '<td class="text-center">'.$no++.'</td>';
        echo '<td>'.esc($row['tahun'].' - '.formatJenisParameter($row['jenis_parameter'])).'</td>';
        echo '<td>'.esc($row['tipe_user']).'</td>';
        echo '<td>'.esc($namaDivisiTabel).'</td>';
        echo '<td>'.esc(date('Y-m-d',strtotime($row['created_at']))).'</td>';
        echo '<td>SATUAN KERJA MANAJEMEN RISIKO</td>';
        echo '<td><a href="'.esc(page_url(['view'=>'pilih','id'=>$row['id'],'tab'=>'RISIKO KREDIT'])).'" class="btn btn-sm btn-primary">Lanjutkan</a></td>';
        echo '<td>
                <form method="post" onsubmit="return confirm(\'Hapus setting ini?\')">
                    <input type="hidden" name="action" value="hapus_setting">
                    <input type="hidden" name="id" value="'.(int)$row['id'].'">
                    <button class="btn btn-sm btn-danger">hapus</button>
                </form>
              </td>';
        echo '</tr>';
    }
}
?>
</tbody>
</table>
</div></div></div>

<?php } else { ?>

<?php if(!$dataHeader){ ?>
<div class="alert alert-warning mt-3">
    Data setting tidak ditemukan.
    <a href="<?= esc(page_url(['view'=>'setting','id'=>null])) ?>" class="btn btn-sm btn-primary ms-2">Kembali</a>
</div>
<?php } else { ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 mt-3">
    <div>
        <div class="title-soft">Checklist Parameter</div>
        <h3 class="mb-1">Pilih Parameter Profil Risiko Inheren</h3>
        <div>
            <span class="info-pill">Tahun: <?= esc($dataHeader['tahun']) ?></span>
            <span class="info-pill">Jenis: <?= esc(formatJenisParameter($jenis_parameter_setting)) ?></span>
            <span class="info-pill">User: <?= esc($nama_user_setting) ?></span>
            <?php if($nama_divisi_setting!==''){ ?>
                <span class="info-pill">Divisi: <?= esc($nama_divisi_setting) ?></span>
            <?php } ?>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= esc(page_url(['view'=>'setting','id'=>null,'tab'=>null])) ?>" class="btn btn-outline-secondary">Kembali</a>
        <div><span class="badge-soft">Checklist Parameter / Sub Parameter</span></div>
    </div>
</div>

<?php if($msg=='berhasil_simpan_checklist') toast('Checklist parameter berhasil disimpan'); ?>

<ul class="nav nav-tabs tab-risk mb-3">
<?php foreach($allowed_tabs as $rt){ ?>
    <li class="nav-item">
        <a class="nav-link <?= $tab==$rt?'active':'' ?>" href="<?= esc(page_url(['view'=>'pilih','id'=>$id,'tab'=>$rt])) ?>">
            <?= esc(str_replace('RISIKO ','',$rt)) ?>
        </a>
    </li>
<?php } ?>
</ul>

<form method="post">
<input type="hidden" name="action" value="simpan_checklist">
<input type="hidden" name="id" value="<?= (int)$id ?>">

<div class="card"><div class="card-body">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h5 class="mb-0">Daftar Parameter - <?= esc($tab) ?></h5>
    <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-sm btn-success" id="btn_check_all">
            Checklist Semua
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger" id="btn_uncheck_all">
            Hapus Checklist Semua
        </button>
    </div>
</div>

<div class="matrix-wrap">
<table class="table table-bordered matrix-risk-table">
<thead>
<tr>
    <th style="width:60px;">No</th>
    <th>Parameter / Sub Parameter</th>
    <th style="width:120px;">Pilih</th>
</tr>
</thead>
<tbody>
<?php
if(empty($matrixData)){
    echo '<tr><td colspan="3" class="text-center text-muted">Belum ada data pada tahun ini</td></tr>';
}else{
    foreach($matrixData as $pilar){
        echo '<tr class="matrix-pilar-row"><td colspan="3">'.esc($pilar['nama_pilar']).'</td></tr>';

        foreach($pilar['parameters'] as $param){
            $checkedParam=isset($selectedMap['parameter_'.$param['parameter_id']])?'checked':'';
            echo '<tr>';
            echo '<td class="text-center">'.esc($param['nomor_parameter']).'</td>';
            echo '<td><strong>'.esc($param['nama_parameter']).'</strong></td>';
            echo '<td class="text-center"><input class="form-check-input check-big selectable-check" type="checkbox" name="check_parameter[]" value="'.(int)$param['parameter_id'].'" '.$checkedParam.'></td>';
            echo '</tr>';

            if(!empty($param['subs'])){
                $idx=0;
                foreach($param['subs'] as $sub){
                    $checkedSub=isset($selectedMap['sub_parameter_'.$sub['sub_id']])?'checked':'';
                    echo '<tr>';
                    echo '<td></td>';
                    echo '<td><div class="matrix-sub-only">'.esc(alphaIndex($idx)).'. '.esc($sub['nama_sub_parameter']).'</div></td>';
                    echo '<td class="text-center"><input class="form-check-input check-big selectable-check" type="checkbox" name="check_sub[]" value="'.(int)$sub['sub_id'].'" '.$checkedSub.'></td>';
                    echo '</tr>';
                    $idx++;
                }
            }
        }
    }
}
?>
</tbody>
</table>
</div>

<div class="mt-3">
    <button class="btn btn-primary">Simpan Checklist</button>
</div>
</div></div>
</form>

<?php } ?>
<?php } ?>

</div></div></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var periodeSelect = document.getElementById('pr_inheren_periode_id');
    var userSelectUi = document.getElementById('id_user_profil_risiko_ui');
    var userHidden = document.getElementById('id_user_profil_risiko');
    var divisiWrapper = document.getElementById('divisi_wrapper');
    var divisiSelect = document.getElementById('id_divisi_tetapan');
    var lockNote = document.getElementById('user_lock_note');

    function getSelectedJenisParameter() {
        if (!periodeSelect) return '';
        var opt = periodeSelect.options[periodeSelect.selectedIndex];
        if (!opt) return '';
        return (opt.getAttribute('data-jenis') || '').toLowerCase();
    }

    function findKantorCabangOption() {
        if (!userSelectUi) return null;
        for (var i = 0; i < userSelectUi.options.length; i++) {
            var opt = userSelectUi.options[i];
            var txt = (opt.text || '').toLowerCase();
            if (txt.indexOf('kantor cabang') !== -1) {
                return opt;
            }
        }
        return null;
    }

    function ensureKantorCabangOption() {
        var found = findKantorCabangOption();
        if (found) return found;
        return null;
    }

    function syncHiddenUser() {
        if (userHidden && userSelectUi) {
            userHidden.value = userSelectUi.value || '';
        }
    }

    function toggleDivisiNormal() {
        if (!userSelectUi || !divisiWrapper) return;
        var text = userSelectUi.options[userSelectUi.selectedIndex] ? userSelectUi.options[userSelectUi.selectedIndex].text.toLowerCase() : '';
        if (text.indexOf('divisi') !== -1) {
            divisiWrapper.style.display = '';
        } else {
            divisiWrapper.style.display = 'none';
            if (divisiSelect) divisiSelect.value = '';
        }
    }

    function applyCabangAutoLock() {
        if (!periodeSelect || !userSelectUi) return;

        var jenis = getSelectedJenisParameter();

        if (jenis === 'cabang') {
            var cabangOpt = ensureKantorCabangOption();
            if (cabangOpt) {
                userSelectUi.value = cabangOpt.value;
                if (userHidden) userHidden.value = cabangOpt.value;
            } else {
                userSelectUi.value = '';
                if (userHidden) userHidden.value = '';
            }

            userSelectUi.setAttribute('disabled', 'disabled');
            if (lockNote) lockNote.style.display = 'block';

            if (divisiWrapper) divisiWrapper.style.display = 'none';
            if (divisiSelect) divisiSelect.value = '';
        } else {
            userSelectUi.removeAttribute('disabled');
            if (lockNote) lockNote.style.display = 'none';
            syncHiddenUser();
            toggleDivisiNormal();
        }
    }

    if (periodeSelect) {
        periodeSelect.addEventListener('change', function () {
            applyCabangAutoLock();
        });
    }

    if (userSelectUi) {
        userSelectUi.addEventListener('change', function () {
            syncHiddenUser();
            toggleDivisiNormal();
        });
    }

    var btnCheckAll = document.getElementById('btn_check_all');
    var btnUncheckAll = document.getElementById('btn_uncheck_all');

    function setAllChecklist(status) {
        var checks = document.querySelectorAll('.selectable-check');
        checks.forEach(function (cb) {
            cb.checked = status;
        });
    }

    if (btnCheckAll) {
        btnCheckAll.addEventListener('click', function () {
            setAllChecklist(true);
        });
    }

    if (btnUncheckAll) {
        btnUncheckAll.addEventListener('click', function () {
            setAllChecklist(false);
        });
    }

    applyCabangAutoLock();
    syncHiddenUser();
});
</script>
