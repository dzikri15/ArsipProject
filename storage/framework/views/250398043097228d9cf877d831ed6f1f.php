<?php $__env->startSection('title', 'Pencarian'); ?>
<?php $__env->startSection('page-title', 'Pencarian'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">🔍 Pencarian</div>
    <div class="page-sub">Cari arsip berdasarkan kata kunci</div>
  </div>
</div>

<form method="GET" action="<?php echo e(route('pencarian')); ?>">
  <div class="search-bar-wrap">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
    </svg>
    <input class="search-input" type="text" name="q" value="<?php echo e($keyword); ?>"
      placeholder="Ketik kata kunci pencarian... (contoh: KKN, Wisuda, 2026)">
  </div>

  <div class="category-tabs">
    <?php $__currentLoopData = ['semua' => 'Semua', 'dokumen' => '📄 Dokumen', 'foto' => '🖼️ Foto', 'video' => '🎬 Video', 'link' => '🔗 Link']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <button type="submit" name="kategori" value="<?php echo e($val); ?>"
        class="tab <?php echo e($kategori === $val ? 'active' : ''); ?>"><?php echo e($label); ?></button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</form>

<div class="panel">
  <div class="panel-header">
    <span class="panel-title">Hasil Pencarian
      <?php if($keyword): ?>
        <small style="font-size:12px;font-weight:400;color:var(--text3);">— "<?php echo e($keyword); ?>" (<?php echo e(count($hasil)); ?> hasil)</small>
      <?php endif; ?>
    </span>
  </div>
  <div class="panel-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Judul</th><th>Kategori</th><th>Pemilik</th><th>Tanggal</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $hasil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($item['judul']); ?></td>
            <td><span class="badge <?php echo e($item['badge']); ?>"><?php echo e($item['kategori']); ?></span></td>
            <td><?php echo e($item['pemilik']); ?></td>
            <td><?php echo e($item['tanggal']); ?></td>
            <td><button class="btn btn-sm btn-outline" onclick="viewItem(<?php echo e($item['id']); ?>, '<?php echo e(strtolower($item['kategori'])); ?>')" title="Lihat Detail">👁 Lihat</button></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5">
              <div class="empty-state">
                <div class="icon">🔍</div>
                <p><?php echo e($keyword ? 'Tidak ada hasil untuk "' . $keyword . '"' : 'Masukkan kata kunci untuk mencari arsip.'); ?></p>
              </div>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/pencarian.blade.php ENDPATH**/ ?>