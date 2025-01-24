@extends('layouts.navbar')

@section('content')
    <h3>Change Password</h3>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control" name="current_password" id="current_password">
                        <label for="current_password">Current Password</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="password" class="form-control" name="new_password" id="new_password">
                        <label for="new_password">New Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
