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
                                <h3>Overzicht</h3>
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name"  />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" />
                                </div>
                                <button class="btn btn-primary nextBtn pull-right float-right" type="button" >Volgende</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="col">
                            <div class="col">
                                <h3>Behandeling</h3>
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name"  />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" />
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
                                <button class="btn btn-success pull-right float-right" type="submit">Afspraak maken</button>
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
