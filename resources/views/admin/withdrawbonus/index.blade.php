@extends('admin.layout.main')

@section('content')
    <style>
        .form-group.required .control-label:after {
            content: "*";
            color: red;
        }

    </style>
    <div class="content-wrapper">
        <div class="tab-content bg-white" id="myTabContent">
                <div class="tab-pane fade show active" id="withdrawbonus" role="tabpanel" aria-labelledby="withdraw-bonus-tab">
            <table id="table" data-toggle="table" data-height="460" data-ajax="withdrawbonus" data-pagination="true"
                data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
                data-show-export="true">
                <thead>
                    <tr>
					    <th data-field="user_id">user ID</th>
                        <th data-field="bank_name">Bank Name</th>
                        <th data-field="branch_name">Branch Name</th>
                        <th data-field="account_name">Account Number</th>
                        <th data-field="amount" data-formatter="usd" data-footer-formatter="priceFormatter">WithDraw Amount</th>
                        <th data-field="amount_users_will_receive" data-formatter="usd" data-footer-formatter="priceFormatter">Amount User Recieved</th>
						<th data-field="status" data-formatter="status">status</th>
						<th data-formatter="action">Actions</th>
                    </tr>
                </thead>
                <tbody>
				
                </tbody>
            </table>
			
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
                        <form method="get" id="view_user_form">
						 @csrf
							<div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label>Type Of Bonus User Want To WithDraw</label>
                                        <select name="bonus_type" class="form-control bonus_details" id="bonus_type" readonly>
										      <option></option>                                                      
                                              <option value="1">Direct Bonus</option>      
                                              <option value="2">Matching Bonus</option>											  
                                              <option value="3">LeaderShip Bonus</option>											  
                                          </select>	
                                  </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Name:</label>
                                        <input type="text" class="form-control form-control-user success" name="name" id="user_name" readonly>
										<input type="hidden" name="id" id="userid">										
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">User ID:</label>
                                        <input type="text" class="form-control form-control-user success" name="unique_id" id="user_details" readonly>
                                    </div>
                                    <div class="col-sm-6">
									    <label for="" class="control-label">Email Address:</label>
                                        <input type="text" class="form-control form-control-user success" name="email" id="email_details" readonly>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Amount User Has Requested For WithDraw:</label>
                                        <input type="text" class="form-control form-control-user success" name="amount" id="amount_details" readonly>
                                    </div>
									<div class="col-sm-6">
									    <label for="" class="control-label">Balance Of Matching Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="matchingBonus" id="matchingBonus_details" readonly>
                                    </div>
                                </div>
								    <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									    <label for="" class="control-label">Balance Of Direct Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="directBonus" id="directBonus_details" readonly>
                                    </div>	
                                        <div class="col-sm-6">
									    <label for="" class="control-label">Balance Of Leadership Bonus:</label>
                                        <input type="text" class="form-control form-control-user success" name="leadershipBonus" id="leadershipBonus_details" readonly>
                                    </div>								
                                </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                       <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>                                        
                    </div>
                </div>
            </div>
        </div>
        {{-- end view user --}}
	

    <div id="user_loder" style="display: none">
        @include('admin.loder.index')
    </div>
@section('javascript')


    <script>
        function withdrawbonus(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.withdrawbonus.create') }}",
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
		
		function status(data) {
            if (data == 1) {
                return '<span class="badge badge-inline badge-danger">Pending</span>';
            } else {
                return '<span class="badge badge-inline badge-Success">Success</span>';
            }
        }
		
		function action(value, row, index) 
		{
			var order_details = "{{ route('admin.approvewithdraw', 'id=:id') }}";
            order_details = order_details.replace(":id", row.id);
			return [
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="'+order_details+'" title="Approve">',
                '<i class="fas fa-check-circle"></i>',
                '</a>  ',
				'<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="view" onclick="viewUsers(' +
                row.id + ')">',
                '<i class="las la-eye"></i>',
                '</a>  ',
            ].join('')
			
		}

        function viewUsers(id) {			
            $('#view_user_modal').modal('show');
            $.ajax({
                url: "{{ route('admin.view_user_details') }}",
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
				  $('#bonus_type').val(data.bonus_type);
				  $('#user_name').val(data.name);
				  $('#user_details').val(data.unique_id);
				  $('#email_details').val(data.email);
				  $('#amount_details').val(data.amount);
				  $('#pvpoint_details').val(data.total_pv_point);
				  $('#directBonus_details').val(data.total_direct_dponsor);
				  $('#matchingBonus_details').val(data.total_matching_bonus);
				  $('#leadershipBonus_details').val(data.leadership_bonus);				  
                },
                error: function() {
                    $('#user_loder').hide();
                    alert("Fail")
                }

            })
        }		


    </script>
@endsection
@endsection