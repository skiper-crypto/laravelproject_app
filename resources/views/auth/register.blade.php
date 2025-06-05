@extends("layouts.auth")
@section("style")
    <style>
        html,
        body{
            height: 100%;
        }
        .form-signin{
            max-width: 330px;
            padding: 1rem;
        }
        .form-signin .form-floating:focus-within{
            z-index: 2;
        }
        .form-signin input[type="email"]{
            margin-bottom: -1px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .form-signin input[type="password"]{
            margin-bottom: 2rem;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
@endsection
@section("content")
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <img class ="mb-4" src="{{ asset('assets/img/logo.jpg') }}" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Please signup</h1>

            <div class="form-floating">
                <input type="text" name="name" class="form-control"
                    id="floatingInput"
                    placeholder="Enter your name">
                <label for="floatingInput">Enter Name</label>
                @error('name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-floating">
                <input type="email" name="email" class="form-control"
                    id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
                @error('email')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-floating" style="margin-bottom: 10px">
                <input type="password" name="password" class="form-control"
                    id="floatingPassword"
                    placeholder="Password">
                <label for="floatingPassword">Password</label>
                @error('password')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            @if (session()->has("success"))
                <div class="alert alert-success">
                    {{ session()->get("success") }}
                </div>
            @endif
            @if (session()->has("error"))
                <div class="alert alert-danger">
                    {{ session()->get("error") }}
                </div>
            @endif
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>
            <a href="{{route('login')}}" class="text-center">Login here</a>
            <p class="mt-5 mb-3 text-body-secondary">&copy; {{ date('Y') }} CodeEasy</p>
    </main>
@endsection
