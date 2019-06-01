<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Week extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'weeks';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var array
     */
    public static $rules = [
        'season_id' => 'required',
        'name' => 'required',
    ];

    /**
     * @var array
     */
    protected $with = ['matches', 'isPlayed'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\Models\Match', 'week_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function isPlayed()
    {
        return $this->hasOne('App\Models\Match', 'week_id')
            ->select([DB::raw('MIN(`is_played`)  as is_played'), 'week_id'])
            ->groupBy('week_id');
    }

    /**
     * @param int $seasonId
     * @param string $name
     * @return Week
     */
    public function create(int $seasonId, string $name): Week
    {
        $season = new static();
        $season->season_id = $seasonId;
        $season->name = $name;
        $season->save();

        return $season;
    }

    /**
     * @param int $id
     * @return Week
     */
    public function find(int $id): Week
    {
        return self::findOrFail($id);
    }
}
