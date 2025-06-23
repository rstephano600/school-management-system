<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $library_book->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Author</label>
    <input type="text" name="author" class="form-control" value="{{ old('author', $library_book->author ?? '') }}" required>
</div>
<div class="mb-3">
    <label>ISBN</label>
    <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $library_book->isbn ?? '') }}">
</div>
<div class="mb-3">
    <label>Publisher</label>
    <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $library_book->publisher ?? '') }}">
</div>
<div class="mb-3">
    <label>Edition</label>
    <input type="text" name="edition" class="form-control" value="{{ old('edition', $library_book->edition ?? '') }}">
</div>
<div class="mb-3">
    <label>Year Published</label>
    <input type="number" name="year_published" class="form-control" value="{{ old('year_published', $library_book->year_published ?? '') }}">
</div>
<div class="mb-3">
    <label>Category</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $library_book->category ?? '') }}">
</div>
<div class="mb-3">
    <label>Price</label>
    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $library_book->price ?? '') }}">
</div>
<div class="mb-3">
    <label>Quantity</label>
    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $library_book->quantity ?? 1) }}" required>
</div>
<div class="mb-3">
    <label>Available Quantity</label>
    <input type="number" name="available_quantity" class="form-control" value="{{ old('available_quantity', $library_book->available_quantity ?? 1) }}" required>
</div>
<div class="mb-3">
    <label>Rack Number</label>
    <input type="text" name="rack_number" class="form-control" value="{{ old('rack_number', $library_book->rack_number ?? '') }}">
</div>
<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        @foreach(['available', 'lost', 'damaged'] as $status)
            <option value="{{ $status }}" @if(($library_book->status ?? 'available') === $status) selected @endif>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
</div>