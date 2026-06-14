<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Judul Gambar</label>
        <input type="text" name="judul" class="form-control" value="{{ old('judul', $siteImage->judul ?? '') }}" placeholder="Contoh: Hero Badminton" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Kategori</label>
        @php($kategori = old('kategori', $siteImage->kategori ?? ''))
        <input list="kategoriGambarList" type="text" name="kategori" class="form-control" value="{{ $kategori }}" placeholder="Contoh: Hero Slider" required>
        <datalist id="kategoriGambarList">
            <option value="Hero Slider">
            <option value="Badminton">
            <option value="Billiard">
            <option value="Pendukung">
        </datalist>
        <small class="text-muted">Kategori ini menentukan posisi gambar di landing page.</small>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Alt Text</label>
        <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text', $siteImage->alt_text ?? '') }}" placeholder="Deskripsi singkat gambar">
    </div>
    <div class="col-md-3">
        <label class="form-label fw-bold">Urutan</label>
        <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $siteImage->urutan ?? 0) }}" min="0">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $siteImage->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="isActive">Tampilkan</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Upload Gambar</label>
        <input type="file" name="gambar" class="form-control" accept="image/*" {{ isset($siteImage) ? '' : 'required' }}>
        <small class="text-muted">Format JPG/PNG/WEBP maksimal 3 MB.</small>
    </div>
    <div class="col-md-6">
        @if(isset($siteImage) && !empty($siteImage->path_gambar))
            @php($defaultImagePath = $siteImage->defaultAssetPath())
            <label class="form-label fw-bold">Gambar Saat Ini</label>
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <img src="{{ asset($siteImage->path_gambar) }}" alt="{{ $siteImage->alt_text ?: $siteImage->judul }}" style="width:180px;height:110px;object-fit:cover;border-radius:20px;">
                <div class="small text-muted">
                    @if($siteImage->isUsingDefaultAsset())
                        Gambar ini sedang memakai asset default dari sistem.
                    @elseif($defaultImagePath)
                        <div class="form-check mb-2">
                            <input type="checkbox" name="hapus_gambar" value="1" class="form-check-input" id="hapusGambarLanding">
                            <label class="form-check-label fw-bold text-danger" for="hapusGambarLanding">Hapus gambar upload dan kembali ke default</label>
                        </div>
                        <div>Jika dicentang, gambar upload akan dihapus dan diganti kembali ke asset default.</div>
                    @else
                        Gambar ini adalah gambar tambahan. Jika ingin menghapus seluruh data gambar, gunakan tombol hapus pada daftar gambar.
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-gaza rounded-4 px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan</button>
    <a href="{{ route('admin.site-images.index') }}" class="btn btn-soft rounded-4 px-4">Batal</a>
</div>
