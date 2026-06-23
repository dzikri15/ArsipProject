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
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>User</th><th>Aksi</th><th>Dokumen/File</th><th>Waktu</th><th>Keterangan</th></tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($log['user']); ?></td>
            <td><span class="badge <?php echo e($log['badge']); ?>"><?php echo e($log['aksi']); ?></span></td>
            <td><?php echo e($log['file']); ?></td>
            <td><?php echo e($log['waktu']); ?></td>
            <td><?php echo e($log['keterangan']); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/log.blade.php ENDPATH**/ ?>