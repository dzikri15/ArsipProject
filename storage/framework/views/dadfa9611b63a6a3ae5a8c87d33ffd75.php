

<?php $__env->startSection('title', 'Edit User'); ?>
<?php $__env->startSection('page-title', 'Edit User'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-heading">👤 Edit User</div>
    <div class="page-sub">Perbarui data pengguna sistem</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="<?php echo e(route('users.update', $editUser->id)); ?>" method="POST" class="form-vertical">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      <div class="form-group">
        <label for="nama">Nama Lengkap *</label>
        <input type="text" id="nama" name="nama" value="<?php echo e($editUser->nama); ?>" class="form-control" placeholder="Nama lengkap pengguna" required>
        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" value="<?php echo e($editUser->email); ?>" class="form-control" placeholder="email@example.com" required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label for="nim">NIM/NPK</label>
        <input type="text" id="nim" name="nim" value="<?php echo e($editUser->nim); ?>" class="form-control" placeholder="Nomor Induk Mahasiswa" readonly>
      </div>

      <div class="form-group">
        <label for="role">Role *</label>
        <select id="role" name="role" class="form-control" required>
          <option value="admin" <?php echo e($editUser->role === 'admin' ? 'selected' : ''); ?>>Admin</option>
          <option value="user" <?php echo e($editUser->role === 'user' ? 'selected' : ''); ?>>User</option>
        </select>
        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-actions">
        <a href="<?php echo e(route('users')); ?>" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/users-edit.blade.php ENDPATH**/ ?>