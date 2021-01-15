@extends('layouts.home')

@section('content')
<div class="container">
    @if($appointment->treatments()->count() != 1)
        <div class="alert alert-info" role="alert">
            Wegens technische limitaties is het voor u niet mogelijk uw behandeling en tijd zelfstandig aan te passen. We willen u vragen hiervoor contact op te nemen, mocht dit nodig zijn. Wel kunt u andere persoonlijke gegevens veranderen.
        </div>
    @endif
    @include('flash::message')
    <div class="row justify-content-center mb-5">
        <div class="col">
            <h2 class="mb-3">Afspraak bewerken</h2>
            <p class="lead">
                Met het onderstaande formulier kunt u uw afspraak zelfstandig verzetten of annuleren.
            </p>
            <p>Uw afspraak staat momenteel gepland op het volgende moment:<br/>
            <strong>Datum:</strong> {{ \Carbon\Carbon::create($appointment->date)->format('d-m-Y') }}<br/>
            <strong>Tijd:</strong> {{ explode(':', $appointment->time_from)[0] }}:{{ explode(':', $appointment->time_from)[1] }} - {{ explode(':', $appointment->time_until)[0] }}:{{ explode(':', $appointment->time_until)[1] }}
            </p>
        </div>
    </div>
    <div class="row justify-content-center mb-5">
        <div class="col">
            <form method="POST" action="{{ route('submitappointmentedit') }}">
                @csrf

                @if(isset($appointment))
                    <input type="hidden" name="appointment_hash" value="{{ $appointment->hash }}"/>
                    <input type="hidden" name="treatmentanddatechange" value="false"/>
                @endif

                <div class="form-group">
                    <label for="firstname">{{ __('Voornaam') }}</label>

                    <input id="firstname" readonly type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname', isset($appointment->firstname) ? $appointment->firstname : '') }}" required autocomplete="firstname" autofocus>

                    @error('firstname')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lastname">{{ __('Achternaam') }}</label>

                    <input id="lastname" readonly type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname', isset($appointment->lastname) ? $appointment->lastname : '') }}" required autocomplete="lastname" autofocus>

                    @error('lastname')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($appointment->email) ? $appointment->email : '') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phonenumberinput">{{ __('Telefoonnummer') }}</label>

                    <input pattern="[0-9 ]{9,10}" id="phonenumberinput" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone[main]" value="{{ old('phone', isset($appointment->phone) ? $appointment->phone : '') }}" required autocomplete="phone" autofocus>

                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                @if($appointment->treatments->count() == 1)
                    <a id="btntreatmentdateselection" onclick="showTreatmentAndDateSelection();" class="btn btn-block btn-outline-primary mb-2">Behandeling en datum/tijd veranderen</a>
                    <div id="treatmentdateselection" class="d-none">
                        <div id="treatments" onmouseup="clearInputs();">
                            <div class="form-group">
                                <select name="treatments" class="list-group" required="required" id="treatmentsSelectBox">
                                    @forelse(\App\Models\Treatment::all() as $treatment)
                                        <option @if($treatment->timetables()->count() == 0) disabled @endif @if($appointment->treatments()->where('id', $treatment->id)->count() > 0) selected @endif value={{ $treatment->id }} data-description="{{ $treatment->description }}" data-price="{{ number_format($treatment->price, 2, ',', '.') }}">{{ $treatment->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div id="timeanddate">
                            <div class="form-group">
                                <label class="control-label">Afspraak datum</label>
                                <div class='input-group date' id='datetimepicker1' onclick="loadDates();">
                                    <div class="input-group-prepend input-group-addon">
                                        <span class="material-icons input-group-text" id="dateTimePickerAppointment">
                                            calendar_today
                                        </span>
                                    </div>
                                    <input type='text' class="form-control" id="appointmentmomentInput" aria-describedby="dateTimePickerAppointment" name="appointmentmoment" onkeydown="return false;"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="appointmenttime" id="appointmentTimesSelectBox">
                                </select>
                            </div>
                        </div>
                    </div>

                @endif

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block mr-3">
                        {{ __('Afspraak bijwerken') }}
                    </button>
                    <a href="{{ route('deleteappointment', $appointment->hash) }}" onclick="return confirm('Weet je zeker dat je deze afspraak wilt annuleren?')" type="submit" class="btn btn-danger btn-block">
                        {{ __('Afspraak annuleren') }}
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script>
        /* create new international telephone input */
        $(function() {
            $.telinput = $("#phonenumberinput").intlTelInput({
                initialCountry: "nl",
                separateDialCode: true,
                hiddenInput: "full",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });
            clearInputs();
        });

        /* Create new array with all possible days */
        var daysOfWeek = [
            "sunday",
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday"
        ];

        /* Create new datetimepicker*/
        $(function () {
            $('#datetimepicker1').datetimepicker({
                minDate: new Date(),
                format : 'DD/MM/YYYY',
            }).on("dp.change",function() {
                /* When date is changed load all possible times again */
                loadTimes();
            });
            $('#datetimepicker1').data("DateTimePicker").daysOfWeekDisabled([0,1,2,3,4,5,6]);
        });

        /* Load all of the possible dates when the date selection input is clicked */
        function loadDates(){
            /* Execute get request to api endpoint to see all possible dates */
            $.get('{{ route('gettimetables') }}',
                {
                    id: $('#treatmentsSelectBox').children("option:selected").val(),
                },
                (data, textStatus) => {
                    console.log(daysOfWeek)
                    /* Create new empty array for disabled days */
                    var disabledDaysOfWeek = [];
                    disabledDaysOfWeek = [];
                    /* Loop through all of the days in a week */
                    for(var i = 0; i < daysOfWeek.length; i++){
                        /* If the day is not found push it to the disabledDaysOfWeek array */
                        /*
                        * The includes function always returns a boolean.
                        * */
                        if(!Object.keys(data).includes(daysOfWeek[i])){
                            /* If there is no array key found with the name of the day specified then item to array */
                            disabledDaysOfWeek.push(i);
                        }
                    }
                    /* Console log the result */
                    console.log(disabledDaysOfWeek);
                    /* Add the disabledDaysOfWeek array to the datetimepicker options. If there are no contents, set it to null*/
                    $('#datetimepicker1').data("DateTimePicker").daysOfWeekDisabled((disabledDaysOfWeek == []) ? null : disabledDaysOfWeek);
                }
            );
            /* Directly load all possible times for currently selected day */
            loadTimes();
        }

        function loadTimes(){
            /* Execute get request to api endpoint to see all possible times */
            $.get('{{ route('gettimetabletimes') }}',
                {
                    id: $('#treatmentsSelectBox').children("option:selected").val(),
                    date: $('#datetimepicker1').data("DateTimePicker").date().format('YYYY-MM-DD')
                },
                (data, textStatus) => {
                    /* Create variable with the selectbox */
                    var appointmentTimesSelectBox = $('#appointmentTimesSelectBox');
                    /* Empty the selectbox */
                    appointmentTimesSelectBox.empty();
                    /* Loop through the retrieved data from the get request */
                    $.each(data, function (key, element) {
                        /* Split the times so we can remove the seconds */
                        var time_from = element.time_from.split(":");
                        var time_until = element.time_until.split(":");
                        /* Append (add to the bottom of the element) a new selectbox option. */
                        appointmentTimesSelectBox.append($('<option value=' + element.id + '>' + time_from[0] + ':' + time_from[1] + ' - ' + time_until[0] + ':' + time_until[1] + '</option>'));
                    });
                    console.log(data)
                }
            );
        }

        function clearInputs(){
            /* Clear the datetimepicker and time selectbox */
            $('#appointmentTimesSelectBox').empty();
            $('#appointmentmomentInput').val('');
            setTimeout(function(){ loadDates(); }, 750);
        }

        function showTreatmentAndDateSelection(){
            $("#treatmentdateselection").removeClass('d-none');
            $("#btntreatmentdateselection").addClass('d-none');
            $("input[name=treatmentanddatechange]").val('true');
            $("select[name=appointmenttime]").attr("required", "true");
        }
    </script>
@endsection
