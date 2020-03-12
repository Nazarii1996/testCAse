<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Project extends Model implements HasMedia
{
    use HasMediaTrait;

    public $table = 'projects';

    protected $appends = [
        'attachments',
    ];

    protected $dates = [
        'end',
        'start',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE_SELECT = [
        'Work'   => 'Work',
        'Book'   => 'Book',
        'Course' => 'Course',
        'Blog'   => 'Blog',
        'Other'  => 'Other',
    ];

    protected $fillable = [
        'end',
        'role',
        'link',
        'type',
        'title',
        'start',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'organiztion',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);

    }
    public function skills(){
        return $this->hasMany(Skills::class,'projecs_id')->select('name');
    }
    public function getStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;

    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;

    }

    public function getEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;

    }

    public function setEndAttribute($value)
    {
        $this->attributes['end'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;

    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');

    }
}
