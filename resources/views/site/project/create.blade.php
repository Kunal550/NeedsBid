@extends('site.layout.commonLayout')
@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }

    .img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>
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
<div class="container emp-profile">

    <div class="row">
        <div class="col-md-12">
            <h2>Create Jobs</h2>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="left-bar">
                @include('site.auth.layout.sidebar')
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="right-main  afrom-style">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name" placeholder="name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Project Category *</label>
                            <select class="form-control" id="category">
                                <option>Select Category</option>
                                <option> Infrastructure </option>
                                <option> Environmental </option>
                                <option> Residential </option>
                                <option> Institutional </option>
                                <option> Industrial </option>
                                <option> Commercial </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="contractor">Contractor Trade *</label>
                            <select class="form-control" id="contractor">
                                <option>Select Contractor Trade</option>
                                <option>Land Clearing contractors</option>
                                <option>Tree Planting and Removal Services</option>
                                <option>Plumbing Contractors</option>
                                <option>Pest Control Services</option>
                                <option>Drone Services</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="constructorType">Constructor Type *</label>
                            <select class="form-control" id="constructorType">
                                <option>Select Constructor Type</option>
                                <option>New Construction</option>
                                <option>Rehabilitation/Restoration</option>
                                <option>Demolition/Removal</option>
                                <option>Renovation</option>
                                <option>Repurpose/Conversion</option>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">States *</label>
                            <select class="form-control" id="state">
                                <option>Select State</option>
                                <option> Baker Island </option>
                                <option> Johnston Atoll </option>
                                <option> Texas </option>
                                <option> Hawai </option>
                                <option> Maryland </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="price">Price *</label>
                            <input type="number" class="form-control" id="price" placeholder="Enter Price">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="deadline">Project Deadline *</label>
                            <input type="date" class="form-control" id="deadline" placeholder="dd-mm-yyyy">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Project Description</label>
                        <textarea class="form-control" id="description" rows="5"></textarea>
                    </div>
                    <div class=" row">

                        <div class="form-group col-sm-6 img-input">
                            <label for="imageFile">Image (JPG/PNG)</label>
                            <input type="file" class="form-control" id="imageFile" accept=".jpg,.jpeg,.png">
                        </div>

                        <div class="form-group col-sm-6 img-input">
                            <label for="otherFile">Other File (DOCX/PDF)</label>
                            <input type="file" class="form-control" id="otherFile" accept=".docx,.pdf">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group get-started-now">
                            <button type="submit" class="get-started-button"><span>Save & Continue</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@push('script')

@endpush