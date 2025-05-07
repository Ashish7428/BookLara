public function show(Category $category)
{
    $books = $category->books()
        ->where('status', 'approved')
        ->with(['author', 'categories'])
        ->latest()
        ->paginate(12);

    return view('categories.show', compact('category', 'books'));
}