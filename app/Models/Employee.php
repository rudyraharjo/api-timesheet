<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'employee_id';

    public function scopeCompanyId($query, $comp_id = null)
    {   
        if (!is_null($comp_id)) {
            if ($comp_id != 1) {
                return $query->where('fk_company_id', $comp_id);
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'fk_branch_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'fk_department_id');
    }

    public function job_title()
    {
        return $this->belongsTo(JobTitle::class, 'fk_job_title_id');
    }

    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'fk_job_type_id');
    }
}
