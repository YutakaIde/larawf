<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brexis\LaravelWorkflow\Traits\WorkflowTrait;

class Project extends Model
{
    use WorkflowTrait;

    protected $table = 'projects';

    protected $casts = [
        'currentPlace' => 'json'
    ];
}
