@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ __('Medewerkers') }}
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Naam') }}</th>
                            <th scope="col">{{ __('Email') }}</th>
                            <th scope="col">{{ __('Actie') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <th scope="row">{{ $employee->id }}</th>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td><a href="{{ route('deleteemployee', $employee->id) }}" class="btn-primary btn btn-sm material-icons"><span class="material-icons">delete</span></a></td>
                        </tr>
                        @empty
                            <p>{{ __('Er zijn geen medewerkers gevonden.') }}</p>
                        @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection