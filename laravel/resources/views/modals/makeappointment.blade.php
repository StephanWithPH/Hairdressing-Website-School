<div class="modal fade" id="makeAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="makeAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="makeAppointmentModalLabel">{{ __('Afspraak maken') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                            <a href="#step-1" type="button" class="btn btn-primary btn-circle text-black">1</a>
                            <p>Overzicht</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-2" type="button" class="btn btn-outline-primary btn-circle disabled text-black">2</a>
                            <p>Behandeling</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-3" type="button" class="btn btn-outline-primary btn-circle disabled text-black" onclick="clearInputs()">3</a>
                            <p>Datum/Tijd</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-4" type="button" class="btn btn-outline-primary btn-circle disabled text-black">3</a>
                            <p>Gegevens</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-5" type="button" class="btn btn-outline-primary btn-circle disabled text-black">3</a>
                            <p>Bevestiging</p>
                        </div>
                    </div>
                </div>
                <form role="form" action="{{ route('submitappointment') }}" method="post" id="appointmentForm">
                    @csrf
                    <div class="row setup-content" id="step-1">
                        <div class="col">
                            <div class="col">
                                <div class="alert alert-danger" role="alert">
                                    In onze salon gelden op dit moment coronamaatregelen die het RIVM voorschrijft.
                                    <a class="alert-link" href="https://www.rijksoverheid.nl/onderwerpen/coronavirus-covid-19/winkels-en-contactberoepen/kapper-masseur-en-andere-contactberoepen">Lees meer over de corona maatregelen.</a>
                                </div>
                                <h4>Overzicht</h4>
                                <div class="mt-3 row mb-3">
                                    <div class="col-md-7 col-12">
                                        <div>In deze wizard leiden we u door het reserverings proces van {{ env('APP_NAME') }}. In de volgende stap vragen we u een behandeling te kiezen en een moment waarop u graag geknipt wilt worden. We vragen u vervolgens om uw gegevens zodat we u kunnen herinneren aan uw afspraak.</div><br/>
                                    </div>
                                    <div class="col-md-5 d-none d-md-block">
                                        <img class="w-100" src="{{ asset('img/calendar.svg') }}"/>
                                    </div>
                                </div>

                                <button class="btn btn-primary nextBtn pull-right float-right" type="button" >Volgende</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="col">
                            <div class="col">
                                <h4>Behandeling</h4>
                                Selecteer de door u gewenste behandeling.
                                <br/><br/>
                                <div class="form-group">
                                    <select name="treatments" class="list-group" required="required" id="treatmentsSelectBox">
                                        @forelse(\App\Models\Treatment::all() as $treatment)
                                            <option @if($treatment->timetables()->count() == 0) disabled @endif value={{ $treatment->id }} data-description="{{ $treatment->description }}" data-price="{{ number_format($treatment->price, 2, ',', '.') }}">{{ $treatment->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <button class="btn btn-primary nextBtn pull-right float-right" type="button" onclick="clearInputs()">Volgende</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-3">
                        <div class="col">
                            <div class="col">
                                <h3>Datum/Tijd</h3>
                                <div class="form-group">
                                    <label class="control-label">Afspraak datum</label>
                                    <div class='input-group date' id='datetimepicker1' onclick="loadDates();">
                                        <div class="input-group-prepend input-group-addon">
                                            <span class="material-icons input-group-text" id="dateTimePickerAppointment">
                                                calendar_today
                                            </span>
                                        </div>
                                        <input autofocus="false" type='text' class="form-control" id="appointmentmomentInput" aria-describedby="dateTimePickerAppointment" name="appointmentmoment" onkeydown="return false;"/>
                                    </div>
                                </div>
                                <br/><br/>
                                <div class="form-group">
                                    <select class="form-control" name="appointmenttime" required="required" id="appointmentTimesSelectBox">
                                    </select>
                                </div>
                                <button class="btn btn-primary nextBtn pull-right float-right" type="button" >Volgende</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-4">
                        <div class="col">
                            <div class="col">
                                <h3>Gegevens</h3>
                                <div class="form-group">
                                    <label class="control-label">Naam</label>
                                    <input maxlength="200" name="firstname" type="text" required="required" class="form-control" placeholder="Voer uw voornaam in" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Achternaam</label>
                                    <input maxlength="200" name="lastname" type="text" required="required" class="form-control" placeholder="Voer uw achternaam in" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input maxlength="200" name="email" type="email" required="required" class="form-control" placeholder="Voer uw email adres in"  />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Telefoonnummer</label>
                                    <input maxlength="200" name="phone[main]" type="tel" required="required" class="form-control w-100" placeholder="Voer uw telefoonnummer in" id="phonenumberinput"/>
                                </div>
                                <button class="btn btn-primary nextBtn pull-right float-right" type="button" >Volgende</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-5">
                        <div class="col">
                            <div class="col">
                                <h3>Bevestiging</h3>
                                <button class="btn btn-secondary pull-right float-right" type="submit">Afspraak maken</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- In document styling, because it is less styling and we don't want it to be loaded on each page --}}
<style>
    body{
        margin-top:40px;
    }

    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0;

    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
</style>
{{-- Make appointment modal --}}
<script>
    /* When the page is loaded */
    $(document).ready(function () {
        /* Create variables for the content, nav items and next buttons */
        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');
        /* Hide all tab contents */
        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-outline-primary');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url'],input[type='email'],input[type='tel'],select"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).addClass("is-invalid");
                }
                else if ($(curInputs[i]).attr('type') == "tel" && !$.isNumeric($(curInputs[i]).val())){
                    isValid = false;
                }
                else {
                    $(curInputs[i]).removeClass("is-invalid");
                }
            }

            if (isValid){
                nextStepWizard.removeClass('disabled').addClass('text-white').trigger('click');
            }

        });

        $('div.setup-panel div a.btn-primary').trigger('click');
    });
</script>

<script>
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
                id: $('#treatmentsSelectBox').children("option:selected").val()
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
        loadDates();
    }

    /* create new international telephone input */
    $(function() {
        $.telinput = $("#phonenumberinput").intlTelInput({
            initialCountry: "nl",
            separateDialCode: true,
            hiddenInput: "full",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });
    });
</script>
