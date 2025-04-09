@extends('layouts.base', ['subtitle' => 'Sign Up'])

@section('body-attribuet')
class="authentication-bg"
@endsection

@section('content')
<div class="account-pages py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <div class="mx-auto mb-4 text-center auth-logo">
                                <a href="" class="logo-dark">
                                    <img src="/images/logomunihazul.png" height="60" alt="logo dark">
                                </a>

                                <a href="" class="logo-light">
                                    <img src="/images/logomunihblanco.png" height="60" alt="logo light">
                                </a>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Registro de Usuario</h3>

                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="example-name">Nombre</label>
                                <input type="name" id="name" name="name" class="form-control"
                                    placeholder="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="example-email">Correo</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="example-password">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="">
                            </div>

                            <div class="mb-1 text-center d-grid">
                                <button class="btn btn-dark btn-lg fw-medium" type="submit">Registrar Usuario</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection