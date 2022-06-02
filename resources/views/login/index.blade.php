@extends('layouts.main')

@section('home')
<div id="loginContainer" class="container-fluid justify-content-center" style="height: 90%">
    <div class="row main-content text-center">
        <div class="col-xl-4 text-center company__info">
            <img class="" src="img/LogoGFGWhite.png" alt="GFG">
        </div>
        <div class="col-xl-8 col-xs-12 col-sm-12 login_form ">
            <div class="container-fluid">
                <div class="row mt-2" style="color: #191919 !important">
                    <h2>Log In</h2>
                </div>
                <div class="row">
                    <form control="" class="form-group" action="/login" method="post">
                        @csrf

                        <input type="hidden" id="previous" name="previous" value="{{ URL::PREVIOUS() }}">

                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session()->has('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row mb-3">
                            Email
                            <input type="email" id="email" name="email" class="form__input @error('email') is-invalid @enderror" placeholder="Type your email address" autocomplete="off" required value="{{ old('email') }}" style="bg-danger">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            Password
                            <input type="password" id="password" name="password" class="form__input" placeholder="Type your password" autocomplete="off" required>
                        </div>
                        <div id="loginSubmit" class="row justify-content-center">
                            <input type="submit" value="Log In" class="btn">
                        </div>
                    </form>
                </div>
                <div class="row">
                    <p>Don't have an account? <a href="/register">Register Here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection