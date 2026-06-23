<?php $__env->startSection('title', 'Log Aktivitas'); ?>
<?php $__env->startSection('page-title', 'Log Aktivitas'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">📋 Log Aktivitas</div>
    <div class="page-sub">Riwayat seluruh aktivitas pengguna</div>
  </div>
  <div style="display:flex; gap:8px;">
    <button class="btn btn-outline btn-sm" onclick="exportData('csv')" style="display:flex; gap:6px; align-items:center;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
      </svg>
      Export CSV
    </button>
    <button class="btn btn-outline btn-sm" onclick="exportData('pdf')" style="display:flex; gap:6px; align-items:center;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
      </svg>
      Export PDF
    </button>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="log-item">
        <div class="log-avatar"><?php echo e(strtoupper(substr($log->user->nama ?? 'U', 0, 1))); ?></div>
        <div class="log-info">
          <div class="action">
            <span class="badge badge-blue"><?php echo e(str_replace('_', ' ', $log->aksi)); ?></span>
            <?php echo e($log->keterangan ?? 'Tidak ada keterangan tambahan'); ?>

          </div>
          <div class="meta">
            <?php echo e($log->user->nama ?? 'Pengguna tidak dikenal'); ?> · <?php echo e($log->model ?? 'Sistem'); ?> · <?php echo e($log->created_at->diffForHumans()); ?>

          </div>
          <div class="meta">
            ID: <?php echo e($log->model_id ?? '-'); ?> · IP: <?php echo e($log->ip_address ?? '-'); ?>

          </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="empty-state">Belum ada aktivitas yang dicatat.</div>
    <?php endif; ?>

    <?php if(method_exists($logs, 'links')): ?>
      <div style="margin-top:24px;">
        <?php echo e($logs->links()); ?>

      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\arsip-ukri\resources\views/pages/log.blade.php ENDPATH**/ ?>