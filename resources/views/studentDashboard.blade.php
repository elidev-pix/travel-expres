@extends('base')

@section('title')

<a href="{{ route('studentDashboard') }}">Informations personnelles</a>

@endsection

@section('left')

<div class="profile">
    <img src="{{ asset('images/pp.jpg')}}" alt="profile picture">
    <h5>Username</h5>
    <span>{{ $user->name ?? '' }}</span>
    <h5>Student ID</h5>
    <span>{{ $user->id ?? '' }}</span>
</div>

@endsection

@section('student_infos')

<div class="card">
        <div class="card-header">
            <h3>Nom Prénom (s) et Email</h3>
            <a id="fill" href="#" class="btn-remplir" data-type="identity">Remplir</a>
            <a id="modify"  href="#" class="open-modal-btn" data-type="identity">Modifier</a>
        </div>
        <div class="card-body">
            <div class="info-group">
                <label>Nom</label>
                <strong>{{ $student->last_name ?? '' }}</strong>
            </div>
            <div class="info-group">
                <label>Prénom (s)</label>
                <strong>{{ $student->first_name ?? '' }}</strong>
            </div>
            <div class="info-group">
                <label>Email</label>
                <strong>{{ $user->email ?? '' }}</strong>
            </div>
        </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>Détails personnels</h3>
        <a id="fill" href="#" class="btn-remplir" data-type="personal">Remplir</a>
        <a id="modify"  href="#" class="open-modal-btn" data-type="personal">Modifier</a>
    </div>
    <div class="card-body">
        <div class="info-group">
            <label>Genre</label>
            <strong>{{ $student->gender }}</strong>
        </div>
        <div class="info-group">
            <label>Date de naissance</label>
            <strong>{{ $student->dob }}</strong>
        </div>
        <div class="info-group">
            <label>Addresse</label>
            <strong>{{ $student->address }}</strong>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>Détails d'identification</h3>
        <a id="fill" href="#" class="btn-remplir" data-type="identification">Remplir</a>
        <a id="modify"  href="#" class="open-modal-btn" data-type="identification">Modifier</a>
    </div>
    <div class="card-body">
        <div class="info-group">
            <label>Numéro de passport</label>
            <strong>{{ $student->passport_number }}</strong>
        </div>
        <div class="info-group">
            <label>CNIB</label>
            <strong>{{ $student->cnib_number }}</strong>
        </div>
        <div class="info-group">
            <label>Nationalité</label>
            <strong>{{ $student->nationality }}</strong>
        </div>
        <div class="info-group">
            <label>Téléphone</label>
            <strong>{{ $user->phone ?? '' }}</strong>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>Détails de santé</h3>
        <a id="fill" href="#" class="btn-remplir" data-type="health">Remplir</a>
        <a id="modify"  href="#" class="open-modal-btn" data-type="health">Modifier</a>
    </div>
    <div class="card-body">
        <div class="info-group">
            <label>Taille</label>
            <strong>{{ $student->height }}</strong>
        </div>
        <div class="info-group">
            <label>Poids</label>
            <strong>{{ $student->weight }}</strong>
        </div>
        <div class="info-group">
            <label>Antécédants médicaux</label>
            <strong>{{ $student->medical_history }}</strong>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>Filière & formations</h3>
        <a id="fill" href="#" class="btn-remplir" data-type="program">Remplir</a>
        <a id="modify"  href="#" class="open-modal-btn" data-type="program">Modifier</a>
    </div>
    <div class="card-body">
        <div class="info-group">
            <label>Filière</label>
            <strong>{{ $student->program }}</strong>
        </div>
        <div class="info-group">
            <label>Université</label>
            <strong>{{ $student->university }}</strong>
        </div>
        <div class="info-group">
            <label>Niveau</label>
            <strong>{{ $student->level }}</strong>
        </div>
        <div class="info-group">
            <label>Année en cours</label>
            <strong>{{ $student->academic_year }}</strong>
        </div>
        <div class="info-group">
            <label>Ville</label>
            <strong>{{ $student->city }}</strong>
        </div>
    </div>
</div>
@endsection