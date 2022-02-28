@extends('font.layouts.main')

@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('public/admin/dist/css/adminlte.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('asset/css/font/style.min.css') }}">
    {{-- <script src="{{ asset('public/admin/plugins/bootstrap/js/bootstrap.bundle.js') }}"></script> --}}
    <!-- End Header -->
    <main class="main">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb" style="background: none;">
                    <li><a href="{{ URL::route('users.index') }}"><i class="d-icon-home"></i></a></li>
                    <li>Loyality Point</li>
                </ul>
            </div>
        </nav>
        <div class="page-header pl-4 pr-4" style="background-image: url({{ asset('asset/image/font/about-us.jpg') }})">

            <h1 class="page-title font-weight-bold lh-1 text-capitalize">Loyality Point Wallet</h1>

        </div>
        @php
            $img = Auth::user()->image == null ? 'asset/image/icon/user.png' : Auth::user()->image;
        @endphp
        <div class="container">
            <div class="point-wallet">
                <img src="{{ asset($img) }}" alt="" class="img-fluid rounded-circle">
                <h2>{{ Auth::user()->firstname . ' ' . Auth::user()->lasetname }}</h2>
            <div class="row text-center">
                <div class="col-md-3"></div>

                <div class="col-md-3">
                    <a href="#myModal" class="btn btn-primary btn-md btn-block" data-toggle="modal" data-target="#myModal"
                        onclick="get_pv_poin_history()">Point
                        History</a>
                </div>
                <div class="col-md-3">
                    <a href="#" class="btn btn-primary btn-md btn-block" data-toggle="modal"
                        data-target="#myModal2">Redeem</a>
                </div>
                <div class="col-md-3"></div>
            </div>

        </div>

    </main>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Point History</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table loyal-table">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
								<th scope="col">User Name</th>
                                <th scope="col">Points</th>

                            </tr>
                        </thead>
                        <tbody id="pv_pint_table_history">
                            {{-- loder --}}
                            <div class="auto-load text-center" id="loder" style="display: none">
                                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                                    viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                    <path fill="#000"
                                        d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                        <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                            dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                    </path>
                                </svg>
                            </div>
                            {{-- end loder --}}
                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="padding: 8px">Close</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal credit_bonus" id="myModal2">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Reedem</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                <p>You have <?php echo "$".$result;?> Points </p>
                    <input type="text" class="form-control input-group-sm redeemfull_point" id="loyality_point" name="credit_points" placeholder="Enter Your Redeem Points">
					<span id="loyality_point_error" style="color: red"></span>	
                    <br>
                    <button class="btn btn-primary btn-md" id="reedem_full_amount">Use Full Redeem</button>
                    <button class="btn btn-dark btn-md" id="redeem_loyality_points">Submit</button>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <br>

@section('javascript')
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])
        });

        function get_pv_poin_history() {
            $.ajax({
                url: "{{ URL::signedRoute('MLM.get_loyalitypoint_history') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $('#loder').show();
                },
                success: function(data) {
                    $('#loder').hide();
                    var len = data.length;
                    $('#pv_pint_table_history').empty();
                    for (var i = 0; i < len; i++) {
                        $('#pv_pint_table_history').append(
                            "<tr><th scope='row'>" + data[i]['date'] +
                            "</th><td>" + data[i]['name'] + "</td><td>" + data[i]['loyality_point'] +
                            "</td> </tr>");
                    }
					
					$('#myModal').modal();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
		
	jQuery('#redeem_loyality_points').click(function()
	{
        var formData= jQuery('#loyality_point').serialize();
		toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };
        $.ajax({
        url: "{{ URL::signedRoute('MLM.loyalitypoints_withdraw.store') }}",
		headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
        type: 'post',
        dataType: 'json',
        data: formData,
		beforeSend: function() {
                $('#loder').show()
            },
        success: function(data) {
         if (data.status == 'success') {
                    toastr.success(data.message);
                }
				else{
					toastr.error();
				}
				
                $('#loyality_point').val('');
                $('#loder').hide()
            },
            error: function(error) {
                $('#loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    toastr.error("Error");
                    $('#redeem_point_error').html(err.loyality_point)
                    if (err.loyality_point) {
                        toastr.error(err.loyality_point);
                    }
                }
                console.log(error)
            }
        });
    });
	
	jQuery('#reedem_full_amount').click(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('MLM.redeem_full_loyality_bonus') }}",
                dataType: "json",
                success: function(data) {
                     //console.log(data)
                    $('.redeemfull_point').val(data);
                },
                error: function() {
                    alert("Fail")
                }
            });
        });
		
    </script>
@endsection

@endsection