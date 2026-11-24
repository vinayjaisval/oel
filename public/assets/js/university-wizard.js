(function ($) {
    'use strict';

    var cfg = window.UNIVERSITY_WIZARD;
    if (!cfg) return;

    var STEP_LABELS = { 1: 'Location', 2: 'Basic Info', 3: 'Ranking', 4: 'Accreditation', 5: 'Documents' };
    var currentStep = 1;
    var maxUnlockedStep = cfg.isEdit ? 5 : 1;
    var isDirty = false;
    var lastSavedAt = null;
    var autosaveTimer = null;
    var loadedSteps = { 1: true }; // step 1 fields are always in the DOM already
    var summernoteInited = {};
    var pendingDelete = null; // { type: 'ranking'|'accreditation', id: ... }

    function setupCSRF() {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': cfg.csrfToken } });
    }

    function universityId() {
        return $('.university_id').first().val() || null;
    }

    function setUniversityId(id) {
        $('.university_id').val(id);
        cfg.universityId = id;
        $('#wizard-app').attr('data-university-id', id);
    }

    function markDirty() {
        isDirty = true;
    }

    /* ================= Stepper visuals ================= */
    function renderStepper() {
        $('.pr-step').each(function () {
            var step = parseInt($(this).data('step'), 10);
            $(this).removeClass('pr-step-done pr-step-current pr-step-locked pr-step-clickable');

            if (step < currentStep) {
                $(this).addClass('pr-step-done');
            } else if (step === currentStep) {
                $(this).addClass('pr-step-current');
            }

            var clickable = cfg.isEdit || step <= maxUnlockedStep;
            $(this).addClass(clickable ? 'pr-step-clickable' : 'pr-step-locked');
        });

        var pct = Math.round((currentStep / 5) * 100);
        $('#wizard-mobile-step-label').text('Step ' + currentStep + ' of 5 · ' + STEP_LABELS[currentStep]);
        $('#wizard-mobile-step-percent').text(pct + '%');
        $('#wizard-mobile-progress-fill').css('width', pct + '%');

        $('#wizard-back-btn').toggle(currentStep > 1);
        $('#wizard-next-btn').toggle(currentStep < 5);
        $('#wizard-submit-btn').toggle(currentStep === 5);
        $('#wizard-save-draft-btn').toggle(currentStep <= 2);
    }

    function goToStep(step, skipValidation) {
        if (!cfg.isEdit && step > maxUnlockedStep) return;

        $('.tab-pane').removeClass('active show');
        $('#step' + step).addClass('active show');
        currentStep = step;
        renderStepper();
        lazyLoadStep(step);
        if (step === 2) {
            var activeTab = $('.pr-content-tab-active').data('content-tab') || 'details';
            initSummernoteFor(activeTab);
        }
        window.scrollTo({ top: $('.pr-card').offset().top - 80, behavior: 'smooth' });
    }

    $(document).on('click', '.pr-step.pr-step-clickable', function () {
        var step = parseInt($(this).data('step'), 10);
        goToStep(step);
    });

    $('#wizard-back-btn').on('click', function () {
        if (currentStep > 1) goToStep(currentStep - 1);
    });

    /* ================= Lazy loading per step ================= */
    function lazyLoadStep(step) {
        if (loadedSteps[step]) return;
        var id = universityId();
        if (!id) return;

        if (step === 3) {
            loadedSteps[3] = true;
            fetchRankings();
        } else if (step === 4) {
            loadedSteps[4] = true;
            fetchAccreditations();
        } else if (step === 5) {
            loadedSteps[5] = true;
            fetchDocuments();
        }
    }

    /* ================= Validation ================= */
    function validateStepClient(step) {
        var $form = $('#step' + step).find('form').first();
        var valid = true;
        var $firstError = null;

        $form.find('.pr-error').text('');
        $form.find('[required]').each(function () {
            var val = $(this).val();
            if (!val || (Array.isArray(val) && val.length === 0)) {
                valid = false;
                var name = $(this).attr('name');
                var $err = $form.find('[data-error="' + name + '"]');
                $err.text('This field is required.');
                if (!$firstError) $firstError = $(this);
            }
        });

        if (!valid && $firstError) {
            scrollToField($firstError);
        }

        return valid;
    }

    function scrollToField($field) {
        var $container = $field.closest('.pr-form-field');
        var target = $container.length ? $container : $field;
        $('html, body').animate({ scrollTop: target.offset().top - 150 }, 300);

        // If the field lives inside a hidden content tab (step 2), switch to it and flag the pill red.
        var $panel = $field.closest('.pr-content-panel');
        if ($panel.length && !$panel.hasClass('pr-content-panel-active')) {
            var tabKey = $panel.data('content-panel');
            activateContentTab(tabKey);
            $('.pr-content-tab[data-content-tab="' + tabKey + '"]').addClass('pr-content-tab-error');
        }
    }

    function applyServerErrors(step, errors) {
        var $form = $('#step' + step).find('form').first();
        $form.find('.pr-error').text('');
        var $firstError = null;
        $.each(errors, function (field, msgs) {
            var $err = $form.find('[data-error="' + field + '"]');
            $err.text(Array.isArray(msgs) ? msgs[0] : msgs);
            var $field = $form.find('[name="' + field + '"], [name="' + field + '[]"]');
            if (!$firstError && $field.length) $firstError = $field.first();
        });
        if ($firstError) scrollToField($firstError);
    }

    /* ================= Step 1: country -> state, map ================= */
    function fetchStates(countryId, selected) {
        var $select = $('.province_id');
        $select.empty().append('<option value="">Loading...</option>');
        if (!countryId) {
            $select.empty().append('<option value="">Select country first</option>');
            return;
        }
        setupCSRF();
        $.get(cfg.statesUrl, { country_id: countryId }, function (data) {
            $select.empty();
            if ($.isEmptyObject(data)) {
                $select.append('<option value="">No records found</option>');
                return;
            }
            $select.append('<option value="">Select state / province</option>');
            $.each(data, function (key, value) {
                var opt = $('<option></option>').val(key).text(value);
                if (selected && String(selected) === String(key)) opt.prop('selected', true);
                $select.append(opt);
            });
        });
    }

    function initStep1() {
        var $country = $('.country');
        var selectedState = $('.province_id').data('selected');
        fetchStates($country.val(), selectedState);
        $country.on('change', function () {
            fetchStates($(this).val());
        });

        var $input = $('.google-iframe-url');
        var $iframe = $('#map-iframe');
        var $placeholder = $('#map-preview-placeholder');

        function extractSrc(value) {
            if (!value) return '';
            if (value.indexOf('<iframe') !== -1) {
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = value;
                var el = tempDiv.querySelector('iframe');
                return el ? el.src : '';
            }
            // plain URL
            return value.trim();
        }

        function updateMapPreview() {
            var src = extractSrc($input.val());
            if (src) {
                $iframe.attr('src', src).show();
                $placeholder.hide();
            } else {
                $iframe.hide().attr('src', '');
                $placeholder.show();
            }
        }

        updateMapPreview();
        $input.on('input', function () {
            updateMapPreview();
            markDirty();
        });

        $('#step1 input, #step1 select').on('change input', markDirty);
    }

    /* ================= Step 2: select2 chips, content tabs, summernote ================= */
    function activateContentTab(key) {
        $('.pr-content-tab').removeClass('pr-content-tab-active');
        $('.pr-content-tab[data-content-tab="' + key + '"]').addClass('pr-content-tab-active');
        $('.pr-content-panel').removeClass('pr-content-panel-active');
        $('.pr-content-panel[data-content-panel="' + key + '"]').addClass('pr-content-panel-active');
        initSummernoteFor(key);
    }

    function initSummernoteFor(key) {
        var id = 'summernote-' + key;
        if (summernoteInited[id] || !$.fn.summernote) return;
        summernoteInited[id] = true;
        $('#' + id).summernote({
            placeholder: 'Write here',
            height: 160,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
                ['insert', ['link', 'table']],
                ['view', ['codeview']]
            ]
        });
    }

    function initStep2() {
        if ($.fn.select2) {
            $('.wizard-tests-select').select2({
                placeholder: 'Select tests required',
                width: '100%',
                tags: false
            });
        }

        $('.pr-content-tab').on('click', function () {
            $(this).removeClass('pr-content-tab-error');
            activateContentTab($(this).data('content-tab'));
        });

        $('#step2 input, #step2 select, #step2 textarea').on('change input', markDirty);
    }

    /* ================= Step 3: Ranking ================= */
    var editingRankingId = null;

    function fetchRankings() {
        var id = universityId();
        setupCSRF();
        $.get(cfg.rankingListUrl, { id: id }, function (data) {
            var $tbody = $('.university-ranking').empty();
            if (!data || !data.length) {
                $tbody.append('<tr><td colspan="5" style="text-align:center;color:var(--pr-text-muted);">Abhi koi ranking add nahi hui</td></tr>');
                return;
            }
            $.each(data, function (_, v) {
                $tbody.append(
                    '<tr>' +
                    '<td>' + v.ranking + '</td><td>' + v.from_place + '</td><td>' + v.year + '</td><td>' + v.type + '</td>' +
                    '<td><div class="pr-actions">' +
                    '<button type="button" class="pr-icon-btn ranking-edit" data-id="' + v.id + '" data-ranking="' + v.ranking + '" data-from_place="' + escapeHtml(v.from_place) + '" data-year="' + v.year + '" data-type="' + escapeHtml(v.type) + '" data-tooltip="Edit"><i class="la la-pen"></i></button>' +
                    '<button type="button" class="pr-icon-btn ranking-delete" data-id="' + v.id + '" data-tooltip="Delete"><i class="la la-trash"></i></button>' +
                    '</div></td></tr>'
                );
            });
        });
    }

    function escapeHtml(s) {
        return $('<div>').text(s || '').html();
    }

    $(document).on('click', '.add_ranking', function () {
        var $btn = $(this);
        var id = universityId();
        if (!id) { Swal.fire({ icon: 'warning', title: 'Please complete step 1 first.' }); return; }
        $btn.prop('disabled', true);
        setupCSRF();

        var formData = $('#add_ranking').serialize() + '&university_id=' + id;
        var url = editingRankingId ? cfg.rankingUpdateUrl.replace('__ID__', editingRankingId) : cfg.rankingAddUrl;

        $.post(url, formData, function () {
            $('#add_ranking')[0].reset();
            $('.university_id', '#add_ranking').val(id);
            resetRankingForm();
            fetchRankings();
        }).fail(function (xhr) {
            var res = xhr.responseJSON || {};
            applyFieldErrors('#add_ranking', res.errors);
        }).always(function () {
            $btn.prop('disabled', false);
        });
    });

    function applyFieldErrors(formSelector, errors) {
        $(formSelector).find('.pr-error').text('');
        $.each(errors || {}, function (field, msgs) {
            $(formSelector).find('[data-error="' + field + '"]').text(Array.isArray(msgs) ? msgs[0] : msgs);
        });
    }

    function resetRankingForm() {
        editingRankingId = null;
        $('.add_ranking').text('+ Add Ranking');
        $('.ranking-cancel-edit').hide();
    }

    $(document).on('click', '.ranking-edit', function () {
        var d = $(this).data();
        editingRankingId = d.id;
        $('#add_ranking [name="ranking"]').val(d.ranking);
        $('#add_ranking [name="from_place"]').val(d.from_place);
        $('#add_ranking [name="year"]').val(d.year);
        $('#add_ranking [name="type"]').val(d.type);
        $('.add_ranking').text('Save changes');
        $('.ranking-cancel-edit').show();
        $('html, body').animate({ scrollTop: $('#add_ranking').offset().top - 150 }, 200);
    });

    $(document).on('click', '.ranking-cancel-edit', function () {
        $('#add_ranking')[0].reset();
        resetRankingForm();
    });

    $(document).on('click', '.ranking-delete', function () {
        pendingDelete = { type: 'ranking', id: $(this).data('id') };
        $('#wizard-confirm-text').text('Delete this ranking entry?');
        new bootstrap.Offcanvas(document.getElementById('wizard-confirm-offcanvas')).show();
    });

    /* ================= Step 4: Accreditation ================= */
    var editingAccreditationId = null;

    function fetchAccreditations() {
        var id = universityId();
        setupCSRF();
        $.get(cfg.accreditationListUrl, { id: id }, function (data) {
            var $tbody = $('.accerediation_table').empty();
            if (!data || !data.length) {
                $tbody.append('<tr><td colspan="4" style="text-align:center;color:var(--pr-text-muted);">Abhi koi accreditation add nahi hui</td></tr>');
                return;
            }
            $.each(data, function (_, v) {
                var logoUrl = v.logo ? (cfg.assetBase + v.logo) : '';
                $tbody.append(
                    '<tr>' +
                    '<td>' + (logoUrl ? '<img src="' + logoUrl + '" style="height:32px;width:32px;object-fit:cover;border-radius:4px;">' : '-') + '</td>' +
                    '<td>' + escapeHtml(v.name) + '</td><td>' + v.year + '</td>' +
                    '<td><div class="pr-actions">' +
                    '<button type="button" class="pr-icon-btn accreditation-edit" data-id="' + v.id + '" data-name="' + escapeHtml(v.name) + '" data-year="' + v.year + '" data-tooltip="Edit"><i class="la la-pen"></i></button>' +
                    '<button type="button" class="pr-icon-btn accreditation-delete" data-id="' + v.id + '" data-tooltip="Delete"><i class="la la-trash"></i></button>' +
                    '</div></td></tr>'
                );
            });
        });
    }

    $(document).on('click', '.accerediation_add', function () {
        var $btn = $(this);
        var id = universityId();
        if (!id) { Swal.fire({ icon: 'warning', title: 'Please complete step 1 first.' }); return; }
        $btn.prop('disabled', true);
        setupCSRF();

        var formData = new FormData($('#accerediation')[0]);
        formData.set('university_id', id);
        var url = editingAccreditationId ? cfg.accreditationUpdateUrl.replace('__ID__', editingAccreditationId) : cfg.accreditationAddUrl;

        $.ajax({
            url: url, method: 'POST', data: formData, processData: false, contentType: false,
            success: function () {
                $('#accerediation')[0].reset();
                $('.university_id', '#accerediation').val(id);
                resetAccreditationForm();
                fetchAccreditations();
            },
            error: function (xhr) {
                applyFieldErrors('#accerediation', (xhr.responseJSON || {}).errors);
            },
            complete: function () { $btn.prop('disabled', false); }
        });
    });

    function resetAccreditationForm() {
        editingAccreditationId = null;
        $('.accerediation_add').text('+ Add Accreditation');
        $('.accreditation-cancel-edit').hide();
    }

    $(document).on('click', '.accreditation-edit', function () {
        var d = $(this).data();
        editingAccreditationId = d.id;
        $('#accerediation [name="name"]').val(d.name);
        $('#accerediation [name="year"]').val(d.year);
        $('.accerediation_add').text('Save changes');
        $('.accreditation-cancel-edit').show();
        $('html, body').animate({ scrollTop: $('#accerediation').offset().top - 150 }, 200);
    });

    $(document).on('click', '.accreditation-cancel-edit', function () {
        $('#accerediation')[0].reset();
        resetAccreditationForm();
    });

    $(document).on('click', '.accreditation-delete', function () {
        pendingDelete = { type: 'accreditation', id: $(this).data('id') };
        $('#wizard-confirm-text').text('Delete this accreditation entry?');
        new bootstrap.Offcanvas(document.getElementById('wizard-confirm-offcanvas')).show();
    });

    $('#wizard-confirm-delete-btn').on('click', function () {
        if (!pendingDelete) return;
        setupCSRF();
        var url = pendingDelete.type === 'ranking'
            ? cfg.rankingDeleteUrl.replace('__ID__', pendingDelete.id)
            : cfg.accreditationDeleteUrl.replace('__ID__', pendingDelete.id);

        $.post(url, {}, function () {
            bootstrap.Offcanvas.getInstance(document.getElementById('wizard-confirm-offcanvas')).hide();
            if (pendingDelete.type === 'ranking') fetchRankings(); else fetchAccreditations();
            pendingDelete = null;
        });
    });

    /* ================= Step 5: Documents (drag & drop) ================= */
    function humanFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        var kb = bytes / 1024;
        if (kb < 1024) return kb.toFixed(1) + ' KB';
        return (kb / 1024).toFixed(1) + ' MB';
    }

    function uploadFiles(field, files) {
        var id = universityId();
        if (!id) { Swal.fire({ icon: 'warning', title: 'Please complete step 1 first.' }); return; }

        var $preview = $('.pr-upload-preview[data-preview="' + field + '"]');
        var formData = new FormData();
        formData.append('university_id', id);

        if (field === 'images') {
            $.each(files, function (i, f) { formData.append('images[]', f); });
        } else {
            formData.append(field, files[0]);
        }

        var $item = $(
            '<div class="pr-upload-item"><span class="pr-upload-icon"><i class="la la-file-image"></i></span>' +
            '<div class="pr-upload-meta"><div class="pr-upload-name">' + escapeHtml(files[0].name) + (files.length > 1 ? ' +' + (files.length - 1) + ' more' : '') + '</div>' +
            '<div class="pr-upload-size">' + humanFileSize(files[0].size) + '</div>' +
            '<div class="pr-upload-progress-track"><div class="pr-upload-progress-fill"></div></div></div></div>'
        );
        if (field !== 'images') { $preview.empty(); }
        $preview.append($item);

        setupCSRF();
        $.ajax({
            url: cfg.documentsUploadUrl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var pct = Math.round((e.loaded / e.total) * 100);
                            $item.find('.pr-upload-progress-fill').css('width', pct + '%');
                        }
                    });
                }
                return xhr;
            },
            success: function () {
                $item.find('.pr-upload-progress-fill').css('width', '100%');
                fetchDocuments();
            },
            error: function (xhr) {
                var res = xhr.responseJSON || {};
                var msg = res.errors ? Object.values(res.errors)[0] : 'Upload failed.';
                $item.remove();
                Swal.fire({ icon: 'error', title: 'Upload failed', text: Array.isArray(msg) ? msg[0] : msg });
            }
        });
    }

    function initDropzones() {
        $('.pr-dropzone').each(function () {
            var $zone = $(this);
            var $input = $zone.find('input[type="file"]');

            $zone.on('click', function () { $input.trigger('click'); });
            $input.on('change', function () {
                if (this.files.length) uploadFiles($zone.data('field'), this.files);
            });
            $zone.on('dragover', function (e) { e.preventDefault(); $zone.addClass('pr-dropzone-over'); });
            $zone.on('dragleave', function () { $zone.removeClass('pr-dropzone-over'); });
            $zone.on('drop', function (e) {
                e.preventDefault();
                $zone.removeClass('pr-dropzone-over');
                var files = e.originalEvent.dataTransfer.files;
                if (files.length) uploadFiles($zone.data('field'), files);
            });
        });
    }

    function fetchDocuments() {
        var id = universityId();
        if (!id) return;
        setupCSRF();
        $.get(cfg.documentsListUrl, { id: id }, function (data) {
            $.each(['logo', 'thumbnail', 'banner'], function (_, field) {
                var $preview = $('.pr-upload-preview[data-preview="' + field + '"]').empty();
                var path = data.uniDoc && data.uniDoc[field];
                if (path) {
                    $preview.append(
                        '<div class="pr-upload-item"><img src="' + cfg.assetBase + path + '" alt=""><div class="pr-upload-meta"><div class="pr-upload-name">Uploaded</div></div></div>'
                    );
                }
            });

            var $gallery = $('.pr-upload-preview[data-preview="images"]').empty();
            if (data.university_gallery && data.university_gallery.length) {
                $.each(data.university_gallery, function (_, img) {
                    $gallery.append(
                        '<div class="pr-upload-item" style="width:160px;" data-gallery-id="' + img.id + '">' +
                        '<img src="' + cfg.assetBase + img.file_name + '">' +
                        '<div class="pr-upload-meta"><button type="button" class="pr-upload-remove gallery-remove" data-id="' + img.id + '">Remove</button></div></div>'
                    );
                });
            }
        });
    }

    $(document).on('click', '.gallery-remove', function () {
        var id = $(this).data('id');
        setupCSRF();
        $.post(cfg.galleryDeleteUrl, { id: id }, function () {
            fetchDocuments();
        });
    });

    /* ================= Next / Save draft / Submit ================= */
    function currentStepRequest(callback) {
        var step = currentStep;
        var $form = $('#step' + step).find('form').first();

        if (step >= 3) {
            // Steps 3-5 already save their entries instantly; Next/Save draft just navigates.
            callback(true);
            return;
        }

        if (!validateStepClient(step)) {
            callback(false);
            return;
        }

        setupCSRF();
        $.ajax({
            url: cfg.storeUrl,
            method: 'POST',
            data: new FormData($form[0]),
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.university_id) {
                    setUniversityId(res.university_id);
                }
                lastSavedAt = new Date();
                updateAutosaveNote();
                isDirty = false;
                callback(true);
            },
            error: function (xhr) {
                var res = xhr.responseJSON || {};
                if (res.errors && typeof res.errors === 'object') {
                    applyServerErrors(step, res.errors);
                } else {
                    Swal.fire({ icon: 'error', title: 'Could not save', text: res.errors || 'Please try again.' });
                }
                callback(false);
            }
        });
    }

    $('#wizard-next-btn').on('click', function () {
        var $btn = $(this).prop('disabled', true);
        currentStepRequest(function (ok) {
            $btn.prop('disabled', false);
            if (ok) {
                maxUnlockedStep = Math.max(maxUnlockedStep, currentStep + 1);
                goToStep(currentStep + 1);
            }
        });
    });

    $('#wizard-save-draft-btn').on('click', function () {
        var $btn = $(this).prop('disabled', true);
        currentStepRequest(function (ok) {
            $btn.prop('disabled', false);
            if (ok) {
                Swal.fire({ icon: 'success', title: 'Saved', timer: 1200, showConfirmButton: false });
            }
        });
    });

    $('#wizard-submit-btn').on('click', function () {
        var id = universityId();
        if (!id) { Swal.fire({ icon: 'warning', title: 'Please complete the earlier steps first.' }); return; }
        var $btn = $(this).prop('disabled', true);
        setupCSRF();
        $.post(cfg.submitWizardUrl, { university_id: id }, function (res) {
            window.removeEventListener('beforeunload', beforeUnloadHandler);
            window.location.href = cfg.universitiesIndexUrl + '?tab=all&submitted=1&highlight=' + res.university_id;
        }).fail(function () {
            $btn.prop('disabled', false);
            Swal.fire({ icon: 'error', title: 'Could not submit', text: 'Please try again.' });
        });
    });

    /* ================= Autosave + unsaved-changes guard ================= */
    function updateAutosaveNote() {
        if (!lastSavedAt) { $('#wizard-autosave-note').text(''); return; }
        var mins = Math.max(0, Math.round((Date.now() - lastSavedAt.getTime()) / 60000));
        $('#wizard-autosave-note').text('Draft auto-saved · ' + (mins === 0 ? 'just now' : mins + ' min ago'));
    }
    setInterval(updateAutosaveNote, 15000);

    function startAutosave() {
        autosaveTimer = setInterval(function () {
            if (!isDirty) return;
            if (currentStep > 2) return;
            currentStepRequest(function () {});
        }, 60000);
    }

    function beforeUnloadHandler(e) {
        if (!isDirty) return;
        e.preventDefault();
        e.returnValue = '';
        return '';
    }
    window.addEventListener('beforeunload', beforeUnloadHandler);

    $(document).on('click', 'a[href]:not([href^="#"]):not([target="_blank"])', function (e) {
        if (!isDirty) return;
        if ($(this).attr('id') === 'wizard-submit-btn') return;
        var proceed = confirm('You have unsaved changes. Leave this page?');
        if (!proceed) {
            e.preventDefault();
        } else {
            isDirty = false;
        }
    });

    /* ================= Init ================= */
    $(function () {
        setupCSRF();
        initStep1();
        initStep2();
        initDropzones();
        renderStepper();

        if (cfg.isEdit) {
            // Everything is already saved; edit mode starts fully unlocked and not "dirty".
            loadedSteps = {};
            lazyLoadStep(currentStep);
        }

        startAutosave();
    });

})(jQuery);
