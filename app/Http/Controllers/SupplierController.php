<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers with pagination, search, and filter.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::query()
            // Search by name, email, or company
            ->when($request->query('q'), function ($query) use ($request) {
                $term = $request->query('q');
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                      ->orWhere('email', 'like', "%{$term}%")
                      ->orWhere('company', 'like', "%{$term}%");
                });
            })
            // Filter by status
            ->when($request->query('status'), function ($query) use ($request) {
                $status = $request->query('status');
                if (in_array($status, ['active', 'inactive'])) {
                    $query->where('status', $status);
                }
            })
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $suppliers
        ]);
    }

    /**
     * Store a newly created supplier.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:150',
            'email' => 'required|email|max:100|unique:suppliers,email',
            'phone' => 'required|string|min:8|max:30',
            'address' => 'nullable|string|max:500',
            'company' => 'nullable|string|max:150',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Nama supplier wajib diisi.',
            'name.min' => 'Nama supplier minimal 3 karakter.',
            'name.max' => 'Nama supplier maksimal 150 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email maksimal 100 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon minimal 8 karakter.',
            'phone.max' => 'Nomor telepon maksimal 30 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'company.max' => 'Nama perusahaan maksimal 150 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus active atau inactive.',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier berhasil ditambahkan.',
            'data' => $supplier
        ], 201);
    }

    /**
     * Display the specified supplier.
     */
    public function show(Supplier $supplier)
    {
        return response()->json([
            'status' => 'success',
            'data' => $supplier
        ]);
    }

    /**
     * Update the specified supplier.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|min:3|max:150',
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:100',
                Rule::unique('suppliers', 'email')->ignore($supplier->id)
            ],
            'phone' => 'sometimes|required|string|min:8|max:30',
            'address' => 'nullable|string|max:500',
            'company' => 'nullable|string|max:150',
            'status' => 'sometimes|required|in:active,inactive',
        ], [
            'name.required' => 'Nama supplier wajib diisi.',
            'name.min' => 'Nama supplier minimal 3 karakter.',
            'name.max' => 'Nama supplier maksimal 150 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email maksimal 100 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon minimal 8 karakter.',
            'phone.max' => 'Nomor telepon maksimal 30 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'company.max' => 'Nama perusahaan maksimal 150 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus active atau inactive.',
        ]);

        $supplier->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier berhasil diperbarui.',
            'data' => $supplier
        ]);
    }

    /**
     * Remove the specified supplier.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier berhasil dihapus.'
        ]);
    }
}
