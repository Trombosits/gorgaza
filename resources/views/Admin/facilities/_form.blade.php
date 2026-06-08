<div class="mb-3">
    <label class="form-label">Nama Fasilitas</label>
    <input type="text" name="nama_fasilitas" class="form-control" value="{{ old('nama_fasilitas', $facility->nama_fasilitas ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Jenis</label>
    <select name="jenis" class="form-select" required>
        @php($jenis = old('jenis', $facility->jenis ?? ''))
        <option value="Badminton" {{ $jenis === 'Badminton' ? 'selected' : '' }}>Badminton</option>
        <option value="Billiard" {{ $jenis === 'Billiard' ? 'selected' : '' }}>Billiard</option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Harga per Jam</label>
    <input type="number" name="harga_per_jam" class="form-control" value="{{ old('harga_per_jam', $facility->harga_per_jam ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $facility->deskripsi ?? '') }}</textarea>
</div>
<div class="form-check mb-3">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $facility->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="isActive">Aktif</label>
</div>
<button class="btn btn-warning">Simpan</button>
<a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Batal</a>
