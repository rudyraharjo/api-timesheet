<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssignmentDepartment extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'project_assignment_department_id';

    public function project()
    {
        return $this->belongsTo(Project::class, 'fk_project_id');
    }

    public function department()
    {
        return $this->hasMany(Department::class, 'department_id', 'fk_department_id');
    }
}
