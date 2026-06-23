<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('topbar-action'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">Dashboard</div>
    <div class="page-sub">Selamat datang, <?php echo e(session('user.name')); ?> <?php echo e(session('user.role') === 'admin' ? '(Admin)' : ''); ?></div>
  </div>
</div>

<!-- Stats -->
<div class="stats-grid">
  <a href="<?php echo e(route('dokumen')); ?>" class="stat-card stat-dokumen" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">📄</div>
    <div class="card-num"><?php echo e($stats['dokumen']); ?></div>
    <div class="card-label">Dokumen</div>
    <div class="card-trend">↑ 3 baru minggu ini</div>
  </a>
  <a href="<?php echo e(route('foto')); ?>" class="stat-card stat-foto" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">🖼️</div>
    <div class="card-num"><?php echo e($stats['foto']); ?></div>
    <div class="card-label">Foto</div>
    <div class="card-trend">↑ 12 baru minggu ini</div>
  </a>
  <a href="<?php echo e(route('video')); ?>" class="stat-card stat-video" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">🎬</div>
    <div class="card-num"><?php echo e($stats['video']); ?></div>
    <div class="card-label">Video</div>
    <div class="card-trend">↑ 1 baru minggu ini</div>
  </a>
  <a href="<?php echo e(route('link')); ?>" class="stat-card stat-link" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">🔗</div>
    <div class="card-num"><?php echo e($stats['link']); ?></div>
    <div class="card-label">Link</div>
    <div class="card-trend">↑ 5 baru minggu ini</div>
  </a>
</div>

<!-- Bottom panels -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;">
  <!-- Arsip Terbaru -->
  <div class="panel">
    <div class="panel-header"><span class="panel-title">📋 Arsip Terbaru</span></div>
    <div class="panel-body">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Judul</th>
              <th>Kategori</th>
              <?php if($isAdmin): ?> <th>Pemilik</th> <?php endif; ?>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $arsipTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($item['judul']); ?></td>
              <td><span class="badge <?php echo e($item['badge']); ?>"><?php echo e($item['kategori']); ?></span></td>
              <?php if($isAdmin): ?> <td><?php echo e($item['pemilik']); ?></td> <?php endif; ?>
              <td><?php echo e($item['tanggal']); ?></td>
              <td>
                <div class="td-actions">
                  <button class="btn btn-sm btn-outline" onclick="viewItem(<?php echo e($item['id']); ?>, '<?php echo e($item['type']); ?>')" title="Lihat Detail">👁</button>
                  <button class="btn btn-sm btn-warn" onclick="editItem(<?php echo e($item['id']); ?>, '<?php echo e($item['type']); ?>')" title="Edit">✏️</button>
                  <button class="btn btn-sm btn-danger" onclick="deleteItem(<?php echo e($item['id']); ?>, '<?php echo e($item['type']); ?>', '<?php echo e($item['judul']); ?>')" title="Hapus">🗑</button>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Log Aktivitas -->
  <div class="panel">
    <div class="panel-header"><span class="panel-title">📜 Log Aktivitas</span></div>
    <div class="panel-body">
      <?php $__currentLoopData = $logAktivitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="log-item">
        <div class="log-avatar"><?php echo e($log['initial']); ?></div>
        <div class="log-info">
          <div class="action"><?php echo e($log['action']); ?></div>
          <div class="meta"><?php echo e($log['user']); ?> · <?php echo e($log['waktu']); ?></div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal-body'); ?>
<div style="padding: 20px; text-align: center; color: var(--text3);">
  <p>⚠️ Silakan navigasi ke halaman Dokumen, Foto, Video, atau Link untuk upload.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\arsip-ukri\resources\views/pages/dashboard.blade.php ENDPATH**/ ?>