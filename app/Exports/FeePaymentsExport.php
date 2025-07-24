<?php

namespace App\Exports;

use App\Models\FeePayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request; // Import Request

class FeePaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request; // To store the request object with filters
    protected $userSchoolId; // To store the user's school ID for confidentiality

    public function __construct(Request $request, $userSchoolId = null)
    {
        $this->request = $request;
        $this->userSchoolId = $userSchoolId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = FeePayment::with(['student', 'fee.academicYear', 'fee.school', 'receivedBy']);

        // Apply confidentiality if userSchoolId is present
        if ($this->userSchoolId) {
            $query->whereHas('fee', function ($q) {
                $q->where('school_id', $this->userSchoolId);
            });
        } else {
            // Allow super-admin to filter by school_id from request
            if ($this->request->filled('school_id')) {
                $query->whereHas('fee', function ($q) {
                    $q->where('school_id', $this->request->school_id);
                });
            }
        }

        // Apply filters from the request (similar to your index method)
        if ($this->request->filled('academic_year_id')) {
            $query->whereHas('fee', function ($q) {
                $q->where('academic_year_id', $this->request->academic_year_id);
            });
        }

        if ($this->request->filled('fee_structure_id')) {
            $query->where('fee_structure_id', $this->request->fee_structure_id);
        }

        if ($this->request->filled('student_search')) {
            $query->whereHas('student', function ($q) {
                $q->where('name', 'like', '%' . $this->request->student_search . '%')
                  ->orWhere('email', 'like', '%' . $this->request->student_search . '%');
            });
        }

        if ($this->request->filled('payment_method')) {
            $query->where('method', $this->request->payment_method);
        }

        if ($this->request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $this->request->date_from);
        }

        if ($this->request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $this->request->date_to);
        }

        return $query->orderBy('payment_date', 'desc')->get();
    }

    /**
     * Define the column headings for the export file.
     * @return array
     */
    public function headings(): array
    {
        return [
            // 'Payment ID',
            'Student Name',
            // 'Student Admission',
            // 'Fee Structure',
            'Academic Year',
            // 'School',
            'Total Amount',
            'Amount Paid',
            'Payment Date',
            'Payment Method',
            // 'Transaction ID',
            'Received By',
            // 'Notes',
        ];
    }

    /**
     * Map data to the export columns.
     * @param mixed $payment
     * @return array
     */
    public function map($payment): array
    {
        return [
            // $payment->id,
            $payment->student->name ?? 'N/A',
            // $payment->student->email ?? 'N/A',
            // $payment->fee->name ?? 'N/A',
            $payment->fee->academicYear->name ?? 'N/A',
            // $payment->fee->school->name ?? 'N/A',
            number_format($payment->fee->amount, 2),
            number_format($payment->amount_paid, 2),
            $payment->payment_date,
            $payment->method,
            // $payment->transaction_id,
            $payment->receivedBy->name ?? 'N/A', // Assuming receivedBy is a User model
            // $payment->notes,
        ];
    }
}
