<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function property()
    {
        return $this->belongsTo(Property::class , "property_id");
    }

    public function file()
    {
        return $this->belongsTo(File::class , "file_id");
    }

    // public function url()
    // {
    //     return optional($this->file)->url();
    // }

    public function url()
    {
        $file = $this->file;

        $filepath = optional($file)->path;

        if (!empty($filepath)) {
            $path = str_replace("app", "", $filepath);
            return url($path);
        }
    }

    public function cleanDelete()
    {
        $this->delete();
        optional($this->file)->cleanDelete();
    }
}
