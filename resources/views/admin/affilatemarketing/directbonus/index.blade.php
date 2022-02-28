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
          <div class="tab-pane fade show active" id="showdirectsponsor" role="tabpanel" aria-labelledby="direct-sponser-tab">
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
        </div>
    </div>

    <div id="user_loder" style="display: none">
        @include('admin.loder.index')
    </div>
@section('javascript')


    <script>
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