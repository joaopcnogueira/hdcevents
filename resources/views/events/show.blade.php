@extends('layouts.main')

@section('title', 'Evento')

@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="{{ asset("img/events/$event->image") }}" class="img-fluid" alt="{{ $event->title }}">
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{ $event->title }}</h1>
                <p class="event-city"><ion-icon name="location-outline"></ion-icon> {{ $event->city }}</p>
                <p class="event-date"><ion-icon name="calendar-outline"></ion-icon> {{ $event->date->format('d/m/Y') }}</p>
                <p class="events-participants"><ion-icon name="people-outline"></ion-icon> X participantes</p>
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon> Dono: {{ $eventOwner['name'] }} </p>
                <form action="{{ route('events.join', $event->id) }}" method="post">
                    @csrf
                    <button class="btn btn-primary" type="submit">Confirmar Presença</button>
                    {{-- <a href="#" class="btn btn-primary" id="event-submit">Confirmar Presença</a> --}}
                </form>
                
                <h3>O evento conta com:</h3>
                <ul id="items-list">
                    @foreach ($event->items as $item)
                        <li><ion-icon name="play-outline"></ion-icon>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento:</h3>
                <p class="event-description">{{ $event->description }}</p>
            </div>
        </div>
    </div>
    
@endsection