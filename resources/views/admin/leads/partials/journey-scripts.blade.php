    <script src="{{ asset('assets/js/apply-360-redesign.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function(){
        if($('input[name="fees_details"]:checked').val() == 'Prepaid'){
            $('.prepaid').removeClass('d-none');
        }
        $('input[name="fees_details"]').on('change',function(){
            if($(this).val() == 'Prepaid'){
                $('.prepaid').removeClass('d-none');
            }else{
                $('.prepaid').addClass('d-none');
            }
        });
    });
</script>
    <script>
        $(document).ready(function() {
            function handleNext() {
                const activeTab = $('.apply360-page .tab-pane.active');
                const nextTab = activeTab.next('.tab-pane');
                if (nextTab.length) {
                    activeTab.removeClass('active');
                    activeTab.removeClass('show');
                    nextTab.addClass('active show');
                    const nextTabLink = nextTab.attr('id') + '-tab';
                    $('#' + nextTabLink).tab('show');
                }
            }

            function handlePrevious() {
                const activeTab = $('.apply360-page .tab-pane.active');
                const previousTab = activeTab.prev('.tab-pane');
                if (previousTab.length) {
                    activeTab.removeClass('active');
                    activeTab.removeClass('show');
                    previousTab.addClass('active show');
                    const previousTabLink = previousTab.attr('id') + '-tab';
                    $('#' + previousTabLink).tab('show');
                }
            }
            // $('.next').on('click', handleNext);
            $('.apply360-page .previous').on('click', handlePrevious);
            $('.apply360-page .next').on('click', function(event) {
                event.preventDefault();
                if ($(this).hasClass('disabled')) return;
                $('.next').addClass('disabled');
                var spinner = this.querySelector('.spinner-grow');
                spinner.classList.remove('d-none');
                var sba_id = $('.sba_id').val();
                var activeTab = document.querySelector('.apply360-page .tab-pane.fade.show.active');
                var activeFormId = activeTab.querySelector('form').id;
                if ('tab1DataForm' == activeFormId) {
                    var tab1 = 'tab1';
                    var collegeValues = [];
                    $('.college-checkbox').each(function() {
                        if ($(this).is(':checked')) {
                            collegeValues.push($(this).val());
                        }
                    });
                    var formData = {
                        sba_id: sba_id,
                        collegeValues: collegeValues,
                        tab1: tab1
                    };
                } else if ('tab2DataForm' == activeFormId) {
                    var tab2 = 'tab2';
                    var courseValues = [];
                    $('.course-checkbox').each(function() {
                        if ($(this).is(':checked')) {
                            courseValues.push($(this).val());
                        }
                    });
                    var formData = {
                        sba_id: sba_id,
                        courseValues: courseValues,
                        tab2: tab2
                    };
                } else if ('tab3DataForm' == activeFormId) {
                    var formData = $('#tab3DataForm').serialize();
                } else if ('tab4DataForm' == activeFormId) {
                    var tab = 'tab4';
                    var joining_date = $('#joining_date').val();
                    var offer_amount = $('#offer_amount').val();
                    var course_details = $('#course_details').val();
                    var course_details_status = $('#course_details_status').val();
                  
                    var university_details_status = $('#university_details_status').val();

                    var formData = {
                        sba_id: sba_id,
                        joining_date: joining_date,
                        offer_amount: offer_amount,
                        course_details: course_details,
                        course_details_status: course_details_status,
                        university_details_status: university_details_status,
                        tab: tab
                    };
                } else if ('tab5DataForm' == activeFormId) {
                    var tab = 'tab5';
                    if ($('#visa_manual').is(':visible')) {
                        var visa_manual = $('#visa_manual').val();
                    } else {
                        var visa_manual = '';
                    }
                    if ($('#visa_agent').is(':visible')) {
                        var visa_agent = $('#visa_agent').val();
                    } else {
                        var visa_agent = '';
                    }
                    var visa_apply_date = $('#visa_apply_date').val();
                    var portal_url = $('#portal_url').val();
                    var portal_email = $('#portal_email').val();
                    var portal_userid = $('#portal_userid').val();
                    var portal_password = $('#portal_password').val();
                    var portal_question = $('#portal_question').val();
                    var portal_answer = $('#portal_answer').val();
                    var visa_document_type = $('#visa_document_type').val();
                    var visa_sub_document_type = $('#visa_sub_document_type').val();
                    var visa_document = $('#visa_document').val();
                    var formData = new FormData();
                    formData.append('sba_id', sba_id);
                    formData.append('tab5', tab);
                    formData.append('visa_agent', visa_agent);
                    formData.append('visa_manual', visa_manual);
                    formData.append('visa_apply_date', visa_apply_date);
                    formData.append('portal_url', portal_url);
                    formData.append('portal_email', portal_email);
                    formData.append('portal_userid', portal_userid);
                    if (typeof portal_password !== 'undefined') formData.append('portal_password', portal_password);
                    formData.append('portal_question', portal_question);
                    formData.append('portal_answer', portal_answer);
                    formData.append('visa_document_type', visa_document_type);
                    formData.append('visa_sub_document_type', visa_sub_document_type);
                    formData.append('visa_document', visa_document);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('store-lead-360') }}',
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            spinner.classList.add('d-none');
                            $('.next').removeClass('disabled');

                            if (response.success) {
                                document.dispatchEvent(new CustomEvent('apply360:saved', {detail: {form: activeFormId}}));
                                if (response.status != 'Rejected') {
                                    handleNext();
                                } else {
                                    return false;
                                }
                            }
                        },
                        error: function(xhr) {
                            $('.next').removeClass('disabled');
                            spinner.classList.add('d-none');
                            Swal.fire('Save failed', 'Check the fields and try again.', 'error');
                        }
                    });
                    return;
                } else if ('tab6DataForm' == activeFormId) {
                    $('#visa-remarks-error').text('');
                    var tab = 'tab6';
                    var visa_no = $('#visa_no').val();
                    var visa_exp_date = $('#visa_exp_date').val();
                    var remarks = $('#remarks').val();
                    const radioButtons = document.getElementsByName("visa_application");
                    let visa_application = "";
                    radioButtons.forEach(radioButton => {
                        if (radioButton.checked) {
                            visa_application = radioButton.id;
                        }
                    });
                    var formData = {
                        sba_id: sba_id,
                        visa_no: visa_no,
                        visa_exp_date: visa_exp_date,
                        visa_remarks: remarks,
                        visa_application: visa_application,
                        tab: tab
                    };
                } else if ('tab7DataForm' == activeFormId) {
                    var formData = $('#tab7DataForm').serialize();
                } else if ('tab8DataForm' == activeFormId) {
                    var formData = $('#tab8DataForm').serialize();
                } else if ('tab9DataForm' == activeFormId) {
                    var formData = $('#tab9DataForm').serialize();
                } else if ('tab10DataForm' == activeFormId) {
                    var formData = $('#tab10DataForm').serialize();
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('store-lead-360') }}',
                    type: 'post',
                    data: formData,
                    success: function(response) {
                        if (response.application_punching) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Data Inserted Successfully',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "{{ route('oel_360') }}";
                                }
                            });
                        }
                        spinner.classList.add('d-none');
                        $('.next').removeClass('disabled');
                        if (response.program && response.table_three_sixtee ) {
                            $('.select_course').empty();
                            let selected_program = response.table_three_sixtee.selected_program;
                            let selectedProgramIds = selected_program.split(',').map(id => parseInt(id.trim()));
                            let remarks = JSON.parse(response.table_three_sixtee.remarks);
                            let application = JSON.parse(response.table_three_sixtee.application);
                            response.program.forEach(function(course) {
                                $('.select_course').append(`
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <p><input class="form-check-input course-checkbox" name="program_ids[]" ${selectedProgramIds.includes((course.id)) ? 'checked' : ''} type="checkbox" value="${course.id}">${course.name}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="${course.id}_application_status" value="accepted" id="accepted${course.id}" ${(application && application[`${course.id}_application_status`] === 'accepted') ? 'checked' : ''}>
                                            <label class="form-check-label" for="accepted${course.id}">Accepted</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="${course.id}_application_status" value="rejected" id="rejected${course.id}" ${(application && application[`${course.id}_application_status`] === 'rejected') ? 'checked' : ''}>
                                            <label class="form-check-label" for="rejected${course.id}">Rejected</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="${course.id}_application_status" value="in_progress" id="in_progress${course.id}"  ${(application && application[`${course.id}_application_status`] === 'in_progress') ? 'checked' : ''}>
                                            <label class="form-check-label" for="in_progress${course.id}">In Progress</label>
                                        </div>
                                    </div>
                                <div class="col-12">
                                    <div class="row" id="tab3remarks_${course.id}" style="${(application && (application[`${course.id}_application_status`] === 'rejected' || application[`${course.id}_application_status`] === 'in_progress')) ? 'display: block;' : 'display: none;'}">
                                        <div class="input-block mb-3">
                                            <label for="remarksdata_${course.id}" class="form-label">Remarks</label>
                                            <input type="text" maxlength="150" class="form-control remarks-input" placeholder="Remarks" name="remarks_${course.id}" id="remarksdata_${course.id}" value="${application && application[`remarks_${course.id}`] ? application[`remarks_${course.id}`] : ''}">
                                        </div>
                                    </div>
                                </div>
                                `);
                                $(`input[name='${course.id}_application_status']`).on('change', function() {
                                    let status = $(this).val();
                                    if (status === 'rejected' || status === 'in_progress') {
                                        $(`#tab3remarks_${course.id}`).show();
                                    } else {
                                        $(`#tab3remarks_${course.id}`).hide();
                                    }
                                });
                                $(`input[name='${course.id}_application_status']:checked`).trigger('change');
                            });
                        }
                        if(response.program){
                            $('#course_details').empty();
                            $('#course_details').append(`
                                    <option value="">--Select Course--</option>
                                `);
                            $.each(response.program, function(index, item) {
                                $('#course_details').append(`
                                    <option value="${item.id}">${item.name}</option>
                                `);
                            });
                        }
                        if (response.hasOwnProperty('university')) {
                            $('#universitySelected').empty();
                            $('#universitySelected').append(`
                                    <option value="">--Select University--</option>
                                `);
                            $.each(response.university, function(index, item) {
                                $('#universitySelected').append(`
                                    <option value="${item.id}">${item.university_name}</option>
                                `);
                            });
                        } else {
                            $('#universitySelected').append(`
                                <option value="">No University Found</option>
                            `);
                        }
                        if (response.success) {
                            document.dispatchEvent(new CustomEvent('apply360:saved', {detail: {form: activeFormId}}));
                            if (response.status != 'Rejected') {
                                handleNext();
                            } else {
                                return false;
                            }
                        }
                        if (response.success) {
                            if (response.tab10 == 'tab10') {
                                var html = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong>Done!</strong> Success! 🎉
                                                You have Successfully Update the Student 360.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>`;
                                $('.done-alert').append(html)
                            }
                        }
                    },
                    error: function(xhr) {
                        spinner.classList.add('d-none');
                        $('.next').removeClass('disabled');
                        var response = xhr.responseJSON || {};
                        response.errors = response.errors || {};
                        if (response.errors.visa_remarks) {
                            $('#visa-remarks-error').text(response.errors.visa_remarks[0]);
                            $('.remarks').show();
                        }
                        if (!response.errors.collegeValues && !response.errors.courseValues && !response.errors.visa_remarks) {
                            Swal.fire('Save failed', 'Check the fields and try again.', 'error');
                        }
                        if (response.errors.collegeValues) {
                            var collegeError = ` <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <strong>${response.errors.collegeValues}</strong>
                                                </div>`;
                            $('.alert-college').html(collegeError);
                        }
                        if (response.errors.courseValues) {
                            var courseError = ` <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <strong>${response.errors.courseValues}</strong>
                                                </div>`;
                            $('.alert-course').html(courseError);
                        }

                    }
                });
                    return false;
                });
            $('input[type="radio"]').on('change', function() {
                let status = $(this).val();
                let courseId = $(this).attr('name').split('_')[0];
                if (status === 'rejected' || status === 'in_progress') {
                    $(`#tab3remarks_${courseId}`).show();
                } else {
                    $(`#tab3remarks_${courseId}`).hide();
                }
            });
            $('.upload-image').on('click', function() {
                if ($(this).hasClass('disabled')) return;
                $('.upload-image').addClass('disabled');
                $('.alert-image-error').attr('role', 'status').text('Uploading document…');
                var spinner = this.querySelector('.spinner-grow');
                spinner.classList.remove('d-none');
                var formData = new FormData($('#tab4DataForm')[0]);
                var files = $('#document')[0].files;
                for (var i = 0; i < files.length; i++) {
                    formData.append('images[]', files[i]);
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('store-lead-360') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        spinner.classList.add('d-none');
                        $('.upload-image').removeClass('disabled');
                        $('.alert-image-error').text('Document uploaded.');
                        var table_data = response.table_three_sixtee_image;
                        var tableBody = $('.course_details_document_table');
                        tableBody.empty();
                        var assetBaseUrl = "{{ asset('') }}/";
                        table_data.forEach(function(row) {
                            var tr = $('<tr>');
                            tr.append($('<td>').text(row.id));
                            tr.append($('<td>').text(row.program_name));
                            if (row.image && row.image.endsWith('.pdf')) {
                                tr.append($('<td>').html(`<a href="${assetBaseUrl}${row.image}" target="_blank">View PDF</a>`));
                            } else {
                                tr.append($('<td>').html(`<img src="${assetBaseUrl}${row.image ?? ''}" style="width:150px;height:150px">`));
                            }
                            tr.append($('<td>').html(`<a href="javascript:void(0)" class="btn btn-warning delete-document" data-id="${row.id}"><i class="fa-solid fa-trash"></i></a>`));
                            tableBody.append(tr);
                        });

                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON || {};
                        spinner.classList.add('d-none');
                        $('.upload-image').removeClass('disabled');
                        $('.alert-image-error').attr('role', 'alert').text('Upload failed. Check the file and try again.');
                        if (response.errors && response.errors.document) {
                            Swal.fire({
                                title: 'Error',
                                text: response.errors.document,
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                });
            });
            $(document).on('click.workspaceJourney', '.delete-document', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('delete-lead-360-image') }}',
                            type: 'GET',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Document has been deleted.',
                                        'success'
                                    );
                                    get_lead_360_images();
                                }
                            }
                        });
                    }
                })
            });
            function get_lead_360_images() {
                var sba_id = $('.sba_id').val();
                $.ajax({
                    url: '{{ route('get-lead-360-images') }}',
                    type: 'GET',
                    data: {
                        sba_id: sba_id
                   
                    },
                    success: function(response) {
                        var assetBaseUrl = "{{ asset('') }}/";
                        if (response.status) {
                            var table_data = response.table_three_sixtee_image;
                            var tableBody = $('.course_details_document_table');
                            tableBody.empty();
                            table_data.forEach(function(row) {
                                var tr = $('<tr>');
                                tr.append($('<td>').text(row.id));
                                tr.append($('<td>').text(row.program_name));
                                if (row.image && row.image.endsWith('.pdf')) {
                                    tr.append($('<td>').html(`<a href="${assetBaseUrl}${row.image}" target="_blank">View PDF</a>`));
                                } else {
                                    tr.append($('<td>').html(`<img src="${assetBaseUrl}${row.image ?? ''}" style="width:150px;height:150px">`));
                                }
                                tr.append($('<td>').html(`<a href="javascript:void(0)" class="btn btn-warning delete-document" data-id="${row.id}"><i class="fa-solid fa-trash"></i></a>`));
                                tableBody.append(tr);
                            });
                        }
                    }
                });
            }
            get_lead_360_images();
            $('#visa_document').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue == 'agent') {
                    $('#agent').show();
                    $('#manual').hide();
                } else if (selectedValue == 'manual') {
                    $('#manual').show();
                    $('#agent').hide();
                } else {
                    $('#manual').hide();
                    $('#agent').hide();
                }
            });
            $('#fee_payment_by').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue == 'agent') {
                    $('#feeagent').show();
                } else {
                    $('#feeagent').hide();
                }
            });

            $('#rejected, #accepted').on('click', function() {
                $('#tab3remarks').toggle($(this).is(':checked'));
            });
            $('#Accepted').on('click', function() {
                $('.remarks').hide();
                $('.visa-data').show();
            });
            $('#Rejected').on('click', function() {
                $('.remarks').show();
                $('.visa-data').hide();
            });
            if ($('#Rejected').is(':checked')) {
                $('.remarks').show();
                $('.visa-data').hide();
            }
            if ($('#Inprogress').is(':checked')) {
                $('.remarks').hide();
                $('.visa-data').hide();
            }
            if ($('#Accepted').is(':checked')) {
                $('.remarks').hide();
                $('.visa-data').show();
            }
            $('#Inprogress').on('click', function() {
                $('.remarks').hide();
                $('.visa-data').hide();
            });
            $('#inprogress').on('click', function() {
                $('#tab3remarks').hide();
            });

            $('#universitySelect').change(function() {
                $('#selectedValues').empty();
                $('#universitySelect option:selected').each(function() {
                    var value = $(this).val();
                    var college_id = [];
                    $('.college-checkbox:checked').each(function() {
                        college_id.push($(this).val());
                    });
                    if (college_id.includes(value)) {
                        alert("University already added!");
                    } else {
                        var text = $(this).text();
                        $('#selectedValues').append(
                            '<input type="checkbox" class="universityCheckbox college-checkbox" value="' +
                            value + '" checked> ' + text + '<br>');
                    }
                });
                $('#universitySelect option:not(:selected)').each(function() {
                    var value = $(this).val();
                    $('.universityCheckbox[value="' + value + '"]').remove();
                });
            });
            $('#courses').change(function() {
                var selectedValues = {};
                // Iterate through all selected options
                $('#courses option:selected').each(function() {
                    var value = $(this).val();
                    var text = $(this).text();
                    var school_id = $(this).attr('school-id');

                    // Remove previous course entries for this school
                    $('.courseEntry[school-id="' + school_id + '"]').remove();

                    // Store the selected value
                    selectedValues[school_id] = value;

                    // Append the checkbox and text inside a div
                    $('#courseValues').append(
                        '<span class="courseEntry" school-id="' + school_id + '">' +
                        '<input type="checkbox" class="courseCheckbox course-checkbox" value="' +
                        value + '" checked school-id="' + school_id + '"> ' + text + '<br></span>'
                    );
                });
                // Iterate through all options
                $('#courses option').each(function() {
                    var value = $(this).val();
                    var school_id = $(this).attr('school-id');

                    // Check if the option is not selected
                    if (!$(this).is(':selected')) {
                        // Remove the entire course entry for the unselected option
                        $('.courseEntry:has(.courseCheckbox[value="' + value + '"][school-id="' + school_id + '"])').remove();

                        // Remove the value from selectedValues if it matches
                        if (selectedValues[school_id] === value) {
                            delete selectedValues[school_id];
                        }
                    }
                });
            });



            $('#universitySelected').on('change',function(){
                var selectedValue = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('university.courses') }}",
                    type: "post",
                    data:{university_id:selectedValue},
                    success: function(response) {
                        $('#courses').empty();
                        $('#courses').append(`<option value="">--Select Course--</option>`);
                        response.program.forEach(function(item) {
                            $('#courses').append(`<option value="${item.id}" school-id="${response.college_id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error here
                    }
                });
            });
            $('.change-visa-document').change(function(){
                var visa_document_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('admin/fetch-visa-sub-document') }}",
                    type: "GET",
                    data: {visa_document_id:visa_document_id},
                    success: function(data){
                        $('#visa_sub_document_type').empty();
                        $('#visa_sub_document_type').append(`<option>-- Select --</option>`);
                        $.each(data.data, function(key, value){
                            $('#visa_sub_document_type').append('<option value="'+ value.id +'">'+ value.name +'</option>')
                        });
                    }
                });
            });
            $('.upload-visa-document').on('click', function() {
                if ($(this).hasClass('disabled')) return;
                $('.upload-visa-document').addClass('disabled');
                $('#apply360-visa-upload-feedback').attr('role', 'status').text('Uploading document…');
                var tab5 = 'tab5';
                var spinner = this.querySelector('.spinner-grow');
                spinner.classList.remove('d-none');
                var formData = new FormData($('#tab5DataForm')[0]);
                var files = $('#lead_document')[0].files;
                for (var i = 0; i < files.length; i++) {
                    formData.append('images[]', files[i]);
                }
                formData.append('tab5', tab5);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('store-lead-360') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        spinner.classList.add('d-none');
                        $('.upload-visa-document').removeClass('disabled');
                        $('#apply360-visa-upload-feedback').text('Document uploaded.');
                        var assetBaseUrl = "{{ asset('') }}/";
                        if (response.status) {
                            var table_data = response.visa_document;
                            var tableBody = $('.visa_document_table');
                            tableBody.empty();
                            table_data.forEach(function(row) {
                                var tr = $('<tr>');
                                tr.append($('<td>').text(row.id));
                                tr.append($('<td>').text(row.visa_document_name));
                                tr.append($('<td>').text(row.visa_sub_document_name));
                                if (row.image && row.image.endsWith('.pdf')) {
                                    tr.append($('<td>').html(`<a href="${assetBaseUrl}${row.image}" target="_blank">View PDF</a>`));
                                } else {
                                    tr.append($('<td>').html(`<img src="${assetBaseUrl}${row.image ?? ''}" style="width:150px;height:150px">`));
                                }
                                tr.append($('<td>').html(`<a href="javascript:void(0)" class="btn btn-warning delete-visa-document" data-id="${row.id}"><i class="fa-solid fa-trash"></i></a>`));
                                tableBody.append(tr);
                            });
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON || {};
                        spinner.classList.add('d-none');
                        $('.upload-visa-document').removeClass('disabled');
                        $('#apply360-visa-upload-feedback').attr('role', 'alert').text('Upload failed. Check the file and try again.');
                        if (response.errors && response.errors.document) {
                            Swal.fire({
                                title: 'Error',
                                text: response.errors.document,
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                });
            });
            function get_visa_document() {
                var sba_id = $('.sba_id').val();
                $.ajax({
                    url: '{{ route('get-visa-document') }}',
                    type: 'GET',
                    data: {
                        sba_id: sba_id
                    },
                    success: function(response) {
                        var assetBaseUrl = "{{ asset('') }}/";
                        if (response.data.status) {
                            var table_data = response.data.visa_document;
                            var tableBody = $('.visa_document_table');
                            tableBody.empty();
                            table_data.forEach(function(row) {
                                var tr = $('<tr>');
                                tr.append($('<td>').text(row.id));
                                tr.append($('<td>').text(row.visa_document_name));
                                tr.append($('<td>').text(row.visa_sub_document_name));
                                if (row.image && row.image.endsWith('.pdf')) {
                                    tr.append($('<td>').html(`<a href="${assetBaseUrl}${row.image}" target="_blank">View PDF</a>`));
                                } else {
                                    tr.append($('<td>').html(`<img src="${assetBaseUrl}${row.image ?? ''}" style="width:150px;height:150px">`));
                                }
                                tr.append($('<td>').html(`<a href="javascript:void(0)" class="btn btn-warning delete-visa-document" data-id="${row.id}"><i class="fa-solid fa-trash"></i></a>`));
                                tableBody.append(tr);
                            });
                        }
                    }
                });
            }
            get_visa_document();
            $(document).on('click.workspaceJourney', '.delete-visa-document', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('delete-visa-document-three') }}',
                            type: 'GET',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Document has been deleted.',
                                        'success'
                                    );
                                    get_visa_document();
                                }
                            }
                        });
                    }
                })
            });
        });

        
    </script>

    <script>


$(document).ready(function() {

    $('#university_details_status').change(function() {
        var universityId = $(this).val(); // Get the selected university ID
        var sbaId = $('#sba_idd').val(); // Get the value of the hidden input field

        if (universityId) {
            // AJAX request to fetch the courses for the selected university
            $.ajax({
             
                url: '{{ route('getCourses') }}',
                method: 'GET',
                data: { university_id: universityId ,
                    sba_id: sbaId
                },
                success: function(data) {
                    // Clear the previous courses
                    $('#course_details_status').html('<option value="">--Select--</option>');
                    
                    // Populate the course dropdown with new data
                    if (data.courses.length > 0) {
                        $.each(data.courses, function(index, course) {
                            $('#course_details_status').append(
                                `<option value="${course.id}">${course.name}</option>`
                            );
                        });
                    } else {
                        $('#course_details_status').html('<option value="">No courses available</option>');
                    }
                },
                error: function() {
                    // Handle error case
                    alert("Error fetching courses. Please try again.");
                }
            });
        } else {
            // Clear the course dropdown if no university is selected
            $('#course_details_status').html('<option value="">--Select--</option>');
        }
    });
});

    </script>
