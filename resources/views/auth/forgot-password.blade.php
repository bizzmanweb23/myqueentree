@extends('font.layouts.main')
@section('content')
    <style>
        .login-popup .tab {
            font-size: 17px;
            color: #ccc;

        }



        .login-bg {
            height: 280px;
        }

        /* .tab-pane {
                                                                                                                                                                                                                                                                                                                            line-height: 1.5rem;
                                                                                                                                                                                                                                                                                                                        } */

    </style>
    <main class="main">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                    <li><a href="shop.html">Myqueen</a></li>
                    <li>My Account</li>
                </ul>
            </div>
        </nav>
        <div class="page-content mt-6 pb-2 mb-10">
            <div class="container">
                <div class="login-popup login-bg">
                    <div class="form-box">
                        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                            <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active border-no lh-1 ls-normal" href="#signin">Password Reset</a>
                                </li>
                            </ul>
                            <span style="color: green">{{ session('status') }}</span>


                            <div class="tab-content">
                                <div class="tab-pane active" id="signin">
                                    <form action="{{ route('password.email') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="singin-email" name="email"
                                                placeholder="Email Address *" value="{{ old('email') }}" />
                                            @error('email')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <button class="btn btn-dark btn-block btn-rounded" type="submit" id="login_btn">
                                            <i class="loading-icon fa fa-spinner fa-spin" id="login_spin"
                                                style="display: none">
                                            </i>
                                            {{ __('Email Password Reset Link') }}
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@section('javascript')
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])
        });
    </script>
@endsection

@endsection
