@extends('site.layout.commonLayout')
@section('content')

<section>
    <div class="banner-section banner inner-banner">
        <div class="">
            <div class="">
                <figure>
                    <img src="{{ asset('public/uploads/images/banner-img.jpeg')}}" alt="" />
                </figure>
                <div class="banner-contain">
                    <div class="bannerinner-contain">
                        <h1 class="inner-heading-text1 small-heading wow bounceInRight">Search Projects in United States</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="common-padding1">
    <div class="container">
        <div class="search-inner-main-one1">
            <div class="search-section-main iner-section-main">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="inner-search-one">
                            <input type="text" class="search-section-main1" placeholder="Search For Projects" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <input type="button" value="search" class="search-button search-button-inner" />
                    </div>
                </div>
                <div class="filter-section-main">
                    <ul>
                        <li class="d=flex">
                            <h5>Filter</h5>
                            <button class="filter-button1"><img src="{{ asset('public/uploads/images/filter-section1.svg')}}" alt="" /></button>
                        </li>
                        <li>
                            <input type="text1" placeholder="Enter a location" class="location-1">
                        </li>
                        <li>
                            <select class="select-one1">
                                <option>Building Use</option>
                                <option>Building Use 1</option>
                            </select>
                        </li>
                        <li>
                            <select class="select-one1">
                                <option>Trade Or Scope</option>
                                <option>Trade Or Scope 1</option>
                            </select>
                        </li>
                        <li>
                            <select class="select-one1">
                                <option>Sector</option>
                                <option>Sector 1</option>
                            </select>
                        </li>
                        <li>
                            <select class="select-one1">
                                <option>Project Stage</option>
                                <option>Project Stage 1</option>
                            </select>
                        </li>
                        <li>
                            <select class="select-one1">
                                <option>Value</option>
                                <option>Value 1</option>
                            </select>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="common-padding">
    <div class="container">
        @if (!empty($projects[0]))
        <div class="search-project-contain">
            @foreach ($projects as $project)
            <div class="project-contain-main1">
                <div class="project-name-date">
                    <h2 class="common-heading">{{$project->title}}</h2>
                    <p class="date-icon1"><img src="{{ asset('public/uploads/images/date-icon1.svg')}}" alt="" /> {{ \Carbon\Carbon::parse($project->updated_at)->format('F d, Y') }}</p>
                </div>
                <p class="lorem-text1">{!! $project->description !!}</p>
                <div class="location-one">
                    <div class="row">
                        <div class="col-sm-3 revert-text1">
                            Riverport, OH
                        </div>
                        <div class="col-sm-4 revert-text1">
                            Bidding: February 18, 2025
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 revert-text1">
                            Public - State
                        </div>
                        <div class="col-sm-4 revert-text1">
                            ${{$project->budget}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 revert-text1">
                            Transportation Terminals
                        </div>
                        <div class="col-sm-4 revert-text1">
                            GC Bidding
                        </div>
                    </div>
                </div>
                <div class="tag-contain">
                    <a href="#">tag</a>
                    <a href="#">tag</a>
                    <a href="#">tag</a>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="business-mid-section1 product-row ">
            <h3>No Project Available.</h3>
        </div>
        @endif
        <div class="pt-lg-4 list_pagination"> {{ $projects->links() }} </div>
    </div>
</div>

@endsection