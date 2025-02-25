<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'type'];

    const TYPE_TEXT = 'text';
    const TYPE_DATE = 'date';
    const TYPE_NUMBER = 'number';
    const TYPE_SELECT = 'select';

    public function projects()
    {
        return $this->morphedByMany(Project::class, 'entity', 'entity_attribute_values', 'attribute_id', 'entity_id')->withPivot('value');
    }
     public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class,);
    }
}
