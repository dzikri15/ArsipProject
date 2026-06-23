

<?php $__env->startSection('title', 'Detail Video'); ?>
<?php $__env->startSection('page-title', 'Detail Video'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">🎬 Detail Video</div>
    <div class="page-sub"><?php echo e($video->judul); ?></div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
      <div>
        <?php
          $videoUrl = Illuminate\Support\Facades\Storage::url($video->file_path);
          $videoExt = strtolower(pathinfo($video->file_path, PATHINFO_EXTENSION));
          $videoType = match($videoExt) {
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            default => 'video/mp4',
          };
        ?>
        <video width="100%" height="auto" style="border-radius: 8px; background: #000; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" controls>
          <source src="<?php echo e($videoUrl); ?>" type="<?php echo e($videoType); ?>">
          Your browser does not support the video tag.
        </video>
        <p style="margin-top: 12px; font-size: 13px; color: var(--text3);">
          <a href="<?php echo e($videoUrl); ?>" target="_blank" style="color: var(--accent);">Buka atau download file video</a>
        </p>
      </div>
      <div>
        <div class="form-group">
          <label>Judul</label>
          <div style="font-size: 16px; font-weight: 500;"><?php echo e($video->judul); ?></div>
        </div>
        <div class="form-group">
          <label>Pemilik</label>
          <div style="font-size: 14px;"><?php echo e($video->user->nama ?? 'N/A'); ?></div>
        </div>
        <div class="form-group">
          <label>Durasi</label>
          <div style="font-size: 14px;"><?php echo e($video->durasi ?? '-'); ?></div>
        </div>
        <div class="form-group">
          <label>Ukuran</label>
          <div style="font-size: 14px;"><?php echo e($video->ukuran); ?></div>
        </div>
        <div class="form-group">
          <label>Tanggal Upload</label>
          <div style="font-size: 14px;"><?php echo e($video->created_at->format('d M Y H:i')); ?></div>
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <div style="font-size: 14px; color: var(--text2);"><?php echo e($video->deskripsi ?? '-'); ?></div>
        </div>
        <div style="display: flex; gap: 8px; margin-top: 20px;">
          <a href="<?php echo e(route('video.edit', $video->id)); ?>" class="btn btn-danger">Edit</a>
          <a href="<?php echo e(route('video')); ?>" class="btn btn-outline">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\arsip-ukri\resources\views/pages/video-show.blade.php ENDPATH**/ ?>