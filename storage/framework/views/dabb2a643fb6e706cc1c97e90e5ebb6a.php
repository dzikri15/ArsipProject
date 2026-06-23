

<?php $__env->startSection('title', 'Edit Link'); ?>
<?php $__env->startSection('page-title', 'Edit Link'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">🔗 Edit Link</div>
    <div class="page-sub"><?php echo e($link['judul'] ?? 'Edit Link'); ?></div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="<?php echo e(route('link.update', $link['id'])); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      <div class="form-group">
        <label class="form-label">Judul Link</label>
        <input type="text" name="judul" value="<?php echo e($link['judul']); ?>" class="form-input" placeholder="Judul tautan..." required>
      </div>

      <div class="form-group">
        <label class="form-label">URL</label>
        <input type="url" name="url" value="<?php echo e($link['url']); ?>" class="form-input" placeholder="https://example.com" required>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 100px; resize: vertical;"><?php echo e($link['deskripsi']); ?></textarea>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?php echo e(route('link')); ?>" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/link-edit.blade.php ENDPATH**/ ?>