@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('Behandeling toevoegen') }}
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('submittreatment') }}" enctype="multipart/form-data">
                            @csrf

                            @if(isset($treatment))
                                <input type="hidden" name="treatment_id" value="{{ $treatment->id }}"/>
                            @endif

                            <div class="form-group row">
                                <label for="name">{{ __('Naam') }}</label>

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($treatment->name) ? $treatment->name : '') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="description">{{ __('Beschrijving') }}</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>{{ old('description', isset($treatment->description) ? $treatment->description : '') }}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="price">{{ __('Prijs') }}</label>

                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" required autocomplete="price" value="{{ old('price', isset($treatment->price) ? $treatment->price : '') }}" >

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="image">{{ __('Afbeelding') }}</label>

                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" @if(!isset($treatment->image)) required @endif autocomplete="image" value="{{ old('image') }}" >

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="row mb-2 mt-5">
                                <h4>Rooster</h4>

                            </div>
                            <div class="row mb-2">
                                <p>
                                    In het tekstveld van de dag op elke nieuwe lijn een tijdsblok gescheiden door een middenstreepje.
                                    <br/>
                                    Voorbeeld:
                                    <br/>
                                    10:00-11:00<br/>
                                    11:00-12:00<br/>
                                    12:30-13:30
                                </p>
                            </div>

                            <div class="form-group row">
                                <label for="monday">{{ __('Maandag') }}</label>

                                <textarea id="monday" class="form-control @error('monday') is-invalid @enderror" name="monday" autocomplete="monday" autofocus>{{ old('monday') }}</textarea>

                                @error('monday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="tuesday">{{ __('Dinsdag') }}</label>

                                <textarea id="tuesday" class="form-control @error('tuesday') is-invalid @enderror" name="tuesday" autocomplete="tuesday" autofocus>{{ old('tuesday') }}</textarea>

                                @error('tuesday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="wednesday">{{ __('Woensdag') }}</label>

                                <textarea id="wednesday" class="form-control @error('wednesday') is-invalid @enderror" name="wednesday" autocomplete="wednesday" autofocus>{{ old('wednesday') }}</textarea>

                                @error('wednesday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="thursday">{{ __('Donderdag') }}</label>

                                <textarea id="thursday" class="form-control @error('thursday') is-invalid @enderror" name="thursday" autocomplete="thursday" autofocus>{{ old('thursday') }}</textarea>

                                @error('thursday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="friday">{{ __('Vrijdag') }}</label>

                                <textarea id="friday" class="form-control @error('friday') is-invalid @enderror" name="friday" autocomplete="friday" autofocus>{{ old('friday') }}</textarea>

                                @error('friday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="saturday">{{ __('Zaterdag') }}</label>

                                <textarea id="saturday" class="form-control @error('saturday') is-invalid @enderror" name="saturday" autocomplete="saturday" autofocus>{{ old('saturday') }}</textarea>

                                @error('saturday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="sunday">{{ __('Zondag') }}</label>

                                <textarea id="sunday" class="form-control @error('sunday') is-invalid @enderror" name="sunday" autocomplete="sunday" autofocus>{{ old('sunday') }}</textarea>

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
