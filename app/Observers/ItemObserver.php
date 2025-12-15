<?php
namespace App\Observers;

use App\Models\Item;
use App\Services\ItemMatcher;

class ItemObserver
{
    public function created(Item $item): void
    {
        // why: domain side-effect triggered by lifecycle, not controller
        ItemMatcher::notifyPotentialMatches($item);
    }
}
