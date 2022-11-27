<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'branch_id';

    public function scopeCompanyId($query, $comp_id = null)
    {
        if (!is_null($comp_id)) {
            if ($comp_id != 1) {
                return $query->where('fk_company_id', $comp_id);
            }
        }
    }
}
