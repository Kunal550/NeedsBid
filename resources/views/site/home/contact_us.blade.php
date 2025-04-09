@extends('site.layout.commonLayout')
@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }

    small.help-block {
        color: red;
    }

    .select2-container {
        width: 100% !important;
        padding: 0;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
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

<section>
    <div class="banner-section banner inner-banner">

        <div class="">

            <div class="">

                <figure>
                    <img src="{{ asset('public/uploads/images/banner-img.jpeg')}}" alt="" />
                </figure>
                <div class="banner-contain">
                    <div class="bannerinner-contain">
                        <h1 class="inner-heading-text1 small-heading wow bounceInRight">Contact Us.</h1>
                    </div>
                </div>
            </div>

        </div>


    </div>
</section>
<div class="contact-us-bg common-padding" style="background: url(../needs_Bids/public/front_end/images/contactus12.png) no-repeat;">
    <div class="container">
        <div class="col-sm-10 mx-auto">
            <div class="contact-us-from-one">
                <h2 class="common-heading text-center">
                    Got A Question? Feel Free To <span>Contact Us.</span>
                </h2>
                <p class="col-sm-8 mx-auto text-center">{!! $contact_details->contact_us !!}</p>
                <form action="{{ route('submit-contactform') }}" method="post" enctype="multipart/form-data" id="contact-form">
                    @csrf
                    <div class="row m-0">
                        <div class="col-sm-6 input-main-0ne">
                            <label>Name</label>
                            <input type='text' id="name" name="name" placeholder="Enter Full Name" class="contact-input" />
                        </div>
                        <div class="col-sm-6 input-main-0ne">
                            <label>Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter email" class="contact-input" />
                        </div>
                    </div>
                    <div class="col-sm-12 input-main-0ne">
                        <label>Phone No.</label>
                        <input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10"  name="phone" id="phone" placeholder="Enter Phone No." class="contact-input" />
                    </div>
                    <div class="col-sm-12 input-main-0ne">
                        <label>Message</label>
                        <textarea class="contact-input address-input" id="how_can_we_help" name="how_can_we_help" rows="3"></textarea>
                    </div>
                    <div class="col-sm-12 input-main-0ne">
                        <input type="submit" placeholder="Conatct Us" class="submitone" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection

@push('script')
<script>
    $(document).ready(function($) {
        "use strict";
        $("#contact-form")
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

                },
            })
    });
</script>
@endpush