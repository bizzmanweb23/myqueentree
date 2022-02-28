@extends('font.layouts.main')

@section('content')
    <style>
        .bg-grad-1 {
            background-color: #eb4786;
            background-image: linear-gradient(315deg, #eb4786 0%, #b854a6 74%);
        }

        .text-white {
            color: #fff !important;
        }

        .h-60px,
        .size-60px {
            height: 60 px;
        }

        .w-60px,
        .size-60px {
            width: 60 px;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        .align-items-center {
            -ms-flex-align: center !important;
            align-items: center !important;
        }



        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        .ml-auto,
        .mx-auto {
            margin-left: auto !important;
        }

        .mr-auto,
        .mx-auto {
            margin-right: auto !important;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1 rem !important;
        }

        .align-items-center {
            -ms-flex-align: center !important;
            align-items: center !important;
        }

        .justify-content-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        input[type="checkbox"] {
            -webkit-appearance: checkbox;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('asset/table/bootstrap-table.min.css') }}">
    <main class="main mt-6 single-product">
        <div class="page-content mb-10 pb-6">
            <div class="container">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">My Wallet</h1>
                        </div>
                    </div>
                </div>
                <div class="row gutters-10">
                    <div class="col-md-4 mx-auto mb-3">
                        <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                            <span
                                class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                                <i class="las la-dollar-sign la-2x text-white"></i>
                            </span>
                            <div class="px-3 pt-3 pb-3">
                                <div class="h4 fw-700 text-center">{{ Auth::user()->wallet }}</div>
                                <div class="opacity-50 text-center">Wallet Balance</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mx-auto mb-3">
                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition"
                            onclick="show_wallet_modal()" style="height: 115px;cursor: pointer;">
                            <span style="width: 54px;"
                                class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-6">
                                <i class="las la-plus la-3x text-white"></i>
                            </span>
                            <div class="fs-18 text-primary">Recharge Wallet</div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="wallet-tab" data-toggle="tab" href="#show_wallet_page"
                                    role="tab" aria-controls="wallet" aria-selected="true">Wallet History</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="credit-wallet-tab" data-toggle="tab" href="#get_wallet_bonus"
                                    role="tab" aria-controls="creditwallet" aria-selected="false">Credit Wallet History</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="Loyality-wallet-tab" data-toggle="tab"
                                    href="#get_loyalitypoint_history" role="tab" aria-controls="Loyalitywallet"
                                    aria-selected="false">Loyality wallet History</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="Loyality-wallet-tab" data-toggle="tab"
                                    href="#get_payment_history" role="tab" aria-controls="payment"
                                    aria-selected="false">Payment History</a>
                            </li>
                        </ul>
                        <div class="tab-content bg-white" id="myTabContent">
                            <div class="tab-pane fade show active" id="show_wallet_page" role="tabpanel"
                                aria-labelledby="wallet-tab">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="get_all_payment"
                                    data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                    data-show-refresh="true" data-search="true" data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-checkbox="true"></th>
                                            <th data-field="name">Name</th>
                                            <th data-field="payment_type">Payment Type</th>
                                            <th data-field="amount" data-formatter="amount">Amount</th>
                                            <th data-field="screen_shot" data-formatter="screen_shot">Screenshot</th>
                                            <th data-field="status" data-formatter="status">Status</th>
                                            <th data-field="created_at" data-formatter="change_date_format">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="get_wallet_bonus" role="tabpanel"
                                aria-labelledby="credit-wallet-tab">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="showwalletdetails"
                                    data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                    data-show-refresh="true" data-search="true" data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-checkbox="true"></th>
                                            <th data-field="name">User Name</th>
                                            <th data-field="credit_points" data-formatter="amount">Amount</th>
                                            <th data-field="status" data-formatter="status">Status</th>
                                            <th data-field="redemption_date">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="get_loyalitypoint_history" role="tabpanel"
                                aria-labelledby="Loyality-wallet-tab">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="showloyalitypointdetails"
                                    data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                    data-show-refresh="true" data-search="true" data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-checkbox="true"></th>
                                            <th data-field="name">User Name</th>
                                            <th data-field="credit_points" data-formatter="amount">Amount</th>
                                            <th data-field="status" data-formatter="status">Status</th>
                                            <th data-field="redemption_date">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="get_payment_history" role="tabpanel">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="get_payment_history"
                                    data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                    data-show-refresh="true" data-search="true" data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-checkbox="true"></th>
                                            <th data-field="order_unique">Order Id</th>
                                            <th data-field="wallet" data-formatter="amount">Amount</th>
                                            <th data-field="created_at" data-formatter="change_date_format">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </main>
    <div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recharge Wallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="wallet_form">
                    @csrf
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Amount <span class="text-danger">*</span></label>
                                <input type="number" lang="en" class="form-control mb-3" name="amount" placeholder="Amount"
                                    id="amount" autocomplete="off">
                                <span style="color:red" id="amount_error"></span><br>

                                <label>Payment Screenshot <span class="text-danger">*</span></label>
                                <input type="file" lang="en" class="form-control mb-3" name="payment_screen_shot">
                            </div>
                            <div class="col-md-6">
                                <label>Payment Method <span class="text-danger">*</span></label>


                                <div>
                                    <input type="checkbox" name="mct_pay" id="mct_pay">
                                    <label for="">MCT Pay</label>

                                    <div>
                                        <img src="" alt="" class="img-fluid" id="mct_pay_qrcode" style="display: none">
                                    </div>

                                </div>

                                <div>
                                    <input type="checkbox" name="pay_now" id="pay_now">
                                    <label for="">Pay Now</label>

                                    <div>
                                        <img src="{{ asset('payment_qr_code/paynow.jpeg') }}" alt=""
                                            class="img-fluid" id="pay_now_qrcode" style="display: none">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1"
                                id="user_wallet_btn">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="loder" style="display: none">
        @include('admin.loder.index')
    </div>

@section('javascript')
    <script src="{{ asset('asset/table/bootstrap-table.min.js') }}"></script>
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };

        $('#wallet_form :input').click(function() {
            $('#amount_error').html('')
        });

        $('#mct_pay').click(function() {
            $('#pay_now').prop('checked', false)
            $('#pay_now_qrcode').hide()

            if ($('#mct_pay').prop('checked') == true) {
                if ($('#amount').val() > 0) {
                    $('#mct_pay_qrcode').show()
                    get_qr_code()
                } else {
                    $('#amount_error').html('Please Enter Amount');
                    $('#mct_pay').prop('checked', false)
                }
            } else {
                $('#mct_pay_qrcode').hide()
            }
        })

        $('#pay_now').click(function() {
            $('#mct_pay').prop('checked', false)
            $('#mct_pay_qrcode').hide()

            if ($('#pay_now').prop('checked') == true) {
                $('#pay_now_qrcode').show()
            } else {
                $('#pay_now_qrcode').hide()
            }
        })


        function get_qr_code() {
            $.ajax({
                url: "{{ URL::signedRoute('users.get_qr_code_for_wallet') }}",
                type: 'post',
                data: {
                    amount: $('#amount').val(),
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#loder').show()
                },
                success: function(data) {
                    $('#mct_pay_qrcode').attr('src', data.qr_pic_url)
                    $('#loder').hide()
                },
                error: function(error) {
                    console.log(error)
                    $('#loder').hide()
                    if (error.status == 422) {
                        var err = error.responceJSON.errors
                        $('#amount_error').html(err.amount)
                    }
                }
            })
        }

        $('#user_wallet_btn').click(function(e) {
            e.preventDefault();
            var form = $('#wallet_form')[0]
            var data = new FormData(form);
            $.ajax({
                url: "{{ URL::signedRoute('users.store_wallet_payment') }}",
                data: data,
                type: 'post',
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loder').show()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.success(data.message);
                        $('#wallet_modal').modal('hide');
                        $('#mct_pay_qrcode').hide()
                        $('#pay_now_qrcode').hide()
                        $('#table').bootstrapTable('refresh');
                    }
                    $('#loder').hide()
                },
                error: function(error) {
                    console.log(error)
                    $('#loder').hide()

                    if (error.status == 422) {
                        var err = error.responseJSON.errors
                        if (err.select_one)
                            toastr.error(err.select_one);
                        if (err.payment_screen_shot)
                            toastr.error(err.payment_screen_shot);
                        $('#amount_error').html(err.amount)
                    }
                }
            })
        });



        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])

        });

        function get_all_payment(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('users.get_all_payment') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function showwalletdetails(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('users.get_wallet_bonus') }}",
                dataType: "json",
                success: function(data) {
                    //console.log(data)
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function showloyalitypointdetails(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('MLM.redeem_loyality_bonus') }}",
                dataType: "json",
                success: function(data) {
                    //console.log(data)
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function amount(data) {
            return "$" + data;
        }

        function screen_shot(data) {
            var url = "{{ asset('') }}"
            if (data != null)
                return "<img src='" + url + data + "' style='width:100px'>"

            else
                return "";
        }

        function status(data) {
            if (data == 1) {
                return '<span class="badge badge-inline badge-success">Success</span>';
            } else {
                return '<span class="badge badge-inline badge-danger">Pending</span>';
            }
        }

        function show_wallet_modal() {
            $('#wallet_modal').removeClass('fade');
            $('#wallet_modal').modal('show');
            $('#wallet_form')[0].reset()
            $('#amount_error').html('')
        }

        function show_make_wallet_recharge_modal() {
            // $.post('', {
            //     _token: '{{ csrf_token() }}'
            // }, function(data) {
            //     $('#offline_wallet_recharge_modal_body').html(data);
            //     $('#offline_wallet_recharge_modal').modal('show');
            // });
        }

        function change_date_format(data) {
            var d = new Date(data),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');

        }

        function get_payment_history(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('users.payment_history') }}",
                dataType: "json",
                success: function(data) {
                    //console.log(data)
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }
    </script>
@endsection
@endsection
