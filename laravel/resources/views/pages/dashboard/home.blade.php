@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100 border-0">
                <div class="card-body bg-primary">
                    <h6 class="text-uppercase">{{ __('Afspraken') }}</h6>
                    <h1 class="display-4">{{ \App\Models\Appointment::count() }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100 border-0">
                <div class="card-body bg-primary">
                    <h6 class="text-uppercase">{{ __('Medewerkers') }}</h6>
                    <h1 class="display-4">{{ \App\Models\Role::where('identifier', 'employee')->first()->users->count() }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100 border-0">
                <div class="card-body bg-primary">
                    <h6 class="text-uppercase">{{ __('Behandelingen') }}</h6>
                    <h1 class="display-4">{{ \App\Models\Treatment::count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
