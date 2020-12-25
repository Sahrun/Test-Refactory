@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card  col-lg-12 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">{{$viewdata['room_name']}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                         @if(isset($viewdata['room_photo']))
                        <img src="{!! Route('storage',['filename'=>$viewdata['room_photo']]) !!}" class="img-fluid" alt="image">
                        @endif
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <form method="POST"  action="/booking/now" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="room_id" value="{{$viewdata['room_id']}}"/>
                            <input type="hidden" name="room_capacity" value="{{$viewdata['room_capacity']}}"/>
                            <input type="hidden" name="room_name" value="{{$viewdata['room_name']}}"/>

                            <div class="form-group row" style="margin-bottom:0">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Nama</b></label>
                                <div class="col-md-6">
                                    <label class="col-md-12 col-form-label text-md-left">{{$viewdata['room_name']}}</label>
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom:0">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Kapasitas</b></label>
                                <div class="col-md-6">
                                    <label class="col-md-12 col-form-label text-md-left">{{$viewdata['room_capacity']}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Tanggal Booking</b></label>
                                <div class="col-md-6">
                                 <input id="booking_time" type="date" class="form-control @error('booking_time') is-invalid @enderror" name="booking_time"  value="{{$viewdata['booking_time']}}" required autocomplete="booking_time">
                                    @error('booking_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Jumlah Orang</b></label>
                                <div class="col-md-6">
                                 <input id="total_person" type="number" class="form-control @error('total_person') is-invalid @enderror" name="total_person"  value="{{$viewdata['total_person']}}" required autocomplete="total_person">
                                    @error('total_person')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @if(isset($viewdata['total_person_invalid']))
                                    <span class="text-danger" role="alert">
                                            <strong>{{$viewdata['total_person_invalid']}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Noted</b></label>
                                <div class="col-md-6">
                                    <textarea name="noted" row="4" class="form-control" value="{{$viewdata['noted']}}"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-lg btn-block btn-primary">Booking Sekarang</button>
                        </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
