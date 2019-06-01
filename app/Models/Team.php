<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    /**
     *
     */
    const MAX_STRENGTHS = 100;

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'teams';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'logo',
        'strengths'
    ];

    /**
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    /**
     * @return Team[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection
    {
        return self::all();
    }
}
