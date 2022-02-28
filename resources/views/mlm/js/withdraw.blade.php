<script>
	
	$('#withdraw_button').click(function() {
        var form = $('#withdraw_form')[0];
        var data = new FormData(form);

        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };
        $.ajax({
            url: "{{ URL::signedRoute('MLM.withdrawform.store') }}",
			headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
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
				
                $('#withdraw_form').trigger("reset");
                $('#loder').hide()
            },
            error: function(error) {
                $('#loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    toastr.error("Error");
                    $('#bonus_type_error').html(err.bonus_type)
                    $('#bank_name_error').html(err.bank_name)
                    $('#branch_name_error').html(err.branch_name)
                    $('#account_number_error').html(err.account_name)
                    $('#amount_error').html(err.amount)
                    if (err.amount) {
                        toastr.error(err.amount);
                    }
                }
                console.log(error)
            }
        })
    });
	
	$('#withdraw_form :input').click(function() {
        $(bonus_type_error).html('')
        $('#bank_name_error').html('')
        $('#branch_name_error').html('')
        $('#account_number_error').html('')
        $('#amount_error').html('')
    })
	
	$('.bonus_details').change(function() {
        var form = $(this).val();
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };
        $.ajax({
			type: 'get',
			url : '{{URL::signedRoute("MLM.deducated_bonus")}}&id='+form,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                //$('#loder').show()
            },
            success: function(data) {
                
                //$('#loder').hide()
            }
        })
    });
	
</script>