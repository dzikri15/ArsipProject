@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Detail Dokumen</h1>
        <a href="{{ route('dokumen') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-600">Judul</label>
                <p class="text-lg">{{ $dokumen['judul'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Pemilik</label>
                <p class="text-lg">{{ $dokumen['pemilik'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Ukuran</label>
                <p class="text-lg">{{ $dokumen['ukuran'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Tipe</label>
                <p class="text-lg">{{ $dokumen['tipe'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Tanggal</label>
                <p class="text-lg">{{ $dokumen['tanggal'] }}</p>
            </div>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-semibold text-gray-600">Deskripsi</label>
            <p class="text-lg">{{ $dokumen['deskripsi'] }}</p>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('dokumen.edit', $dokumen['id']) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Edit</a>
            <a href="{{ route('dokumen.download', $dokumen['id']) }}" class="px-4 py-2 bg-green-500 text-white rounded">Download</a>
            <a href="{{ route('dokumen.preview', $dokumen['id']) }}" target="_blank" class="px-4 py-2 bg-gray-700 text-white rounded">Preview</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h2 class="text-2xl font-bold mb-4">Preview Dokumen</h2>
        <div style="position:relative; padding-top:56.25%; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
            <iframe src="{{ route('dokumen.preview', $dokumen['id']) }}" style="position:absolute; inset:0; width:100%; height:100%; border:none;" title="Preview Dokumen"></iframe>
        </div>
        <p style="margin-top:12px; color:#475569; font-size:14px;">
            Jika browser tidak menampilkan preview, gunakan tombol <strong>Download</strong> atau buka link preview di tab baru.
        </p>
    </div>
</div>
@endsection
