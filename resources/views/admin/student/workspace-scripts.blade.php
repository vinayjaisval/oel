@section('scripts')
<script defer src="{{ asset('assets/js/oel360-workspace.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script>
    $('#paymentMode').on('change', function() {
        var selectedValue = $(this).val();
        if (selectedValue === 'Cash' || selectedValue === 'Cheque') {
            $('.paymentModeRemarks').show();
            $('.bank-details').hide();
            $('.submit-amount').show();
            $('.payment-button').hide();
        } else if (selectedValue === 'Bank') {
            $('.bank-details').show();
            $('.paymentModeRemarks').hide();
            $('.submit-amount').show();
            $('.payment-button').hide();
        } else {
            $('.paymentModeRemarks').hide();
            $('.bank-details').hide();
            $('.submit-amount').hide();
            $('.payment-button').show();
        }
    });

    function discountField() {
        if ($("#is_discount").val() == "1") {
            $(".discount-field").show();
        } else {
            $(".discount-field").hide();
        }
    }

    

    function getSubService(master_service_id) {
        $.ajax({
            url: "{{route('get-sub-service')}}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "master_service_id": master_service_id
            },
            success: function(response) {
                const hiddenSelect = $('#usr-sub_service');
                const optionsList = $('#sub-service-options');

                hiddenSelect.empty();
                optionsList.empty();

                if (response.subservice?.length > 0) {
                    response.subservice.forEach(function(item) {
                        const option = new Option(item.name, item.id);
                        hiddenSelect.append(option);

                        const optionItem = `
                        <div class="option-item" data-value="${item.id}" data-name="${item.name}">
                        ${item.name}
                        </div>
                        `;
                        optionsList.append(optionItem);
                    });
                } else {
                    optionsList.append('<div class="p-2">No records found</div>');
                    $('#usr-amount').val('');
                }

                if (master_service_id === "2") {
                    $('#usr-amount').val($('#application_fee').val());
                    return false;
                }

                $('#usr-amount').val(response.amount);
                updateSelectedDisplay();
            },
            error: function(xhr) {
                console.log(xhr);
                $('#sub-service-options').html('<div class="p-2">Error loading services</div>');
            }
        });
    }

    function updateSelectedDisplay() {
        const selectedContainer = $('.selected-options-payy');
        selectedContainer.empty();

        $('.options-list1 .option-item.selected').each(function() {
            const value = $(this).data('value');
            const name = $(this).data('name');
            selectedContainer.append(`
                  <span class="badge" data-value="${value}">
                  ${name}
                  <i class="fas fa-times" onclick="removeSelection('${value}')"></i>
                  </span>
                `);
        });

        updateHiddenSelect();
    }

    function removeSelection(value) {
        $(`.options-list1 .option-item[data-value="${value}"]`).removeClass('selected');
        updateSelectedDisplay();
    }

    function updateHiddenSelect() {
        const selectedValues = $('.options-list1 .option-item.selected').map(function() {
            return $(this).data('value');
        }).get();

        $('#usr-sub_service').val(selectedValues).trigger('change');
    }

    $(document).ready(function() {
        $('#sub-service-input').on('click', function() {
            $(this).closest('.custom-dropdown').find('.menu').toggleClass('show');
        });

        $(document).on('click', '.option-item', function() {
            $(this).toggleClass('selected');
            updateSelectedDisplay();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.custom-dropdown').length) {
                $('.menu').removeClass('show');
            }
        });
    });


    function getappfee(pro_id) {
        $.ajax({
            url: "{{route('get-app-fee')}}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "pro_id": pro_id
            },
            success: function(response) {
                $('#usr-amount').val(response.application_fee);
                $('#application_fee').val(response.application_fee);
            },
            error: function(xhr, status, error) {
                console.log(xhr);
            }
        });
    }

    $(document).ready(function() {
        function setupCSRF() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        $('.btnDiv').on('click', function(event) {
            $('.btnDiv').addClass('disabled');
            var spinner = this.querySelector('.spinner-grow');
            spinner.classList.remove('d-none');
            var formData = $('#score-data').serialize();
            setupCSRF();
            $.ajax({
                url: `{{ route('send-payment-link') }}`,
                type: 'post',
                data: formData,
                success: function(response) {
                    spinner.classList.add('d-none');
                    if (response.status) {
                        fetchscore(response.student_id);
                        Swal.fire(
                            'Success!',
                            'Payment link sent successfully',
                            'success'
                        );
                        setTimeout(() => {
                            // location.reload();
                        }, 1000);
                    }
                    $('.btnDiv').removeClass('disabled');
                    $('#score-data')[0].reset();
                },
                error: function(xhr) {
                    $('.btnDiv').removeClass('disabled');
                    spinner.classList.add('d-none');
                    var response = JSON.parse(xhr.responseText);
                    console.log(response);
                    if (!(response.status)) {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                }
            });
        });
        
        $('.payment_model').on('click', function() {
            var student_id = $(this).attr('student-id');
            $('#student_second_id').val(student_id);
            $('input[name="student_id"]').val(student_id);
            fetchscore(student_id);
        });

        function fetchscore(student_id) {
            $('.score-table').empty();
            setupCSRF();
            $.ajax({
                url: "{{ route('fetch-student-payment') }}",
                method: 'get',
                data: {
                    student_id: student_id
                },
                success: function(response) {
                    console.log(response.program_applied);
                    var score = response.payment_data;
                    var fee = response.program_applied;
                    if ($.isEmptyObject(response)) {
                        $('.score-table').append('<option value="">No records found</option>');
                    } else {
                        $.each(score, function(key, value) {
                            key++;
                            $('.score-table').append('<tr><td>' +
                                key + '</td><td>' +
                                (value.master_service ? value.master_service.name : '') + '</td><td>' +
                                value.amount + '</td><td>' +
                                value.remarks + '</td><td class="text-center  view-payment"  data-id="' + value.id + '" user-id="' + value.user_id + '"><i class="la la-eye btn btn-secondary"></i> </td> <td><a href="#" class="btn btn-sm btn-danger delete-score" data-id="' + value.id + '"><i class="la la-trash"></i></a></td></tr>');
                        });
                    }
                    // if (response.program_applied != null) {
                    //     $('#selected_program').empty();
                    //     $('#selected_program').append(`<option value="">--Select Program -</option>`);
                    //     $.each(response.program_applied, function(index, item) {
                    //         $('#selected_program').append(`<option value="${item.program?.id}">${item.program?.name}</option>`);
                    //     });
                    // }

                    if (response.university != null) {
                        $('#selected_university').empty();
                        $('#selected_university').append(`<option value="">--Select University-</option>`);
                        $.each(response.university, function(index, item) {
                            $('#selected_university').append(`<option value="${item?.id}">${item?.university_name}</option>`);
                        });
                    }

                }
            }).then(function() {
                $('.delete-score').on('click', function(e) {
                    e.preventDefault();
                    var score_id = $(this).data('id');
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
                            setupCSRF();
                            $.ajax({
                                url: "{{ route('delete-payment-link') }}",
                                method: 'get',
                                data: {
                                    score_id: score_id
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Payment Deleted Successfully',
                                        showConfirmButton: false,
                                        timer: 1000
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1100);
                                }
                            });
                        }
                    });
                });
            });
        }

        $(document).on('click', '.view-payment', function() {
            var student_id = $(this).attr('user-id');
            var payment_id = $(this).attr('data-id');
            console.log(student_id);
            console.log(payment_id);
            $('#paymentModal').modal('show');
            $.ajax({
                url: "{{ route('fetch-payment-details') }}",
                method: 'get',
                data: {
                    student_id: student_id,
                    payment_id: payment_id
                },
                success: function(response) {
                    $('#payment_table').empty();
                    $.each(response.about_payment, function(index, value) {
                        var table = `<tr>
                                            <td>${value.payment_link.master_service.name}</td>
                                            <td>${value.payment_link.program.name}</td>
                                            <td>${value.payment_link.currency} ${value.payment_link.amount}</td>
                                            <td>${value.payment_status}</td>
                                          </tr>`;
                        $('#payment_table').append(table);
                    });
                }
            });
        });
    });
