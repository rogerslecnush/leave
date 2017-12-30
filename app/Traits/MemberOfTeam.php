<?php
namespace App\Traits;

trait MemberOfTeam
{
    public function teams()
    {
        return $this->belongsToMany(\App\Team::class);
    }
}