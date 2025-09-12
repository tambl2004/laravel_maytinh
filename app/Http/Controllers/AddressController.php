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
            'province_id' => 'nullable|string',
            'province_name' => 'nullable|string',
            'district_id' => 'nullable|string',
            'district_name' => 'nullable|string',
            'ward_id' => 'nullable|string',
            'ward_name' => 'nullable|string',
            'detail_address' => 'nullable|string|max:500',
        ]);

        // Nếu là địa chỉ đầu tiên, đặt mặc định
        $isFirstAddress = Auth::user()->addresses()->count() === 0;

        Auth::user()->addresses()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'province_name' => $request->province_name,
            'district_id' => $request->district_id,
            'district_name' => $request->district_name,
            'ward_id' => $request->ward_id,
            'ward_name' => $request->ward_name,
            'detail_address' => $request->detail_address,
            'is_default' => $isFirstAddress,
        ]);

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

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'province_id' => 'nullable|string',
            'province_name' => 'nullable|string',
            'district_id' => 'nullable|string',
            'district_name' => 'nullable|string',
            'ward_id' => 'nullable|string',
            'ward_name' => 'nullable|string',
            'detail_address' => 'nullable|string|max:500',
        ]);

        $address->update($validated);

        return back()->with('success', 'Đã cập nhật địa chỉ thành công!');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Bỏ mặc định các địa chỉ khác, đặt mặc định cho địa chỉ được chọn
        Auth::user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Đã đặt địa chỉ mặc định.');
    }
}