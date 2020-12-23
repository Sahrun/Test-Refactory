@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Daftar Ruangan') }}</div>
                <a href="/room/create" class="btn btn-info"> Tambah Ruangan </a>
                <div class="card-body">
                <div class="table-responsive">
                            <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="add-row" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                                            <thead>
                                                <tr role="row">
                                                    <th tabindex="0" aria-controls="add-row" rowspan="1" colspan="1">No</th>
                                                    <th tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" style="width: 233px;">Photo</th>
                                                    <th tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" style="width: 233px;">Nama Ruangan</th>
                                                    <th class="sorting_asc" id="sorting_nama" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1">Kapasitas</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1 ?>
                                                @foreach ($rooms as $item)
                                                <tr role="row" class="{{$no%2?'odd':'even'}}">
                                                    <td class="sorting_1">{{$no++}}</td>
                                                    <td class="sorting_1" style="width: 15%;">
                                                    @if($item->photo != null)
                                                            <img src="{!! Route('storage',['filename'=>$item->photo]) !!}" alt="{{$item->room_name}}" class="img-fluid img-thumbnail">
                                                            @endif
                                         
                                                    </td>
                                                    <td class="sorting_1">{{$item->room_name}}</td>
                                                    <td>{{$item->room_capacity}}</td>
                                                    <td><a href="{{url('booking/now?roomId='.$item->id)}}" class="btn btn-warning"> Book </a> </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
