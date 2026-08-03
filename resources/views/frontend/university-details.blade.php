
@extends('frontend.layouts.main')
@section('title', ($about_university->university_name ?? 'University') . ' | Overseas Education Lane')
@section('meta_description', 'Explore programs, courses and admission details at ' . ($about_university->university_name ?? '') . ' in ' . ($about_university->country->name ?? '') . '.')
@section('og_title', $about_university->university_name ?? 'University')
@section('og_description', Str::limit(strip_tags($about_university->details ?? ''), 160))
@section('og_image', $about_university->banner ? asset($about_university->banner) : asset('frontend/img/default-og.jpg'))
@php
$studyInUniversitySlugs = [
'country' => \Illuminate\Support\Str::slug($about_university->country->name ?? 'unknown'),
'university' => \Illuminate\Support\Str::slug($about_university->university_name) . '-' . $about_university->id,
];
@endphp
@section('canonical_url', route('study-in.university', $studyInUniversitySlugs))
@section('content')

@include('frontend.partials.breadcrumb', ['items' => [
['label' => 'Home', 'url' => url('/')],
['label' => $about_university->country->name ?? ''],
['label' => $about_university->university_name ?? ''],
]])

<style>
    .un-detail-nav-container {
        border-bottom: 2px solid #e9ecef;
        padding: 0 15px;
    }

    .un-nav-tabs .un-nav-link {
        color: #495057;
        border: none;
        padding: 12px 20px;
        margin-right: 5px;
        font-weight: 500;
        position: relative;
        border-radius: 4px;
        margin-bottom: 16px;
    }

    .un-nav-tabs .un-nav-link:hover {
        color: rgb(35, 35, 124);
        background-color: rgba(7, 7, 88, 0.05);
        color: #ffffff;
        border: none;
    }

    .un-nav-tabs .un-nav-link.active {
        color: #ffffff;
        background-color: #070758;
        border: none;
        font-weight: 500;
    }

    .un-nav-tabs .un-nav-link.active::after {
        display: none;
    }

    .un-detail-nav-wrapper {
        margin-bottom: 18px;
    }

    .un-nav-tabs {
        border-bottom: none;
        gap: 10px;
    }
