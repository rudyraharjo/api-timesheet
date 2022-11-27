<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'project_id';

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
        return $this->belongsTo(User::class, 'fk_createdby_id');
    }

    public function tag()
    {
        return $this->hasMany(Tag::class, 'fk_project_id');
    }
}
