@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card  col-lg-12 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">{{$viewdata->room_name}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                        @if(isset($viewdata->photo))
                        <img src="{!! Route('storage',['filename'=>$viewdata->photo]) !!}" class="img-fluid" alt="image">
                        @endif
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <form method="POST"  action="/booking/inout" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="type_in" value="{{$type}}"/>
                            <input type="hidden" name="bookingId" value="{{$viewdata->id}}"/>

                            <div class="form-group row" style="margin-bottom:0">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Nama</b></label>
                                <div class="col-md-6">
                                    <label class="col-md-12 col-form-label text-md-left">{{$viewdata->room_name}}</label>
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom:0">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Kapasitas</b></label>
                                <div class="col-md-6">
                                    <label class="col-md-12 col-form-label text-md-left">{{$viewdata->room_capacity}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Tanggal Booking</b></label>
                                <div class="col-md-6">
                                    <label for="nama" class="col-md-6 col-form-label text-md-right"><b>{{\Carbon\Carbon::parse($viewdata->booking_time)->format('d/m/Y')}}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Jumlah Orang</b></label>
                                <div class="col-md-6">
                                    <label for="nama" class="col-md-3 col-form-label text-md-right"><b>{{$viewdata->total_person}}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Noted</b></label>
                                <div class="col-md-6">
                                    <label for="nama" class="col-md-3 col-form-label text-md-right"><b>{{$viewdata->note}}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Cek in</b></label>
                                <div class="col-md-6">
                                    <label for="nama" class="col-md-6 col-form-label text-md-right"><b>{{isset($viewdata->check_in_time) ? \Carbon\Carbon::parse($viewdata->check_in_time)->format('d/m/Y'):''}}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-3 col-form-label text-md-right"><b>Cek Out</b></label>
                                <div class="col-md-6">
                                    <label for="nama" class="col-md-6 col-form-label text-md-right"><b>{{isset($viewdata->check_out_time)? \Carbon\Carbon::parse($viewdata->check_out_time)->format('d/m/Y'):''}}</b></label>
                                </div>
                            </div>

                            @if($type == 'cek-in')
                            <button type="submit" class="btn btn-lg btn-block btn-primary">Cek in </button>
                            @endif

                            @if($type == 'cek-out')
                            <button type="submit" class="btn btn-lg btn-block btn-primary">Cek Out </button>
                            @endif
                        </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 