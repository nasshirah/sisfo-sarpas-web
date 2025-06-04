@extends('layouts.app')

@section('content')
<h2>Login</h2>

@if (session('success'))
    <div class="alert success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url('/login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
@endsection
