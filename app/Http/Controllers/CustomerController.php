<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::query()
            ->when($request->query('q'), function($q) use ($request){
                $term = $request->query('q');
                $q->where(function($qq) use ($term){
                    $qq->where('name', 'like', "%{$term}%")
                       ->orWhere('email', 'like', "%{$term}%")
                       ->orWhere('phone', 'like', "%{$term}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json(['status' => 'success', 'data' => $customers]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);
        $customer = Customer::create($validated);
        return response()->json(['status' => 'success', 'data' => $customer], 201);
    }

    public function show(Customer $customer)
    {
        return response()->json(['status' => 'success', 'data' => $customer]);
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:customers,email,' . $customer->id,
            'phone' => 'sometimes|required|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);
        $customer->update($validated);
        return response()->json(['status' => 'success', 'data' => $customer]);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['status' => 'success', 'message' => 'Customer deleted']);
    }
}