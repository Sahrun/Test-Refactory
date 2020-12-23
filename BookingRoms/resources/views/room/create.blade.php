@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Room') }}</div>

                <div class="card-body">
                    <form method="POST" action="/room/store" enctype="multipart/form-data" >
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Nama Ruangan') }}</label>

                            <div class="col-md-6">
                                <input id="room_name" type="text" class="form-control @error('room_name') is-invalid @enderror" name="room_name" value="{{ old('room_name') }}" required autocomplete="room_name">

                                @error('room_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Kapasitas Ruangan') }}</label>

                            <div class="col-md-6">
                                <input id="room_capacity" type="number" class="form-control @error('room_capacity') is-invalid @enderror" name="room_capacity" required autocomplete="room_capacity">

                                @error('room_capacity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                            <div class="col-md-6">
                                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" required accept="image/png, image/jpeg">
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>File Foto Terlalu Besar </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
