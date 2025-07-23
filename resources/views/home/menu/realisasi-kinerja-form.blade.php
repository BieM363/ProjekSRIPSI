{{-- resources/views/home/menu/realisasi-kinerja-form.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card bg-purple-50 shadow-md">
        <div class="card-header bg-purple-700 text-white">
            <h3 class="text-xl font-bold">
                @if(isset($realisasi))
                    Edit Realisasi Kinerja
                @else
                    Tambah Realisasi Kinerja Baru
                @endif
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" 
                  action="{{ isset($realisasi) ? route('realisasi_kinerja.update', $realisasi->id) : route('realisasi_kinerja.store') }}">
                @csrf
                @if(isset($realisasi))
                    @method('PUT')
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Input Pegawai -->
                    <div class="mb-4">
                        <label class="block text-purple-800 font-medium mb-2">Pegawai</label>
                        <select name="pegawai_id" class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @foreach($pegawai as $p)
                                <option value="{{ $p->id }}" 
                                    @if((isset($realisasi) && $realisasi->pegawai_id == $p->id) || old('pegawai_id') == $p->id) selected @endif>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_id')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Input Indikator -->
                    <div class="mb-4">
                        <label class="block text-purple-800 font-medium mb-2">Indikator Kinerja</label>
                        <select name="indikator_id" class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @foreach($indikator as $i)
                                <option value="{{ $i->id }}" 
                                    @if((isset($realisasi) && $realisasi->indikator_id == $i->id) || old('indikator_id') == $i->id) selected @endif>
                                    {{ $i->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('indikator_id')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Input Periode -->
                    <div class="mb-4">
                        <label class="block text-purple-800 font-medium mb-2">Periode</label>
                        <select name="periode" class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @foreach($periodes as $p)
                                <option value="{{ $p }}" 
                                    @if((isset($realisasi) && $realisasi->periode == $p) || old('periode') == $p) selected @endif>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                        @error('periode')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Input Target -->
                    <div class="mb-4">
                        <label class="block text-purple-800 font-medium mb-2">Target</label>
                        <input type="number" name="target" min="0" step="0.01" 
                               value="{{ old('target', $realisasi->target ?? '') }}"
                               class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('target')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Input Realisasi -->
                    <div class="mb-4">
                        <label class="block text-purple-800 font-medium mb-2">Realisasi</label>
                        <input type="number" name="realisasi" min="0" step="0.01" 
                               value="{{ old('realisasi', $realisasi->realisasi ?? '') }}"
                               class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('realisasi')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end mt-6">
                    <a href="{{ route('realisasi_kinerja') }}" class="btn bg-gray-500 text-white hover:bg-gray-600 mr-2">
                        Batal
                    </a>
                    <button type="submit" class="btn bg-purple-700 text-white hover:bg-purple-800">
                        <i class="fas fa-save mr-1"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection