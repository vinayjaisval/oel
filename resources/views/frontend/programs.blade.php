@extends('frontend.layouts.main')
@section('title', 'Programs')
@section('content')
<style>
    .program_title_honors {
        height: 100% !important;
    }
    /* Mobile-friendly filter section */
    .search_dropdown {
        flex-wrap: wrap;
        gap: 10px;
    }
    .search_dropdown select,
    .search_dropdown .serch_btn {
        min-width: 200px;
        flex: 1;
    }
    @media (max-width: 768px) {
        .search_dropdown {
            flex-direction: column;
            align-items: stretch;
        }
    }

    /* Select2 Custom Styling */
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
        min-height: 38px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

<section>
    <div class="university_title">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold">Find your Program</h1>
                </div>
                <form action="{{ route('programs') }}" method="get" id="filter_form">
                    <div class="row g-2 mt-4">
                        <!-- Country Dropdown (Static) -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <select id="country_search" name="country" class="form-control">
                                <option value="">--Select Country--</option>
                                @foreach(\App\Models\Country::where('is_active', 1)->select('id','name')->get() as $c) 
                                <option value="{{ \Illuminate\Support\Str::slug($c->name).'-'.$c->id }}">
                                    {{ $c->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- University Dropdown (Dynamic AJAX) -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <select id="university_search" name="university" class="form-control">
                                <option value="">Search University...</option>
                            </select>
                        </div>

                        <!-- Program Dropdown (Dynamic AJAX) -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <select id="program_search" name="program" class="form-control">
                                <option value="">Search Program...</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <button type="submit" class="serch_btn w-100 border-0 text-white rounded px-4 py-2" style="background:#007bff;">
                                Search
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<section>
    <div class="program_title my-5">
        <div class="container">
            <div class="row h-100 gy-4" id="program-data"></div>
            <div class="ajax-load text-center" style="display:none">
                <i class="fa fa-spinner fa-spin"></i> Loading ...
            </div>
            <div class="no-data text-center mb-4" style="display:none">
                <b>No data - last page</b>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript_section')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    
    // ==========================================
    // Helper Functions
    // ==========================================
    
  function getParams() {
    return $('#filter_form').serialize();
}

    function renderPrograms(data) {
        let assetBaseUrl = "{{ asset('') }}/";
        return data.map(item => `
            <div class="col-lg-4 col-md-6 col-12">
                <div class="program_title_honors p-3 border rounded">
                    <div class="main_ors_title d-flex gap-3">
                        <div class="foundation_ttile">
                            <img src="${assetBaseUrl}${item.university_name?.logo || ''}" alt="logo" style="max-width:60px;">
                        </div>
                        <div class="low_title fw-bold">
                            <a href="{{ url('/') }}/study-in-${slugify(item.university_name?.country_name?.name)}/${slugify(item.university_name?.university_name)}-${item.university_name?.id ?? 0}/${slugify(item.name)}-${item.id}"
                            style="text-decoration: none; color: inherit;">

                                <h2 class="fw-bold">
                                    ${item.name}
                                </h2>
                            </a>
                            <span class="fw-medium">${item.university_name?.university_name || ''}</span>
                        </div>
                    </div>
                    <div class="fees_structure mt-4">
                        <ul>
                            <li>Level: ${item.program_level?.name || 'N/A'}</li>
                            <li>Duration: ${item.length} month</li>
                            <li>Application Fees: ${item.application_fee}</li>
                            <li>1st Year Tuition Fees: ${item.currency} ${item.tution_fee}</li>
                            <li>Exams Required: ${item.university_name?.testrequired || 'N/A'}</li>
                        </ul>
                    </div>
                    <hr>
                    <p class="small">Fees may vary according to university current structure and policy</p>
                    <hr>
                    <div class="uni_king">
                        <span>${item.university_name?.country_name?.name || ''} - ${item.programType || ''}</span>
                        <div class="deatils_view mt-2">
                            <a href="{{ url('/') }}/study-in-${slugify(item.university_name?.country_name?.name)}/${slugify(item.university_name?.university_name)}-${item.university_name?.id ?? 0}/${slugify(item.name)}-${item.id}" class="btn btn-sm btn-outline-primary">View Details</a>
                      
                            </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

   function loadData(page) {
    $.ajax({
        url: "{{ route('programs') }}",
        type: "GET",
        data: $('#filter_form').serialize() + '&page=' + page,
        beforeSend: function () {
            $('.ajax-load').show();
        },
        success: function (response) {
            $('.ajax-load').hide();

            if (response.data.data.length === 0) {
                $('.no-data').show();
                return;
            }

            $('#program-data').append(renderPrograms(response.data.data));
        },
        error: function () {
            $('.ajax-load').hide();
        }
    });
}

    // ==========================================
    // Initial Load
    // ==========================================
    
    loadData(1);

    // ==========================================
    // Infinite Scroll
    // ==========================================
    
    let page = 2, loading = false;
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 1000 && !loading) {
            loading = true;
            loadData(page++);
            setTimeout(() => loading = false, 500);
        }
    });

    // ==========================================
    // Select2 Initialization
    // ==========================================

    // Country Dropdown (Static)
    $("#country_search").select2({
        placeholder: "Select Country",
        allowClear: true,
        width: '100%'
    });

    // University Dropdown (AJAX Dynamic Search)
    $("#university_search").select2({
        placeholder: "Search University",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "{{ route('ajax.universities') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,      // e.g., "oxford-5"
                        text: item.text   // e.g., "Oxford University"
                    }))
                };
            },
            cache: true
        }
    });

    // Program Dropdown (AJAX Dynamic Search)
    $("#program_search").select2({
        placeholder: "Search Program",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "{{ route('ajax.programs') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,      // e.g., "bs-computer-science-12"
                        text: item.text   // e.g., "BS Computer Science"
                    }))
                };
            },
            cache: true
        }
    });

    // ==========================================
    // Form Submission
    // ==========================================

    $('#filter_form').on('submit', function (e) {
        e.preventDefault();
        
        // Reset page number for new search
        page = 1;
        $('#program-data').html('');
        $('.no-data').hide();
        
        // Load data with new filters
        loadData(1);
    });

    // ==========================================
    // Debug: Log selected values (Optional)
    // ==========================================

    $('#country_search, #university_search, #program_search').on('change', function () {
        console.log('Country:', $('#country_search').val());
        console.log('University:', $('#university_search').val());
        console.log('Program:', $('#program_search').val());
    });
});
</script>
@endsection