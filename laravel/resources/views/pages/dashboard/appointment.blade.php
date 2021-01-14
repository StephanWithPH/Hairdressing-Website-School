@extends('layouts.dashboard')

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ __('Afspraak bewerken') }}
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('submitappointmentadmin') }}">
                        @csrf

                        @if(isset($appointment))
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}"/>
                        @endif

                        <div class="form-group row">
                            <label for="firstname">{{ __('Voornaam') }}</label>

                            <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname', isset($appointment->firstname) ? $appointment->firstname : '') }}" required autocomplete="firstname" autofocus>

                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="lastname">{{ __('Achternaam') }}</label>

                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname', isset($appointment->lastname) ? $appointment->lastname : '') }}" required autocomplete="lastname" autofocus>

                            @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="email">{{ __('Email') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($appointment->email) ? $appointment->email : '') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="phonenumberinput">{{ __('Telefoonnummer') }}</label>

                            <input id="phonenumberinput" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone[main]" value="{{ old('phone', isset($appointment->phone) ? $appointment->phone : '') }}" required autocomplete="phone" autofocus>

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label></label>
                            <select name="treatments[]" multiple class="list-group" required="required" id="treatmentsSelectBox">
                                @forelse(\App\Models\Treatment::all() as $treatment)
                                    <option @if($appointment->treatments()->where('id', $treatment->id)->count() > 0) selected @endif value={{ $treatment->id }} data-description="{{ $treatment->description }}" data-price="{{ number_format($treatment->price, 2, ',', '.') }}">{{ $treatment->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="form-group row">
                            <label class="control-label">Afspraak datum</label>
                            <div class='input-group date' id='datetimepicker1'>
                                <div class="input-group-prepend input-group-addon">
                                    <span class="material-icons input-group-text" id="dateTimePickerAppointment">
                                        calendar_today
                                    </span>
                                </div>
                                <input type='text' class="form-control" id="appointmentmomentInput" aria-describedby="dateTimePickerAppointment" name="appointmentmoment" onkeydown="return false;"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label">Tijd vanaf</label>
                            <div class='input-group date' id='timePickerFrom'>
                                <div class="input-group-prepend input-group-addon">
                                    <span class="material-icons input-group-text" id="timePickerFrom">
                                        calendar_today
                                    </span>
                                </div>
                                <input type='text' class="form-control" id="timePickerFromInput" aria-describedby="timePickerFromInput" name="timefrom" onkeydown="return false;"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label">Tijd tot</label>
                            <div class='input-group date' id='timePickerUntil'>
                                <div class="input-group-prepend input-group-addon">
                                    <span class="material-icons input-group-text" id="timePickerUntil">
                                        calendar_today
                                    </span>
                                </div>
                                <input type='text' class="form-control" id="timePickerUntilInput" aria-describedby="timePickerUntilInput" name="timeuntil" onkeydown="return false;"/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <button type="submit" class="btn btn-primary mr-3">
                                {{ __('Afspraak bijwerken') }}
                            </button>
                            <a href="{{ route('deleteappointment', $appointment->id) }}" onclick="return confirm('Weet je zeker dat je deze afspraak wilt annuleren?')" type="submit" class="btn btn-danger">
                                {{ __('Afspraak annuleren') }}
                            </a>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        /* Create new international telephone input and disable time selection */
        $(function () {
            $.telinput = $("#phonenumberinput").intlTelInput({
                initialCountry: "nl",
                separateDialCode: true,
                hiddenInput: "full",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });
            <?php
            $dateArray = explode('-', $appointment->date);
            ?>
            $('#datetimepicker1').datetimepicker({
                format : 'DD/MM/YYYY',
                defaultDate: new Date(<?php echo (int)$dateArray[0]?>, <?php echo (int)$dateArray[1]?>-1, <?php echo (int)$dateArray[2]?>)

            });
            <?php
            $timeFromArray = explode(':', $appointment->time_from);
            ?>
            $('#timePickerFrom').datetimepicker({
                defaultDate: new Date (<?php echo (int)$dateArray[0]?>, <?php echo (int)$dateArray[1]?>-1, <?php echo (int)$dateArray[2]?>, <?php echo $timeFromArray[0] ?>, <?php echo $timeFromArray[1] ?>),
                format : 'HH:mm'
            });

            <?php
            $timeUntilArray = explode(':', $appointment->time_until);
            ?>
            $('#timePickerUntil').datetimepicker({
                defaultDate: new Date (<?php echo (int)$dateArray[0]?>, <?php echo (int)$dateArray[1]?>-1, <?php echo (int)$dateArray[2]?>, <?php echo $timeUntilArray[0] ?>, <?php echo $timeUntilArray[1] ?>),
                format : 'HH:mm'
            });

        });
    </script>
@endsection
