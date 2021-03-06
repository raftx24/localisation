<?php

namespace LaravelEnso\Localisation\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\app\Contracts\Activatable;
use LaravelEnso\Helpers\app\Traits\ActiveState;
use LaravelEnso\Tables\app\Traits\TableCache;

class Language extends Model implements Activatable
{
    use ActiveState, TableCache;

    private const FlagClassPrefix = 'flag-icon flag-icon-';

    protected $fillable = ['name', 'display_name', 'flag', 'is_rtl', 'is_active'];

    protected $casts = ['is_rtl' => 'boolean', 'is_active' => 'boolean'];

    public function updateWithFlagSufix($attributes, string $sufix)
    {
        $this->fill($attributes);

        $this->flag = self::FlagClassPrefix.$sufix;

        $this->update();
    }

    public function storeWithFlagSufix($attributes, string $sufix)
    {
        $this->fill($attributes);

        $this->flag = self::FlagClassPrefix.$sufix;

        return tap($this)->save();
    }

    public function scopeExtra($query)
    {
        return $query->where('name', '<>', config('app.fallback_locale'));
    }
}
