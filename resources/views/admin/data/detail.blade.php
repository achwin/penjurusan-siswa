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
<div style="overflow: auto">
<table id="myTable" class="table table-striped table-bordered" cellspacing="0">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Nilai UN</th>
      <th>Nilai Test Penempatan</th>
      <th>Nilai Ujian Sekolah</th>
      <th>Minat Siswa</th>
      <th>Hasil Akumulasi</th>
      <th>Jurusan</th>
    </tr>
</thead>
  <tbody>
   @forelse($students as $i => $student) 
    <tr>
      <td>{{ $i+1 }}</td>
      <td>{{$student->nama}}</td>
      <td>{{$student->nilai_un}}</td>
      <td>{{$student->nilai_test_penempatan}}</td>    
      <td>{{$student->nilai_ujian_sekolah}}</td>
      <td>{{$student->minat_siswa == '1' ? 'IPA' : 'IPS'}}</td>
      <td>{{$student->hasil}}</td>  
      <td>{{$student->jurusan}}</td>    
    </tr>
     @empty
        <tr>
          <td colspan="7"><center>Belum ada data</center></td>
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