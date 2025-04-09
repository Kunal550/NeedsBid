@extends('site.layout.commonLayout')
{{-- {{dd($productsDetails->product_to_images)}} --}}
<meta property="og:url" content="{{ route('product_details', $productsDetails->slug) }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $productsDetails->product_name }}" />
<meta property="og:description" content="{!! $productsDetails->desc !!}" />
@if (!empty($productsDetails->product_to_images))
    <meta property="og:image"
        content="{{ asset('public/uploads/product/' . $productsDetails->product_to_images[0]->Product_images) }}" />
    <meta property="og:site_name" content="Twitter">
    <meta name="twitter:card"
        content="{{ asset('public/uploads/product/' . $productsDetails->product_to_images[0]->Product_images) }}">
@else
    <meta property="og:image" content="{{ asset('public/uploads/product/noimg.png') }}" />
    <meta property="og:site_name" content="Twitter">
    <meta name="twitter:card" content="{{ asset('public/uploads/product/noimg.png') }}">
@endif


@push('style')
    <style>
        .error {
            color: red;
        }

        .req {
            color: red;
        }
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
@endpush
@section('content')
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}")
        </script>
    @endif
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif
    <main>


        <section class="sec-space product-details">
            <div class="container ">
                <ul class="product_pagination">
                    <li><a href="{{ route('/') }}">Home</a></li>
                    <li><a href="{{ route('our-product') }}">Products</a></li>
                    <li><a
                            href="{{ route('category-product', $productsDetails->product_to_sub_category->slug) }}">{{ ucwords($productsDetails->product_to_category->name) }}</a>
                    </li>
                    <li>{{ ucwords($productsDetails->product_name) }}</li>
                </ul>
                <div class="row">
                    <div class="col-lg-5 pr-lg-4">
                        <div id="big" class="owl-carousel owl-theme ">
                            @foreach ($productsDetails->product_to_images as $image)
                                <div class="item">
                                    <div class="img_producto_container" data-scale="1.6">
                                        <a data-fancybox="gallery" class="dslc-lightbox-image img_producto"
                                            href="{{ asset('public/uploads/product/' . $image->Product_images) }}"
                                            target="_self"
                                            style="background-image:url('{{ asset('public/uploads/product/' . $image->Product_images) }}')">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="thumbs" class="owl-carousel owl-theme">
                            @foreach ($productsDetails->product_to_images as $image)
                                <div class="item">
                                    <img src="{{ asset('public/uploads/product/' . $image->Product_images) }}"
                                        alt="" loading="lazy">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-7 pl-lg-5">
                        <div class="details-top">
                            <h6>{{ ucwords($productsDetails->product_to_category->name) }}</h6>
                            <h2>{{ ucwords($productsDetails->product_name) }}</h2>

                            @if (count($thickness) == 1)
                                <h6>Price</h6>
                                <h3 class="product-price">
                                    £{{ $productsDetails->product_low_price }}
                                </h3>
                            @else
                                <h6>Price Form</h6>
                                @if ($productsDetails->product_low_price)
                                    <h3 class="product-price">
                                        £{{ $productsDetails->product_low_price }}
                                        @php
                                            if (!empty($productsDetails->product_high_price)) {
                                                echo '- £' . $productsDetails->product_high_price;
                                            }
                                        @endphp


                                    </h3>
                                @else
                                    <h3 class="product-price">No Price Available </h3>
                                @endif
                            @endif
                            <ul>
                                <li>
                                    <h6>Available Finishes:</h6>
                                    @if (!empty($productsDetails->product_polish))
                                        @foreach ($productsDetails->product_polish as $polish)
                                            <span>{{ $polish->name }}</span>
                                        @endforeach
                                    @endif
                                </li>
                                <li>
                                    <h6>Available Thickness:</h6>
                                    @if (!empty($thickness))
                                        @foreach ($thickness as $thick)
                                            <span>{{ $thick['thickness'] }}mm</span>
                                        @endforeach
                                    @endif
                                </li>
                                <li>
                                    <h6>Color:</h6>
                                    <span>{{ ucwords($productsDetails->product_to_color->color_name) }}</span>
                                </li>
                            </ul>
                            <div class="d-flex flex-wrap dtls-btn">
                                <a href="#" class="btn btn-outline-primary mr-4 mb-3" onclick="openModal3()">Get A
                                    Quick Quote <i class="fa fa-info-circle"></i></a>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Get An
                                    In Depth-Estimate <i class="fa fa-info-circle"></i></a>
                            </div>
                        </div>
                        <ul class="nav nav-tabs dtls-tabnav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#tabs-1" role="tab">Descriptions</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tabs-2" role="tab">Additional information</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        {{-- {{dd($productsDetails)}} --}}
                        <div class="tab-content dtls-tab-content py-4">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h3>Description</h3>
                                <p>{!! $productsDetails->desc !!}</p>

                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <table class="table">

                                    <tbody>
                                        <tr>
                                            <td> <strong>Product Name</strong></td>
                                            <td> {{ ucwords($productsDetails->product_name) }}</td>
                                        </tr>
                                        <tr>
                                            <td> <strong>Category</strong></td>
                                            <td> {{ $productsDetails->product_to_category->name }}</td>
                                        </tr>
                                        <tr>
                                            <td> <strong>Brand Name</strong></td>
                                            <td> {{ ucwords($productsDetails->product_to_brand->brand_name) }}</td>
                                        </tr>
                                        <tr>
                                            <td> <strong>Color</strong></td>
                                            <td> {{ ucwords($productsDetails->product_to_color->color_name) }}</td>
                                        </tr>
                                        <tr>
                                            <td> <strong>Available Finishes</strong></td>
                                            <td>
                                                @foreach ($productsDetails->product_polish as $polish)
                                                    {{ $polish->name }}
                                                @endforeach
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> <strong>Available Thickness</strong></td>
                                            <td>
                                                @foreach ($thickness as $thick)
                                                    {{ $thick['thickness'] }}mm
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- SOCIAL ICON -->
        <div class="social-sec">
            <div class="container">
                <div class="sharethis-inline-share-buttons"></div>
            </div>
        </div>
        <!-- RELATED PRODUCT -->
        @if (!empty($relatedProducts[0]))
            <section class="related-product sec-space bg-gray">
                <div class="container">
                    <div class="text-center mb-lg-5">
                        <h2>Related Products</h2>
                    </div>
                    <div class="owl-carousel product-slider">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="item">
                                <div class="pbox">
                                    <figure class="pimg"><a href="{{ route('product_details', $relatedProduct->slug) }}">
                                            <img src="{{ asset('public/uploads/product/' . $relatedProduct->featured_images) }}"
                                                alt=""></a></figure>
                                    <div class="pcontent">
                                        <h3><a href="#">{{ $relatedProduct->product_name }} </a></h3>
                                        @if (!empty($relatedProduct->product_high_price))
                                            <h4>
                                                £{{ $relatedProduct->product_low_price }} -
                                                £{{ $relatedProduct->product_high_price }}
                                            </h4>
                                        @else
                                            £{{ $relatedProduct->product_low_price }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @else
            <div class="text-center mb-3">
                <h2>No Record Found</h2>
            </div>
        @endif
        <!-- BRANDS -->
        <section class="sec-space brand-sec">
            <div class="container">
                <div class="text-center">
                    <h2>Our Brands</h2>
                </div>
                <div class="owl-carousel brand-slider">
                    @foreach ($brands as $brand)
                        <div class="item">
                            <figure class="brand-icon">
                                <a href="{{ route('brand-wise-product', $brand->slug) }}">
                                    <img src="{{ asset('public/uploads/brand/' . $brand->brand_image) }}" alt="">
                                </a>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Product Details Modal START -->
        <div class="modal right fade detailsmodal" id="myModal2" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel2">Get An In Depth Estimate</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><img src="{{ asset('public/front_end/images/close-black.png') }}"
                                    alt=""></span></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('user_quotes_details') }}" id="quotation_details" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mdl-title border-bottom">
                                <h6>{{ $productsDetails->product_to_category->name }}</h6>
                                <h3>{{ $productsDetails->product_name }}</h3>
                            </div>
                            <input type="hidden" name="proDuct_name" id="proDuct_name"
                                value="{{ $productsDetails->product_name }}">
                            <input type="hidden" name="templatingPrice" id="templatingPrice"
                                value="{{ $productsDetails->templating_price }}">
                            <input type="hidden" name="proDuctId" id="proDuctId" value="{{ $productsDetails->id }}">
                            <input type="hidden" name="splashback_price" id="splashback_price" class="form-control"
                                value="{{ $productsDetails->splashback_price }}">
                            <input type="hidden" name="upstand_price" id="upstand_price" class="form-control"
                                value="{{ $productsDetails->upstand_price }}">
                            <input type="hidden" name="window_sill_price" id="window_sill_price" class="form-control"
                                value="{{ $productsDetails->window_sill_price }}">


                            <div class="choose-option">
                                <div class="form-row">
                                    <div class="col-md-5 form-group">
                                        <legend>Available Finishes:</legend>
                                        <select name="avaiilable_finishes" id="avaiilable_finishes" class="form-control">
                                            <option value="">Select Finishes</option>
                                            @foreach ($productsDetails->product_polish as $polish)
                                                <option value="{{ $polish->name }}">{{ $polish->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 form-group">
                                        <legend>Available Thickness:</legend>
                                        <select name="avaiilable_thickness" id="avaiilable_thickness"
                                            class="form-control avaiilable_thickness">
                                            <option value="">Select Thickness</option>
                                            @foreach ($thickness as $thick)
                                                <option value="{{ $thick['thickness'] }}"
                                                    data-value="{{ $thick['price'] }}">{{ $thick['thickness'] }} mm
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h2>Worktops</h2>
                            <p>The image below shows an example of a kitchen worktop layout. You have to measure the length
                                and
                                width of each piece in millimetres (mm).</p>
                            <table style="width: 100%;" id="WorkTop">
                                <thead>
                                    <tr>
                                        <th>Width (metres e.g. 3.0m)</th>
                                        <th>Length (metres e.g. 0.6m)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="worktop-row">
                                        <td><input type="text" value="0" name="worktop_width[]"
                                                id="worktop_width"
                                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                class="form-control worktop_input worktop_width"></td>
                                        <td><input type="text"
                                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                name="worktop_length[]" value="0"id="worktop_length"
                                                class="form-control worktop_input worktop_length"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="workTopAddmore mb-lg-4 mt-lg-2 add-div"><span>+</span> ADD MORE</a>

                            <h2>Upstands</h2>
                            <p>A vertical extension along the edge of a worktop, providing a protective barrier against
                                spills
                                and enhances the aesthetics of the space, adding a finished look to the worktop.
                                Additionally,
                                upstands contribute to maintaining hygiene by preventing the accumulation of dirt. Leave
                                blank
                                if not included. NOTE: Standard height is 100mm</p>
                            <table style="width: 100%;" class="mt-lg-3 mt-3" id="Upstand">
                                <thead>
                                    <tr>
                                        <th>Width (metres e.g. 3.0m)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="upstand-row">
                                        <td><input type="text" name="upstand_length[]"
                                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                value="0" class="form-control upstand_input"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="UpstandAddmore mb-lg-4 mt-lg-2 add-div"><span>+</span> ADD MORE</a>
                            <h2>Splashbacks</h2>
                            <p>A stone panel installed behind a hob or sink. Its purpose is to shield the wall from stains
                                and
                                allow easy maintenance. Additionally, you have the option to cover the entire wall from the
                                worktop to the top cabinets to create an aesthetic and cohesive look in your kitchen.
                                measure
                                your desired splashback height and length in mm. Leave boxes blank if splashbacks not
                                included.
                            </p>
                            <table style="width: 100%;" class="mt-3" id="Splashback">
                                <thead>
                                    <tr>
                                        <th>Width (metres e.g. 3.0m)</th>
                                        <th>Length (metres e.g. 0.6m)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="splashback-row">
                                        <td>
                                            <input type="text" value="0" name="splashback_width[]"
                                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                class="form-control splashback_input splashback_width">
                                        </td>
                                        <td>
                                            <input type="text" value="0"
                                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                name="splashback_length[]"
                                                class="form-control splashback_input splashback_length">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="splashBackAddmore mb-lg-4 mt-lg-2 add-div"><span>+</span> ADD
                                MORE</a>
                            <h2>Window sill</h2>
                            <p>A horizontal ledge located at the bottom of a window frame on the inside. It provides a
                                surface
                                for placing items and adds visual appeal to the window area. Measure the length and width of
                                your window ledge in mm and insert the measurements below. </p>
                            <p>Leave boxes blank if window sill not included</p>
                            <table style="width: 100%;" class="mt-lg-3 mt-3" id="WindowSil">
                                <thead>
                                    <tr>
                                        <th>Length (millimeter e.g. 3.0mm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="windowsil-row">
                                        <td><input type="text" value="0"
                                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                name="windowsil_length[]" class="form-control windowsil_input">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <a href="#" class="WindowSilAddmore mb-lg-4 mt-lg-2 add-div"><span>+</span> ADD MORE</a>
                            <h2>Polishing & cut-outs</h2>
                            <p>Choose desired options and quantities.</p>
                            <div class="qtyform mt-4 mb-3 mb-lg-4">
                                <div class="form-row">
                                    @foreach ($productsDetails->product_polish as $polish)
                                        <div class="col-md-4 mb-lg-4 mb-3">
                                            <h6 class="labelhead">{{ $polish->name }} <a href="#"
                                                    title="{{ $polish->name }} (£){{ $polish->price }}"><i
                                                        class="fa fa-question-circle" aria-hidden="true"></i></a></h6>
                                            <input type="number" name="polish_price[]" class="form-control">
                                            <input type="hidden" name="polish_id[]" class="form-control"
                                                value="{{ $polish->id }}">
                                            <input type="hidden" name="total_price[]" class="form-control"
                                                value="{{ $polish->price }}">
                                            <input type="hidden" name="polish_namee[]" class="form-control"
                                                value="{{ $polish->name }}">

                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="note-green mb-4 mb-lg-5 p-4 text-white">
                                <h2>Note :</h2>
                                <p>Due to external factors, the estimated price given may not be 100% accurate and may be
                                    subject to adjustment during the templating process. To ensure a more precise quotation,
                                    we
                                    recommend contacting our team at Marble Tops Ltd.They will gladly assist you and
                                    provide a
                                    free accurate pricing assessment based on the detailed specifications of your project.
                                </p>
                            </div>
                            @php
                                $user = Auth::user();
                            @endphp
                            <h2>Your Details</h2>
                            <p class="mb-2"><strong>Are you looking for worktops as a :</strong></p>

                            <div class="d-flex radio-flex mb-2">
                                <label class="radiobox">
                                    <input type="radio" name="user_type" id="user_type" value="personal"
                                        {{ (!empty($user->user_type) && $user->user_type == 'personal') || empty($user->user_type) ? 'checked' : 'disabled' }}>
                                    <span></span>
                                    Personal user
                                </label>
                                <label class="radiobox">
                                    <input type="radio" name="user_type" id="user_type" value="trader"
                                        {{ !empty($user->user_type) && $user->user_type == 'trader' ? 'checked' : (empty($user->user_type) ? '' : 'disabled') }}>
                                    <span></span>
                                    Trade user
                                </label>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="labelhead">Full Name <span class="req">*</span></h6>
                                    <input type="text" name="name" id="name"
                                        value="{{ !empty($user->name) ? $user->name : '' }}"
                                        class="form-control alphaonly" @if (!empty($user->name)) readonly @endif>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="labelhead">Business name <span class="req">*</span></h6>
                                    <input type="text" name="business_name" id="business_name"
                                        value="{{ !empty($user->business_name) ? $user->business_name : '' }}"
                                        class="form-control alphaonly" @if (!empty($user->business_name)) readonly @endif>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="labelhead">Email Address <span class="req">*</span></h6>
                                    <input type="email" name="email" id="email"
                                        value="{{ !empty($user->email) ? $user->email : '' }}" class="form-control"
                                        @if (!empty($user->email)) readonly @endif>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="labelhead">Telephone Number <span class="req">*</span></h6>
                                    <input type="text" name="phone" minlength="10" maxlength="15" id="phone"
                                        value="{{ !empty($user->phone) ? $user->phone : '' }}"
                                        class="form-control numbersOnly"
                                        @if (!empty($user->phone)) readonly @endif>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="labelhead">Your Post Code<span class="req">*</span></h6>
                                    <input type="text" name="post_code" id="post_code"
                                        value="{{ !empty($user->post_code) ? $user->post_code : '' }}"
                                        class="form-control numbersOnly"
                                        @if (!empty($user->post_code)) readonly @endif>
                                </div>
                                <div class="col-12 mb-2">
                                    <p><strong>Project Timescale:</strong></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="labelhead">Time</h6>
                                    <input type="text" name="time" id="time" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="labelhead">Additional Details</h6>
                                    <input type="text" name="additional_details" id="additional_details"
                                        class="form-control">
                                </div>
                                {{-- <div class="col-12">
                                    <p class="mb-2"><strong>Make Additional</strong></p>
                                    <label class="checkbox d-flex align-items-center">
                                        <input type="checkbox" name="kitchen_plan" id="kitchen_plan">
                                        <span></span>
                                        kitchen plan (optional)
                                    </label>
                                </div> --}}
                                <div class="col-md-9 col-lg-8 mb-3">
                                    <div class="file-upload">
                                        <div class="file-upload-select">
                                            <div class="file-select-name">Upload your kitchen plan</div>
                                            <a class="file-select-button"><img class="mr-2"
                                                    src="{{ asset('public/front_end/images/upload-icon.png') }}"
                                                    alt=""> Upload Now</a>
                                            <input type="file" name="kitchen_plan_upload" id="kitchen_plan_file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Submit Your Quote</button>
                            </div>
                        </form>

                    </div>

                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- Product Details Modal END -->
        <div class="modal fade" id="myModal3" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pageModalLabel">
                            Get A Quick Quote
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#pageModal').modal('hide');">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('submit-quick-quote-form') }}" method="post" enctype="multipart/form-data"
                        id="quickQuoteFprm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="">Name <span class="req">*</span></label>
                                        <input type="text" name="user_name" id="user_name" class="form-control"
                                            placeholder="Enter Name" />
                                        @if ($errors->has('user_name'))
                                            <span
                                                class="error"><small>{{ ucwords($errors->first('user_name')) }}</small></span>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Email <span class="req">*</span></label>
                                        <input type="email" name="user_email" id="user_email" class="form-control"
                                            placeholder="Enter Email" />
                                        @if ($errors->has('user_email'))
                                            <span
                                                class="error"><small>{{ ucwords($errors->first('user_email')) }}</small></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="">Phone <span class="req">*</span></label>
                                        <input type="text" name="user_phone" id="user_phone"
                                            class="form-control numbersOnly" minlength="10" maxlength="12"
                                            placeholder="Enter Phone" />
                                        @if ($errors->has('user_phone'))
                                            <span
                                                class="error"><small>{{ ucwords($errors->first('user_phone')) }}</small></span>
                                        @endif
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <label for="">Post Code</label>
                                        <input type="post_code" name="post_code" id="post_code" class="form-control"
                                            placeholder="Enter Post Code" />
                                        @if ($errors->has('post_code'))
                                            <span
                                                class="error"><small>{{ ucwords($errors->first('post_code')) }}</small></span>
                                        @endif
                                    </div> --}}
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <label for="">How Can We Help?</label>
                                        <textarea name="how_can_we_help" id="how_can_we_help" class="form-control"></textarea>
                                        @if ($errors->has('how_can_we_help'))
                                            <span
                                                class="error"><small>{{ ucwords($errors->first('how_can_we_help')) }}</small></span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                                onclick="$('#pageModal').modal('hide');">
                                Close
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    </section>
@endsection
@push('script')
    <script>
        function openModal3() {
            reset();
            $('#myModal3').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        }

        function reset() {
            $('#myModal3').find('#user_name').val('');
            $('#myModal3').find('#user_email').val('');
            $('#myModal3').find('#user_phone').val('');
            $('#myModal3').find('#how_can_we_help').val('');
        }
        $(document).ready(function() {
            var bigimage = $("#big");
            var thumbs = $("#thumbs");
            //var totalslides = 10;
            var syncedSecondary = true;

            bigimage
                .owlCarousel({
                    items: 1,
                    slideSpeed: 2000,
                    nav: true,
                    autoplay: false,
                    dots: false,
                    loop: true,
                    responsiveRefreshRate: 200,
                    navText: [
                        '<i class="fa fa-angle-left"></i>',
                        '<i class="fa fa-angle-right"></i>'
                    ]
                })
                .on("changed.owl.carousel", syncPosition);

            thumbs
                .on("initialized.owl.carousel", function() {
                    thumbs
                        .find(".owl-item")
                        .eq(0)
                        .addClass("current");
                })
                .owlCarousel({
                    items: 3,
                    dots: false,
                    nav: true,
                    margin: 20,
                    navText: [
                        '<i class="fa fa-angle-left"></i>',
                        '<i class="fa fa-angle-right"></i>'
                    ],
                    smartSpeed: 200,
                    slideSpeed: 500,
                    slideBy: 4,
                    responsiveRefreshRate: 100
                })
                .on("changed.owl.carousel", syncPosition2);

            function syncPosition(el) {
                var count = el.item.count - 1;
                var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

                if (current < 0) {
                    current = count;
                }
                if (current > count) {
                    current = 0;
                }
                thumbs
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(current)
                    .addClass("current");
                var onscreen = thumbs.find(".owl-item.active").length - 1;
                var start = thumbs
                    .find(".owl-item.active")
                    .first()
                    .index();
                var end = thumbs
                    .find(".owl-item.active")
                    .last()
                    .index();

                if (current > end) {
                    thumbs.data("owl.carousel").to(current, 100, true);
                }
                if (current < start) {
                    thumbs.data("owl.carousel").to(current - onscreen, 100, true);
                }
            }

            function syncPosition2(el) {
                if (syncedSecondary) {
                    var number = el.item.index;
                    bigimage.data("owl.carousel").to(number, 100, true);
                }
            }

            thumbs.on("click", ".owl-item", function(e) {
                e.preventDefault();
                var number = $(this).index();
                bigimage.data("owl.carousel").to(number, 300, true);
            });

            // $("#quotation_details").submit(function() {
            //     $('#myDiv').show();
            // });
        });

        // =============================
        $(".img_producto_container")
            // tile mouse actions
            .on("mouseover", function() {
                $(this)
                    .children(".img_producto")
                    .css({
                        transform: "scale(" + $(this).attr("data-scale") + ")"
                    });
            })
            .on("mouseout", function() {
                $(this)
                    .children(".img_producto")
                    .css({
                        transform: "scale(1)"
                    });
            })
            .on("mousemove", function(e) {
                $(this)
                    .children(".img_producto")
                    .css({
                        "transform-origin": ((e.pageX - $(this).offset().left) / $(this).width()) * 100 +
                            "% " +
                            ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +
                            "%"
                    });
            });
        /* =========================== */
        let fileInput = document.getElementById("kitchen_plan_file");
        let fileSelect = document.getElementsByClassName("file-upload-select")[0];
        fileSelect.onclick = function() {
            fileInput.click();
        }
        fileInput.onchange = function() {
            let filename = fileInput.files[0].name;
            let selectName = document.getElementsByClassName("file-select-name")[0];
            selectName.innerText = filename;
        }

        // $(document).ready(function() {
        //     $("#quotation_details").submit(function(e) {
        //         e.preventDefault();
        //         var total = 0;
        //         var totalWorktop = 0;
        //         var upstandTotal = 0;
        //         var splashbacktotal = 0;
        //         var windowsilTotal = 0;
        //         var option = $('#avaiilable_thickness option:selected').attr('data-value');
        //         // alert(option)
        //         var name = $("#name").val();
        //         var business_name = $("#business_name").val();
        //         var email = $("#email").val();
        //         var phone = $("#phone").val();
        //         var post_code = $("#post_code").val();
        //         var time = $("#time").val();
        //         var additional_details = $("#additional_details").val();
        //         var kitchen_plan_file = $("#kitchen_plan_file").val();
        //         var proDuct_name = $("#proDuct_name").val();
        //         var templatingPrice = $("#templatingPrice").val();
        //         var splashback_price = $("#splashback_price").val();
        //         var upstand_price = $("#upstand_price").val();
        //         var window_sill_price = $("#window_sill_price").val();
        //         var proDuctId = $("#proDuctId").val();

        //         $(".worktop-row").each(function() {
        //             var total_row = 0;
        //             var w = $(this).find(".worktop_width").val();
        //             var l = $(this).find(".worktop_length").val();
        //             total_row = w * l;
        //             total += total_row;
        //         });
        //         totalWorktop = total / 1000;
        //         getTotal = (totalWorktop / 1000).toFixed(1);
        //         WorkTopfinalprice = getTotal * option;

        //         $(".upstand-row").each(function() {
        //             var upstandlength = $(this).find(".upstand_input").val();
        //             upstandTotal += parseInt(upstandlength);
        //         });
        //         upstandgetTotal = (upstandTotal / 1000).toFixed(1);
        //         Upstandfinalprice = upstandgetTotal * upstand_price;
        //         $(".splashback-row").each(function() {
        //             var splashback_row = 0;
        //             var spwidth = $(this).find(".splashback_width").val();
        //             var splength = $(this).find(".splashback_length").val();
        //             splashback_row = spwidth * splength;
        //             splashbacktotal += splashback_row;
        //         });
        //         totalSplashBack = splashbacktotal / 1000;
        //         getTotal = (totalSplashBack / 1000).toFixed(1);
        //         SplashBackfinalprice = getTotal * splashback_price;

        //         $(".windowsil-row").each(function() {
        //             var windowwidth = $(this).find(".windowsil_input").val();
        //             windowsilTotal += parseInt(windowwidth);
        //         });
        //         getWindowTotal = (windowsilTotal / 1000).toFixed(1);
        //         WindowSilgetprice = getWindowTotal * window_sill_price;

        //         var formData = new FormData($('#quotation_details')[0]);
        //         alert(formData);
        //         formData.append('WorkTopfinalprice', WorkTopfinalprice);
        //         formData.append('Upstandfinalprice', Upstandfinalprice);
        //         formData.append('SplashBackfinalprice', SplashBackfinalprice);
        //         formData.append('WindowSilgetprice', WindowSilgetprice);
        //         formData.append('option', option);
        //         $.ajax({
        //             url: $(this).attr('action'),
        //             processData: false,
        //             contentType: false,
        //             type: "post",
        //             data: formData,
        //             success: function(res) {
        //                 if (res.status == '1') {
        //                     toastr.success(res.msg);
        //                     setTimeout(() => {
        //                         location.reload();
        //                     }, 3000);
        //                 }
        //             },
        //             error: function(err) {
        //                 console.log(err);
        //             }
        //         });

        //     });
        // });
    </script>

    <script>
        $(document).ready(function($) {
            "use strict";
            $("#quotation_details")
                .formValidation({
                    message: "This value is not valid",
                    fields: {
                        name: {
                            validators: {
                                notEmpty: {
                                    message: "Name is required",
                                },
                            },
                        },
                        business_name: {
                            validators: {
                                notEmpty: {
                                    message: "Business Name is required",
                                },
                            },
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: "Email is required",
                                },
                            },
                        },
                        phone: {
                            validators: {
                                notEmpty: {
                                    message: "Phone is required",
                                },
                            },
                        },
                        post_code: {
                            validators: {
                                notEmpty: {
                                    message: "Post Code is required",
                                },
                            },
                        }

                    },
                });
        }).on("success.form.fv", function(e) {
            e.preventDefault();
            var total = 0;
            var totalWorktop = 0;
            var upstandTotal = 0;
            var splashbacktotal = 0;
            var windowsilTotal = 0;
            var option = $('#avaiilable_thickness option:selected').attr('data-value');
            // alert(option)
            var name = $("#name").val();
            var business_name = $("#business_name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var post_code = $("#post_code").val();
            var time = $("#time").val();
            var additional_details = $("#additional_details").val();
            var kitchen_plan_file = $("#kitchen_plan_file").val();
            var proDuct_name = $("#proDuct_name").val();
            var templatingPrice = $("#templatingPrice").val();
            var splashback_price = $("#splashback_price").val();
            var upstand_price = $("#upstand_price").val();
            var window_sill_price = $("#window_sill_price").val();
            var proDuctId = $("#proDuctId").val();

            $(".worktop-row").each(function() {
                var total_row = 0;
                var w = $(this).find(".worktop_width").val();
                var l = $(this).find(".worktop_length").val();
                total_row = w * l;
                total += total_row;
            });
            totalWorktop = total / 1000;
            getTotal = (totalWorktop / 1000).toFixed(1);
            WorkTopfinalprice = getTotal * option;

            $(".upstand-row").each(function() {
                var upstandlength = $(this).find(".upstand_input").val();
                upstandTotal += parseInt(upstandlength);
            });
            upstandgetTotal = (upstandTotal / 1000).toFixed(1);
            Upstandfinalprice = upstandgetTotal * upstand_price;
            $(".splashback-row").each(function() {
                var splashback_row = 0;
                var spwidth = $(this).find(".splashback_width").val();
                var splength = $(this).find(".splashback_length").val();
                splashback_row = spwidth * splength;
                splashbacktotal += splashback_row;
            });
            totalSplashBack = splashbacktotal / 1000;
            getTotal = (totalSplashBack / 1000).toFixed(1);
            SplashBackfinalprice = getTotal * splashback_price;

            $(".windowsil-row").each(function() {
                var windowwidth = $(this).find(".windowsil_input").val();
                windowsilTotal += parseInt(windowwidth);
            });
            getWindowTotal = (windowsilTotal / 1000).toFixed(1);
            WindowSilgetprice = getWindowTotal * window_sill_price;

            var formData = new FormData($('#quotation_details')[0]);
            // alert(formData);
            formData.append('WorkTopfinalprice', WorkTopfinalprice);
            formData.append('Upstandfinalprice', Upstandfinalprice);
            formData.append('SplashBackfinalprice', SplashBackfinalprice);
            formData.append('WindowSilgetprice', WindowSilgetprice);
            formData.append('option', option);
            $.ajax({
                url: "{{route('user_quotes_details')}}",
                processData: false,
                contentType: false,
                type: "post",
                data: formData,
                success: function(res) {
                    if (res.status == '1') {
                        toastr.success(res.msg);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });            
        });


        $(document).ready(function($) {
            "use strict";
            $("#quickQuoteFprm")
                .formValidation({
                    message: "This value is not valid",
                    fields: {
                        user_name: {
                            validators: {
                                notEmpty: {
                                    message: "Name is required",
                                },
                            },
                        },
                        user_email: {
                            validators: {
                                notEmpty: {
                                    message: "Email is required",
                                },
                            },
                        },

                        user_phone: {
                            validators: {
                                notEmpty: {
                                    message: "Phone is required",
                                },
                            },
                        },

                    },
                });
        });




        jQuery(document).ready(function($) {
            / only numbers accept /
            jQuery(".numbersOnly").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                        105)) {
                    e.preventDefault();
                }
            });
            / alpha only /
            jQuery('.alphaonly').keypress(function(key) {
                if ((key.charCode < 97 || key.charCode > 122) && (key.charCode < 65 || key.charCode > 90) &&
                    (
                        key.charCode != 45) && (key.charCode != 32)) return false;
            });
            /* restrict special character*/
            jQuery('.specialrescrict').keyup(function() {
                var yourInput = $(this).val();
                re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
            var isSplChar = re.test(yourInput);
            if (isSplChar) {
                var no_spl_char = yourInput.replace(/[`~!$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/]/gi, '');
                    jQuery(this).val(no_spl_char);
                }
            });
        });
    </script>
@endpush
