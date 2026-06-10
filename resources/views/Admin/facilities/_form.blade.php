<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Nama Fasilitas</label>
        <input type="text" name="nama_fasilitas" class="form-control" value="{{ old('nama_fasilitas', $facility->nama_fasilitas ?? '') }}" placeholder="Contoh: Lapangan Badminton, Biliard, Cafe" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Jenis</label>
        <select name="jenis" class="form-select" required>
            @php($jenis = old('jenis', $facility->jenis ?? ''))
            <option value="Badminton" {{ $jenis === 'Badminton' ? 'selected' : '' }}>Badminton</option>
            <option value="Billiard" {{ $jenis === 'Billiard' ? 'selected' : '' }}>Billiard</option>
            <option value="Cafe" {{ $jenis === 'Cafe' ? 'selected' : '' }}>Cafe</option>
        </select>
        <small class="text-muted">Catatan: Cafe bisa disimpan di admin, tetapi belum ditampilkan di landing page dan booking customer.</small>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Harga per Jam</label>
        <input type="number" name="harga_per_jam" class="form-control" value="{{ old('harga_per_jam', $facility->harga_per_jam ?? '') }}" placeholder="50000" required>
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $facility->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="isActive">Fasilitas Aktif</label>
        </div>
    </div>
    <div class="col-12">
        <label class="form-label fw-bold">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tulis deskripsi singkat fasilitas...">{{ old('deskripsi', $facility->deskripsi ?? '') }}</textarea>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-gaza rounded-4 px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan</button>
    <a href="{{ route('admin.facilities.index') }}" class="btn btn-soft rounded-4 px-4">Batal</a>
</div>
