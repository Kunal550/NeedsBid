@extends('site.layout.commonLayout')
@section('content')
    <main>
        <section class="innerbanner">
            <div class="text-center innerbanner-text">
                <div class="container">
                    <h2>{{ ucwords($categories->name) }}</h2>
                    <p>{!! $categories->description !!}</p>
                    <div class="breadcrumb-box">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">Products</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ ucwords($categories->name) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="quartz-products sec-space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 filters stickySidebar">
                        <form action="" id="filter-form" method="get">
                            <h4>Filters</h4>
                            @if (!empty($colors))
                                <div class="colours">
                                    <div class="colour-dropdown">
                                        <h3>COLOURS</h3>
                                    </div>
                                    <div class="colour-filters">
                                        <div class="filters-scroll">
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($colors as $color)
                                                <div class="form-check color-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input colorInput" name="color[]"
                                                            name="checkbox" type="checkbox" value="{{ $color->slug }}"
                                                            {{ isset($_GET['color']) && in_array($color->slug, $_GET['color']) ? 'checked' : '' }}>
                                                        {{ $color->color_name }}
                                                        ({{ $color->colorcounts }})
                                                    </label>
                                                </div>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <br>
                            @if (!@empty($brands))
                                <div class="colours">
                                    <div class="colour-dropdown">
                                        <h3>BRANDS</h3>
                                    </div>
                                    <div class="colour-filters">
                                        <div class="filters-scroll">
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($brands as $brand)
                                                <div class="form-check brand-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input brand-check-input" type="checkbox"
                                                            name="brand[]" value="{{ $brand->slug }}"
                                                            {{ isset($_GET['brand']) && in_array($brand->slug, $_GET['brand']) ? 'checked' : '' }}>
                                                        {{ $brand->brand_name }}
                                                        ({{ $brand->brandcounts }})
                                                    </label>
                                                </div>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <br>
                            @if (!@empty($thickness))
                                <div class="colours">
                                    <div class="colour-dropdown">
                                        <h3>THICKNESS</h3>
                                    </div>
                                    <div class="colour-filters">
                                        <div class="filters-scroll">
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($thickness as $thick)
                                                <div class="form-check thick-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input thick-check-input" type="checkbox"
                                                            name="thickness[]" value="{{ $thick->id }}" id="thickness[]"
                                                            {{ isset($_GET['thickness']) && in_array($thick->id, $_GET['thickness']) ? 'checked' : '' }}>
                                                        {{ $thick->thickness }} mm
                                                        ({{ !empty($thickCounts[$i]->counts) ? $thickCounts[$i]->counts : 0 }})
                                                    </label>
                                                </div>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div class="col-lg-9 products stickyContent">
                        <div class="row">
                            <div class="col-lg-8">
                                @if (!empty($products))
                                    <h5>Showing <span>{{ count($products) }}</span> results out of
                                        <span>{{ $products_category_count }}</span>
                                    </h5>
                                @endif
                                <div class="d-flex align-items-center filter-tab">
                                    <div class="d-flex align-items-center">
                                        @if (!empty($colorCheckBox))
                                            <h5>Colour: </h5>
                                            @foreach ($colorCheckBox as $product)
                                                <div>
                                                    <span data-id={{ $product->slug }}
                                                        class="selected-filter-item">{{ $product->color_name }} <i
                                                            class="fa fa-times" aria-hidden="true"></i></span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if (!empty($brandCheckBox))
                                            <h5>Brand: </h5>
                                            @foreach ($brandCheckBox as $brandCheck)
                                                <div>
                                                    <span data-id={{ $brandCheck->slug }}
                                                        class="selected-filter-item">{{ $brandCheck->brand_name }}
                                                        <i class="fa fa-times" aria-hidden="true"></i></span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if (!empty($thicknessCheckBox))
                                            <h5>Thickness: </h5>
                                            @foreach ($thicknessCheckBox as $thickCheckBox)
                                                <div>
                                                    <span data-id={{ $thickCheckBox->id }}
                                                        class="selected-filter-item">{{ $thickCheckBox->thickness }} mm
                                                        <i class="fa fa-times" aria-hidden="true"></i></span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="sortBy d-flex justify-content-end align-items-center ">
                                    <h6>Sort by :</h6>
                                    <form action="" method="get" id="FilterData">
                                        <select class="form-select filter_by_price" name="filter_data"
                                            aria-label="Default select example">
                                            <option value="" selected>Please Select</option>
                                            <option value="price_low_to_high">Price Low To High </option>
                                            <option value="price_high_to_low">Price High To Low</option>
                                            <option value="alphabetical">Alphabetical</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if (!empty($products[0]))
                            <div class="row pt-lg-4 product-row">
                                @foreach ($products as $product)
                                    <div class="col-lg-3">
                                        <div class="pbox">
                                            <figure class="pimg"><a
                                                    href="{{ route('product_details', $product->slug) }}"><img
                                                        src="{{ asset('public/uploads/product/' . $product->featured_images) }}"
                                                        alt=""></a></figure>
                                            <div class="pcontent">
                                                <h3><a href="{{ route('product_details', $product->slug) }}">{{ $product->product_name }}
                                                    </a></h3>
                                                <h4>
                                                    @if (!empty($product->product_high_price))
                                                        £{{ $product->product_low_price }} -
                                                        £{{ $product->product_high_price }}
                                                    @else
                                                        £{{ $product->product_low_price }}
                                                    @endif
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row pt-lg-4 product-row ">
                                <h3>No Product Available.</h3>
                            </div>
                        @endif
                        <div class="pt-lg-4 list_pagination">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $(".color-check").click(function(e) {
                // alert('s')
                $('#filter-form').submit();
            });
            $(".brand-check").click(function(e) {
                $('#filter-form').submit();
            });
            $(".thick-check").click(function(e) {
                $('#filter-form').submit();
            });


            $(".filter_by_price").change(function(e) {
                $('#FilterData').submit();
            });

            $('.colour-dropdown').click(function() {
                $(this).toggleClass('uparrow');
                $(this).siblings('.colour-filters').slideToggle(300);
            });

            $('.selected-filter-item').click(function(e) {
                var Item = $(this).data('id');
                $('input[value~="' + Item + '"]').prop('checked', false);
                $('#filter-form').submit();
            });
        });
    </script>
@endpush
