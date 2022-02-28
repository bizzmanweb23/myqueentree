@extends('admin.layout.main')

@section('content')
    <style>
        .form-group.required .control-label:after {
            content: "*";
            color: red;
        }

    </style>
    <div class="content-wrapper">
	    <div class="container-fluid">
	      <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="genology-tab" data-toggle="tab" href="#affilatemarketing" role="tab"
                        aria-controls="genology" aria-selected="true">Genology</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="direct-sponser-tab" data-toggle="tab" href="#showdirectsponsor"
                        role="tab" aria-controls="directsponsor" aria-selected="false">Direct Sponser Bonus</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="matching-bonus-tab" data-toggle="tab" href="#getmatchingbonusdetails" role="tab"
                        aria-controls="matchingbonus" aria-selected="false">Matching Bonus</a>
                </li>
				 <li class="nav-item" role="presentation">
                    <a class="nav-link" id="leadership-bonus-tab" data-toggle="tab" href="#getleadershipbonusdetails" role="tab"
                        aria-controls="leadershipbonus" aria-selected="false">Leadership Bonus</a>
                </li>
            </ul>
                <div class="tab-content bg-white" id="myTabContent">
                    <div class="tab-pane fade show active" id="affilatemarketing" role="tabpanel" aria-labelledby="genology-tab">
                        <table id="table" data-toggle="table" data-height="460" data-ajax="showmlmusers" data-pagination="true"
                               data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
                               data-show-export="true">
                           <thead>
                                <tr>
                                    <th data-field="user_id">User ID</th>
                                    <th data-field="member_id">Member ID</th>
                                    <th data-field="member_name">Name</th>
                                    <th data-field="sponser_id">Sponser ID</th>
                                    <th data-field="email">Email</th>
						            <th data-field="details">Ranking</th>
									<th data-field="id" data-formatter="usersAction">Action</th>
                               </tr>
                          </thead>
                                <tbody>

                               </tbody>
                     </table>
			      </div>
		                <div class="tab-pane" id="getmatchingbonusdetails" role="tabpanel" aria-labelledby="matching-bonus-tab">
                            <table id="table" data-toggle="table" data-height="460" data-ajax="showmatchingbonus" data-pagination="true"
                                   data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
                                   data-show-export="true">
                                <thead>
                                    <tr>
                                        <th data-field="user_id">User ID</th>
                                        <th data-field="member_id">Member ID</th>
                                        <th data-field="sponser_id">Sponser ID</th>
                                        <th data-field="order_id">Order ID</th>
                                        <th data-field="point" data-formatter="usd" data-footer-formatter="priceFormatter">USD</th>
                                   </tr>
                               </thead>
                                    <tbody>
                                    </tbody>
                          </table>
                       </div>
		                    <div class="tab-pane" id="showdirectsponsor" role="tabpanel" aria-labelledby="direct-sponser-tab">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="showdirectsponsors" data-pagination="true"
                                       data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
                                       data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-field="sponsors_id">Sponser ID</th>
                                            <th data-field="member_id">Member ID</th>
                                            <th data-field="member_name">Member Name</th>
                                            <th data-field="details">Ranking</th>
						                    <th data-field="point" data-formatter="usd" data-footer-formatter="priceFormatter">USD</th>
                                       </tr>
                                   </thead>
                                        <tbody>
                                        </tbody>
                              </table>
			               </div>
			                    <div class="tab-pane" id="getleadershipbonusdetails" role="tabpanel" aria-labelledby="leadership-bonus-tab">
                                    <table id="table" data-toggle="table" data-height="460" data-ajax="showleadershipsponsors" data-pagination="true"
                                           data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
                                           data-show-export="true">
                                       <thead>
                                            <tr>
                                                <th data-field="sponser_id">Sponser ID</th>
                                                <th data-field="member_id">Member ID</th>
                                                <th data-field="member_name">Sponser Name</th>
                                                <th data-field="order_id">Order ID</th>
                                                <th data-field="point" data-formatter="usd" data-footer-formatter="priceFormatter">USD</th>
                                           </tr>
                                       </thead>
                                            <tbody>
                                            </tbody>
                                   </table>
		                      </div>
              </div>
	   </div> 
   </div>	
   
   {{-- view user details --}}
        <div class="modal fade" id="view_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" id="edit_user_form">
						 @csrf
							<div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label>Please Select Bonus Type*</label>
                                        <select name="rank_id" class="form-control bonus_details" id="ranking_type">
										      <option></option>
                                              <option value="1">Normal Member</option>         
                                              <option value="2">Middle Class Member</option>      
                                              <option value="3">High Class Member</option>											  
                                              <option value="4">Diamond Member</option>											  
                                          </select>
                                             <span id="ranking_type_error" style="color: red"></span>	
                                  </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Sponser ID:</label>
                                        <input type="text" class="form-control form-control-user success" name="sponserID" id="sponserID" readonly>
										<input type="hidden" name="id" id="userid">										
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Member ID:</label>
                                        <input type="text" class="form-control form-control-user success" name="memberID" id="memberID" readonly>
                                    </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Member Name:</label>
                                        <input type="text" class="form-control form-control-user success" name="memberName" id="membername" readonly>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Email Address:</label>
                                        <input type="text" class="form-control form-control-user success" name="emailAddress" id="emailAddress">
										<span id="edit_user_email_error" style="color: red"></span>
                                    </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Total PV Points:</label>
                                        <input type="text" class="form-control form-control-user success" name="pv_points" id="totalPv">
										<span id="edit_user_pvpoints_error" style="color: red"></span>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Direct Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="directBonus" id="directBonus">
										<span id="edit_user_directbonus_error" style="color: red"></span>
                                    </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Matching Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="matchingBonus" id="matchingBonus">
										<span id="edit_user_matchingbonus_error" style="color: red"></span>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Leadership Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="leadershipBonus" id="leadershipBonus">
										<span id="edit_user_leadershipbonus_error" style="color: red"></span>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                       <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="edit_user_btn"><i
                                class="loading-icon fa fa-spinner fa-spin" id="edit_user_spin" style="display: none">
                            </i>Save</button>                        
                    </div>
                </div>
            </div>
        </div>
        {{-- end view user --}}
	
	{{-- edit user details --}}
        <div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" id="edit_user_form">
						 @csrf
							<div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label>Please Select Bonus Type*</label>
                                        <select name="rank_id" class="form-control bonus_details" id="ranking_type">
										      <option></option>
                                              <option value="1">Normal Member</option>         
                                              <option value="2">Middle Class Member</option>      
                                              <option value="3">High Class Member</option>											  
                                              <option value="4">Diamond Member</option>											  
                                          </select>
                                             <span id="ranking_type_error" style="color: red"></span>	
                                  </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Sponser ID:</label>
                                        <input type="text" class="form-control form-control-user success" name="sponserID" id="sponserID" readonly>
										<input type="hidden" name="id" id="userid">										
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Member ID:</label>
                                        <input type="text" class="form-control form-control-user success" name="memberID" id="memberID" readonly>
                                    </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Member Name:</label>
                                        <input type="text" class="form-control form-control-user success" name="memberName" id="membername" readonly>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Email Address:</label>
                                        <input type="text" class="form-control form-control-user success" name="emailAddress" id="emailAddress">
										<span id="edit_user_email_error" style="color: red"></span>
                                    </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Total PV Points:</label>
                                        <input type="text" class="form-control form-control-user success" name="pv_points" id="totalPv">
										<span id="edit_user_pvpoints_error" style="color: red"></span>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Direct Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="directBonus" id="directBonus">
										<span id="edit_user_directbonus_error" style="color: red"></span>
                                    </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Matching Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="matchingBonus" id="matchingBonus">
										<span id="edit_user_matchingbonus_error" style="color: red"></span>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Leadership Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="leadershipBonus" id="leadershipBonus">
										<span id="edit_user_leadershipbonus_error" style="color: red"></span>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                       <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="edit_user_btn"><i
                                class="loading-icon fa fa-spinner fa-spin" id="edit_user_spin" style="display: none">
                            </i>Save</button>                        
                    </div>
                </div>
            </div>
        </div>
        {{-- end edit user --}}
	
	<div id="user_loder" style="display: none">
        @include('admin.loder.index')
    </div>

