<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'timesheet_id';

    public function scopeCompanyId($query, $comp_id = null)
    {
        if (!is_null($comp_id)) {
            if ($comp_id != 1) {
                return $query->where('fk_company_id', $comp_id);
            }
        }
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'fk_employee_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'fk_project_id');
    }
}
