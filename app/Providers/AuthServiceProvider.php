<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\{Flow, Policies\FlowPolicy};
use App\{BusinessUnit, Policies\BusinessUnitPolicy};
use App\{Program, Policies\ProgramPolicy};
use App\{Project, Policies\ProjectPolicy};
use App\{User, Policies\UserPolicy};
use App\{Competence, Policies\CompetencePolicy};
use App\{SubCompetence, Policies\SubCompetencePolicy};
use App\{Profile, Policies\ProfilePolicy};

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',        
        BusinessUnit::class => BusinessUnitPolicy::class,
        Flow::class => FlowPolicy::class, 
        Program::class => ProgramPolicy::class, 
        Project::class => ProjectPolicy::class, 
        User::class => UserPolicy::class, 
        Competence::class => CompetencePolicy::class,
        SubCompetence::class => SubCompetencePolicy::class,
        Profile::class => ProfilePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
