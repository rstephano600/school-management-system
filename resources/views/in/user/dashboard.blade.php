<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System | Super Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            transition: all 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .notification-dot {
            position: absolute;
            top: -5px;
            right: -5px;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-indigo-800 text-white w-64 flex-shrink-0">
            <div class="p-4 flex items-center space-x-3 border-b border-indigo-700">
                <img src="/logo.png" alt="School Logo" class="w-10 h-10 rounded-full">
                <div>
                    <h1 class="font-bold text-xl">EduManage Pro</h1>
                    <p class="text-xs text-indigo-300">Super Admin Panel</p>
                </div>
            </div>
            
            <div class="p-4">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ Auth::user()->avatar ?? '/default-avatar.png' }}" alt="User" class="w-10 h-10 rounded-full">
                    <div>
                        <h3 class="font-medium">{{ Auth::user()->name }}</h3>
                        <span class="text-xs bg-indigo-600 px-2 py-1 rounded-full">Super Admin</span>
                    </div>
                </div>
                
                <nav class="space-y-1">
                    <a href="#" class="flex items-center space-x-3 bg-indigo-900 px-3 py-2 rounded-lg">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg">
                        <i class="fas fa-school w-5"></i>
                        <span>Schools</span>
                        <span class="ml-auto bg-indigo-600 text-xs px-2 py-1 rounded-full">15</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg">
                        <i class="fas fa-users w-5"></i>
                        <span>System Users</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span>Reports</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg relative">
                        <i class="fas fa-bell w-5"></i>
                        <span>Alerts</span>
                        <span class="notification-dot bg-red-500 w-2 h-2 rounded-full"></span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg">
                        <i class="fas fa-comments w-5"></i>
                        <span>Comments</span>
                        <span class="ml-auto bg-indigo-600 text-xs px-2 py-1 rounded-full">3</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span>Academic Calendar</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:bg-indigo-700 px-3 py-2 rounded-lg">
                        <i class="fas fa-book w-5"></i>
                        <span>Courses</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Super Admin Dashboard</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-500 cursor-pointer"></i>
                            <span class="notification-dot bg-red-500 w-2 h-2 rounded-full"></span>
                        </div>
                        <div class="relative">
                            <i class="fas fa-envelope text-gray-500 cursor-pointer"></i>
                            <span class="notification-dot bg-red-500 w-2 h-2 rounded-full"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img src="{{ Auth::user()->avatar ?? '/default-avatar.png' }}" alt="User" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="dashboard-card bg-white rounded-lg shadow p-6 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Total Schools</p>
                                <h3 class="text-2xl font-bold">15</h3>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-school text-blue-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-sm font-medium"><i class="fas fa-arrow-up"></i> 2 new this month</span>
                        </div>
                    </div>

                    <div class="dashboard-card bg-white rounded-lg shadow p-6 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Total Users</p>
                                <h3 class="text-2xl font-bold">1,245</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-users text-green-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-sm font-medium"><i class="fas fa-arrow-up"></i> 5.2% increase</span>
                        </div>
                    </div>

                    <div class="dashboard-card bg-white rounded-lg shadow p-6 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Pending Requests</p>
                                <h3 class="text-2xl font-bold">8</h3>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-red-500 text-sm font-medium"><i class="fas fa-exclamation-circle"></i> Needs attention</span>
                        </div>
                    </div>

                    <div class="dashboard-card bg-white rounded-lg shadow p-6 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">System Health</p>
                                <h3 class="text-2xl font-bold">Good</h3>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-heartbeat text-purple-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-sm font-medium"><i class="fas fa-check-circle"></i> All systems normal</span>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Activities -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg">Recent Activities</h3>
                            <button class="text-sm text-blue-600">View All</button>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">New school registered</p>
                                    <p class="text-sm text-gray-500">Greenwood High School was added to the system</p>
                                    <p class="text-xs text-gray-400">2 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="bg-green-100 p-2 rounded-full">
                                    <i class="fas fa-user-shield text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">New admin created</p>
                                    <p class="text-sm text-gray-500">Sarah Johnson was assigned as school admin</p>
                                    <p class="text-xs text-gray-400">5 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="bg-yellow-100 p-2 rounded-full">
                                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">System warning</p>
                                    <p class="text-sm text-gray-500">Storage usage reached 85% capacity</p>
                                    <p class="text-xs text-gray-400">Yesterday</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-semibold text-lg mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <button class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-4 rounded-lg flex flex-col items-center">
                                <i class="fas fa-plus-circle text-xl mb-2"></i>
                                <span class="text-sm">Add School</span>
                            </button>
                            <button class="bg-green-50 hover:bg-green-100 text-green-600 p-4 rounded-lg flex flex-col items-center">
                                <i class="fas fa-user-plus text-xl mb-2"></i>
                                <span class="text-sm">Create User</span>
                            </button>
                            <button class="bg-purple-50 hover:bg-purple-100 text-purple-600 p-4 rounded-lg flex flex-col items-center">
                                <i class="fas fa-file-export text-xl mb-2"></i>
                                <span class="text-sm">Generate Report</span>
                            </button>
                            <button class="bg-orange-50 hover:bg-orange-100 text-orange-600 p-4 rounded-lg flex flex-col items-center">
                                <i class="fas fa-cog text-xl mb-2"></i>
                                <span class="text-sm">System Settings</span>
                            </button>
                        </div>
                    </div>

                    <!-- Schools Overview -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg">Schools Overview</h3>
                            <button class="text-sm text-blue-600">View All</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left border-b">
                                        <th class="pb-2">School Name</th>
                                        <th class="pb-2">Students</th>
                                        <th class="pb-2">Staff</th>
                                        <th class="pb-2">Status</th>
                                        <th class="pb-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-3">Sunrise Academy</td>
                                        <td>1,245</td>
                                        <td>85</td>
                                        <td><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Active</span></td>
                                        <td><button class="text-blue-600 text-sm">View</button></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3">Greenwood High</td>
                                        <td>890</td>
                                        <td>62</td>
                                        <td><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Pending</span></td>
                                        <td><button class="text-blue-600 text-sm">View</button></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3">Riverside School</td>
                                        <td>1,520</td>
                                        <td>94</td>
                                        <td><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Active</span></td>
                                        <td><button class="text-blue-600 text-sm">View</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- System Alerts -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg">System Alerts</h3>
                            <button class="text-sm text-blue-600">View All</button>
                        </div>
                        <div class="space-y-3">
                            <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-r">
                                <p class="font-medium text-red-800">Storage Warning</p>
                                <p class="text-sm text-red-600">System storage at 85% capacity</p>
                            </div>
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded-r">
                                <p class="font-medium text-yellow-800">Pending Approvals</p>
                                <p class="text-sm text-yellow-600">3 schools waiting for approval</p>
                            </div>
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded-r">
                                <p class="font-medium text-blue-800">New Update Available</p>
                                <p class="text-sm text-blue-600">Version 2.3.1 ready to install</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>