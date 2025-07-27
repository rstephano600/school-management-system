<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SubscriptionCategory;
use App\Models\SchoolSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // Show all subscriptions
    public function index()
    {
        $categories = SubscriptionCategory::where('is_active', true)->get();
        $subscriptions = SchoolSubscription::with('school', 'category')->paginate(10);
        return view('in.school.subscriptions.index', compact('subscriptions','categories'));
    }

    // Show form to create new subscription
    public function create()
    {
        $schools = School::all();
        $categories = SubscriptionCategory::where('is_active', true)->get();
        return view('in.school.subscriptions.create', compact('schools', 'categories'));
    }

    // Store subscription
    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'subscription_category_id' => 'required|exists:subscription_categories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $totalStudents = \App\Models\Student::where('school_id', $request->school_id)->count();

        SchoolSubscription::create([
            'school_id' => $request->school_id,
            'subscription_category_id' => $request->subscription_category_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_students' => $totalStudents,
            'is_active' => true,
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    // Show a specific subscription
    public function show($id)
    {
        $subscription = SchoolSubscription::with('school', 'category')->findOrFail($id);
        return view('in.school.subscriptions.show', compact('subscription'));
    }

    // Edit form
    public function edit($id)
    {
        $subscription = SchoolSubscription::findOrFail($id);
        $schools = School::all();
        $categories = SubscriptionCategory::where('is_active', true)->get();
        return view('in.school.subscriptions.edit', compact('subscription', 'schools', 'categories'));
    }

    // Update subscription
    public function update(Request $request, $id)
    {
        $subscription = SchoolSubscription::findOrFail($id);

        $request->validate([
            'subscription_category_id' => 'required|exists:subscription_categories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $subscription->update([
            'subscription_category_id' => $request->subscription_category_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated.');
    }

    // Delete
    public function destroy($id)
    {
        $subscription = SchoolSubscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted.');
    }
}
