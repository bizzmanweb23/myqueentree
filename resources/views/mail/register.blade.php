<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
</head>

<body>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "">
    <html lang="en" style="-ms-overflow-y: auto !important;">

    <head>

        <meta http-equiv="x-ua-compatible" content="IE=edge">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <style type="text/css">
            @media screen and (max-width: 480px) {
                .padding-outer {
                    padding-left: 20px !important;
                    padding-right: 20px !important;
                }
            }

            @media screen and (max-width: 480px) {
                .no-padding {
                    padding: 0 !important;
                }
            }

            @media screen and (max-width: 480px) {
                .no-border {
                    border: 0 !important;
                }
            }

            @font-face {
                font-family: "Graphik";
                font-weight: 500;
                src: url(https://cdn-s3.headout.com/assets/fonts/Graphik-Medium-Web.eot?#iefix);
                src: url(https://cdn-s3.headout.com/assets/fonts/Graphik-Medium-Web.eot?#iefix) format("eot"), url(https://cdn-s3.headout.com/assets/fonts/Graphik-Medium-Web.woff2) format("woff2"), url(https://cdn-s3.headout.com/assets/fonts/Graphik-Medium-Web.woff) format("woff");
            }

            @font-face {
                font-family: "Graphik";
                font-weight: 400;
                src: url(https://cdn-s3.headout.com/assets/fonts/Graphik-Regular-Web.eot?#iefix);
                src: url(https://cdn-s3.headout.com/assets/fonts/Graphik-Regular-Web.eot?#iefix) format("eot"), url(https://cdn-s3.headout.com/assets/fonts/Graphik-Regular-Web.woff2) format("woff2"), url(https://cdn-s3.headout.com/assets/fonts/Graphik-Regular-Web.woff) format("woff");
            }

            @font-face {
                font-family: "Graphik";
                font-weight: 300;
                src: url(https://cdn-s3.headout.com/assets/fonts/Graphik-Light-Web.eot?#iefix);
                src: url(https://cdn-s3.headout.com/assets/fonts/Graphik-Light-Web.eot?#iefix) format("eot"), url(https://cdn-s3.headout.com/assets/fonts/Graphik-Light-Web.woff2) format("woff2"), url(https://cdn-s3.headout.com/assets/fonts/Graphik-Light-Web.woff) format("woff");
            }

            @media screen and (max-width: 480px) {
                .pb-10 {
                    padding-bottom: 10px !important;
                }
            }

            @media screen and (max-width: 480px) {
                .pb-20 {
                    padding-bottom: 20px !important;
                }
            }

            @media screen and (max-width: 480px) {
                .full-width {
                    display: block;
                    text-align: center !important;
                    width: 100% !important;
                }
            }

            @media screen and (max-width: 480px) {
                .full-width td {
                    text-align: center !important;
                }
            }

            @media screen and (max-width: 480px) {
                .mobile-hide {
                    display: none !important;
                }
            }

        </style>
    </head>

    <body marginwidth="0" marginheight="0" bgcolor="#F3F3F5"
        style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;"
        offset="0" topmargin="0" leftmargin="0">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#F6F6F6">
            <tbody>
                <tr>
                    <td>
                        <table width="100%" style="max-width:600px;" cellspacing="0" cellpadding="0" border="0"
                            align="center" class="main_table" bgcolor="#FFFFFF">
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#"><img src="{{ asset('asset/image/Welcome.jpg') }}" /> </a>
                                        <section style="margin-top: -25px; padding-bottom: 15px;">
                                            <br>
                                            <br>


                                            <!-- blog1 -->
                                            <div style="margin-left: 24px;">

                                                <div class="blog-content" style="width: 90%; float: left; ">


                                                    <h3>Hi, {{ $name }},</h3>
                                                    <p>Your Account has been verified and all you need to login your
                                                        account </p>
                                                    <p><a href="{{ route('users.index') }}" class="btn btn-primary"
                                                            style="padding: 8px; background: #c89f63; color: #fff;">Shop
                                                            Now</a></p>


                                                    <p>Kind Regards,</p>
                                                    <p>Myqueen Team</p>
                                                    <p>+6567219257</p>
                                                    <p>admin@xzymyqueen.com</p>
                                                    <p>www.xzymyqueen.com</p>

                                                </div>
                                            </div>
                                            <div class="clearfix" style="clear: both;"></div>
                                            <hr>




                                        </section>

                                        <div class="clearfix" style="clear: both;"></div>

                                        <section style="background-color: #e1e1e1; padding: 10px 0">
                                            <h3 style="text-align: center; ">FOLLOW US ON </h3>
                                            <div style="margin-left: 232px;">
                                                <a href="#"> <img src="{{ asset('facebook.config_path()') }}"
                                                        class="img-responsive" style="margin-right: 20px;" /></a>
                                                <a href="#"> <img src="{{ asset('asset/image/icon/search.png') }}"
                                                        class="img-responsive" style="margin-right: 20px;" /> </a>
                                                <a href="#">
                                                    <img src="{{ asset('asset/image/icon/wechat.png') }}">
                                                </a>
                                            </div>


                                            <p style="text-align: center;">Contact us <span
                                                    style="color: #00b0bb">admin@xzymyqueen.com</span> or<span
                                                    style="color: #00b0bb;"> +6567219257 </span>.
                                            </p>
                                        </section>

                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>

    </html>
