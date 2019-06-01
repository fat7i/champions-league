<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Season extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'seasons';

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
        'name' => 'required',
    ];

    /**
     * @var array
     */
    protected $with = ['leagueTable', 'weeks'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leagueTable()
    {
        return $this->hasMany('App\Models\League', 'season_id')
            ->orderBy('points', 'DESC')
            ->orderBy(DB::raw('(goals_for - goals_against)'), 'DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function weeks()
    {
        return $this->hasMany('App\Models\Week', 'season_id');
    }

    /**
     * @param string $name
     * @return Season
     */
    public function create(string $name): Season
    {
        $season = new static();
        $season->name = $name;
        $season->save();

        return $season;
    }

    /**
     * @param int $id
     * @return Season
     */
    public function find(int $id): Season
    {
        return self::findOrFail($id);
    }
}
