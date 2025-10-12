@extends('layouts.app')

@section("title", "Dashboard")

@section("breadcrumb")
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="#"
            class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Dashboard</li>
</ul>
@endsection

@section("content")
<div class="row gy-5 g-xl-8">
    <div class="col-xxl-12">
        <div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover"
            style="background-color: #663259;background-size: auto 100%; background-image: url(assets/media/patterns/taieri.svg)">
            <div class="card-body container-xxl pt-10 pb-8">
                <div class="d-flex align-items-center">
                    <h1 class="fw-bold me-3 text-white">Welcome Back Admin !</h1>
                    <span class="fw-bold text-white opacity-50">Laundry Admin App</span>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-lg-flex align-lg-items-center flex-column">
                        <div
                            class="rounded d-flex flex-column flex-lg-row align-items-lg-center bg-white p-5 w-xxl-750px h-lg-60px me-lg-10 my-5">
                            <div class="row flex-grow-1 mb-5 mb-lg-0">
                                <div class="col-lg-12 d-flex align-items-center mb-3 mb-lg-0">
                                    <span class="svg-icon svg-icon-1 svg-icon-gray-400 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                fill="black" />
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <input type="text" id="search_input" class="form-control form-control-flush flex-grow-1"
                                        name="search" value="" placeholder="Search Menu" autocomplete="off" />
                                </div>
                            </div>
                            <div class="min-w-150px text-end">
                                <button type="submit" class="btn btn-dark" onclick="searchButtonTrigger()"
                                    id="kt_advanced_search_button_1">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>		
@endsection