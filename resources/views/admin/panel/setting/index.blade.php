@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Setting | Admin')

@push('style')
    <style>
        .error {
            color: red;
        }

        .req {
            color: red;
        }

        .img {
            height: 30px;
            width: 30px;
            border-radius: 50%;
        }

        .oldimg {
            display: none;
        }

        .LogoIamge {
            height: 100px;
            width: 100px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <script src="//maps.googleapis.com/maps/api/js?key={{ env('LOCATION_API') }}&libraries=places"></script>
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
    <?php
    $errtype = 'siteinfo';
    if (@$errors->has('setting_type')) {
        $errtype = $errors->first('setting_type');
    }
    ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Setting</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ $errtype == 'siteinfo' ? 'active' : '' }}"
                                                id="custom-tabs-two-home-tab" data-toggle="pill"
                                                href="#custom-tabs-two-home" role="tab"
                                                aria-controls="custom-tabs-two-home" aria-selected="true">Site Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $errtype == 'metainfo' ? 'active' : '' }}"
                                                id="custom-tabs-two-meta-tab" data-toggle="pill"
                                                href="#custom-tabs-two-meta" role="tab"
                                                aria-controls="custom-tabs-two-meta" aria-selected="false">Meta Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $errtype == 'socialinfo' ? 'active' : '' }}"
                                                id="custom-tabs-two-profile-tab" data-toggle="pill"
                                                href="#custom-tabs-two-profile" role="tab"
                                                aria-controls="custom-tabs-two-profile" aria-selected="false">Social
                                                Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $errtype == 'smtpinfo' ? 'active' : '' }}"
                                                id="custom-tabs-two-messages-tab" data-toggle="pill"
                                                href="#custom-tabs-two-messages" role="tab"
                                                aria-controls="custom-tabs-two-messages" aria-selected="false">SMTP</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $errtype == 'detailsinfo' ? 'active' : '' }}"
                                                id="custom-tabs-two-details-tab" data-toggle="pill"
                                                href="#custom-tabs-two-details" role="tab"
                                                aria-controls="custom-tabs-two-details" aria-selected="false">Extra
                                                Content</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-two-tabContent">
                                        <div class="tab-pane fade {{ $errtype == 'siteinfo' ? 'show active' : '' }}"
                                            id="custom-tabs-two-home" role="tabpanel"
                                            aria-labelledby="custom-tabs-two-home-tab">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <form action="{{ route('admin.setting') }}" method="post"
                                                        id="siteform" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="site_name">Site Name</label>
                                                                <input type="text" name="site_name"
                                                                    value="{{ old('site_name', @$setting->site_name) }}"
                                                                    id="site_name" class="form-control"
                                                                    placeholder="Site Name">
                                                                @if ($errors->has('site_name'))
                                                                    <span
                                                                        class="error"><small>{{ ucwords($errors->first('site_name')) }}</small></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="site_image">Logo</label>
                                                                <input type="file" name="site_image" id="site_image"
                                                                    class="form-control" accept="image/*">
                                                                @if ($errors->has('site_image'))
                                                                    <span
                                                                        class="error"><small>{{ ucwords($errors->first('site_image')) }}</small></span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="site_mail">Site Email-ID</label>
                                                                <input type="text" name="site_mail"
                                                                    value="{{ old('site_mail', @$setting->site_mail) }}"
                                                                    id="site_mail" class="form-control"
                                                                    placeholder="Email-ID">
                                                                @if ($errors->has('site_mail'))
                                                                    <span
                                                                        class="error"><small>{{ ucwords($errors->first('site_mail')) }}</small></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="contact_no">Contact No.</label>
                                                                <input type="text" name="contact_no"
                                                                    value="{{ old('contact_no', @$setting->contact_no) }}"
                                                                    id="contact_no" class="form-control"
                                                                    placeholder="Contact No.">
                                                                @if ($errors->has('contact_no'))
                                                                    <span
                                                                        class="error"><small>{{ ucwords($errors->first('contact_no')) }}</small></span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="site_address">Address</label>
                                                                <input type="text" name="site_address"
                                                                    value="{{ old('site_address', @$setting->site_address) }}"
                                                                    id="site_address" class="form-control"
                                                                    placeholder="Address">
                                                                @if ($errors->has('site_address'))
                                                                    <span
                                                                        class="error"><small>{{ ucwords($errors->first('site_address')) }}</small></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="type" value="siteinfo">
                                                        <input type="hidden" name="rowid"
                                                            value="{{ @$setting->id }}">
                                                        <div class="row">
                                                            {{-- <div class="col-md-12">
                                                            <label for="footer_text">Footer Text</label>
                                                            <textarea name="footer_text"
                                                                value="{{old('footer_text',@$setting->footer_text)}}"
                                                                id="footer_text" class="form-control"></textarea>
                                                            @if ($errors->has('footer_text')) <span
                                                                class="error"><small>{{ ucwords($errors->first('footer_text')) }}</small></span>
                                                            @endif
                                                        </div> --}}
                                                            <div class="col-md-12 mt-3">
                                                                <button type="button"
                                                                    onclick="loader('show');$('#siteform').submit();"
                                                                    class="btn btn-primary">Save Site Info</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Logo:</label>
                                                    <br>
                                                    <img src="{{ asset('public/uploads/setting/' . optional($setting)->logo) }}"
                                                        class="LogoIamge" alt="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade {{ $errtype == 'metainfo' ? 'show active' : '' }}"
                                            id="custom-tabs-two-meta" role="tabpanel"
                                            aria-labelledby="custom-tabs-two-meta-tab">
                                            <form action="{{ route('admin.setting') }}" method="post"
                                                id="metainfoform">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="meta_title">Meta Title</label>
                                                        <input type="text" name="meta_title"
                                                            value="{{ old('meta_title', @$setting->meta_title) }}"
                                                            id="meta_title" class="form-control"
                                                            placeholder="Meta Title">
                                                        @if ($errors->has('meta_title'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('meta_title')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="meta_keyword">Meta Keyword</label>
                                                        <input type="text" name="meta_keyword"
                                                            value="{{ old('meta_keyword', @$setting->meta_keyword) }}"
                                                            id="meta_keyword" class="form-control"
                                                            placeholder="Meta Keyword">
                                                        @if ($errors->has('meta_keyword'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('meta_keyword')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="meta_description">Meta Description</label>
                                                        <textarea name="meta_description" value="{{ old('meta_description', @$setting->meta_description) }}"
                                                            id="meta_description" class="form-control" placeholder="Meta Description">{{ @$setting->meta_description }}</textarea>
                                                        @if ($errors->has('meta_description'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('meta_description')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" value="metainfo">
                                                <input type="hidden" name="rowid" value="{{ @$setting->id }}">
                                                <div class="row">
                                                    <div class="col-md-8 mt-3">
                                                        <button type="button"
                                                            onclick="loader('show');$('#metainfoform').submit();"
                                                            class="btn btn-primary">Save Meta Info</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade {{ $errtype == 'socialinfo' ? 'show active' : '' }}"
                                            id="custom-tabs-two-profile" role="tabpanel"
                                            aria-labelledby="custom-tabs-two-profile-tab">
                                            <form action="{{ route('admin.setting') }}" method="post"
                                                id="socialinfoform">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="fb_link">Facebook Link</label>
                                                        <input type="text" name="fb_link"
                                                            value="{{ old('fb_link', @$setting->fb_link) }}"
                                                            id="fb_link" class="form-control"
                                                            placeholder="Facebook Link">
                                                        @if ($errors->has('fb_link'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('fb_link')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="fb_link">Linkdin Link</label>
                                                        <input type="text" name="linkdin_link"
                                                            value="{{ old('linkdin_link', @$setting->linkdin_link) }}"
                                                            id="linkdin_link" class="form-control"
                                                            placeholder="Linkdin Link">
                                                        @if ($errors->has('linkdin_link'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('linkdin_link')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="twitter_link">Twitter Link</label>
                                                        <input type="text" name="twitter_link"
                                                            value="{{ old('twitter_link', @$setting->twitter_link) }}"
                                                            id="twitter_link" class="form-control"
                                                            placeholder="Twitter Link">
                                                        @if ($errors->has('twitter_link'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('twitter_link')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="insta_link">Instagram Link</label>
                                                        <input type="text" name="insta_link"
                                                            value="{{ old('insta_link', @$setting->insta_link) }}"
                                                            id="insta_link" class="form-control"
                                                            placeholder="Instagram Link">
                                                        @if ($errors->has('insta_link'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('insta_link')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="youTube_link">YouTube Link</label>
                                                        <input type="text" name="youTube_link"
                                                            value="{{ old('you_tube_link', @$setting->you_tube_link) }}" id="youTube_link" class="form-control"
                                                            placeholder="YouTube Link">
                                                        @if ($errors->has('youTube_link'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('youTube_link')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                               


                                                <input type="hidden" name="type" value="socialinfo">
                                                <input type="hidden" name="rowid" value="{{ @$setting->id }}">
                                                <div class="row">
                                                    <div class="col-md-8 mt-3">
                                                        <button type="button"
                                                            onclick="loader('show');$('#socialinfoform').submit();"
                                                            class="btn btn-primary">Save Social Info</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade {{ $errtype == 'smtpinfo' ? 'show active' : '' }}"
                                            id="custom-tabs-two-messages" role="tabpanel"
                                            aria-labelledby="custom-tabs-two-messages-tab">
                                            <form action="{{ route('admin.setting') }}" method="post" id="smtpform">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="smtp_host">Host</label>
                                                        <input type="text" name="smtp_host"
                                                            value="{{ old('smtp_host', @$setting->smtp_host) }}"
                                                            id="smtp_host" class="form-control" placeholder="SMTP Host">
                                                        @if ($errors->has('smtp_host'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('smtp_host')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="smtp_port">Port</label>
                                                        <input type="text" name="smtp_port"
                                                            value="{{ old('smtp_port', @$setting->smtp_port) }}"
                                                            id="smtp_port" class="form-control" placeholder="SMTP Port">
                                                        @if ($errors->has('smtp_port'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('smtp_port')) }}</small></span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="smtp_name">Name</label>
                                                        <input type="text" name="smtp_name"
                                                            value="{{ old('smtp_name', @$setting->smtp_name) }}"
                                                            id="smtp_name" class="form-control"
                                                            placeholder="SMTP Sender Name">
                                                        @if ($errors->has('smtp_name'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('smtp_name')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="smtp_username">Username</label>
                                                        <input type="text" name="smtp_username"
                                                            value="{{ old('smtp_username', @$setting->smtp_username) }}"
                                                            id="smtp_username" class="form-control"
                                                            placeholder="SMTP Username">
                                                        @if ($errors->has('smtp_username'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('smtp_username')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="smtp_pass">Password</label>
                                                        <input type="password" name="smtp_pass"
                                                            value="{{ old('smtp_pass', @$setting->smtp_pass) }}"
                                                            id="smtp_pass" class="form-control"
                                                            placeholder="SMTP Password">
                                                        @if ($errors->has('smtp_pass'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('smtp_pass')) }}</small></span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="smtp_formadd">Form Address</label>
                                                        <input type="email" name="smtp_formadd"
                                                            value="{{ old('smtp_formadd', @$setting->smtp_formadd) }}"
                                                            id="smtp_formadd" class="form-control"
                                                            placeholder="SMTP Form Address">
                                                        @if ($errors->has('smtp_formadd'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('smtp_formadd')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" value="smtpinfo">
                                                <input type="hidden" name="rowid" value="{{ @$setting->id }}">
                                                <div class="row">
                                                    <div class="col-md-8 mt-3">
                                                        <button type="button"
                                                            onclick="loader('show');$('#smtpform').submit();"
                                                            class="btn btn-primary">Save Smtp Info</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade {{ $errtype == 'detailsinfo' ? 'show active' : '' }}"
                                            id="custom-tabs-two-details" role="tabpanel"
                                            aria-labelledby="custom-tabs-two-details-tab">
                                            <form action="{{ route('admin.setting') }}" method="post"
                                                id="detailsinfoform" enctype="multipart/form-data">
                                                @csrf
                                                
                                                

                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="have_question">Have A Question </label>
                                                        <textarea name="have_question" id="have_question" class="form-control"
                                                            value="{{ old('have_question', @$setting->have_question) }}">{!! optional($setting)->have_question !!}</textarea>
                                                        @if ($errors->has('have_question'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('have_question')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                


                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="other_ervices">Other Services</label>
                                                        <textarea name="other_ervices" id="other_ervices" class="form-control"
                                                            value="{{ old('other_ervices', @$setting->other_ervices) }}">{!! optional($setting)->other_ervices !!}</textarea>
                                                        @if ($errors->has('other_ervices'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('other_ervices')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="contact_us">Contact us</label>
                                                        <textarea name="contact_us" id="contact_us" class="form-control"
                                                            value="{{ old('contact_us', @$setting->contact_us) }}">{!! optional($setting)->contact_us !!}</textarea>
                                                        @if ($errors->has('contact_us'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('contact_us')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="newsletter">Newsletter</label>
                                                        <textarea name="newsletter" id="newsletter" class="form-control"
                                                            value="{{ old('newsletter', @$setting->newsletter) }}">{!! optional($setting)->newsletter !!}</textarea>
                                                        @if ($errors->has('newsletter'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('newsletter')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="about_company">About Company</label>
                                                        <textarea name="about_company" id="about_company" class="form-control"
                                                            value="{{ old('about_company', @$setting->about_company) }}">{!! optional($setting)->about_company !!}</textarea>
                                                        @if ($errors->has('about_company'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('about_company')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                


                                                <input type="hidden" name="type" value="detailsinfo">
                                                <input type="hidden" name="rowid" value="{{ @$setting->id }}">
                                                <div class="row">
                                                    <div class="col-md-8 mt-3">
                                                        <button type="button"
                                                            onclick="loader('show');$('#detailsinfoform').submit();"
                                                            class="btn btn-primary">Save Extra Details Info</button>
                                                    </div>
                                                </div>
                                            </form>
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
@endsection
@push('script')
    <script>
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
    </script>
    <!-- google map api  -->
    <script>
        function initialize() {
            var address = (document.getElementById('address'));
            var autocomplete = new google.maps.places.Autocomplete(address);
            autocomplete.setTypes(['geocode']);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                document.getElementById("start_latitude").value = place.geometry.location.lat();
                document.getElementById("start_longitude").value = place.geometry.location.lng();
                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endpush
