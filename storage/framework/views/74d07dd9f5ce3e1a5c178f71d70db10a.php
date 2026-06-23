<?php $__env->startSection('title', 'Arsip Link'); ?>
<?php $__env->startSection('page-title', 'Arsip Link'); ?>

<?php $__env->startSection('topbar-action'); ?>
  <button class="btn btn-outline btn-sm" onclick="openModal('🔗 Tambah Link', 'link', '/link')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah
  </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">🔗 Arsip Link</div>
    <div class="page-sub">Kelola koleksi tautan</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Judul</th>
            <th>URL</th>
            <?php if($isAdmin): ?> <th>Pemilik</th> <?php endif; ?>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($l->judul); ?></td>
            <td><a href="https://<?php echo e($l->url); ?>" target="_blank" style="color:var(--accent);font-size:12px;"><?php echo e($l->url); ?></a></td>
            <?php if($isAdmin): ?> <td><?php echo e($l->user->nama ?? 'N/A'); ?></td> <?php endif; ?>
            <td><?php echo e($l->deskripsi ?? '-'); ?></td>
            <td><?php echo e($l->created_at->format('d M Y H:i')); ?></td>
            <td>
              <div class="td-actions">
                <button class="btn btn-sm btn-outline" onclick="window.open('https://<?php echo e($l->url); ?>', '_blank')" title="Buka Link">🔗</button>
                <button class="btn btn-sm btn-warn" onclick="editItem(<?php echo e($l->id); ?>, 'link')" title="Edit">✏️</button>
                <button class="btn btn-sm btn-danger" onclick="deleteItem(<?php echo e($l->id); ?>, 'link', '<?php echo e($l->judul); ?>')" title="Hapus">🗑</button>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="6" style="text-align:center;color:var(--text3);padding:32px;">Belum ada tautan.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal-body'); ?>
<div class="form-group">
  <label class="form-label">Judul</label>
  <input type="text" name="judul" class="form-input" placeholder="Judul tautan..." required>
</div>
<div class="form-group">
  <label class="form-label">URL</label>
  <input type="url" name="url" class="form-input" placeholder="https://example.com" required>
</div>
<div class="form-group">
  <label class="form-label">Deskripsi (Opsional)</label>
  <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 80px; resize: vertical;"></textarea>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\resources\views/pages/link.blade.php ENDPATH**/ ?>