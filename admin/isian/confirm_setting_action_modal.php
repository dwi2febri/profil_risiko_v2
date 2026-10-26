<style>
    .setting-action-confirm .modal-dialog {
        max-width: 470px;
    }

    .setting-action-confirm .modal-content {
        border: 0;
        border-radius: 20px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, 0.24);
        overflow: hidden;
    }

    .setting-action-confirm .modal-body {
        padding: 32px 32px 18px;
        text-align: center;
    }

    .setting-action-confirm .btn-close {
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 2;
    }

    .setting-confirm-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        transition: background-color .2s ease, color .2s ease;
    }

    .setting-confirm-icon.is-danger {
        color: #e11d48;
        background: #fff1f2;
    }

    .setting-confirm-icon.is-warning {
        color: #d97706;
        background: #fffbeb;
    }

    .setting-confirm-icon.is-success {
        color: #059669;
        background: #ecfdf5;
    }

    .setting-confirm-title {
        color: #0f172a;
        font-size: 21px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    .setting-confirm-message {
        max-width: 390px;
        margin: 0 auto;
        color: #64748b;
        font-size: 14px;
        line-height: 1.65;
    }

    .setting-confirm-context {
        display: none;
        width: fit-content;
        max-width: 100%;
        margin: 17px auto 0;
        padding: 8px 13px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .setting-action-confirm .modal-footer {
        justify-content: center;
        gap: 10px;
        padding: 0 32px 30px;
        border-top: 0;
    }

    .setting-action-confirm .modal-footer .btn {
        min-width: 118px;
        padding: .68rem 1rem;
        border-radius: 10px;
        font-weight: 700;
    }

    .setting-confirm-submit.is-danger {
        color: #fff;
        border-color: #ef4444;
        background: #ef4444;
        box-shadow: 0 10px 22px rgba(239, 68, 68, .23);
    }

    .setting-confirm-submit.is-danger:hover {
        color: #fff;
        border-color: #dc2626;
        background: #dc2626;
    }

    .setting-confirm-submit.is-warning {
        color: #fff;
        border-color: #f59e0b;
        background: #f59e0b;
        box-shadow: 0 10px 22px rgba(245, 158, 11, .23);
    }

    .setting-confirm-submit.is-warning:hover {
        color: #fff;
        border-color: #d97706;
        background: #d97706;
    }

    .setting-confirm-submit.is-success {
        color: #fff;
        border-color: #10b981;
        background: #10b981;
        box-shadow: 0 10px 22px rgba(16, 185, 129, .23);
    }

    .setting-confirm-submit.is-success:hover {
        color: #fff;
        border-color: #059669;
        background: #059669;
    }

    @media (max-width: 575.98px) {
        .setting-action-confirm .modal-dialog {
            margin: .75rem;
        }

        .setting-action-confirm .modal-body {
            padding: 28px 22px 16px;
        }

        .setting-action-confirm .modal-footer {
            padding: 0 22px 24px;
        }
    }
</style>

<div class="modal fade setting-action-confirm" id="settingActionConfirmModal" tabindex="-1" aria-labelledby="settingConfirmTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            <div class="modal-body">
                <div class="setting-confirm-icon is-danger" id="settingConfirmIcon" aria-hidden="true">
                    <i class="mdi mdi-delete-outline"></i>
                </div>
                <h4 class="setting-confirm-title" id="settingConfirmTitle">Konfirmasi Aksi</h4>
                <p class="setting-confirm-message" id="settingConfirmMessage">Apakah Anda yakin ingin melanjutkan aksi ini?</p>
                <div class="setting-confirm-context" id="settingConfirmContext"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn setting-confirm-submit is-danger" id="settingConfirmSubmit">Ya, Lanjutkan</a>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    function initSettingActionConfirm() {
        var modalElement = document.getElementById('settingActionConfirmModal');
        if (!modalElement || modalElement.dataset.confirmBound === '1') {
            return;
        }

        modalElement.dataset.confirmBound = '1';

        var titleElement = document.getElementById('settingConfirmTitle');
        var messageElement = document.getElementById('settingConfirmMessage');
        var contextElement = document.getElementById('settingConfirmContext');
        var iconElement = document.getElementById('settingConfirmIcon');
        var iconGlyph = iconElement ? iconElement.querySelector('i') : null;
        var submitButton = document.getElementById('settingConfirmSubmit');
        var variants = {
            danger: { icon: 'mdi mdi-delete-outline' },
            warning: { icon: 'mdi mdi-alert-outline' },
            success: { icon: 'mdi mdi-check-circle-outline' }
        };

        document.addEventListener('click', function (event) {
            var trigger = event.target.closest ? event.target.closest('.js-setting-action-confirm') : null;
            if (!trigger) {
                return;
            }

            event.preventDefault();

            var targetUrl = trigger.getAttribute('href') || '#';
            var title = trigger.getAttribute('data-confirm-title') || 'Konfirmasi Aksi';
            var message = trigger.getAttribute('data-confirm-message') || 'Apakah Anda yakin ingin melanjutkan aksi ini?';
            var context = trigger.getAttribute('data-confirm-context') || '';
            var buttonText = trigger.getAttribute('data-confirm-label') || 'Ya, Lanjutkan';
            var variant = trigger.getAttribute('data-confirm-variant') || 'danger';

            if (!variants[variant]) {
                variant = 'danger';
            }

            titleElement.textContent = title;
            messageElement.textContent = message;
            submitButton.setAttribute('href', targetUrl);
            submitButton.textContent = buttonText;
            submitButton.className = 'btn setting-confirm-submit is-' + variant;

            if (context) {
                contextElement.textContent = context;
                contextElement.style.display = 'block';
            } else {
                contextElement.textContent = '';
                contextElement.style.display = 'none';
            }

            if (iconElement) {
                iconElement.className = 'setting-confirm-icon is-' + variant;
            }
            if (iconGlyph) {
                iconGlyph.className = variants[variant].icon;
            }

            if (window.bootstrap && bootstrap.Modal) {
                var modal = bootstrap.Modal.getInstance(modalElement);
                if (!modal) {
                    modal = new bootstrap.Modal(modalElement);
                }
                modal.show();
                return;
            }

            if (window.confirm(message)) {
                window.location.href = targetUrl;
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSettingActionConfirm);
    } else {
        initSettingActionConfirm();
    }
})();
</script>
