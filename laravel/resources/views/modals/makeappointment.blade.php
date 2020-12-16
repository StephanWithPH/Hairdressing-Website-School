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
                            <a href="#step-3" type="button" class="btn btn-outline-primary btn-circle disabled text-black">3</a>
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
                <form role="form">
                    <div class="row setup-content" id="step-1">
                        <div class="col">
                            <div class="col">
                                <h4>Overzicht</h4>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Info: </strong>In onze salon gelden op dit moment coronamaatregelen. We verzoeken u om u te houden aan de coronamaatregelen zoals hieronder beschreven.
                                    <ul class="list-unstyled">
                                        <li><strong>-</strong> Blijf bij <strong>klachten thuis</strong></li>
                                        <li><strong>-</strong> Houd 1,5 meter afstand</li>
                                        <li><strong>-</strong> Kom enkel op de gereserveerde tijd</li>
                                        <li><strong>-</strong> Desinfecteer uw handen voor binnenkomst</li>
                                        <li><strong>-</strong> U bent verplicht een mondkapje te dragen in de wachtkamer</li>
                                    </ul>
                                </div>
                                In deze wizard leiden we u door het reserverings proces van {{ env('APP_NAME') }}. In de volgende stappen wordt gevraagd
                                één of meerdere behandelingen te kiezen en een moment te kiezen waarop u graag geknipt wil worden. We vragen u vervolgens om uw gegevens.<br/>
                                <button class="btn btn-primary nextBtn pull-right float-right" type="button" >Volgende</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="col">
                            <div class="col">
                                <h4>Behandeling</h4>
                                Selecteer de door u gewenste behandelingen. Er zijn meerdere keuzes mogelijk.
                                <br/><br/>
                                <div class="form-group">
                                    <select name="treatments" class="list-group" multiple required="required">
                                        @forelse(\App\Models\Treatment::all() as $treatment)
                                            <option value={{ $treatment->id }} data-description="{{ $treatment->description }}" data-price="{{ number_format($treatment->price, 2, ',', '.') }}">{{ $treatment->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <button class="btn btn-primary nextBtn pull-right float-right" type="button" >Volgende</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-3">
                        <div class="col">
                            <div class="col">
                                <h3>Datum/Tijd</h3>
                                <div class="form-group">
                                    <label class="control-label">Company Name</label>
                                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Company Address</label>
                                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address"  />
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
                                    <label class="control-label">Company Name</label>
                                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Company Address</label>
                                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address"  />
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
