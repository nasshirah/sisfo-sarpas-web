@extends('layouts.app')

@section('content')
<h2>Register</h2>

@if ($errors->any())
    <div class="alert error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url('/register') }}">
    @csrf
    <input type="text" name="name" placeholder="Nama" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
    <button type="submit">Register</button>
</form>

<p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
@endsection
