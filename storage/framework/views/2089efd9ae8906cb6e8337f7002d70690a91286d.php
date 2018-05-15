<?php $__env->startSection('code-header'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('htmlheader_title'); ?>
Data siswa
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
Data siswa
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

<br>
<!-- include summernote css/js-->
<div class="flash-message" style="margin-left: -16px;margin-right: -16px; margin-top: 13px;">
  <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php if(Session::has('alert-' . $msg)): ?>
<div class="alert alert-<?php echo e($msg); ?>">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <p class="" style="border-radius: 0"><?php echo e(Session::get('alert-' . $msg)); ?></p>
</div>
  <?php echo Session::forget('alert-' . $msg); ?>

  <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div style="margin-bottom: 10px">
  <a href="<?php echo e(url('input-data')); ?>" type="button" class="btn btn-primary btn-md" >
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
   <?php $__empty_1 = true; $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
    <tr>
      <td><?php echo e($i+1); ?></td>
      <td><?php echo e($period->tahun); ?></td>
      <td><?php echo e($period->nilai_un); ?></td>
      <td><?php echo e($period->nilai_test_penempatan); ?></td>
      <td><?php echo e($period->nilai_ujian_sekolah); ?></td>
      <td><?php echo e($period->minat_siswa); ?></td>
      <td><?php echo e($period->kuota_ipa); ?></td>
      <td style="width: 10%;">
        <a style="margin-bottom: 5px;" href="<?php echo e('data-siswa/detail/'.$period->id); ?>" class="btn btn-sm btn-info">Detail</a>
        <a style="margin-bottom: 5px;" onclick="return confirm('Apakah anda yakin untuk menghapus?')" href="<?php echo e('data-siswa/delete/'.$period->id); ?>" class="btn btn-sm btn-danger">Hapus</a>
        <a href="<?php echo e('data-siswa/export/'.$period->id); ?>" class="btn btn-sm btn-success">Export as excel</a>
      </td>
    </tr>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="8"><center>Belum ada data</center></td>
        </tr>
    <?php endif; ?>
  </tbody>
</table>
</div>
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('code-footer'); ?>
<script type="text/javascript">
  $(document).ready(function(){
      $('#myTable').DataTable({
        destroy: true,
        "ordering": true
      });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>