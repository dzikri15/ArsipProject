

<?php $__env->startSection('title', 'Edit Dokumen'); ?>
<?php $__env->startSection('page-title', 'Edit Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">📄 Edit Dokumen</div>
    <div class="page-sub"><?php echo e($dokumen['judul'] ?? 'Edit Dokumen'); ?></div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="<?php echo e(route('dokumen.update', $dokumen['id'])); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      <div class="form-group">
        <label class="form-label">Judul Dokumen</label>
        <input type="text" name="judul" value="<?php echo e($dokumen['judul']); ?>" class="form-input" required>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 100px; resize: vertical;"><?php echo e($dokumen['deskripsi']); ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">File Dokumen (Opsional)</label>
        <input type="file" name="file" class="form-input" accept=".pdf,.doc,.docx,.xls,.xlsx">
        <div style="font-size: 12px; color: var(--text3); margin-top: 6px;">PDF, DOCX, XLSX — Maks. 50MB</div>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
        <a href="<?php echo e(route('dokumen')); ?>" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\arsip-ukri\resources\views/pages/dokumen-edit.blade.php ENDPATH**/ ?>