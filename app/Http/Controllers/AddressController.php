<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        Auth::user()->addresses()->create($request->all());

        return back()->with('success', 'Đã thêm địa chỉ mới thành công!');
    }

    public function destroy(Address $address)
    {
        // Đảm bảo user chỉ có thể xóa địa chỉ của chính mình
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        return back()->with('success', 'Đã xóa địa chỉ thành công!');
    }
}