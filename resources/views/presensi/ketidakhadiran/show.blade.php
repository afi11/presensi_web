@extends('templates.main')
@section('title',$title)
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb p-0">
              <li class="breadcrumb-item">
                <a href="{{ url("/") }}">
                  <span class="mdi mdi-home"></span>                
                </a>
              </li>
              <li class="breadcrumb-item text-success" aria-current="page">
                Ketidakhadiran Pegawai
              </li>
            </ol>
        </nav>
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Daftar Ketidakhadiran Pegawai</h2>
            </div>
            <div class="card-body">
                <a href="{{ route('ketidakhadiran.create') }}" class="btn btn-primary mb-4">Tambah Ketidakhadiran <i class="fa fa-plus"></i></a>
                @if(Session::has('success'))
                    <div class="alert alert-dismissible fade show alert-success" role="alert">
                        {{ Session::get("success") }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                <div class="basic-data-table">
                    <table id="data" class="table dt-responsive nowrap table-bordered dt-responsive nowrap " style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>NIP</td>
                                <td>Nama</td>
                                <td>Tipe</td>
                                <td>Tanggal Mulai</td>
                                <td>Tanggal Selesai</td>
                                <td>Status Izin</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($absensi as $item) @php $no++; @endphp
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->tipe_izin }}</td>
                                    <td>{{ $item->tgl_start_izin }}</td>
                                    <td>{{ $item->tgl_end_izin }}</td>
                                    <td>
                                        @if ($item->status_izin == "waiting")
                                            <span class="badge badge-warning rounded-pill">Pending</span>
                                        @elseif(($item->status_izin == "accepted"))
                                            <span class="badge badge-success rounded-pill">Diterima</span>
                                        @elseif(($item->status_izin == "rejected"))
                                            <span class="badge badge-danger rounded-pill">Ditolak</span></td>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailAbsen{{ $item->presensi_id }}">Detail</button>
                                        @if($item->tipe_izin != "dinas_luar")
                                            <a href="{{ url('pengajuan_izin_cuti/'.$item->presensi_id.'/'.$item->pegawai_id) }}" class="btn btn-primary btn-sm">Cetak Pengajuan</a>
                                        @endif
                                    </td>
                                </tr>
    
                                <!-- Modal -->
                                <div class="modal fade" id="detailAbsen{{ $item->presensi_id }}" data-backdrop="static" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Ketidakhadiran</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Pegawai : </label>
                                                    <p>{{ $item->nama }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jabatan : </label>
                                                    <p>{{ $item->nama_jabatan }} | {{ $item->nama_tipe }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Mulai Izin : </label>
                                                    <p>{{ $item->tgl_start_izin }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Selesai Izin : </label>
                                                    <p>{{ $item->tgl_end_izin }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tipe Izin / Cuti : </label>
                                                    <p>{{ $item->tipe_izin }} </p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Status Izin / Cuti</label>
                                                    <p>
                                                        @if ($item->status_izin == "waiting")
                                                            <span class="font-weight-bolder text-warning">Pending</span>
                                                        @elseif(($item->status_izin == "accepted"))
                                                            <span class="font-weight-bolder text-success">Diterima</span>
                                                        @elseif(($item->status_izin == "rejected"))
                                                            <span class="font-weight-bolder text-danger">Ditolak</span></td>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan : </label>
                                                    <p>{{ $item->keterangan }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label>File Izin : </label>
                                                    @if($item->tipe_file == "image")
                                                        <img class="img" src="{{ asset('files/absensi/'.$item->bukti_izin) }}" />
                                                    @else
                                                        <p>
                                                            <a target="blank" href="{{ asset('files/absensi/'.$item->bukti_izin) }}">Lihat file <i class="mdi mdi-file-pdf"></i> </a>
                                                        </p>
                                                    @endif                                  
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan Pengajuan</label>
                                                    <p>{{ $item->ket_izin_admin }}</p>
                                                </div>
                                            </div>
                                            @if($item->status_izin == "waiting")
                                            <form action="{{ route('ketidakhadiran.store') }}" method="POST">
                                                @csrf
                                                <div class="form-group p-3">
                                                    <input type="hidden" name="pegawai_id" value="{{ $item->pegawai_id }}" />
                                                    <input type="hidden" name="presensi_id" value="{{ $item->presensi_id }}" />
                                                    <input type="hidden" name="tgl_awal" value="{{ $item->tgl_start_izin }}" />
                                                    <input type="hidden" name="tgl_akhir" value="{{ $item->tgl_end_izin }}" />
                                                    <input type="hidden" name="status_izin" class="status_izin" />
                                                    <label>Keterangan </label>
                                                    <textarea class="form-control" id="ket_from_admin" name="ket_izin_admin" placeholder="Contoh : Bukti izin belum"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn-approve btn btn-primary" 
                                                        onclick="actAbsen('accepted')">Approve</button>
                                                    <button class="btn btn-primary btn-loading hide" type="button" disabled>
                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                        Loading...
                                                    </button>
                                                    <button type="submit" class="btn btn-danger btn-reject"
                                                        onclick="actAbsen('rejected')">Reject</button>
                                                </div>
                                            </form>
                                            @endif
                                            <div id="snackbar"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection