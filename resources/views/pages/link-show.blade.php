@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Detail Link</h1>
        <a href="{{ route('link') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-600">Judul</label>
                <p class="text-lg">{{ $link['judul'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Pemilik</label>
                <p class="text-lg">{{ $link['pemilik'] }}</p>
            </div>
            <div class="col-span-2">
                @php
                  $linkUrl = preg_match('/^https?:\/\//i', $link['url']) ? $link['url'] : 'https://' . $link['url'];
                @endphp
                <label class="block text-sm font-semibold text-gray-600">URL</label>
                <a href="{{ $linkUrl }}" target="_blank" class="text-lg text-blue-600 underline">{{ $link['url'] }}</a>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Tanggal</label>
                <p class="text-lg">{{ $link['tanggal'] }}</p>
            </div>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-semibold text-gray-600">Deskripsi</label>
            <p class="text-lg">{{ $link['deskripsi'] }}</p>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('link.edit', $link['id']) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Edit</a>
            <a href="{{ route('link') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
        </div>
    </div>
</div>
@endsection
