<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">School Name</label>
        <input type="text" name="name" value="{{ old('name', $school->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">School Code</label>
        <input type="text" name="code" value="{{ old('code', $school->code ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $school->phone ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $school->email ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $school->city ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">State</label>
        <input type="text" name="state" value="{{ old('state', $school->state ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Postal Code</label>
        <input type="text" name="postal_code" value="{{ old('postal_code', $school->postal_code ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Country</label>
        <input type="text" name="country" value="{{ old('country', $school->country ?? 'Tanzania') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Website</label>
        <input type="url" name="website" value="{{ old('website', $school->website ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Established Date</label>
        <input type="date" name="established_date" value="{{ old('established_date', $school->established_date ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Logo</label>
        <input type="file" name="logo" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="1" {{ old('status', $school->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $school->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="2" required>{{ old('address', $school->address ?? '') }}</textarea>
    </div>
</div>
