@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center" style="height: 100vh">
        <div class="col-md-3 align-self-center">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center">
                        <img class="mb-5 w-75" src="{{ asset('img/logo_transparent.png') }}"/>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Stuur wachtwoord vergeten mail') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
