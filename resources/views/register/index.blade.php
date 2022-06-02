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
                    <h2>Register</h2>
                </div>
                <div class="row">
                    <form control="" class="form-group" action="/register" method="post">
                        @csrf    
                        <div class="row mb-3">
                            Name
                            <input type="text" id="name" name="name" class="form__input @error('name') is-invalid @enderror" placeholder="Type your name" autocomplete="off" required value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            Username
                            <input type="text" id="username" name="username" class="form__input @error('username') is-invalid @enderror" placeholder="Type your username" autocomplete="off" required value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            Email
                            <input type="email" id="email" name="email" class="form__input @error('email') is-invalid @enderror" placeholder="Type your email address" autocomplete="off" required value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            Password
                            <input type="password" id="password" name="password" class="form__input @error('password') is-invalid @enderror" placeholder="Type your password" autocomplete="off" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div id="loginSubmit" class="row justify-content-center">
                            <input type="submit" value="Register" class="btn">
                        </div>
                        <div class="row">
                            <p>Already have an account? <a href="/login">Login Here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection