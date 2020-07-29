@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row pb-5">
        <div class="col-3 pt-4">
            <img src="../{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-4 pb-3">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{ $user->profile->name }}</h1>
                @can('update', $user->profile)
                    <a href="{{ route('profile.edit', $user->id) }}">Modify profile</a>
                @endcan
            </div>
            <p>{{ $user->events->count() }} events</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-baseline pt-4">
            <h4>Events created</h4>
            @can('update', $user->profile)
                <a href="{{ route('events.new') }}">Create new event</a>
            @endcan
        </div>
            <div class="card-body">
                <table class="table table-bordered">
                        <tr class="thead-light">
                            <th scope="col">Nom</th>
                            <th scope="col">Date</th>
                            <th scope="col">Categorie</th>
                        </tr>
                    @foreach($user->events as $event)
                        <tr>
                            <td><a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a></td>
                            <td>{{ date('d-m-Y', strtotime($event->date)) }}</td>
                            <td>{{ $event->category }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection