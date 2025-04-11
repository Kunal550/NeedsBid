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
            <h2>All Job Lists</h2>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="left-bar">
                @include('site.auth.layout.sidebar')
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="right-main atable text-center">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered m-0">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th scope="col" class="col-sm-4">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Budget</th>
                                <th scope="col">Satus</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Ankit Kumar Saha</td>
                                <td>
                                    Institutional
                                </td>
                                <td>
                                    64.00
                                </td>
                                <td>
                                    Active
                                </td>
                                <td class="d-flex align-content-center justify-content-center">
                                    <a href="#!" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="#!" class="delete"><i class="fa-solid fa-trash"></i></a>

                                </td>
                            </tr>
                            <tr>
                                <td>Ankit Kumar Saha</td>
                                <td>
                                    Institutional
                                </td>
                                <td>
                                    64.00
                                </td>
                                <td>
                                    Active
                                </td>
                                <td class="d-flex align-content-center justify-content-center">
                                    <a href="#!" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="#!" class="delete"><i class="fa-solid fa-trash"></i></a>

                                </td>
                            </tr> <tr>
                                <td>Ankit Kumar Saha</td>
                                <td>
                                    Institutional
                                </td>
                                <td>
                                    64.00
                                </td>
                                <td>
                                    Active
                                </td>
                                <td class="d-flex align-content-center justify-content-center">
                                    <a href="#!" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="#!" class="delete"><i class="fa-solid fa-trash"></i></a>

                                </td>
                            </tr>




                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@push('script')

@endpush