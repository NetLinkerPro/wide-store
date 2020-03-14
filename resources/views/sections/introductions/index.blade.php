@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::introductions.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::introductions.meta_description'))

@push('head')
    @include('wide-store::integration.favicons')
    @include('wide-store::integration.ga')
@endpush

@section('create_button')

@endsection

@section('content')
    <div class="grid">
        <div class="cell">
            <h2>Proces powiązania aukcji</h2>
            <ol>
                <li>
                    <a href="{{route('lead-allegro.accounts.index')}}">Dodanie konta Allegro</a>
                </li>
                <li>
                    Importowanie aukcji z Allegro. Opcja dostępna w liście zawierającej dodane konta Allegro.
                </li>
                <li>
                   Oczekiwanie na zakończenie importowania aukcji. Podgląd procesu importowania dostępny w
                   <a href="{{route('fair-queue.job_statuses.index') }}">zarządzaniu statusami zadań</a>.
                </li>
                <li>
                    Wyszukiwanie produktów do powiązania. Zadanie uruchamiane przyciskiem <code>Wyszukaj powiązania</code>
                    na <a href="{{route('wide-store.relations.index') }}">stronie powiązań</a>.
                </li>
                <li>
                    Oczekiwanie na zakończenie wyszukiwania powiązań. Podgląd procesu wyszukiwania dostępny w
                    <a href="{{route('fair-queue.job_statuses.index') }}">zarządzaniu statusami zadań</a>.
                </li>
                <li>
                   Wybranie powiązań wymagających ręcznego zatwierdzenia przyciskiem <code>Wybierz produkt</code>.
                </li>
                <li>
                   Zapisanie powiązań produktów do systemu Allegro z użyciem przycisku <code>Zastosuj wybrane powiązania w aukcjach</code>.
                    Podgląd procesu zapisywania dostępny w
                    <a href="{{route('fair-queue.job_statuses.index') }}">zarządzaniu statusami zadań</a>.
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('modals')


@endsection