</script>

<script>


        $("#selected_university").change(function() {
            // Get the student ID from an element with the class .student_second_id
            var student_id = $(".student_second_id").val();  
            
            // Ensure student_id is available
            if (!student_id) {
                alert("Student ID is not available.");
                return;  // Exit the function if student_id is missing
            }

            var selectedUniversityId = $(this).val();  // Get the selected university ID

            // Ensure university ID is selected
            if (!selectedUniversityId) {
                alert("Please select a university.");
                return;  // Exit the function if no university is selected
            }


            // AJAX call to get program data
            $.ajax({
                url: "{{ route('get-program') }}",
                method: 'get',
                data: {
                    selectedUniversityId: selectedUniversityId,
                    student_id: student_id  // Send student_id in the request
                },
                success: function(response) {
                    // console.log(response.program_appliedd);  // Log the response to check the data

                    if (response.program_appliedd != null && response.program_appliedd.length > 0) {
                        // Clear the existing program options
                        $('#selected_program').empty();

                        // Add a default option
                        $('#selected_program').append(`<option value="">--Select Program--</option>`);

                        // Populate the program options dynamically
                        $.each(response.program_appliedd, function(index, item) {
                            console.log(item.program?.name);
                            $('#selected_program').append(`<option value="${item.program?.id}">${item.program?.name}</option>`);
                        });
                    } else {
                        // If no programs are available
                        $('#selected_program').empty();
                        $('#selected_program').append(`<option value="">No programs available</option>`);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error case
                    console.error("Error fetching program data:", error);
                    alert("An error occurred while fetching the programs. Please try again later.");
                }
            });
        });

</script>
@if($tab === 'journey' && $journeyData)
    @include('admin.leads.partials.journey-scripts', $journeyData)
@endif
@endsection
