<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Nama Menu</label>
        <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu', $cafeMenu->nama_menu ?? '') }}" placeholder="Contoh: Teh Manis" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Kategori</label>
        @php($kategori = old('kategori', $cafeMenu->kategori ?? ''))
        <input list="kategoriMenuList" type="text" name="kategori" class="form-control" value="{{ $kategori }}" placeholder="Contoh: Minuman & Snack" required>
        <datalist id="kategoriMenuList">
            <option value="Main Course">
            <option value="Mie & Extra">
            <option value="Minuman & Snack">
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold">Harga</label>
        <input type="number" name="harga" class="form-control" value="{{ old('harga', $cafeMenu->harga ?? '') }}" placeholder="Kosongkan jika TBD" min="0">
        <small class="text-muted">Kosongkan jika harga belum ditentukan.</small>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold">Urutan</label>
        <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $cafeMenu->urutan ?? 0) }}" min="0">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $cafeMenu->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="isActive">Tampilkan di Landing Page</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Gambar Menu</label>
        <input type="file" name="gambar" class="form-control" accept="image/*">
        <small class="text-muted">Opsional. Format JPG/PNG/WEBP maksimal 2 MB.</small>
    </div>
    <div class="col-md-6">
        @if(isset($cafeMenu) && !empty($cafeMenu->gambar))
            <label class="form-label fw-bold">Gambar Saat Ini</label>
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <img src="{{ asset($cafeMenu->gambar) }}" alt="{{ $cafeMenu->nama_menu }}" style="width:120px;height:90px;object-fit:cover;border-radius:18px;">
                <div class="form-check mt-2">
                    <input type="checkbox" name="hapus_gambar" value="1" class="form-check-input" id="hapusGambarMenu">
                    <label class="form-check-label fw-bold text-danger" for="hapusGambarMenu">Hapus gambar ini</label>
                    <div class="text-muted small mt-1">Centang jika gambar menu tidak ingin ditampilkan lagi.</div>
                </div>
            </div>
        @else
            <label class="form-label fw-bold">Pratinjau Gambar</label>
            <div class="text-muted small">Belum ada gambar yang diupload untuk menu ini.</div>
        @endif
    </div>
    <div class="col-12">
        <label class="form-label fw-bold">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tulis catatan menu jika ada...">{{ old('deskripsi', $cafeMenu->deskripsi ?? '') }}</textarea>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-gaza rounded-4 px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan</button>
    <a href="{{ route('admin.cafe-menus.index') }}" class="btn btn-soft rounded-4 px-4">Batal</a>
</div>