@section('javascript')


    <script>
        function showmlmusers(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.affilatemarketing.create') }}",
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
		
		function usersAction(value, row, index) {
            return [
			    '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="viewUsers(' +
                row.id + ')">',
                '<i class="las la-eye"></i>',
                '</a>  ',
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="editUsers(' +
                row.id + ')">',
                '<i class="las la-edit"></i>',
                '</a>  ',				
            ].join('')
        }
		
		function viewUsers(id) {			
            $('#view_user_modal').modal('show');
            $.ajax({
                url: "{{ route('admin.view_affilate_details') }}",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#user_loder').show()
                },
                success: function(data) {
				  $('#user_loder').hide();
				  $('#userid').val(data.id);
                  $('#ranking_type').val(data.rank_id);
                  $("#sponserID").val(data.sponser_id);
                  $("#memberID").val(data.member_id);
                  $('#membername').val(data.member_name);
                  $('#emailAddress').val(data.email);
                  $('#totalPv').val(data.total_pv_point);
                  $('#directBonus').val(data.total_direct_dponsor);
                  $('#matchingBonus').val(data.total_matching_bonus);
                  $('#leadershipBonus').val(data.leadership_bonus);
                },
                error: function() {
                    $('#user_loder').hide();
                    alert("Fail")
                }

            })
        }
		
		function editUsers(id) {			
            $('#edit_user_modal').modal('show');
            $.ajax({
                url: "{{ route('admin.get_affilate_details') }}",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#user_loder').show()
                },
                success: function(data) {
				  $('#user_loder').hide();
				  $('#userid').val(data.id);
                  $('#ranking_type').val(data.rank_id);
                  $("#sponserID").val(data.sponser_id);
                  $("#memberID").val(data.member_id);
                  $('#membername').val(data.member_name);
                  $('#emailAddress').val(data.email);
                  $('#totalPv').val(data.total_pv_point);
                  $('#directBonus').val(data.total_direct_dponsor);
                  $('#matchingBonus').val(data.total_matching_bonus);
                  $('#leadershipBonus').val(data.leadership_bonus);
                },
                error: function() {
                    $('#user_loder').hide();
                    alert("Fail")
                }

            })
        }
		
		$('#edit_user_btn').click(function() {
            var form = $('#edit_user_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ route('admin.edit_affilate_details') }}",
                type: "POST",
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#edit_user_spin').show();
                    $("#edit_user_form :input").prop("disabled", true);
                    $('#user_loder').show()
                },
                success: function(data) {
                    $('#edit_user_spin').hide();
                    $('#edit_user_modal').modal('hide');
                    $("#edit_user_form :input").prop("disabled", false);
                    $('#user_loder').hide()
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    })
                    $('#table').bootstrapTable('refresh');
                },
			error: function(error) {
                    $('#edit_user_spin').hide();
                    $("#edit_user_form :input").prop("disabled", false);
                    $('#user_loder').hide()
                    console.log(error)
                    var err = error.responseJSON.errors;
                    if (error.status == 422) {
                        $('#ranking_type_error').html(err.ranking)
                        $('#edit_user_email_error').html(err.email)
                        $('#edit_user_pvpoints_error').html(err.pv_points)
                        $('#edit_user_matchingbonus_error').html(err.matchingBonus)
                        $('#edit_user_leadershipbonus_error').html(err.leadershipBonus)
                    }
                }
            })
        });
			
		
		function showmatchingbonus(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.getmatchingbonusdetails.create') }}",
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
		
		function showdirectsponsors(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.getdirectsponserdetails.create') }}",
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
		
		function showleadershipsponsors(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.getleadershipbonusdetails.create') }}",
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
		
		function usd(data) {
            return "$" + data;
        }

        function total() {
            return 'Total';
        }

        function priceFormatter(data) {
            var field = this.field
            console.log(data)
            return '$' + data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }
		

    </script>
@endsection
@endsection
