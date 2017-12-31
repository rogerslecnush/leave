<?php

namespace App;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes, SlugTrait;

    /**
     * Elements I won't be able to (mass) assign.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Team's users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
