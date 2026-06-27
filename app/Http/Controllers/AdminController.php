<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DamageReport;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $this->refreshOverdueBookings();

        return view('admin.dashboard', $this->summaryData() + [
            'recentBookings' => Booking::with(['user', 'equipment'])->latest()->take(6)->get(),
        ]);
    }

    public function equipment()
    {
        return view('admin.equipment.index', [
            'equipment' => Equipment::with('category')->latest()->paginate(10),
        ]);
    }

    public function createEquipment()
    {
        return view('admin.equipment.form', [
            'equipment' => new Equipment(['status' => 'Available', 'quantity' => 1, 'available_quantity' => 1]),
            'categories' => EquipmentCategory::orderBy('name')->get(),
        ]);
    }

    public function storeEquipment(Request $request)
    {
        $data = $this->validateEquipment($request);
        Equipment::create($data);

        return redirect()->route('admin.equipment')->with('success', 'Equipment added.');
    }

    public function editEquipment(Equipment $equipment)
    {
        return view('admin.equipment.form', [
            'equipment' => $equipment,
            'categories' => EquipmentCategory::orderBy('name')->get(),
        ]);
    }

    public function updateEquipment(Request $request, Equipment $equipment)
    {
        $data = $this->validateEquipment($request, $equipment->id);
        $equipment->update($data);

        return redirect()->route('admin.equipment')->with('success', 'Equipment updated.');
    }

    public function deleteEquipment(Equipment $equipment)
    {
        $equipment->delete();

        return back()->with('success', 'Equipment deleted.');
    }

    public function categories()
    {
        return view('admin.categories.index', [
            'categories' => EquipmentCategory::withCount('equipment')->orderBy('name')->get(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        EquipmentCategory::create($request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:equipment_categories,name'],
            'description' => ['nullable', 'string'],
        ]));

        return back()->with('success', 'Category saved.');
    }

    public function updateCategory(Request $request, EquipmentCategory $category)
    {
        $category->update($request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:equipment_categories,name,'.$category->id],
            'description' => ['nullable', 'string'],
        ]));

        return back()->with('success', 'Category updated.');
    }

    public function deleteCategory(EquipmentCategory $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }

    public function bookings()
    {
        $this->refreshOverdueBookings();

        return view('admin.bookings.index', [
            'title' => 'All Bookings',
            'bookings' => Booking::with(['user', 'equipment', 'fine'])->latest()->paginate(12),
        ]);
    }

    public function requests()
    {
        return view('admin.bookings.index', [
            'title' => 'Pending Requests',
            'bookings' => Booking::with(['user', 'equipment'])->where('status', 'Pending')->latest()->paginate(12),
        ]);
    }

    public function issued()
    {
        return view('admin.bookings.index', [
            'title' => 'Issued Equipment',
            'bookings' => Booking::with(['user', 'equipment'])->whereIn('status', ['Issued', 'Return Requested'])->latest()->paginate(12),
        ]);
    }

    public function overdue()
    {
        $this->refreshOverdueBookings();

        return view('admin.bookings.index', [
            'title' => 'Overdue Items',
            'bookings' => Booking::with(['user', 'equipment'])->where('status', 'Overdue')->latest()->paginate(12),
        ]);
    }

    public function approveBooking(Booking $booking)
    {
        abort_unless($booking->status === 'Pending', 403);

        $equipment = $booking->equipment;
        if (! $equipment->isBookable()) {
            return back()->with('error', 'Equipment is not available.');
        }

        $booking->update(['status' => 'Approved']);
        $equipment->decrement('available_quantity');
        $equipment->refresh();
        $equipment->refreshStatusFromQuantity();
        $equipment->save();

        return back()->with('success', 'Booking approved and item reserved.');
    }

    public function rejectBooking(Request $request, Booking $booking)
    {
        abort_unless($booking->status === 'Pending', 403);
        $booking->update([
            'status' => 'Rejected',
            'admin_note' => $request->input('admin_note'),
        ]);

        return back()->with('success', 'Booking rejected.');
    }

    public function issueBooking(Booking $booking)
    {
        abort_unless($booking->status === 'Approved', 403);
        $booking->update(['status' => 'Issued']);

        $equipment = $booking->equipment;
        $equipment->status = $equipment->available_quantity > 0 ? 'Available' : 'Issued';
        $equipment->save();

        return back()->with('success', 'Equipment marked as issued.');
    }

    public function returnBooking(Booking $booking)
    {
        abort_unless(in_array($booking->status, ['Issued', 'Return Requested', 'Overdue'], true), 403);

        DB::transaction(function () use ($booking) {
            $returnDate = now();
            $daysLate = $booking->daysLate($returnDate);

            $booking->update([
                'status' => $daysLate > 0 ? 'Closed' : 'Returned',
                'actual_return_date' => $returnDate,
            ]);

            if ($daysLate > 0) {
                Fine::firstOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'user_id' => $booking->user_id,
                        'amount' => $daysLate * Booking::LATE_FINE_PER_DAY,
                        'days_late' => $daysLate,
                        'status' => 'unpaid',
                    ]
                );
            }

            $equipment = $booking->equipment;
            $equipment->available_quantity = min($equipment->quantity, $equipment->available_quantity + 1);
            $equipment->refreshStatusFromQuantity();
            $equipment->save();
        });

        return back()->with('success', 'Equipment return completed.');
    }

    public function fines()
    {
        return view('admin.fines.index', [
            'fines' => Fine::with(['user', 'booking.equipment'])->latest()->paginate(12),
        ]);
    }

    public function toggleFine(Fine $fine)
    {
        $fine->update(['status' => $fine->status === 'paid' ? 'unpaid' : 'paid']);

        return back()->with('success', 'Fine status updated.');
    }

    public function users()
    {
        return view('admin.users.index', [
            'students' => User::where('role', 'student')->withCount('bookings')->orderBy('name')->get(),
        ]);
    }

    public function toggleUser(User $user)
    {
        abort_if($user->isAdmin(), 403);
        $user->update(['status' => $user->status === 'active' ? 'blocked' : 'active']);

        return back()->with('success', 'User status updated.');
    }

    public function damageReports()
    {
        return view('admin.damage_reports.index', [
            'reports' => DamageReport::with(['user', 'equipment', 'booking'])->latest()->paginate(12),
        ]);
    }

    public function updateDamageReport(Request $request, DamageReport $damageReport)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,reviewed,resolved'],
            'admin_note' => ['nullable', 'string'],
            'mark_maintenance' => ['nullable', 'boolean'],
        ]);

        $markMaintenance = (bool) ($data['mark_maintenance'] ?? false);
        unset($data['mark_maintenance']);

        $damageReport->update($data);

        if ($markMaintenance) {
            $damageReport->equipment->update(['status' => 'Maintenance']);
        }

        return back()->with('success', 'Damage report updated.');
    }

    public function reports()
    {
        return view('admin.reports.index', $this->summaryData() + [
            'mostBorrowed' => Equipment::select('equipment.*')
                ->selectSub(function ($query) {
                    $query->from('bookings')
                        ->selectRaw('count(*)')
                        ->whereColumn('bookings.equipment_id', 'equipment.id');
                }, 'borrow_count')
                ->orderByDesc('borrow_count')
                ->take(5)
                ->get(),
        ]);
    }

    private function validateEquipment(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'serial_number' => ['required', 'string', 'max:100', 'unique:equipment,serial_number,'.($id ?? 'NULL').',id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'available_quantity' => ['required', 'integer', 'min:0', 'lte:quantity'],
            'status' => ['required', 'in:Available,Reserved,Issued,Maintenance,Damaged'],
            'location' => ['nullable', 'string', 'max:150'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function refreshOverdueBookings(): void
    {
        Booking::whereIn('status', ['Issued', 'Return Requested'])
            ->whereDate('expected_return_date', '<', now()->toDateString())
            ->update(['status' => 'Overdue']);
    }

    private function summaryData(): array
    {
        return [
            'totalEquipment' => Equipment::sum('quantity'),
            'availableEquipment' => Equipment::sum('available_quantity'),
            'activeBookings' => Booking::whereIn('status', ['Approved', 'Issued', 'Return Requested', 'Overdue'])->count(),
            'pendingRequests' => Booking::where('status', 'Pending')->count(),
            'overdueItems' => Booking::where('status', 'Overdue')->count(),
            'totalFines' => Fine::sum('amount'),
        ];
    }
}
