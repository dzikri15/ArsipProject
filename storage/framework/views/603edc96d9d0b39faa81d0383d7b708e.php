

<?php $__env->startSection('title', 'Detail Foto'); ?>
<?php $__env->startSection('page-title', 'Detail Foto'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">🖼️ Detail Foto</div>
    <div class="page-sub"><?php echo e($foto->judul); ?></div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
      <div>
        <img src="<?php echo e(asset('storage/' . $foto->file_path)); ?>" alt="<?php echo e($foto->judul); ?>" style="width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      </div>
      <div>
        <div class="form-group">
          <label>Judul</label>
          <div style="font-size: 16px; font-weight: 500;"><?php echo e($foto->judul); ?></div>
        </div>
        <div class="form-group">
          <label>Pemilik</label>
          <div style="font-size: 14px;"><?php echo e($foto->user->nama ?? 'N/A'); ?></div>
        </div>
        <div class="form-group">
          <label>Ukuran</label>
          <div style="font-size: 14px;"><?php echo e($foto->ukuran); ?></div>
        </div>
        <div class="form-group">
          <label>Tanggal Upload</label>
          <div style="font-size: 14px;"><?php echo e($foto->created_at->format('d M Y H:i')); ?></div>
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <div style="font-size: 14px; color: var(--text2);"><?php echo e($foto->deskripsi ?? '-'); ?></div>
        </div>
        <div style="display: flex; gap: 8px; margin-top: 20px;">
          <a href="<?php echo e(route('foto.edit', $foto->id)); ?>" class="btn btn-primary">Edit</a>
          <a href="<?php echo e(route('foto')); ?>" class="btn btn-outline">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/foto-show.blade.php ENDPATH**/ ?>