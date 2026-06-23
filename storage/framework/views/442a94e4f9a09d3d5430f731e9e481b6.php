

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Detail Link</h1>
        <a href="<?php echo e(route('link')); ?>" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-600">Judul</label>
                <p class="text-lg"><?php echo e($link['judul']); ?></p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Pemilik</label>
                <p class="text-lg"><?php echo e($link['pemilik']); ?></p>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-600">URL</label>
                <a href="https://<?php echo e($link['url']); ?>" target="_blank" class="text-lg text-blue-600 underline"><?php echo e($link['url']); ?></a>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Tanggal</label>
                <p class="text-lg"><?php echo e($link['tanggal']); ?></p>
            </div>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-semibold text-gray-600">Deskripsi</label>
            <p class="text-lg"><?php echo e($link['deskripsi']); ?></p>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="<?php echo e(route('link.edit', $link['id'])); ?>" class="px-4 py-2 bg-blue-500 text-white rounded">Edit</a>
            <a href="<?php echo e(route('link')); ?>" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\arsip-ukri\arsip-ukri\resources\views/pages/link-show.blade.php ENDPATH**/ ?>