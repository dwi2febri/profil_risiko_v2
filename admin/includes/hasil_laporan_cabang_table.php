                        <script>
        $(document).ready(function() {
            var tableOptions = {
                dom: 'Bfrti',
                buttons: ['copy', 'csv', 'excel', 'print'].map(function(type) {
                    return {extend:type, exportOptions:{columns:':visible'}, text:{copy:'Salin', csv:'CSV', excel:'Excel', print:'Cetak'}[type]};
                }),
                language: {search:'Cari cabang:', info:'Menampilkan _START_ sampai _END_ dari _TOTAL_ cabang', infoEmpty:'Tidak ada laporan', zeroRecords:'Tidak ada cabang yang cocok', emptyTable:'Tidak ada laporan pada filter ini', paginate:{previous:'Sebelumnya', next:'Berikutnya'}},
                scrollX: true,
                scrollY: '',
                scrollCollapse: true,
                paging: false,
                autoWidth: true,
                responsive: false,
                columnDefs: [
                    { targets: 0, width: '58px', className: 'kc-col-no text-center' },
                    { targets: 1, width: '80px', className: 'kc-col-kode' },
                    { targets: 2, width: '190px', className: 'kc-col-cabang' },
                    { targets: '_all', className: 'kc-table-cell' }
                ]
            };

            var table = $('#datatable-buttons1').DataTable(tableOptions);
            var groups = <?= json_encode($hasilColumnGroups, JSON_THROW_ON_ERROR) ?>;
            var baseColumns = <?= json_encode($hasilBaseColumns, JSON_THROW_ON_ERROR) ?>;
            $('#hasil-risk-view').on('change', function() {
                var selected = this.value;
                var visible = selected === 'semua' ? Array.from({length:<?= $hasilTotalColumns ?>}, function(_,i){return i;}) : baseColumns.concat(groups[selected] || groups.ringkasan);
                table.columns().every(function(index) {this.visible(visible.indexOf(index)!==-1, false);});
                table.columns.adjust().draw(false);
                $('.hasil-lapkc-table .dataTables_scrollBody').scrollLeft(0);
                setStickyOffsets();
            });


            document.querySelectorAll('.hasil-region-tabs button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var indices = [];
                    if (button.dataset.region !== 'semua') for (var id=Number(button.dataset.start);id<=Number(button.dataset.end);id++) indices.push(id);
                    table.column(0).search(indices.length ? '^(' + indices.join('|') + ')$' : '', true, false).draw();
                    document.querySelectorAll('.hasil-region-tabs button').forEach(function(other) {other.setAttribute('aria-pressed', String(other===button));});
                    document.getElementById('hasil-region-caption').textContent = button.dataset.region === 'semua' ? 'Semua area. Seluruh laporan pada periode terpilih.' : button.textContent.trim() + ' cabang memiliki laporan. Nilai kosong tidak dihitung sebagai nol.';
                });
            });

            var scrollBody = document.querySelector('.hasil-lapkc-table .dataTables_scrollBody');
            var scrollTop = document.createElement('div');
            scrollTop.className = 'hasil-scroll-top';
            scrollTop.setAttribute('aria-label', 'Geser kolom tabel');
            scrollTop.innerHTML = '<div></div>';
            scrollBody.parentNode.insertBefore(scrollTop, scrollBody.parentNode.firstChild);
            var scrollHead = document.querySelector('.hasil-lapkc-table .dataTables_scrollHead');
            var lastScrollPosition = scrollBody.scrollLeft;
            // Ignore the event echoed by a programmatic update, including fractional zoom rounding.
            // Synchronize immediately: no animation, debounce or second-frame header update.
            function syncHorizontalScroll(source, target) {
                var position = source.scrollLeft;
                if (Math.abs(position - lastScrollPosition) < 1) return;
                lastScrollPosition = position;
                target.scrollLeft = position;
                if (scrollHead) scrollHead.scrollLeft = position;
            }
            scrollTop.addEventListener('scroll', function(){syncHorizontalScroll(scrollTop, scrollBody);}, {passive:true});
            scrollBody.addEventListener('scroll', function(){syncHorizontalScroll(scrollBody, scrollTop);}, {passive:true});
            function setStickyOffsets() {
                // offsetWidth uses CSS pixels, consistent with sticky left even when body is zoomed.
                var firstWidth = document.querySelector('#datatable-buttons1 tbody tr td.kc-col-no');
                var secondWidth = document.querySelector('#datatable-buttons1 tbody tr td.kc-col-kode');
                var first = firstWidth ? firstWidth.offsetWidth : 58;
                var second = secondWidth ? secondWidth.offsetWidth : 80;
                $('.hasil-lapkc-table').css({'--kc-left-2': first + 'px', '--kc-left-3': (first + second) + 'px'});
                scrollTop.hidden = scrollBody.scrollWidth <= scrollBody.clientWidth;
                scrollTop.firstChild.style.width = (scrollBody.scrollWidth - scrollBody.clientWidth + scrollTop.clientWidth) + 'px';
                lastScrollPosition = scrollBody.scrollLeft;
                scrollTop.scrollLeft = lastScrollPosition;
            }

            setStickyOffsets();
            table.on('draw.dt column-sizing.dt responsive-resize.dt', setStickyOffsets);
            $(window).on('resize', function(){table.columns.adjust();setStickyOffsets();});
        });
    </script>
    <style>
        .hasil-lapkc-table {
            --kc-left-2: 58px;
            --kc-left-3: 138px;
            width: 100%;
            min-width:0;
        }

        .hasil-lapkc-table .dt-buttons {
            display: inline-flex;
            width: auto !important;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }

        .hasil-lapkc-table .dt-buttons .btn,
        .hasil-lapkc-table .dt-buttons button {
            border: 1px solid #d7e0eb !important;
            border-radius: 6px;
            background: #fff !important;
            color: #334155 !important;
            box-shadow: none !important;
            width: auto !important;
            flex: 0 0 auto !important;
            font-weight: 600;
            padding: 9px 16px;
        }

        .hasil-lapkc-table .dataTables_filter {
            margin-bottom: 14px;
        }

        .hasil-lapkc-table .dataTables_filter input {
            border: 1px solid #d7dde5;
            border-radius: 6px;
            padding: 8px 12px;
            min-width: 220px;
        }

        .hasil-lapkc-table .dataTables_scroll {
            border: 1px solid #e4e9f0;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        .hasil-lapkc-table .dataTables_scrollBody {
            border-bottom: 1px solid #e4e9f0 !important;
            width:100% !important;
        }

        .hasil-lapkc-table table.dataTable {
            min-width: 100%;
            border-collapse: separate !important;
            border-spacing: 0;
            margin: 0 !important;
        }

        .hasil-lapkc-table table.dataTable thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: #f4f7fb;
            border-bottom: 1px solid #dce3eb;
            color: #1f2933;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.2;
            padding: 13px 14px;
            white-space: nowrap;
            vertical-align: middle;
        }

        .hasil-lapkc-table table.dataTable tbody td {
            border-bottom: 1px solid #edf1f5;
            color: #27313a;
            font-size: 13px;
            padding: 12px 14px;
            white-space: nowrap;
            vertical-align: middle;
            background: #fff;
        }

        .hasil-lapkc-table table.dataTable tbody tr:nth-child(odd) td {
            background: #f5f7fb;
        }

        .hasil-lapkc-table table.dataTable tbody tr:hover td {
            background: #eaf2ff;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(1),
        .hasil-lapkc-table table.dataTable td:nth-child(1),
        .hasil-lapkc-table table.dataTable th:nth-child(2),
        .hasil-lapkc-table table.dataTable td:nth-child(2),
        .hasil-lapkc-table table.dataTable th:nth-child(3),
        .hasil-lapkc-table table.dataTable td:nth-child(3) {
            position: sticky;
            z-index: 6;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(1),
        .hasil-lapkc-table table.dataTable td:nth-child(1) {
            left: 0;
            min-width: 58px;
            text-align: center;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(2),
        .hasil-lapkc-table table.dataTable td:nth-child(2) {
            left: var(--kc-left-2);
            min-width: 80px;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(3),
        .hasil-lapkc-table table.dataTable td:nth-child(3) {
            left: var(--kc-left-3);
            min-width: 190px;
            box-shadow: 8px 0 12px -12px rgba(15, 23, 42, .75);
        }

        .hasil-lapkc-table table.dataTable thead th:nth-child(-n+3) {
            z-index: 8;
            background: #e9f0f8;
        }

        .hasil-lapkc-table table.dataTable tbody tr:nth-child(odd) td:nth-child(-n+3) {
            background: #eef2f8;
        }

        .hasil-lapkc-table table.dataTable tbody tr:nth-child(even) td:nth-child(-n+3) {
            background: #fff;
        }

        .hasil-lapkc-table table.dataTable tbody tr:hover td:nth-child(-n+3) {
            background: #e2edff;
        }

        .hasil-lapkc-table .dataTables_info,
        .hasil-lapkc-table .dataTables_paginate {
            padding-top: 14px;
        }
        .hasil-lapkc-table .dataTables_wrapper,.hasil-lapkc-table .dataTables_scroll{width:100%;min-width:0;max-width:100%}
        .hasil-lapkc-table .hasil-scroll-top,.hasil-lapkc-table .dataTables_scrollBody,.hasil-lapkc-table .dataTables_scrollHead{scroll-behavior:auto!important;overflow-anchor:none}
        .hasil-scroll-top{overflow-x:auto;overflow-y:hidden;height:18px;background:#f8fafc}
        .hasil-scroll-top>div{height:1px}
        .hasil-scroll-top[hidden]{display:none}
        @media(max-width:767px){.hasil-lapkc-table table.dataTable th:nth-child(-n+3),.hasil-lapkc-table table.dataTable td:nth-child(-n+3){position:static;box-shadow:none}}
        .hasil-pillar-blue{--pillar-bg:#e7f1ff;--pillar-ink:#1746a2}
        .hasil-pillar-green{--pillar-bg:#e9f8ed;--pillar-ink:#176534}
        .hasil-pillar-yellow{--pillar-bg:#fff7cc;--pillar-ink:#735400}
        .hasil-pillar-orange{--pillar-bg:#fff0dc;--pillar-ink:#943c09}
        .hasil-pillar-red{--pillar-bg:#fde7e7;--pillar-ink:#a61e25}
        .hasil-lapkc-table table.dataTable tbody td.hasil-pillar-cell{background:var(--pillar-bg)!important;color:var(--pillar-ink)!important;font-weight:600;box-shadow:none!important;--bs-table-accent-bg:transparent!important}
        .hasil-risk-legend{display:flex;gap:8px;flex-wrap:wrap;margin:0 0 16px;font-size:12px}
        .hasil-risk-legend span{padding:5px 9px;border-radius:5px;background:var(--pillar-bg);color:var(--pillar-ink)}
        .hasil-region-tabs{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px}
        .hasil-region-tabs button{border:1px solid #d8e3ef;border-radius:7px;background:#fff;color:#334155;padding:9px 14px;font:inherit}
        .hasil-region-tabs button[aria-pressed="true"]{background:#eaf3ff;color:#164e85;border-color:#9dbbe0;font-weight:600}
        .hasil-region-tabs button span{margin-left:7px;font-size:11px;color:#64748b}
        .hasil-view-controls{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
        .hasil-view-controls label{font-weight:600;margin:0}.hasil-view-controls select{width:auto;min-width:240px;max-width:100%}
        .hasil-source-note{font-size:12px;color:#64748b;line-height:1.7;margin-bottom:18px}
        .hasil-pillar-incomplete{color:#64748b!important;font-size:11px;text-decoration:underline;text-underline-offset:3px}
        .hasil-pillar-cell .hasil-risk-score{color:var(--pillar-ink)!important;text-decoration-color:currentColor}
        .hasil-risk-score{color:#164e85;font-weight:600;text-decoration:underline;text-decoration-color:#b9cde2;text-underline-offset:4px}
        .hasil-missing{color:#94a3b8}.hasil-lapkc-table .dataTables_filter{float:right}
        @media(max-width:767px){.hasil-lapkc-table .dataTables_filter{float:none;text-align:left}.hasil-lapkc-table .dataTables_filter input{min-width:0;max-width:180px}}
    </style>
                        <!-- end row-->

                        <div class="row">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3"><?= hasil_kc_escape($hasilTableTitle ?? 'Profil Risiko Kantor Cabang') ?></h4>

                                                            <p class="text-muted">
                                                            <?= $status_laporan === 'diterima'
                                                                ? 'Menampilkan laporan yang telah diterima Korwil dan SKMR.'
                                                                : 'Menampilkan seluruh laporan pada periode yang dipilih. Status penerimaan tercantum di setiap baris.' ?>
                                                        </p>
                                                        <?php if (!$hasilKCFrames): ?>
                                                            <div class="alert alert-info" role="status">
                                                                <?= $tahun <= 0 || $periode <= 0
                                                                    ? 'Pilih tahun dan periode, lalu klik Cari.'
                                                                    : ($status_laporan === 'diterima'
                                                                        ? 'Belum ada laporan yang sudah diterima Korwil dan SKMR untuk periode ini. Pilih Semua laporan untuk meninjau laporan yang tersedia.'
                                                                        : 'Belum ada laporan kantor cabang untuk tahun dan periode yang dipilih.') ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (isset($hasilRegions)): ?>
                                                        <div class="hasil-region-tabs" role="group" aria-label="Pilih area">
                                                            <button type="button" data-region="semua" aria-pressed="true">Semua area</button>
                                                            <?php foreach ($hasilRegions as $regionKey => $region): ?>
                                                            <button type="button" data-region="<?= $regionKey ?>" data-start="<?= $region['start'] ?>" data-end="<?= $region['end'] ?>" aria-pressed="false"><?= hasil_kc_escape($region['name']) ?> <span><?= $region['reports'] ?>/7</span></button>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <p id="hasil-region-caption" class="hasil-source-note" aria-live="polite">Semua area. Angka pada tombol menunjukkan jumlah cabang yang memiliki laporan pada filter terpilih.</p>
                                                        <?php endif; ?>
                                                        <div class="hasil-view-controls mb-3">
                                                            <label for="hasil-risk-view">Tampilan tabel</label>
                                                            <select id="hasil-risk-view" class="form-select">
                                                                <option value="semua" selected>Semua risiko dan pilar</option>
                                                                <option value="ringkasan">Ringkasan enam risiko</option>
                                                                <option value="kredit">Rincian kredit</option><option value="operasional">Rincian operasional</option>
                                                                <option value="kepatuhan">Rincian kepatuhan</option><option value="likuiditas">Rincian likuiditas</option>
                                                                <option value="reputasi">Rincian reputasi</option><option value="stratejik">Rincian stratejik</option>
                                                            </select>
                                                        </div>
                                                        <p class="hasil-source-note">Nilai yang ditampilkan adalah nilai inheren. Klik angka untuk melihat sumbernya. Tanda &ndash; berarti nilai belum tersimpan. Kolom pilar mengikuti Pilih Parameter Inheren tahun terpilih. Pilar operasional, kepatuhan, reputasi, dan stratejik dihitung dari isian terpilih dengan metode perumusan yang berlaku.</p>
                                                        <div class="hasil-risk-legend" aria-label="Klasifikasi warna nilai pilar">
                                                            <span class="hasil-pillar-blue">Sangat rendah: 1&ndash;1,25</span>
                                                            <span class="hasil-pillar-green">Rendah: &gt;1,25&ndash;2,25</span>
                                                            <span class="hasil-pillar-yellow">Sedang: &gt;2,25&ndash;3,25</span>
                                                            <span class="hasil-pillar-orange">Tinggi: &gt;3,25&ndash;4,25</span>
                                                            <span class="hasil-pillar-red">Sangat tinggi: &gt;4,25&ndash;5</span>
                                                        </div>
                                                        <div class="tab-pane show active hasil-lapkc-table" id="buttons-table-preview">
                                                                <table id="datatable-buttons1" class="table table-striped nowrap w-100">
                                                                <thead><tr>
                                                                    <th>No.</th><th>Kode</th><th>Kantor Cabang</th><th>Status Laporan</th>
                                                                    <?php foreach ($hasilKCColumns as $column): ?>
                                                                    <th data-risk="<?= $column['risk'] ?>" data-kind="<?= $column['kind'] ?>" <?= isset($column['id']) ? 'data-pillar-id="'.(int)$column['id'].'"' : '' ?> title="<?= hasil_kc_escape($column['name']) ?>"><?= hasil_kc_escape($column['title']) ?></th>
                                                                    <?php endforeach; ?>
                                                                    <th>Nilai Risiko</th><th>Peringkat Komposit</th>
                                                                </tr></thead>
                                                                <tbody>
                                                                <?php $hasilSortedFrames = $hasilKCFrames; ksort($hasilSortedFrames); foreach ($hasilSortedFrames as $branch => $frame):
                                                                    if ($branch < 1 || $branch > 28) continue;
                                                                    $reportId = (int)$frame['id_profil_risiko']; ?>
                                                                    <tr data-report="<?= $reportId ?>">
                                                                        <td><?= (int)$branch ?></td><td><?= sprintf('%03d', $branch) ?></td>
                                                                        <td><?= hasil_kc_escape($hasilBranchNames[$branch] ?? 'Cabang '.$branch) ?></td>
                                                                        <td><?= hasil_kc_status_badge($frame) ?></td>
                                                                        <?php foreach ($hasilKCColumns as $column):
                                                                            $row = $hasilKCResults[$branch][$column['risk']] ?? [];
                                                                            if ($column['kind'] === 'dynamic_pillar') {
                                                                                $pillarValue = $hasilKCDynamic['values'][$reportId][$column['risk']][$column['id']] ?? [];
                                                                                $value = $pillarValue['value'] ?? null;
                                                                                $caption = $column['name'] . ' - ' . ($pillarValue['method'] ?? '') . (!empty($pillarValue['missing']) ? ' - '.(int)$pillarValue['missing'].' penilaian belum lengkap' : '');
                                                                            } elseif ($column['kind'] === 'legacy_pillar') {
                                                                                $value = $row[$column['field']] ?? null; $caption = $column['name'];
                                                                            } else {
                                                                                $value = $row['hasil_tingkat_risiko'] ?? null; $caption = $row['_source'] ?? '';
                                                                            }
                                                                            ?>
                                                                            <td <?= hasil_kc_pillar_attributes($value) ?> data-kind="<?= $column['kind'] ?>" data-risk="<?= $column['risk'] ?>">
                                                                                <?php if ($column['kind'] === 'score' && $value !== null): ?>
                                                                                    <a class="hasil-risk-score" title="<?= hasil_kc_escape($caption) ?> - buka penilaian sumber" href="index.php?page=<?= $hasilRoutes[$column['risk']] ?>&amp;id=<?= $reportId ?>"><?= hasil_kc_escape($value) ?></a>
                                                                                <?php elseif ($column['kind'] === 'rank'):
                                                                                    $band = hasil_kc_pillar_band($value); ?>
                                                                                    <?= hasil_kc_escape($row['hasil_peringkat'] ?? ($band ? ucfirst($band[1]) : '-')) ?>
                                                                                <?php elseif ($column['kind'] === 'dynamic_pillar' && $value === null && !empty($pillarValue['missing'])): ?>
                                                                                    <a class="hasil-pillar-incomplete" title="<?= hasil_kc_escape($caption) ?>; isian masih kosong atau bernilai 0" href="index.php?page=<?= $hasilRoutes[$column['risk']] ?>&amp;id=<?= $reportId ?>">Belum lengkap</a>
                                                                                <?php else: ?>
                                                                                    <span title="<?= hasil_kc_escape($caption) ?>"><?= $value === null ? '&ndash;' : ($column['kind'] === 'dynamic_pillar' ? number_format($value, 2, '.', '') : hasil_kc_escape($value)) ?></span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        <?php endforeach; ?>
                                                                        <td <?= hasil_kc_composite_attributes($hasilKCResults[$branch]['total']['total_nilai'] ?? null) ?>><?= hasil_kc_escape($hasilKCResults[$branch]['total']['total_nilai'] ?? '-') ?></td>
                                                                        <td <?= hasil_kc_composite_attributes($hasilKCResults[$branch]['total']['total_nilai'] ?? null) ?>><?= hasil_kc_escape($hasilKCResults[$branch]['total']['ket_total_nilai'] ?? '-') ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                                </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                        </div>
                        <!-- end row-->