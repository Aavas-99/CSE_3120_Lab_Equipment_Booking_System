<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DamageReport;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        return view('student.dashboard', [
            'pending' => $user->bookings()->where('status', 'Pending')->count(),
            'active' => $user->bookings()->whereIn('status', ['Approved', 'Issued', 'Return Requested', 'Overdue'])->count(),
            'fines' => $user->fines()->where('status', 'unpaid')->sum('amount'),
            'recentBookings' => $user->bookings()->with('equipment')->latest()->take(5)->get(),
        ]);
    }

    public function equipment(Request $request)
    {
        $query = Equipment::with('category')->where('available_quantity', '>', 0)
            ->whereNotIn('status', ['Maintenance', 'Damaged']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('student.equipment.index', [
            'equipment' => $query->latest()->paginate(10)->withQueryString(),
            'categories' => EquipmentCategory::orderBy('name')->get(),
        ]);
    }

    public function equipmentShow(Equipment $equipment)
    {
        abort_unless($equipment->isBookable(), 404);

        return view('student.equipment.show', compact('equipment'));
    }

    public function createBooking(Request $request)
    {
        return view('student.bookings.create', [
            'equipment' => Equipment::where('status', 'Available')->where('available_quantity', '>', 0)->orderBy('name')->get(),
            'selectedEquipmentId' => $request->equipment_id,
        ]);
    }

    public function storeBooking(Request $request)
    {
        $data = $request->validate([
            'equipment_id' => ['required', 'exists:equipment,id'],
            'borrow_date' => ['required', 'date', 'after_or_equal:today'],
            'expected_return_date' => ['required', 'date', 'after_or_equal:borrow_date'],
        ]);

        $equipment = Equipment::findOrFail($data['equipment_id']);

        if (! $equipment->isBookable()) {
            return back()->with('error', 'This equipment is not available for booking right now.');
        }

        Booking::create($data + [
            'user_id' => Auth::id(),
            'status' => 'Pending',
        ]);

        return redirect()->route('student.bookings')->with('success', 'Booking request submitted.');
    }

    public function bookings()
    {
        $this->refreshOverdueBookings();

        return view('student.bookings.index', [
            'bookings' => Auth::user()->bookings()->with(['equipment', 'fine'])->latest()->paginate(10),
        ]);
    }

    public function cancelBooking(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id() && $booking->status === 'Pending', 403);
        $booking->update(['status' => 'Closed', 'admin_note' => 'Cancelled by student.']);

        return back()->with('success', 'Pending request cancelled.');
    }

    public function requestReturn(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id() && $booking->status === 'Issued', 403);
        $booking->update(['status' => 'Return Requested']);

        return back()->with('success', 'Return request sent to lab assistant.');
    }

    public function fines()
    {
        return view('student.fines', [
            'fines' => Auth::user()->fines()->with('booking.equipment')->latest()->paginate(10),
        ]);
    }

    public function damageReports()
    {
        return view('student.damage_reports.index', [
            'reports' => Auth::user()->damageReports()->with('equipment')->latest()->paginate(10),
            'equipment' => Equipment::orderBy('name')->get(),
            'bookings' => Auth::user()->bookings()->with('equipment')->latest()->get(),
        ]);
    }

    public function storeDamageReport(Request $request)
    {
        $data = $request->validate([
            'equipment_id' => ['required', 'exists:equipment,id'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
            'description' => ['required', 'string', 'min:10'],
        ]);

        if (! empty($data['booking_id'])) {
            abort_unless(Booking::where('id', $data['booking_id'])->where('user_id', Auth::id())->exists(), 403);
        }

        DamageReport::create($data + [
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Damage report submitted.');
    }

    public function profile()
    {
        return view('student.profile', ['user' => Auth::user()]);
    }

    private function refreshOverdueBookings(): void
    {
        Booking::whereIn('status', ['Issued', 'Return Requested'])
            ->whereDate('expected_return_date', '<', now()->toDateString())
            ->update(['status' => 'Overdue']);
    }
}
