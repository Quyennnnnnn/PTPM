@extends('default')

@section('content')
    <div class="container p-2 p-sm-4">
        <div class="wide-xs mx-auto">
            <div class="card card-gutter-lg rounded-4 card-auth">
                <div class="card-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h1 class="nk-block-title mb-1 text-center">Đăng ký</h1>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Tên</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter name">
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="form-control-wrap">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter email address">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="role" class="form-label">Role</label>
                                    <div class="form-control-wrap">
                                        <select id="role" class="js-select @error('role') is-invalid @enderror" name="role" required>
                                            <option value="Nhan_Vien" {{ old('role') == 'Nhan_Vien' ? 'selected' : '' }}>Nhân viên</option>
                                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="form-control-wrap">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Enter password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password-confirm" class="form-label">Password confirm</label>
                                    <div class="form-control-wrap">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Enter password confirmation">
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Đăng ký</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
