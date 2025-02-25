<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'entity', 'entity_attribute_values', 'entity_id', 'attribute_id')->withPivot('value');
    }
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'entity_id'); 
    }
}
