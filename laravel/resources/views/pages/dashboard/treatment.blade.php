@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('Medewerker toevoegen') }}
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('submitaddemployee') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name">{{ __('Naam') }}</label>

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="description">{{ __('Beschrijving') }}</label>

                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="price">{{ __('Prijs') }}</label>

                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" required autocomplete="price">

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="monday">{{ __('Maandag') }}</label>

                                <textarea id="monday" class="form-control @error('monday') is-invalid @enderror" name="monday" value="{{ old('monday') }}" required autocomplete="monday" autofocus></textarea>

                                @error('monday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="tuesday">{{ __('Dinsdag') }}</label>

                                <textarea id="tuesday" class="form-control @error('tuesday') is-invalid @enderror" name="tuesday" value="{{ old('tuesday') }}" required autocomplete="tuesday" autofocus></textarea>

                                @error('tuesday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="wednesday">{{ __('Woensdag') }}</label>

                                <textarea id="wednesday" class="form-control @error('wednesday') is-invalid @enderror" name="wednesday" value="{{ old('wednesday') }}" required autocomplete="wednesday" autofocus></textarea>

                                @error('wednesday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="thursday">{{ __('Donderdag') }}</label>

                                <textarea id="thursday" class="form-control @error('thursday') is-invalid @enderror" name="thursday" value="{{ old('thursday') }}" required autocomplete="thursday" autofocus></textarea>

                                @error('thursday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="friday">{{ __('Vrijdag') }}</label>

                                <textarea id="friday" class="form-control @error('friday') is-invalid @enderror" name="friday" value="{{ old('friday') }}" required autocomplete="friday" autofocus></textarea>

                                @error('friday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="saturday">{{ __('Zaterdag') }}</label>

                                <textarea id="saturday" class="form-control @error('saturday') is-invalid @enderror" name="saturday" value="{{ old('saturday') }}" required autocomplete="saturday" autofocus></textarea>

                                @error('saturday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="sunday">{{ __('Zondag') }}</label>

                                <textarea id="sunday" class="form-control @error('sunday') is-invalid @enderror" name="sunday" value="{{ old('sunday') }}" required autocomplete="sunday" autofocus></textarea>

                                @error('sunday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Opslaan') }}
                                </button>

                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
