<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
