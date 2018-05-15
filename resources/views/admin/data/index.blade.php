@extends('adminlte::layouts.app')

@section('code-header')


@endsection

@section('htmlheader_title')
Data siswa
@endsection

@section('contentheader_title')
Data siswa
@endsection

@section('main-content')

<br>
<!-- include summernote css/js-->
<div class="flash-message" style="margin-left: -16px;margin-right: -16px; margin-top: 13px;">
  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(Session::has('alert-' . $msg))
<div class="alert alert-{{ $msg }}">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <p class="" style="border-radius: 0">{{ Session::get('alert-' . $msg) }}</p>
</div>
  {!!Session::forget('alert-' . $msg)!!}
  @endif
  @endforeach
</div>
<div style="margin-bottom: 10px">
  <a href="{{url('input-data')}}" type="button" class="btn btn-primary btn-md" >
    <i class="fa fa-plus-square"></i> Input data</a>
</div>
<div style="overflow: auto">
<table id="myTable" class="table table-striped table-bordered" cellspacing="0">
  <thead>
    <tr>
      <th>No.</th>
      <th>Periode</th>
      <th>Bobot Nilai UN</th>
      <th>Bobot Nilai Test Penempatan</th>
      <th>Bobot Nilai Ujian Sekolah</th>
      <th>Bobot Minat Siswa</th>
      <th>Kuota IPA</th>
      <th>Aksi</th>
    </tr>
</thead>
  <tbody>
   @forelse($periods as $i => $period) 
    <tr>
      <td>{{ $i+1 }}</td>
      <td>{{$period->tahun}}</td>
      <td>{{$period->nilai_un}}</td>
      <td>{{$period->nilai_test_penempatan}}</td>
      <td>{{$period->nilai_ujian_sekolah}}</td>
      <td>{{$period->minat_siswa}}</td>
      <td>{{$period->kuota_ipa}}</td>
      <td style="width: 10%;">
        <a style="margin-bottom: 5px;" href="{{'data-siswa/detail/'.$period->id}}" class="btn btn-sm btn-info">Detail</a>
        <a style="margin-bottom: 5px;" onclick="return confirm('Apakah anda yakin untuk menghapus?')" href="{{'data-siswa/delete/'.$period->id}}" class="btn btn-sm btn-danger">Hapus</a>
        <a href="{{'data-siswa/export/'.$period->id}}" class="btn btn-sm btn-success">Export as excel</a>
      </td>
    </tr>
     @empty
        <tr>
          <td colspan="8"><center>Belum ada data</center></td>
        </tr>
    @endforelse
  </tbody>
</table>
</div>
  
@endsection

@section('code-footer')
<script type="text/javascript">
  $(document).ready(function(){
      $('#myTable').DataTable({
        destroy: true,
        "ordering": true
      });
    });
</script>
@endsection