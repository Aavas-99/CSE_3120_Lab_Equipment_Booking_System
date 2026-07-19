<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\DamageReport;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            DamageReport::query()->delete();
            Fine::query()->delete();
            Booking::query()->delete();
            Equipment::query()->delete();
            EquipmentCategory::query()->delete();

            User::where('email', 'like', '%@example.com')->delete();

            User::updateOrCreate(
                ['email' => 'lab.admin@kuet.ac.bd'],
                [
                    'name' => 'Lab Admin',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'status' => 'active',
                ]
            );

            $students = collect([
                ['name' => 'Rana', 'roll' => '2207094', 'email' => 'rana.2207094@kuet.ac.bd'],
                ['name' => 'Issac', 'roll' => '2207095', 'email' => 'issac.2207095@kuet.ac.bd'],
                ['name' => 'Bipro', 'roll' => '2207096', 'email' => 'bipro.2207096@kuet.ac.bd'],
                ['name' => 'Mutiur', 'roll' => '2207097', 'email' => 'mutiur.2207097@kuet.ac.bd'],
                ['name' => 'Alok', 'roll' => '2207098', 'email' => 'alok.2207098@kuet.ac.bd'],
                ['name' => 'Avash', 'roll' => '2207099', 'email' => 'avash.2207099@kuet.ac.bd'],
            ])->mapWithKeys(fn ($student) => [
                $student['email'] => User::updateOrCreate(
                    ['email' => $student['email']],
                    $student + [
                        'password' => Hash::make('password'),
                        'role' => 'student',
                        'status' => 'active',
                    ]
                ),
            ]);

            $categories = collect([
                ['name' => 'Electronics', 'description' => 'Meters, signal tools, and circuit lab equipment.'],
                ['name' => 'Embedded Systems', 'description' => 'Microcontroller, IoT, and prototyping kits.'],
                ['name' => 'Measurement Tools', 'description' => 'Precision instruments for lab measurement work.'],
                ['name' => 'Power Supplies', 'description' => 'Bench power units and regulated adapters.'],
                ['name' => 'Computer Lab', 'description' => 'Portable computing and networking tools.'],
            ])->mapWithKeys(fn ($category) => [
                $category['name'] => EquipmentCategory::create($category),
            ]);

            $equipment = collect([
                ['category_id' => $categories['Electronics']->id, 'name' => 'Digital Multimeter', 'serial_number' => 'KUET-ELEC-DMM-001', 'quantity' => 8, 'available_quantity' => 5, 'status' => 'Available', 'location' => 'Electronics Lab Shelf A', 'description' => 'Handheld multimeter for voltage, current, and resistance measurement.'],
                ['category_id' => $categories['Electronics']->id, 'name' => 'Digital Oscilloscope', 'serial_number' => 'KUET-ELEC-OSC-014', 'quantity' => 4, 'available_quantity' => 2, 'status' => 'Available', 'location' => 'Electronics Lab Bench 2', 'description' => 'Two-channel oscilloscope for waveform analysis.'],
                ['category_id' => $categories['Embedded Systems']->id, 'name' => 'Arduino Uno Kit', 'serial_number' => 'KUET-EMB-ARD-009', 'quantity' => 10, 'available_quantity' => 8, 'status' => 'Available', 'location' => 'Project Store Cabinet 1', 'description' => 'Arduino starter kit with jumper wires, LEDs, and sensors.'],
                ['category_id' => $categories['Embedded Systems']->id, 'name' => 'Raspberry Pi Kit', 'serial_number' => 'KUET-EMB-RPI-021', 'quantity' => 6, 'available_quantity' => 3, 'status' => 'Available', 'location' => 'Computer Lab Store', 'description' => 'Raspberry Pi kit with power adapter and case.'],
                ['category_id' => $categories['Measurement Tools']->id, 'name' => 'Vernier Caliper', 'serial_number' => 'KUET-MEAS-CAL-006', 'quantity' => 12, 'available_quantity' => 11, 'status' => 'Available', 'location' => 'Measurement Rack B', 'description' => 'Manual caliper for precision dimensional measurement.'],
                ['category_id' => $categories['Power Supplies']->id, 'name' => 'DC Bench Power Supply', 'serial_number' => 'KUET-PWR-DC-003', 'quantity' => 3, 'available_quantity' => 1, 'status' => 'Available', 'location' => 'Power Lab Bench 1', 'description' => 'Regulated DC supply for electronics experiments.'],
                ['category_id' => $categories['Computer Lab']->id, 'name' => 'Network Cable Tester', 'serial_number' => 'KUET-COMP-NET-002', 'quantity' => 5, 'available_quantity' => 4, 'status' => 'Available', 'location' => 'Network Lab Drawer 3', 'description' => 'Cable tester for RJ45 continuity checks.'],
                ['category_id' => $categories['Measurement Tools']->id, 'name' => 'Analytical Balance', 'serial_number' => 'KUET-MEAS-BAL-003', 'quantity' => 2, 'available_quantity' => 0, 'status' => 'Maintenance', 'location' => 'Maintenance Desk', 'description' => 'Precision balance currently under maintenance.'],
            ])->mapWithKeys(fn ($item) => [
                $item['serial_number'] => Equipment::create($item),
            ]);

            $pending = Booking::create([
                'user_id' => $students['rana.2207094@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-ELEC-DMM-001']->id,
                'borrow_date' => now()->addDay()->toDateString(),
                'expected_return_date' => now()->addDays(5)->toDateString(),
                'status' => 'Pending',
            ]);

            $approved = Booking::create([
                'user_id' => $students['avash.2207099@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-EMB-ARD-009']->id,
                'borrow_date' => now()->addDays(2)->toDateString(),
                'expected_return_date' => now()->addDays(7)->toDateString(),
                'status' => 'Approved',
                'admin_note' => 'Approved for microcontroller lab work.',
            ]);

            $issued = Booking::create([
                'user_id' => $students['issac.2207095@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-ELEC-OSC-014']->id,
                'borrow_date' => now()->subDays(2)->toDateString(),
                'expected_return_date' => now()->addDays(3)->toDateString(),
                'status' => 'Issued',
                'admin_note' => 'Issued after lab assistant verification.',
            ]);

            $overdue = Booking::create([
                'user_id' => $students['bipro.2207096@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-EMB-RPI-021']->id,
                'borrow_date' => now()->subDays(10)->toDateString(),
                'expected_return_date' => now()->subDays(3)->toDateString(),
                'status' => 'Overdue',
                'admin_note' => 'Automatically marked overdue for demo testing.',
            ]);

            $returnedLate = Booking::create([
                'user_id' => $students['mutiur.2207097@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-PWR-DC-003']->id,
                'borrow_date' => now()->subDays(12)->toDateString(),
                'expected_return_date' => now()->subDays(5)->toDateString(),
                'actual_return_date' => now()->subDays(2)->toDateString(),
                'status' => 'Returned',
                'admin_note' => 'Returned after due date; fine already paid.',
            ]);

            $returnRequested = Booking::create([
                'user_id' => $students['alok.2207098@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-COMP-NET-002']->id,
                'borrow_date' => now()->subDays(1)->toDateString(),
                'expected_return_date' => now()->addDays(2)->toDateString(),
                'status' => 'Return Requested',
                'admin_note' => 'Student requested return approval.',
            ]);

            Fine::create([
                'booking_id' => $overdue->id,
                'user_id' => $overdue->user_id,
                'amount' => 60,
                'days_late' => 3,
                'status' => 'unpaid',
            ]);

            Fine::create([
                'booking_id' => $returnedLate->id,
                'user_id' => $returnedLate->user_id,
                'amount' => 60,
                'days_late' => 3,
                'status' => 'paid',
            ]);

            DamageReport::create([
                'user_id' => $students['alok.2207098@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-COMP-NET-002']->id,
                'booking_id' => $returnRequested->id,
                'description' => 'Cable tester display flickers during continuity checking.',
                'status' => 'pending',
            ]);

            DamageReport::create([
                'user_id' => $students['issac.2207095@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-ELEC-OSC-014']->id,
                'booking_id' => $issued->id,
                'description' => 'Probe clip is loose and needs inspection before the next lab session.',
                'status' => 'reviewed',
                'admin_note' => 'Lab assistant checked the issue and scheduled replacement probe.',
            ]);

            DamageReport::create([
                'user_id' => $students['rana.2207094@kuet.ac.bd']->id,
                'equipment_id' => $equipment['KUET-ELEC-DMM-001']->id,
                'booking_id' => $pending->id,
                'description' => 'Previous note says the multimeter battery cover was missing.',
                'status' => 'resolved',
                'admin_note' => 'Battery cover replaced and equipment is ready.',
            ]);
        });
    }
}
