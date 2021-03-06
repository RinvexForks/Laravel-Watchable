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

trait HasWatchlistsTrait
{
    public function watchlists()
    {
        return $this->morphMany(Watchlist::class, 'author');
    }

    public function getWatchlist($id)
    {
        return $this->watchlists()->find($id);
    }

    public function getWatchlistBySlug($slug)
    {
        return $this->watchlists()->findBySlug($slug);
    }

    public function getWatchlistByType($type)
    {
        return $this->watchlists()->whereType($type)->get();
    }

    public function createWatchlist($data)
    {
        $data['author_id'] = $this->id;
        $data['author_type'] = get_class($this);

        return $this->watchlists()->create($data);
    }

    public function updateWatchlist($id, $data)
    {
        if (is_string($id)) {
            $wishlist = $this->getWatchlistBySlug($id);
        } else {
            $wishlist = $this->getWatchlist($id);
        }

        return $wishlist->update($data);
    }

    public function deleteWatchlist($id)
    {
        if (is_string($id)) {
            $wishlist = $this->getWatchlistBySlug($id);
        } else {
            $wishlist = $this->getWatchlist($id);
        }

        return $wishlist->delete();
    }
}
