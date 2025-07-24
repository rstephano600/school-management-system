<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeePayment;
use App\Models\User;
use App\Models\FeeStructure;
use Carbon\Carbon;

class FeePaymentSeeder extends Seeder
{
    public function run()
    {
        // Get 10 random students
        $students = User::where('role', 'student')->inRandomOrder()->limit(10)->get();

        // Get a few fee structures and receiver users (e.g., admins)
        $feeStructures = FeeStructure::inRandomOrder()->limit(3)->get();
        $receivers = User::whereIn('role', ['secretary', 'director'])->get();

        foreach ($students as $student) {
            $feeStructure = $feeStructures->random();
            $amountPaid = rand(100000, 1300000); // Random payment amount
            $paymentDate = Carbon::now()->subDays(rand(1, 30));
            $method = collect(['cash', 'mpesa', 'tigo-pesa', 'airtel-money'])->random();
            $reference = strtoupper(uniqid('TXN'));
            $note = 'Payment for ' . $feeStructure->name;
            $receivedBy = $receivers->random();

            FeePayment::create([
                'student_id' => $student->id,
                'fee_structure_id' => $feeStructure->id,
                'amount_paid' => $amountPaid,
                'payment_date' => $paymentDate,
                'method' => $method,
                'reference' => $reference,
                'note' => $note,
                'received_by' => $receivedBy->id,
            ]);
        }
    }
}
