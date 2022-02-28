 @extends('mlm.layouts.main')
@section('content')
    <style>
        label {
            font-weight: bold;
        }

    </style>
	<main class="main account">
	        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                    <li>WithDraw Request</li>
                </ul>
            </div>
        </nav>
	<div class="page-header pl-4 pr-4" style="background-image: url({{ asset('asset/image/font/about-us.jpg') }})">

            <h1 class="page-title font-weight-bold lh-1 text-capitalize" style="color:#231f1f;">WithDraw Bonus</h1>

        </div>
   <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
				    <div class="col-lg-5 d-none d-lg-block bg-register-image">
					        <h4 class="bonus-table">Your Bonus Balance Details Are:</h4>
                               <table id="bonus_table" data-toggle="table" data-height="460" data-ajax="drawbonusdetails" data-pagination="true" class="table-bordered"
                                      data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
                                      data-show-export="true">
                                  <thead>
                                       <tr>					                   
                                          <th class="row-bonus" data-field="total_direct_dponsor" data-formatter="usd" data-footer-formatter="priceFormatter">Direct Bonus</th>
                                          <th data-field="total_matching_bonus" data-formatter="usd" data-footer-formatter="priceFormatter">Matching Bonus</th>
                                          <th data-field="leadership_bonus" data-formatter="usd" data-footer-formatter="priceFormatter">LeaderShip Bonus</th>
                                       </tr>
                                  </thead>
                                      <tbody>
                                         <?php
										     foreach($result as $data)
											 {
										 ?>
										      <td class="row-bonus"><?php echo '$'.$data->total_direct_dponsor;?></td>
										      <td><?php echo '$'.$data->total_matching_bonus;?></td>
										      <td><?php echo '$'.$data->leadership_bonus;?></td>
										 <?php
										     }
										 ?>
                                      </tbody>
                              </table>
				   </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h2 text-gray-900 mb-4" style="text-decoration: underline;">WithDraw Form</h1>
                            </div>
                            <form method="post" id="withdraw_form">
							@csrf
							 <h1 class="h2 text-gray-900 mb-4">Note: Admin will charge you 5% as an withdraw charges and 10% will be added to your loyality Point wallet from the withdraw amount. </h1>
							  <div class="form-group row">
                                  <div class="col-sm-6 margin-right">
                                    <label>Please Select Bonus Type*</label>
                                        <select name="bonus_type" class="form-control bonus_details" id="bonus_type">
										      <option>--select--</option>         
                                              <option value="1">Direct Bonus</option>      
                                              <option value="2">Matching Bonus</option>											  
                                              <option value="3">LeaderShip Bonus</option>											  
                                          </select>
                                             <span id="bonus_type_error" style="color: red"></span>										  
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									   <label>Bank Name*</label>
                                        <input type="text" class="form-control form-control-user" id="bank_name" name="bank_name">
										<span id="bank_name_error" style="color: red"></span>
                                    </div>
                                    <div class="col-sm-6">
									   <label>Branch Name*</label>
                                        <input type="text" class="form-control form-control-user" id="branch_name" name="branch_name">
										<span id="branch_name_error" style="color: red"></span>
                                    </div>
                                </div>
								<div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
									   <label>Account Number*</label>
                                        <input type="text" class="form-control form-control-user" id="account_name" name="account_name">
										<span id="account_number_error" style="color: red"></span>
                                    </div>
                                    <div class="col-sm-6">
									   <label>Amount*</label>
                                        <input type="text" class="form-control form-control-user" id="amount" name="amount">
										<span id="amount_error" style="color: red"></span>
                                    </div>
                                </div>
								     <div class="form-group row">
                                         <div class="col-sm-6 mb-3 mb-sm-0">
								            <button class="btn btn-success" type="button" id="withdraw_button">submit</button>
										</div>
									</div>	
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
	
 <div id="loder" style="display: none">
        @include('mlm.loder.index');
    </div>


@section('javascript')
    @include('mlm.js.withdraw')
@endsection


@endsection