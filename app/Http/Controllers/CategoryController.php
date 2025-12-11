<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with pagination, search, and filter.
     */
    public function index(Request $request)
    {
        $categories = Category::query()
            // Search by name or code
            ->when($request->query('q'), function ($query) use ($request) {
                $term = $request->query('q');
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                      ->orWhere('code', 'like', "%{$term}%");
                });
            })
            // Filter by is_active status
            ->when($request->has('is_active'), function ($query) use ($request) {
                $isActive = filter_var($request->query('is_active'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if ($isActive !== null) {
                    $query->where('is_active', $isActive);
                }
            })
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100|unique:categories,name',
            'code' => [
                'required',
                'string',
                'min:2',
                'max:20',
                'unique:categories,code',
                'regex:/^[A-Za-z0-9_-]+$/'
            ],
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.min' => 'Nama kategori minimal 2 karakter.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'code.required' => 'Kode kategori wajib diisi.',
            'code.unique' => 'Kode kategori sudah digunakan.',
            'code.min' => 'Kode kategori minimal 2 karakter.',
            'code.max' => 'Kode kategori maksimal 20 karakter.',
            'code.regex' => 'Kode kategori hanya boleh berisi huruf, angka, underscore, dan dash.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('categories', 'name')->ignore($category->id)
            ],
            'code' => [
                'sometimes',
                'required',
                'string',
                'min:2',
                'max:20',
                Rule::unique('categories', 'code')->ignore($category->id),
                'regex:/^[A-Za-z0-9_-]+$/'
            ],
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.min' => 'Nama kategori minimal 2 karakter.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'code.required' => 'Kode kategori wajib diisi.',
            'code.unique' => 'Kode kategori sudah digunakan.',
            'code.min' => 'Kode kategori minimal 2 karakter.',
            'code.max' => 'Kode kategori maksimal 20 karakter.',
            'code.regex' => 'Kode kategori hanya boleh berisi huruf, angka, underscore, dan dash.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ]);

        $category->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil diperbarui.',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus.'
        ]);
    }
}
