@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Super Admin Dashboard</h5>
    </div>
    <div class="card-body">
        <!-- Welcome Section -->
        <div class="mb-4">
            <h2 class="text-2xl font-semibold">Welcome, {{ Auth::user()->name }}!</h2>
            <p class="text-gray-600">You are logged in as <span class="badge bg-danger">Super Admin</span></p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Schools</p>
                        <h3 class="text-2xl font-bold">15</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-school text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-green-500 text-xs font-medium">
                        <i class="fas fa-arrow-up"></i> 2 new this month
                    </span>
                </div>
            </div>

            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">System Users</p>
                        <h3 class="text-2xl font-bold">1,245</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-green-500 text-xs font-medium">
                        <i class="fas fa-arrow-up"></i> 5.2% increase
                    </span>
                </div>
            </div>

            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pending Requests</p>
                        <h3 class="text-2xl font-bold">8</h3>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-red-500 text-xs font-medium">
                        <i class="fas fa-exclamation-circle"></i> Needs attention
                    </span>
                </div>
            </div>

            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">System Health</p>
                        <h3 class="text-2xl font-bold">Good</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-heartbeat text-purple-600"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-green-500 text-xs font-medium">
                        <i class="fas fa-check-circle"></i> All systems normal
                    </span>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Recent Activities -->
            <div class="lg:col-span-2 bg-white border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h5 class="font-semibold">Recent Activities</h5>
                    <a href="#" class="text-sm text-primary">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-full mt-1">
                            <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm">New school registered</p>
                            <p class="text-gray-500 text-xs">Greenwood High School was added to the system</p>
                            <p class="text-gray-400 text-xs">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="bg-green-100 p-2 rounded-full mt-1">
                            <i class="fas fa-user-shield text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm">New admin created</p>
                            <p class="text-gray-500 text-xs">Sarah Johnson was assigned as school admin</p>
                            <p class="text-gray-400 text-xs">5 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="bg-yellow-100 p-2 rounded-full mt-1">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm">System warning</p>
                            <p class="text-gray-500 text-xs">Storage usage reached 85% capacity</p>
                            <p class="text-gray-400 text-xs">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <h5 class="font-semibold mb-3">Quick Actions</h5>
                <div class="grid grid-cols-2 gap-2">
                    <a href="#" class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-3 rounded-lg flex flex-col items-center text-center">
                        <i class="fas fa-plus-circle text-lg mb-1"></i>
                        <span class="text-xs">Add School</span>
                    </a>
                    <a href="#" class="bg-green-50 hover:bg-green-100 text-green-600 p-3 rounded-lg flex flex-col items-center text-center">
                        <i class="fas fa-user-plus text-lg mb-1"></i>
                        <span class="text-xs">Create User</span>
                    </a>
                    <a href="#" class="bg-purple-50 hover:bg-purple-100 text-purple-600 p-3 rounded-lg flex flex-col items-center text-center">
                        <i class="fas fa-file-export text-lg mb-1"></i>
                        <span class="text-xs">Generate Report</span>
                    </a>
                    <a href="#" class="bg-orange-50 hover:bg-orange-100 text-orange-600 p-3 rounded-lg flex flex-col items-center text-center">
                        <i class="fas fa-cog text-lg mb-1"></i>
                        <span class="text-xs">System Settings</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Schools Table -->
        <div class="mt-4 bg-white border rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold">Schools Overview</h5>
                <a href="#" class="text-sm text-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>School Name</th>
                            <th>Students</th>
                            <th>Staff</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sunrise Academy</td>
                            <td>1,245</td>
                            <td>85</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><a href="#" class="text-primary">View</a></td>
                        </tr>
                        <tr>
                            <td>Greenwood High</td>
                            <td>890</td>
                            <td>62</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td><a href="#" class="text-primary">View</a></td>
                        </tr>
                        <tr>
                            <td>Riverside School</td>
                            <td>1,520</td>
                            <td>94</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><a href="#" class="text-primary">View</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 500;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>
@endsection

@section('scripts')
<script>
    // You can add dashboard-specific JavaScript here if needed
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
    });
</script>
@endsection