</style>
<section>
    <div class="detail_hr_edu">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left_article bg-white">
                        <div class="ehl-logo">
                            <img src="{{asset($about_university->logo ?? null)}}" alt="logo">
                        </div>
                        <div class="left_heading_h">
                            <h2 class="fw-bold">{{$about_university->university_name ?? null}}</h2>
                        </div>
                        <div class="all_list_h">
                            <ul>
                                <li class="lectures-feature">
                                    <i class="fa fa-flag"></i>
                                    <span class="label mx-2">Country</span>
                                    <span class="value">{{$about_university->country->name ?? null}}</span>
                                </li>
                                <li class="quizzes-feature">
                                    <i class="fa fa-calendar"></i>
                                    <span class="label">Founded In</span>
                                    <span class="value">{{$about_university->founded_in ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-list-alt"></i>
                                    <span class="label">University Type</span>
                                    <span class="value">{{$about_university->university_type->name ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-users"></i>
                                    <span class="label">Total Students</span>
                                    <span class="value">{{$about_university->total_students ?? null}}+</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-phone"></i>
                                    <span class="label">Phone Number</span>
                                    <span class="value">+{{$about_university->phone_number ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-envelope"></i>
                                    <span class="label">Email</span>
                                    <span class="value">{{$about_university->email ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-map-marker"></i>
                                    <span class="label">ZIP Code</span>
                                    <span class="value">{{$about_university->zip ?? null}}</span>
                                </li>
                                <li class="duration-feature ">
                                    <i class="fa fa-globe"></i>
                                    <span class="label" style="font-size: 12px;">Website {{$about_university->website ?? null}}</span>
                                    <span class="value"></span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-arrows-alt"></i>
                                    <span class="label">Size of Campus</span>
                                    <span class="value">{{$about_university->size_of_campus ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-users"></i>
                                    <span class="label">Male Female Ratio</span>
                                    <span class="value">{{$about_university->male_female_ratio ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-users"></i>
                                    <span class="label">Faculty Student Ratio</span>
                                    <span class="value">{{$about_university->faculty_student_ratio ?? null}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--<div class="bg-white mt-4 cd-fg">-->

                    <!--    <div class="btn55 text-center p-2 rounded mt-3 mx-auto">-->
                    <!--        <button class="border-0 "><a href="" class="text-white">Login</a></button>-->
                    <!--    </div>-->

                    <!--</div>-->
                </div>


                <div class="col-lg-8">
                    <div class="tabing-tab">
                        <div class=" ">
                            <div class="cards">
                                <!-- <h2 class=" text-center p-3">Card with Tabs</h2> -->
                                <div class="un-detail-nav-wrapper ">
                                    <nav class="navbar ">

                                        <div class="nav nav-tabs un-nav-tabs g-3" id="nav-tab" role="tablist">
                                            <button class="nav-link un-nav-link {{ !isset($_GET['tab']) ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                                            <button class="nav-link un-nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                                                role="tab" aria-controls="nav-profile" aria-selected="false">Programs</button>
                                            <button class="nav-link un-nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button"
                                                role="tab" aria-controls="nav-contact" aria-selected="false">Gallery</button>
                                            <button class="nav-link un-nav-link" id="nav-contacts-tabs" data-bs-toggle="tab" data-bs-target="#nav-contacts" type="button"
                                                role="tab" aria-controls="nav-contacts" aria-selected="false">Ranking</button>
                                            <button class="nav-link un-nav-link" id="nav-notes-tabs" data-bs-toggle="tab" data-bs-target="#nav-notes" type="button"
                                                role="tab" aria-controls="nav-notes" aria-selected="false">Accommodation</button>
                                            <button class="nav-link un-nav-link" id="nav-tabing-tabs" data-bs-toggle="tab" data-bs-target="#nav-tabing" type="button"
                                                role="tab" aria-controls="nav-tabing" aria-selected="false">Accreditation</button>
                                            <button class="nav-link un-nav-link" id="nav-place-tabs" data-bs-toggle="tab" data-bs-target="#nav-place" type="button"
                                                role="tab" aria-controls="nav-place" aria-selected="false">Placement</button>
                                            <button class="nav-link un-nav-link" id="nav-con-tabs" data-bs-toggle="tab" data-bs-target="#nav-con" type="button"
                                                role="tab" aria-controls="nav-con" aria-selected="false">Notes</button>
                                        </div>
                                    </nav>
                                </div>

                                <div class="tab-content " id="nav-tabContent">
                                    <div class=" tab-pane fade {{ !isset($_GET['tab']) || $_GET['tab'] === 'home' ? 'active show' : '' }}" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <div class="ehl-heading card">
                                            <div class="text-ehl-title">
                                                <h1>Home</h1>
                                                <P>{!! $about_university->details ?? 'No university information available' !!}</P>
                                            </div>
                                        </div>

                                        <div class="ehl-heading mt-3 card">
                                            <div class="text-ehl-title ">
                                                <h3>Location</h3>
                                                <p><i class="fa fa-map-marker fa-2x" style="font-size: 18px;"></i>
                                                    &nbsp; {{$about_university->country->name ?? 'Unknown'}}, {{$about_university->province->name ?? 'Unknown'}}, {{$about_university->city ?? 'Unknown'}}, {{$about_university->zip ?? 'Unknown'}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="tab-content" id="myTabContentLocation">
                                                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="map-tab">

                                                        @php
                                                        // Safe value
                                                        $map = $about_university->map_location ?? '';

                                                        $src_data = $map; // default

                                                        if ($map) {
                                                        // extract src="..."
                                                        $parts = explode('src="', $map);

                                                        if (count($parts) > 1) {
                                                        $urlParts = explode('"', $parts[1]);
                                                        $src_data = $urlParts[0] ?? $map;
                                                        }
                                                        }
                                                        @endphp

                                                        @if ($src_data)
                                                        <iframe src="{{ $src_data }}" width="100%" height="400" style="border:0;" allowfullscreen></iframe>
                                                        @else
                                                        <p class="text-danger">Map location not available.</p>
                                                        @endif

                                                    </div>

                                                    <div class="tab-pane fade" id="street" role="tabpanel" aria-labelledby="street-tab">
                                                        ...
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['tab']) && $_GET['tab'] === 'programs' ? 'active show' : '' }}" id="nav-profile" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <div class="ehl-heading bg-white p-3 border border-primary-subtle">
                                            <div class="text-ehl-title mb-md-3">
                                                <h1>Programs</h1>
                                            </div>
                                            <form
                                                action="{{ route('study-in.university', ['country' => \Illuminate\Support\Str::slug($about_university->country->name ?? 'unknown'), 'university' => \Illuminate\Support\Str::slug($about_university->university_name) . '-' . $about_university->id]) }}"
                                                method="get" class="input-group col-md-12">
                                                <input type="hidden" name="tab" value="programs">
                                                <input name="program_name" class="col-md-12 form-control py-2"
                                                    type="search" id="example-search-input" value=""
                                                    placeholder="Search Degree, Program or Courses">
                                                <span class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </form>
                                        </div>
                                        <div class="ehl-heading  mt-3">
                                            <div class="text-ehl-title">
                                                <h2 class="fw-bold ps-md-4">All Courses Offered</h2>
                                            </div>
                                            @forelse ($program as $item )
                                            <div class="card">
                                                <div class="secong-ehl-text d-flex justify-content-between gap-2 align-items">
                                                    <div class="ehl-heading-title-txt-int">
                                                        <img src="{{asset($item->university_name->logo)}}" alt="logo">
                                                    </div>
                                                    <div class="right-rect">
                                                        <h3>{{$item->name}}</h3>
                                                        <P>{{$item->university_name->university_name ?? null}}</P>
                                                    </div>
                                                </div>
                                                <div class="content-part mt-3">
                                                    <ul class="meta-part">
                                                        <li class="user"><i class="fa fa-graduation-cap"></i> <span
                                                                class="info_bold">Level</span> <span>{{$item->programLevel->name ?? null}}</span>
                                                        </li>
                                                        <li class="user"><i class="fa fa-clock-o"></i> <span
                                                                class="info_bold">Duration</span> <span>{{ $item->length }}
                                                                Months</span></li>
                                                        <li class="user"><i class="fa fa-money"></i> <span
                                                                class="info_bold">Application Fees</span>
                                                            <span>{{ $item->application_fee }}</span>
                                                        </li>
                                                        <li class="user">
                                                            <i class="fa fa-money"></i> <span class="info_bold">1st Year
                                                                Tuition Fees</span> <!----> <span>{{ $item->currency }}
                                                                {{ $item->tution_fee }}</span>
                                                        </li>
                                                        <li class="user"><i class="fa fa-info-circle"></i> <span
                                                                class="info_bold">Exams Required</span> <span><span
                                                                    class="exam_type_item">{{ $item->test_required }}</span></span></li>
                                                    </ul>
                                                    <p class="mb-0" style="font-size: 13px;">fees may vary according to
                                                        university current structure and policy</p>
                                                    <div class="bottom-part">
                                                        <div class="info-meta">
                                                            <ul>
                                                                <li class="user"><i class="fa fa-flag"></i>
                                                                    @php
                                                                    $country=\App\Models\Country::where('id',$item->university_name->country_id ?? null)->first();
                                                                    @endphp
                                                                    <span>{{$country->name ?? null}}</span> <span>-</span>
                                                                    <span>{{ $item->programType }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="btn-part"><a
                                                                href="{{ route('study-in.program', ['country' => \Illuminate\Support\Str::slug($country->name ?? 'unknown'), 'university' => \Illuminate\Support\Str::slug($item->university_name->university_name ?? 'unknown') . '-' . ($item->university_name->id ?? 0), 'program' => \Illuminate\Support\Str::slug($item->name) . '-' . $item->id]) }}"
                                                                class="btn btn-primary">View Details<i
                                                                    class="flaticon-right-arrow"></i></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="nav-contact" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <div class="ehl-heading card">
                                            <div class="text-ehl-title mb-4">
                                                <h1>Gallery</h1>
                                            </div>
                                            @php
                                            $images= DB::table('university_galary_images')->where('university_id',$about_university->id)->get();
                                            @endphp
                                            @foreach ($images as $image)
                                            <div class="gallery-title">
                                                <img src="{{ asset($image->file_name) }}" alt="logo-image">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contacts" role="tabpanel"
                                        aria-labelledby="nav-contacts-tabs">
                                        <div class="tab-f bg-white p-4">
                                            <div class="head-4 mb-3">
                                                <h3 class="">Ranking</h3>
                                            </div>
                                            <div class="table-cl">

                                                <table class="mb-5">
                                                    <tr>
                                                        <th scope="col">
                                                            Ranking</th>
                                                        <th scope="col">Form</th>
                                                        <th scope="col">
                                                            Year</th>
                                                        <th scope="col">Type</th>
                                                    </tr>
                                                    @php
                                                    $university_rankings= DB::table('university_ranking')->where('university_id',$about_university->id)->get();
                                                    @endphp
                                                    @foreach ($university_rankings as $ranking)
                                                    <tr>
                                                        <td>{{ $ranking->ranking }}</td>
                                                        <td>{{ $ranking->from_place }}</td>
                                                        <td>{{ $ranking->year }}</td>
                                                        <td>{{ $ranking->type }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($about_university->accomodation))
                                    <div class="tab-pane fade" id="nav-notes" role="tabpanel"
                                        aria-labelledby="nav-notes-tabs">
                                        <div class="accomadation">
                                            <div class="head-4 mb-3">
                                                <h3>Accommodation</h3>
                                                {!! $about_university->accomodation_details !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if (!empty($university_accerediations))
                                    <div class="tab-pane fade" id="nav-tabing" role="tabpanel"
                                        aria-labelledby="nav-tabing-tabs">
                                        @foreach ($university_accerediations as $accreditation)
                                        <div class="accomadation">
                                            <div class="head-4s mb-3">
                                                <h3>{{ $accreditation->name }}</h3>
                                            </div>
                                            <div class="gt-text">
                                                <img src="{{ asset($accreditation->logo) }}" alt="logo">
                                                <span>{{ $accreditation->year }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if (!empty($about_university->placement))
                                    <div class="tab-pane fade" id="nav-place" role="tabpanel"
                                        aria-labelledby="nav-place-tabs">
                                        <div class="accomadation">
                                            <div class="head-4 mb-3">
                                                <h3>Placement</h3>
                                                {!! $about_university->placement !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="tab-pane fade" id="nav-con" role="tabpanel"
                                        aria-labelledby="nav-con-tabs">
                                        <div class="accomadation">
                                            <div class="head-4 mb-3">
                                                <h3>Notes</h3>
                                                {!! $about_university->notes !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection