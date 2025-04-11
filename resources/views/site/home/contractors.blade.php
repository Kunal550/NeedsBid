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
                        <h1 class="inner-heading-text1 small-heading wow bounceInRight">Find Contracters</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="common-padding1">
    <div class="container">
        <div class="search-inner-main-one">
        <form action="{{ route('contractors') }}" id="searchBtn" method="get">
            <div class="search-section-main">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="inner-search-one">
                            <input type="text" name="contractor_search" @if (request('contractor_search')) value="{{ request('contractor_search') }}" @endif class="search-section-main1" placeholder="Search For Contracters" />
                            @if (request('contractor_search')) <a href="{{ route('contractors') }}" class="btn btn-danger reset-btn">x</a>  @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="search-button search-button-inner" ><i class="fa fa-search" aria-hidden="true"></i></button>
                        
                    </div>
                </div>
            </div>
            </form>

            <div class="location-section pt-5">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text1" placeholder="Location" class="location-1" />
                    </div>
                    <div class="col-sm-3 ">
                        <div class="range-silder-bg">
                            <span class="rating-text4"> <img src="{{ asset('public/uploads/images/rating-icon4.svg')}}" alt="" /> Rating</span>
                            <input type="range" min="1" class="rangr-slider1" id="myRange" max="100" value="50">
                            <span id="demo"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="find-contract-main common-padding">
    <div class="container">
        <div class="row">
            <form action="" id="filter-form" class="col-sm-4" method="get">
                <div class="find-contractleft">
                    <div class="find-contract-card tractor_trade">
                        <h2 class="find-heading-card">Contracters Trade</h2>
                        <ul>
                            @foreach($contractors as $contractor)
                            <li><input type='checkbox' name="contractor[]" value="{{ $contractor->slug }}" {{ (isset($_GET['contractor']) && in_array($contractor->slug, $_GET['contractor'])) ? 'checked' : '' }} /> {{ $contractor->name }}</li>
                            @endforeach
                        </ul>
                        <div class="show-all"><a href="#">Show All <img src="{{ asset('public/uploads/images/arrow-aright1.svg')}}" alt="" /></a> </div>
                    </div>
                    <div class="find-contract-card project_category_type">
                        <h2 class="find-heading-card">Project Types</h2>
                        <ul>
                            @foreach($project_categories as $project_category)
                            <li><input type='checkbox' name="project_category[]" value="{{ $project_category->slug }}" {{ (isset($_GET['project_category']) && in_array($project_category->slug, $_GET['project_category'])) ? 'checked' : '' }} /> {{ $project_category->name }}</li>
                            @endforeach

                        </ul>
                        <div class="show-all"><a href="#">Show All <img src="{{ asset('public/uploads/images/arrow-aright1.svg')}}" alt="" /></a> </div>
                    </div>
                    <div class="find-contract-card constructor_types">
                        <h2 class="find-heading-card">Construction Types</h2>
                        <ul>
                            @foreach($constructors as $constructor)
                            <li><input type='checkbox' name="constructor_type[]" value="{{ $constructor->slug }}" {{ (isset($_GET['constructor']) && in_array($constructor->slug, $_GET['constructor'])) ? 'checked' : '' }} /> {{ $constructor->name }}</li>
                            @endforeach

                        </ul>
                        <div class="show-all"><a href="#">Show All <img src="{{ asset('public/uploads/images/arrow-aright1.svg')}}" alt="" /></a> </div>
                    </div>
                </div>
            </form>
            @if (!empty($projects[0]))
            <div class="col-sm-8 business-right-part1">
                @foreach ($projects as $project)
                <div class="business-mid-section1">
                    <div class="business-mid-section1-profile-left">
                        <img src="{{ asset('public/uploads/images/business-pro-img.png')}}" alt="" />
                    </div>
                    <div class="business-mid-section1-profile-right">
                        <div class="top-section-one">
                            <h2>{{$project->title}}</h2>
                            <div class="star_rating">
                            <div class="star-img">
                                <img src="{{ asset('public/uploads/images/star-icon4.svg')}}" alt="" />
                                <img src="{{ asset('public/uploads/images/star-icon4.svg')}}" alt="" />
                            </div>
                            <h5>3.00 ( 442 Reviews )</h5>
                            </div>
                            
                        </div>
                        <div class="mid-con-one">
                            <p>{!! $project->description !!}</p>
                        </div>
                        <div class="mid-con1">
                            <div class="row">
                                <div class="col-sm-4 cal-text1">
                                    <img src="{{ asset('public/uploads/images/location2-icon.svg')}}" alt="" /> {{$project->stateName}}
                                </div>
                                <div class="col-sm-8 cal-text1">
                                    <img src="{{ asset('public/uploads/images/painting-icon1.svg')}}" alt="" /> {{$project->contractor_name}} 
                                </div>
                            </div>
                        </div>
                        <div class="show-all mt-1"><a href="#">View Portfolio <img src="{{ asset('public/uploads/images/arrow-aright1.svg')}}" alt=""></a> </div>
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

</div>

@endsection
@push('script')
<script>
    $(document).ready(function() {
        $(".tractor_trade").click(function(e) {
            $('#filter-form').submit();
        });
        $(".project_category_type").click(function(e) {
            $('#filter-form').submit();
        });
        $(".constructor_types").click(function(e) {
            $('#filter-form').submit();
        });

    });
</script>
@endpush