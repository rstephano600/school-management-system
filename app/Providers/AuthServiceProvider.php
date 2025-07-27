<?php
namespace App\Providers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Parents;
use App\Policies\StudentPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\StaffPolicy;
use App\Policies\ParentsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Student::class => StudentPolicy::class,
        Teacher::class => TeacherPolicy::class,
        Staff::class => StaffPolicy::class,
        Parents::class => ParentsPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
