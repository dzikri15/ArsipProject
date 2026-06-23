<?php $__env->startSection('title', 'Arsip Video'); ?>
<?php $__env->startSection('page-title', 'Arsip Video'); ?>

<?php $__env->startSection('topbar-action'); ?>
  <button class="btn btn-outline btn-sm" onclick="openModal('🎬 Upload Video', 'video', '/video')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah
  </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">🎬 Arsip Video</div>
    <div class="page-sub">Kelola koleksi video</div>
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
            <th>Durasi</th>
            <th>Ukuran</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if($video->count() > 0): ?>
            <?php $__currentLoopData = $video; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($v->judul); ?></td>
              <?php if($isAdmin): ?> <td><?php echo e($v->user->nama ?? 'N/A'); ?></td> <?php endif; ?>
              <td><?php echo e($v->durasi ?? '-'); ?></td>
              <td><?php echo e($v->ukuran); ?></td>
              <td><?php echo e($v->created_at->format('d M Y H:i')); ?></td>
              <td>
                <div class="td-actions">
                  <button class="btn btn-sm btn-outline" onclick="viewItem(<?php echo e($v->id); ?>, 'video')" title="Play">▶️</button>
                  <button class="btn btn-sm btn-warn" onclick="editItem(<?php echo e($v->id); ?>, 'video')" title="Edit">✏️</button>
                  <button class="btn btn-sm btn-danger" onclick="deleteItem(<?php echo e($v->id); ?>, 'video', '<?php echo e($v->judul); ?>')" title="Hapus">🗑</button>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align: center; padding: 40px; color: var(--text2);">
                <div style="font-size: 36px; margin-bottom: 8px;">🎬</div>
                <p style="margin: 0;">Belum ada video</p>
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
  <label class="form-label">Judul Video</label>
  <input type="text" name="judul" class="form-input" placeholder="Masukkan judul video..." required>
</div>
<div class="form-group">
  <label class="form-label">File Video</label>
  <div class="file-drop" style="border: 2px dashed var(--border); border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.2s;">
    <div class="icon" style="font-size: 32px; margin-bottom: 8px;">🎬</div>
    <p style="margin: 0; font-weight: 500;">Klik atau seret video ke sini</p>
    <p style="font-size: 12px; color: var(--text3); margin: 6px 0 0 0;">MP4, MOV, AVI — Maks. 2GB</p>
  </div>
  <input type="file" name="file" style="display: none;" accept=".mp4,.mov,.avi,.mkv" required>
</div>
<div class="form-group">
  <label class="form-label">Deskripsi (Opsional)</label>
  <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 80px; resize: vertical;"></textarea>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/video.blade.php ENDPATH**/ ?>