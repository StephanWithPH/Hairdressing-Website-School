@extends('layouts.home')

@section('content')
<div class="container">
    @include('flash::message')
    <div class="alert alert-danger" role="alert">
        <strong>In onze salon gelden op dit moment coronamaatregelen die het rivm voorschrijft.</strong>
        <ul class="list-unstyled">
            <li><a class="alert-link" href="https://www.rijksoverheid.nl/onderwerpen/coronavirus-covid-19/winkels-en-contactberoepen/kapper-masseur-en-andere-contactberoepen">Lees meer over de corona maatregelen.</a></li>
        </ul>
    </div>
    <div class="row justify-content-center mb-5" id="aboutus" name="aboutus">
        <div class="col-md-7">
            <h2 class="mb-3">Over ons</h2>
            <p class="lead">
                Wij staan voor <span class="text-primary font-weight-bold">echte aandacht</span>, met als enige echte doel, het mooiste in jou naar boven halen. Haar heeft grote invloed op het uiterlijk en is bepalend voor je uitstraling.
            </p>
            <p class="lead">
                Wij kijken naar jouw haar als onderdeel van een veel groter geheel namelijk, jij!
            </p>
            <p class="lead">
                Met grote liefde voor de mens en ons vak zijn wij in staat om te kijken naar wat het beste bij jou past. Jouw wensen gecombineerd met ons inzicht zijn het recept voor een mooie coupe, kleur en een goed gevoel.
            </p>
            <p class="lead">
                Wij doen waar we goed in zijn alle andere behandelingen vind je in onze prijslijst
            </p>
        </div>
        <div class="col-md-5">
            <div class="image">
                <img class="featurette-image img-fluid mx-auto rounded" src="{{ asset('img/home_aboutus.jpg') }}" data-holder-rendered="true">
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5 mb-5" id="ourspecialisation" name="ourspecialisation">
        <div class="col-md-5">
            <div class="image">
                <img class="featurette-image img-fluid mx-auto rounded" src="{{ asset('img/home_specialisation.jpg') }}" data-holder-rendered="true">
            </div>
        </div>
        <div class="col-md-7 mt-5 mt-md-0">
            <h2 class="mb-3">Onze specialisatie</h2>
            <p class="lead">
                Met ruim <span class="text-primary font-weight-bold">10 jaar ervaring</span> met alle type krullen laten we jouw krullen weer echt krullen.
            </p>
            <p class="lead">
                We knippen het haar op een speciale manier en altijd <span class="text-primary font-weight-bold">droog</span>.
            </p>
            <p class="lead">
                De behandeling is all- in en bestaat uit <span class="text-primary font-weight-bold">Krulanalyse,  Krullenknippen, Wassen en  Verzorging</span>.
            </p>
            <p class="lead">
                Voordeel behandelen van krullen bij een krullenkapper:
            </p>
            <ul>
                <li>Veerkrachtige Krullen</li>
                <li>Geen pluis meer</li>
                <li>Veel volume vanaf de aanzet</li>
            </ul>
            <p class="lead">
                Ook leren wij je om te gaan met jouw krullen zodat je dit zelf ook thuis kunt realiseren.
            </p>

        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container">
        <div class="row justify-content-center mt-5" id="treatments" name="treatments">
            <div class="col text-center">
                <h2>Behandelingen</h2>
            </div>
        </div>

        <div class="row justify-content-center mt-4 mb-5">
            @forelse(\App\Models\Treatment::limit(3)->get() as $treatment)
                <div class="col-md-4 text-center">
                    <img class="rounded-circle" src="{{ $treatment->image }}" alt="{{ $treatment->name }} image" width="140" height="140">
                    <h3 class="mt-3">{{ $treatment->name }}</h3>
                    <p class="mb-2">{{ $treatment->description }}</p>
                    <h5 class="font-weight-bold">&euro;{{ number_format($treatment->price, 2, ',', '.') }}</h5>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
<div class="container-fluid bg-primary">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-5" id="bookappointment" name="bookappointment">
            <div class="col-7 my-5 py-4">
                <h4 class="text-white m-0">Maak nu uw reservering door op de knop te drukken.</h4>
            </div>
            <div class="col-5 my-5 py-4">
                <a class="btn btn-lg btn-secondary float-right m-0" data-toggle="modal" data-target="#makeAppointmentModal">Reserveren</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col" id="contact" name="contact">
            <form action="{{ route('submitcontactform') }}" method="POST">
                @csrf
                <div class="card border-primary rounded-0">
                    <div class="card-header p-0">
                        <div class="bg-primary text-white text-center py-2">
                            <h3>Contact</h3>
                            <p class="m-0">Neem contact op en we reageren zo spoedig mogelijk.</p>
                        </div>
                    </div>
                    <div class="card-body p-3">

                        <!--Body-->
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="material-icons text-primary">perm_identity</span></div>
                                </div>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Naam" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="material-icons text-primary">mail_outline</span></div>
                                </div>
                                <input type="email" class="form-control" id="name" name="email" placeholder="Email adres" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="material-icons text-primary">trending_flat</span></div>
                                </div>
                                <textarea class="form-control" name="comment" placeholder="Opmerking" required></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" value="Versturen" class="btn btn-primary btn-block py-2">
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@include('modals.makeappointment')

@endsection

@section('scripts')
    {{-- Anchor tag scroll --}}
    <script>
        function scrollToAnchor(aid){
            var aTag = $("div[name='"+ aid +"']");
            $('html,body').animate({scrollTop: aTag.offset().top},'slow');
        }

        $("#link").click(function() {
            scrollToAnchor('id3');
        });
    </script>
@endsection
