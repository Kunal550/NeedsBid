@extends('site.layout.commonLayout')
@push('style')
    <style>
    </style>
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
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
           
            <div class="col-md-4 col-lg-3">
                <div class="left-bar">
                    @include('site.auth.layout.sidebar')
                </div>
            </div>

            <div class="col-md-8 col-lg-9">
                <div class="right-main">
                    <div class="content">
                        <h3>User Quotation</h3>
                        {{-- {{dd($getQuotations)}} --}}
                        <div class="card card-primary card-tabs border-0 custom-card">

                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill"
                                            href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home"
                                            aria-selected="true">In Depth Quotation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile"
                                            aria-selected="false">Quick Quotation</a>
                                    </li>
                                </ul>
                            </div>
            
                            <div class="card-body px-0">

                                <div class="tab-content" id="custom-tabs-two-tabContent">

                                    <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-two-home-tab">
                                        <div class="container-fluid px-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" id="quotestbl">
                                                    <thead>
                                                        <tr>
                                                            <th>##</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($getQuotations) > 0)
                                                        @foreach ($getQuotations as $key => $getQuotation)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $getQuotation->name }}</td>
                                                                <td>{{ $getQuotation->email }}</td>
                                                                <td>{{ $getQuotation->phone }}</td>
                                                                <td>{{ $getQuotation->is_mail_send == 0 ? 'Pending' : 'Complete' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0);"
                                                                    class="btn btn-primary btn-sm" onclick="view_details('{{ base64_encode($getQuotation->id) }}')"
                                                                        title="View"><i class="fa fa-eye"></i></a>

                                                                    @if ($getQuotation->is_mail_send != 0)
                                                                        <a href="javascript:void(0);"
                                                                            onclick="downloadPdf('{{ base64_encode($getQuotation->id) }}')"
                                                                            class="btn btn-info btn-sm" title="Download Pdf"><i
                                                                                class="fa fa-download"></i></a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="6"><strong>No Record Found</strong>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                                <div class="col-xs-12 text-right">
                                                    {{ $getQuotations->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-two-profile-tab">
                                        <div class="container-fluid px-0">
                                            <div class="table-responsive">
                                              
                                                    <table class="table table-striped table-bordered" id="quotestbl">
                                                        <thead>
                                                            <tr>
                                                                <th>SL No.</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Phone</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($quickqotes) > 0)
                                                                @foreach ($quickqotes as $key => $quickqote)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $quickqote->name }}</td>
                                                                        <td>{{ $quickqote->email }}</td>
                                                                        <td>{{ $quickqote->phone }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="6"><strong>No Record Found</strong>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <div class="col-xs-12 text-right">
                                                        {{ $quickqotes->links() }}
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
    <div class="modal fade" id="pageModal" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pageModalLabel">Quotation Details <span id="modaltype"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#pageModal').modal('hide');">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    function view_details(rowid) {
        $.ajax({
            type: "post",
            url: "{{ route('user_quotation_details') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": rowid
            },
            success: function(response) {
                // console.log(response);
                $('#pageModal .modal-body').html(response);
                $('#pageModal').modal('show');
            }
        });
    }


    function downloadPdf(rowid) {
        location.href = "{{ route('download-pdf') }}" + '/' + rowid,
            $.ajax({
                type: "post",
                url: "{{ route('download-pdf') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": rowid
                },
            });
    }

    function getdiscountPrice(quotation_price) {
        let price = quotation_price;
        let discount_price = $('#discount_price').val();
        let TotalDiscountPrice = (discount_price / 100) * price;
        let final_price = price - TotalDiscountPrice;
        $("#final_price").val(final_price.toFixed(2));
    }

    function sendEmailWithPdf(rowid) {
        let quotation_price = $('#quotation_price').val();
        let discount_price = $('#discount_price').val();
        let TotalDiscountPrice = (discount_price / 100) * quotation_price;
        let final_price = quotation_price - TotalDiscountPrice;
        // alert(final_price);
        $.ajax({
            type: "get",
            url: "{{ route('send-email-with-pdf') }}" + '/' + rowid,
            data: {
                'quotation_price': quotation_price,
                'discount_price': discount_price,
                'final_price': final_price
            },
            beforeSend: function() {
                $('#myDiv').show();
            },
            success: function(response) {
                // console.log(response);
                if (response.status == '1') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 3000);

                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>
    <script>
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
    </script>
@endpush
