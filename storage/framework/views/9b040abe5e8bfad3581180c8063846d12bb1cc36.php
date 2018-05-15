<?php $__env->startSection('htmlheader_title'); ?>
Input data siswa
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
Input data siswa
<?php $__env->stopSection(); ?>

<?php $__env->startSection('code-header'); ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
<link rel="stylesheet" href="<?php echo e(asset('/css/dropzone.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
<style>
	.form-group label{
		text-align: left !important;
	}
</style>

	<?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if(Session::has('alert-' . $msg)): ?>
<div class="alert alert-<?php echo e($msg); ?>">
	<p class="" style="border-radius: 0"><?php echo e(Session::get('alert-' . $msg)); ?></p>
</div>
	<?php echo Session::forget('alert-' . $msg); ?>

	<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<div class="row">
	<div class="col-md-12">
		<div class="">

			<?php if(count($errors) > 0): ?>
			<div class="alert alert-danger">
				<ul>
					<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li><?php echo e($error); ?></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
			<?php endif; ?>
			<br>
			<form id="inputData" method="post" action="<?php echo e(url('input-data')); ?>" enctype="multipart/form-data"  class="form-horizontal">
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<div class="form-group">
					<label for="tahun" class="col-sm-2 control-label">Periode</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-lg" id="tahun" name="tahun" placeholder="Contoh: 2017/2018" onkeypress="var key = event.keyCode || event.charCode; return ((key  >= 48 && key  <= 57) || key == 8 || key == 47);"; required>
					</div>
				</div>
				<div class="form-group">
					<label for="kuota_ipa" class="col-sm-2 control-label">Jumlah kuota IPA</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-lg" id="kuota_ipa" name="kuota_ipa" placeholder="Masukkan jumlah kuota IPA" onkeypress="var key = event.keyCode || event.charCode; return ((key  >= 48 && key  <= 57) || key == 8);"; required>
					</div>
				</div>
				<div class="form-group">
					<label for="bobot_nilai_un" class="col-sm-2 control-label">Bobot nilai UN</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-lg" id="bobot_nilai_un" name="bobot_nilai_un" placeholder="Masukkan bobot nilai UN" onkeypress="var key = event.keyCode || event.charCode; return ((key  >= 48 && key  <= 57) || key == 8);"; required value="10">
					</div>
				</div>

				<div class="form-group">
					<label for="bobot_nilai_test_penempatan" class="col-sm-2 control-label">Bobot nilai test penempatan</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-lg" id="bobot_nilai_test_penempatan" name="bobot_nilai_test_penempatan" placeholder="Masukkan bobot nilai test penempatan" onkeypress="var key = event.keyCode || event.charCode; return ((key  >= 48 && key  <= 57) || key == 8);"; required value="20">
					</div>
				</div>

				<div class="form-group">
					<label for="bobot_nilai_ujian_sekolah" class="col-sm-2 control-label">Bobot nilai ujian sekolah</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-lg" id="bobot_nilai_ujian_sekolah" name="bobot_nilai_ujian_sekolah" placeholder="Masukkan bobot nilai ujian sekolah" onkeypress="var key = event.keyCode || event.charCode; return ((key  >= 48 && key  <= 57) || key == 8);"; required value="10">
					</div>
				</div>

				<div class="form-group">
					<label for="bobot_minat_siswa" class="col-sm-2 control-label">Bobot minat siswa</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-lg" id="bobot_minat_siswa" name="bobot_minat_siswa" placeholder="Masukkan bobot minat siswa" onkeypress="var key = event.keyCode || event.charCode; return ((key  >= 48 && key  <= 57) || key == 8);"; required value="60">
					</div>
				</div>
				
				<div class="form-group">
					<label for="data_siswa" class="col-sm-2 control-label">Upload excel data siswa</label>
					<div class="col-md-8">
						<input type="file" class="form-control input-lg" id="data_siswa" name="data_siswa" required>
					</div>
				</div>

				<div class="form-group text-center">
					<div class="col-md-8 col-md-offset-2">
					<button type="submit" class="btn btn-primary btn-lg">
							Confirm
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('code-footer'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>