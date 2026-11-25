(function () {
    'use strict';
    var dirty = new Set();
    function updateStep() {
        var tab = document.querySelector('.apply360-page #myTab .nav-link.active');
        var heading = document.getElementById('apply360-current-step');
        var fill = document.getElementById('apply360-progress-fill');
        if (!tab || !heading || !fill) return;
        var match = tab.id.match(/^step(\d+)-tab$/);
        if (!match) return;
        var number = Number(match[1]);
        var label = tab.closest('.nav-item').querySelector('.octicon');
        heading.textContent = 'Step ' + number + ' of 11 · ' + (label ? label.textContent.trim() : 'Application');
        fill.style.width = (number / 11 * 100) + '%';
        var pane = document.querySelector('.apply360-page #step' + number);
        var legacyStatus = pane && pane.querySelector('.form-switch label');
        var badge = document.getElementById('apply360-step-payment');
        if (badge) {
            badge.textContent = legacyStatus ? (number <= 5 ? 'University application fee: ' : 'Visa processing fee: ') + legacyStatus.textContent.trim() : '';
            badge.hidden = !legacyStatus;
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        var menu = document.querySelector('.apply360-step-menu');
        document.querySelectorAll('.apply360-page .form-switch').forEach(function (toggle) {
            toggle.hidden = true;
            toggle.setAttribute('aria-hidden', 'true');
            toggle.querySelectorAll('input').forEach(function (input) { input.disabled = true; });
        });
        var passwordToggle = document.getElementById('apply360-password-toggle');
        if (passwordToggle) passwordToggle.addEventListener('click', function () {
            var input = document.getElementById('portal_password');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            passwordToggle.textContent = show ? 'Hide' : 'Show';
            passwordToggle.setAttribute('aria-pressed', String(show));
        });
        window.setTimeout(function () {
            var select = document.getElementById('universitySelect');
            if (select && !select.closest('.bootstrap-select')) {
                select.classList.add('form-control');
                select.size = 6;
                select.style.setProperty('display', 'block', 'important');
            }
        }, 1500);
        if (menu) menu.open = true;
        updateStep();
        if (window.jQuery) window.jQuery('#myTab a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
            updateStep();
        });
    });
    function markDirty(event) {
        var form = event.target.closest('.apply360-page .tab-pane form');
        if (form && form.id && event.isTrusted) dirty.add(form.id);
    }
    document.addEventListener('input', markDirty);
    document.addEventListener('change', markDirty);
    document.addEventListener('apply360:saved', function (event) { dirty.delete(event.detail.form); });
    window.addEventListener('beforeunload', function (event) {
        if (!dirty.size) return;
        event.preventDefault();
        event.returnValue = '';
    });
    document.addEventListener('click', function (event) {
        var link = event.target.closest('.apply360-page #myTab .nav-link, .apply360-page .previous');
        var form = document.querySelector('.apply360-page .tab-pane.active form');
        if (link && form && dirty.has(form.id) && !window.confirm('You have unsaved changes. Leave this step?')) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    }, true);
})();
