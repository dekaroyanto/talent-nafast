@extends('layouts.navbar')

@section('content')
    <h2>Edit Profile</h2>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" id="name">
                        <label for="name">Nama </label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                            id="email">
                        <label for="email">Email </label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" name="username" value="{{ $user->username }}"
                            id="username">
                        <label for="username">Username </label>
                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
