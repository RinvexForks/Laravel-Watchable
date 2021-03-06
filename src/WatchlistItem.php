<?php

/*
 * This file is part of Laravel Watchable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Watchable;

use Illuminate\Database\Eloquent\Model;

class WatchlistItem extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['watchable'];

    public function watchable()
    {
        return $this->morphTo();
    }

    public function addItem(Model $watchlist, Model $watchable)
    {
        $data = [
            'watchlist_id'   => $watchlist->id,
            'watchable_id'   => $watchable->id,
            'watchable_type' => get_class($watchable),
        ];

        if (!$item = static::where($data)->first()) {
            $item = new static(array_except($data, ['watchlist_id']));

            $watchlist->items()->save($item);
        }

        return $item;
    }

    public function removeItem(Model $watchlist, Model $watchable)
    {
        $data = [
            'watchlist_id'   => $watchlist->id,
            'watchable_id'   => $watchable->id,
            'watchable_type' => get_class($watchable),
        ];

        if (!$item = static::where($data)->first()) {
            return false;
        }

        return $item->delete();
    }
}
