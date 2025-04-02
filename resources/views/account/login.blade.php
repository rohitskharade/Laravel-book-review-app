@extends('layouts.app')

@section('main')
  <section class=" p-3 p-md-4 p-xl-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                        @include('layouts.message')
                        <div class="card border border-light-subtle rounded-4">
                            <div class="card-body p-3 p-md-4 p-xl-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-5">
                                            <h4 class="text-center">Login Here</h4>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route("account.authenticate") }}" method="post">
                                    @csrf
                                    <div class="row gy-3 overflow-hidden">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com">
                                                <label for="email" class="form-label">Email</label>
                                                @error('email')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="" placeholder="Password">
                                                <label for="password" class="form-label">Password</label>
                                                @error('password')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button class="btn bsb-btn-xl btn-primary py-3" type="submit">Log In Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-12">
                                        <hr class="mt-5 mb-4 border-secondary-subtle">
                                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-center">
                                            <a href="{{ route('account.register') }}" class="link-secondary text-decoration-none">Create new account</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection