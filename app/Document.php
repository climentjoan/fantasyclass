<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'url',
        'text',
        'size',
        'indentation',
        'visible',
        'type_document',
        'document_category_id',
        'uploader',
        'order',
        'is_task',
        'xp',
        'hp',
        'gold',
    ];

    public function category() {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id', 'id');
    }
    
    public function students() {
        return $this->belongsToMany(Student::class);
    }
}
