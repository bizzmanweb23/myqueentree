@extends('font.layouts.main')
@section('content')
    <style>
        body {
            color: black
        }

        .nav-link {
            text-align: left;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #c89f63;
        }

        .card-body {
            padding: 1.3rem 1.5rem;
        }

        .card {
            border-radius: 10px;
        }

        .nav-pills .nav-link.active {
            padding-left: 10px;
        }

    </style>
    <main class="main mt-6 single-product">
        <div class="page-content mb-10 pb-6">
            <div class="container">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="d-flex flex-column align-items-center text-center mt-7">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @php
                                                $default_img = 'asset/image/icon/avatar7.png';
                                                $image = Auth::user()->image == null ? $default_img : Auth::user()->image;
                                            @endphp
                                            <img src="{{ asset($image) }}" alt="Admin" class="rounded-circle"
                                                style="width: 190px;height: 190px;">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mt-3"
                                                style="display: flex;align-items: flex-start;flex-direction: column;align-content: stretch;">
                                                <h4>{{ Auth::user()->name }}</h4>
                                                <p class="text-secondary mb-1 text-bold">Balance:
                                                    {{ Auth::user()->wallet }}</p>
                                                <?php 
													foreach($result as $data)
													{?>
                                                <p class="text-bold mb-1">Total Revenue: <?php echo $data->bonusSum; ?></p>
                                                <?php
													}
												?>
                                                <p class="text-bold mb-1">Points: {{ Auth::user()->total_pv_point }} PV
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip"
                                            title="Edit Profile" onclick="open_edit_modal()" style="padding: 8px"><i
                                                class="fa fa-edit"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-3">Unique Id</h6>
                                    </div>
                                    <div class="col-sm-9 ">
                                        {{ Auth::user()->unique_id }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-3">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 ">
                                        {{ Auth::user()->name }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-3">Email</h6>
                                    </div>
                                    <div class="col-sm-9 ">
                                        {{ Auth::user()->email }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-3">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 ">
                                        {{ Auth::user()->phone }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-3">Join</h6>
                                    </div>
                                    <div class="col-sm-9 ">
                                        {{ Auth::user()->created_at }}
                                    </div>
                                </div>

                                <div class="row mt-5">

                                </div>

                            </div>
                        </div>
                    </div>



                </div>




                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            {{-- <h2>My Order</h2> --}}
                            <div class="card-body">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" data-toggle="pill" href="#pending_payment" role="tab"
                                        aria-controls="v-pills-messages" aria-selected="false">
                                        <i class="la la-money"></i> Pending Payment
                                    </a>
                                    <a class="nav-link " data-toggle="pill" href="#user_kyc" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true">
                                        <i class="la la-truck-moving"></i> To Ship
                                    </a>
                                    <a class="nav-link" id="" data-toggle="pill" href="#to_collect" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false">
                                        <i class="la la-money"></i> To Collect
                                    </a>
                                    <a class="nav-link" id="show_passport_proof_tab" data-toggle="pill"
                                        href="#user_membership" role="tab" aria-controls="v-pills-profile"
                                        aria-selected="false">
                                        <i class="la la-handshake"></i> To Receive
                                    </a>
                                    <a class="nav-link" id="" data-toggle="pill" href="#to_rate" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false">
                                        <i class="la la-star-o"></i> To Rate
                                    </a>

                                    {{-- <a class="nav-link" id="" data-toggle="pill" href="#completed" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false">
                                        <i class="la la-money"></i> Completed
                                    </a> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="pending_payment" role="tabpanel"
                                            aria-labelledby="v-pills-settings-tab">
                                            @include('font.profile.pending_payment')
                                        </div>
                                        <div class="tab-pane fade" id="user_kyc" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab">
                                            @include('font.profile.to_ship')
                                        </div>
                                        <div class="tab-pane fade" id="user_membership" role="tabpanel"
                                            aria-labelledby="v-pills-messages-tab">
                                            @include('font.profile.to_receive')
                                        </div>
                                        <div class="tab-pane fade" id="to_rate" role="tabpanel"
                                            aria-labelledby="v-pills-messages-tab">
                                            @include('font.profile.rate')
                                        </div>
                                        <div class="tab-pane fade" id="to_collect" role="tabpanel"
                                            aria-labelledby="v-pills-messages-tab">
                                            @include('font.profile.to_collect')
                                        </div>
                                        {{-- <div class="tab-pane fade" id="completed" role="tabpanel"
                                            aria-labelledby="v-pills-messages-tab">
                                            @include('font.profile.completed')
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="edit_profile" tabindex="1111" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_profile_form">
                        @csrf
                        <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ Auth::user()->name }}">
                            <span style="color: red" id="edit_name_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Email:</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ Auth::user()->email }}">
                            <span style="color: red" id="edit_email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ Auth::user()->phone }}">
                            <span style="color: red" id="edit_phone_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Upload Profile Image:</label>
                            <input type="file" name="image" id="image" class="form-control"
                                value="{{ Auth::user()->image }}">
                            @if (Auth::user()->image != null)
                                <div>
                                    <img src="{{ asset(Auth::user()->image) }}" alt="" class="img-fluid"
                                        style="width: 21%;height: 50%;">
                                </div>
                            @endif
                            <span style="color: red" id="edit_image_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 8px">Close</button>
                    <button type="button" class="btn btn-primary" style="padding: 8px" id="save_edit_form_btn">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="loder" style="display: none">
        @include('admin.loder.index');
    </div>

@section('javascript')
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])
        });

        function open_edit_modal() {
            $('#edit_profile').removeClass('fade');
            $('#edit_profile').modal('show')
        }

        $('#save_edit_form_btn').click(function(e) {
            e.preventDefault();
            var form = $('#edit_profile_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ URL::signedRoute('users.profile.store') }}",
                type: 'post',
                data: data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loder').show()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.options = {
                            "closeButton": true,
                            "newestOnTop": true,
                            "positionClass": "toast-top-right"
                        };
                        toastr.success(data.message);
                        setTimeout(() => {
                            window.location.reload()
                        }, 1000)
                    }
                    $('#loder').hide()
                },
                error: function(error) {
                    console.log(error)
                    $('#loder').hide()
                    if (error.status == 422) {
                        var err = error.responseJSON.errors
                        $('#edit_name_error').html(err.name);
                        $('#edit_email_error').html(err.email);
                        $('#edit_phone_error').html(err.phone);
                        $('#edit_image_error').html(err.image);
                    }
                }
            })
        });

        function show_pending_payment(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('users.show_pending_payment') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function total_pending(data) {
            return "$ " + data;
        }

        function payment_status(data) {
            return '<span class="badge badge-inline badge-danger">Processing</span>';
        }


        function show_to_ship(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('users.show_to_ship') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function ship_payment_status(data) {
            if (data == 0)
                return '<span class="badge badge-inline badge-danger">Processing</span>';
            else
                return '<span class="badge badge-inline badge-success">Approved</span>';
        }

        function show_to_receive(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('users.show_to_receive') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function receive_payment_status(data) {
            if (data == 0)
                return '<span class="badge badge-inline badge-danger">Processing</span>';
            else
                return '<span class="badge badge-inline badge-success">Approved</span>';
        }

        function show_rate(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('users.show_rate') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function rate_image(data) {
            var url = "{{ asset('') }}";
            return '<img src="' + url + data + '" class="img-fluid" width="100">'
        }

        function rate_star(data) {
            var calstar = 10 * parseInt(data);
            return '<div class="ratings-full">' +
                ' <span class="ratings" style="width:' + calstar + '%"></span>' +
                ' <span class="tooltiptext tooltip-top">4.00</span>' +
                ' </div>';
        }


        function show_to_collect(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('users.show_collect') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function collect_payment_status(data) {
            if (data == 0)
                return '<span class="badge badge-inline badge-danger">Processing</span>';
            else
                return '<span class="badge badge-inline badge-success">Approved</span>';
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


        // function show_completed(params) {
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ URL::signedRoute('users.show_completed') }}",
        //         dataType: "json",
        //         success: function(data) {
        //             params.success(data)
        //         },
        //         error: function(er) {
        //             params.error(er);
        //         }
        //     });
        // }
    </script>
@endsection
@endsection
