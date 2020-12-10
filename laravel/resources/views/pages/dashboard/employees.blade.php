@extends('layouts.dashboard')

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ __('Medewerkers') }}
                </div>
                <div class="card-body">
                    <a type="button" href="{{ route('addemployee') }}" class="btn btn-primary float-right mb-3">{{ __('Medewerkers toevoegen') }}</a>
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
                            <td>
                                <a href="{{ route('editemployee', $employee->id) }}" class="btn-primary btn btn-sm material-icons"><span class="material-icons">edit</span></a>
                                <a href="{{ route('deleteemployee', $employee->id) }}" class="btn-primary btn btn-sm material-icons"><span class="material-icons">delete</span></a>
                            </td>
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
