<?php $__env->startSection('title', 'Arsip Foto'); ?>
<?php $__env->startSection('page-title', 'Arsip Foto'); ?>

<?php $__env->startSection('topbar-action'); ?>
  <button class="btn btn-outline btn-sm" onclick="openModal('🖼️ Upload Foto', 'foto', '/foto')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah
  </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">🖼️ Arsip Foto</div>
    <div class="page-sub">Kelola koleksi foto</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Judul</th>
            <?php if($isAdmin): ?> <th>Pemilik</th> <?php endif; ?>
            <th>Ukuran</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if($foto->count() > 0): ?>
            <?php $__currentLoopData = $foto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($f->judul); ?></td>
              <?php if($isAdmin): ?> <td><?php echo e($f->user->nama ?? 'N/A'); ?></td> <?php endif; ?>
              <td><?php echo e($f->ukuran); ?></td>
              <td><?php echo e($f->created_at->format('d M Y H:i')); ?></td>
              <td>
                <div class="td-actions">
                  <button class="btn btn-sm btn-outline" onclick="viewItem(<?php echo e($f->id); ?>, 'foto')" title="Lihat">👁</button>
                  <button class="btn btn-sm btn-warn" onclick="editItem(<?php echo e($f->id); ?>, 'foto')" title="Edit">✏️</button>
                  <button class="btn btn-sm btn-danger" onclick="deleteItem(<?php echo e($f->id); ?>, 'foto', '<?php echo e($f->judul); ?>')" title="Hapus">🗑</button>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align: center; padding: 40px; color: var(--text2);">
                <div style="font-size: 36px; margin-bottom: 8px;">🖼️</div>
                <p style="margin: 0;">Belum ada foto</p>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal-body'); ?>
<div class="form-group">
  <label class="form-label">Judul Foto</label>
  <input type="text" name="judul" class="form-input" placeholder="Masukkan judul foto..." required>
</div>
<div class="form-group">
  <label class="form-label">File Foto</label>
  <div class="file-drop" style="border: 2px dashed var(--border); border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.2s;">
    <div class="icon" style="font-size: 32px; margin-bottom: 8px;">🖼️</div>
    <p style="margin: 0; font-weight: 500;">Klik atau seret foto ke sini</p>
    <p style="font-size: 12px; color: var(--text3); margin: 6px 0 0 0;">JPG, PNG, WEBP — Maks. 10MB</p>
  </div>
  <input type="file" name="file" style="display: none;" accept=".jpg,.jpeg,.png,.webp" required>
</div>
<div class="form-group">
  <label class="form-label">Deskripsi (Opsional)</label>
  <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 80px; resize: vertical;"></textarea>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\arsip-ukri\resources\views/pages/foto.blade.php ENDPATH**/ ?>