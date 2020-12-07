@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ __('Behandelingen') }}
                </div>
                <div class="card-body">
                    <a type="button" href="{{ route('addtreatment') }}" class="btn btn-primary float-right mb-3">{{ __('Behandeling toevoegen') }}</a>
                    <table class="table">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Naam') }}</th>
                            <th scope="col">{{ __('Prijs') }}</th>
                            <th scope="col" style="width: 150px">{{ __('Actie') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($treatments as $treatment)
                        <tr>
                            <th scope="row">{{ $treatment->id }}</th>
                            <td>{{ $treatment->name }}</td>
                            <td>&euro;{{ number_format($treatment->price, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('edittreatment', $treatment->id) }}" class="btn-primary btn btn-sm material-icons"><span class="material-icons">edit</span></a>
                                <a href="{{ route('deletetreatment', $treatment->id) }}" class="btn-primary btn btn-sm material-icons"><span class="material-icons">delete</span></a>
                            </td>
                        </tr>
                        @empty
                            <p>{{ __('Er zijn geen behandelingen gevonden.') }}</p>
                        @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
