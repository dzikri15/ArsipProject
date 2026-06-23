

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Detail Dokumen</h1>
        <a href="<?php echo e(route('dokumen')); ?>" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-600">Judul</label>
                <p class="text-lg"><?php echo e($dokumen['judul']); ?></p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Pemilik</label>
                <p class="text-lg"><?php echo e($dokumen['pemilik']); ?></p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Ukuran</label>
                <p class="text-lg"><?php echo e($dokumen['ukuran']); ?></p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Tipe</label>
                <p class="text-lg"><?php echo e($dokumen['tipe']); ?></p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Tanggal</label>
                <p class="text-lg"><?php echo e($dokumen['tanggal']); ?></p>
            </div>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-semibold text-gray-600">Deskripsi</label>
            <p class="text-lg"><?php echo e($dokumen['deskripsi']); ?></p>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="<?php echo e(route('dokumen.edit', $dokumen['id'])); ?>" class="px-4 py-2 bg-blue-500 text-white rounded">Edit</a>
            <a href="<?php echo e(route('dokumen.download', $dokumen['id'])); ?>" class="px-4 py-2 bg-green-500 text-white rounded">Download</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/dokumen-show.blade.php ENDPATH**/ ?>