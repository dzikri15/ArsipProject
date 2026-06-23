<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Sistem Arsip Digital UKRI</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>

<body>

  <div class="login-page">
    <div class="login-card">
      <div class="login-logo">
        <div class="logo-badge">
          <?php $loginLogoPath = public_path('images/ukri.jpg'); ?>
          <?php if(file_exists($loginLogoPath)): ?>
            <img src="<?php echo e(asset('images/ukri.jpg')); ?>" alt="UKRI Logo">
          <?php else: ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
              <path d="M8 7h8M8 11h8M8 15h5" />
            </svg>
          <?php endif; ?>
          UKRI — Sistem Arsip
        </div>
      </div>
      <h1 class="login-title">Selamat Datang</h1>
      <p class="login-sub">Masuk ke Sistem Arsip Dokumen Digital UKRI</p>

      <?php if($errors->any()): ?>
        <div class="alert-error"><?php echo e($errors->first()); ?></div>
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('login.post')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input class="form-input" type="email" name="email" placeholder="email@ukri.ac.id" value="<?php echo e(old('email')); ?>"
            required>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input class="form-input" type="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-danger login-submit">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3" />
          </svg>
          Masuk
        </button>
      </form>

      <div class="login-hint">
        <p>Demo akun:</p>
        <code>dzikri@ukri.ac.id</code> → Admin<br>
        <code>jilan@ukri.ac.id</code> → User<br>
        <small>Password semua: <code>password</code></small>
      </div>

      <p style="text-align:center;margin-top:16px;font-size:12px;color:var(--text3);">
        Tidak punya akun? Hubungi Admin untuk mendapatkan akses.
      </p>
    </div>
  </div>

</body>

</html><?php /**PATH C:\Users\hp\Downloads\arsip-ukri\resources\views/pages/login.blade.php ENDPATH**/ ?>