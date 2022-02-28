<link rel="stylesheet" href="{{ asset('asset/alert/toastr.min.css') }}">
<script src="{{ asset('scanner/html5-qrcode.min.js') }}"></script>
<div class="row">
    <div class="col-md-6">
        <div id="reader"></div>
        <button onclick="start_scan()" class="btn btn-primary" id="start_scan">Start</button>
    </div>
    <div class="col-md-6">
        <div id="scan_data" class="row">
            {{-- <div class="col-md-12">
                <p class="text-center"><img src="{{ asset('asset/image/icon/user.png') }}" width="100"></p>
                <span>Product Name: <strong>Debasis</strong></span><br>
                <span>Price: <strong>$10</strong></span><br>
                <span>Size: <strong>30</strong></span><br>
                <span>Stock: <strong>30</strong></span><br>
            </div> --}}
        </div>
    </div>
</div>

<script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('asset/alert/toastr.min.js') }}"></script>
<script>
    function start_scan() {
        $('#start_scan').hide()

        function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            console.log(`Scan result: ${decodedText}`, decodedResult);
            get_scan_result(decodedResult.result.text)
        }
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: 300
            });
        html5QrcodeScanner.render(onScanSuccess);
    }

    function get_scan_result(id) {
        $.ajax({
            url: "{{ URL::signedRoute('admin.get_barcode_product_details') }}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loder').show()
            },
            success: function(data) {
                // console.log(data)

                var url = "{{ asset('') }}";
                $('#scan_data').html('<div class="col-md-12">' +
                    '<p class="text-center"><img src="' + url + data.product.productimagee +
                    '" width="100"></p>' +
                    '<span>Product Name: <strong>' + data.product.title + '</strong></span><br>' +
                    '<span>Price: <strong>$' + data.product.saleprice + '</strong></span><br>' +
                    '<span>Size: <strong>' + data.product.size + '</strong></span><br>' +
                    '<span>Category: <strong>' + data.category.name + '</strong></span><br>' +
                    '<span>Stock: <strong>' + data.stock + '</strong></span><br>' +
                    '</div>')
                $('#loder').hide()
            },
            error: function(error) {
                console.log(error)
                $('#loder').hide()
                if (error.status == 422) {
                    var err = error.responseJSON.errors;
                    toastr.error(err.id)
                }
            }
        })
        // $('#scan_data').html(id)
    }
</script>
