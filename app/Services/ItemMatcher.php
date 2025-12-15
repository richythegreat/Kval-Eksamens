<?php
namespace App\Services;

use App\Models\Item;
use App\Notifications\ItemMatchFound;

final class ItemMatcher
{
    private const THRESHOLD = 0.35;
    private const STOP = ['un','vai','and','the','a','an','ir','kas','ar'];

    public static function notifyPotentialMatches(Item $item): void
    {
        if (!$item->city || !$item->category) return;

        $a = "{$item->title} {$item->description}";

        $candidates = Item::query()
            ->oppositeStatusOf($item)
            ->sameCityCategory($item->city, $item->category)
            ->whereKeyNot($item->getKey())
            ->select(['id','title','description','user_id'])
            ->get();

        foreach ($candidates as $other) {
            if (!$other->user) continue;
            $b = "{$other->title} {$other->description}";
            if (self::similarity($a,$b) >= self::THRESHOLD) {
                $other->user->notify(new ItemMatchFound($item)); // include data['url']
            }
        }
    }

    public static function similarity(string $a, string $b): float
    {
        $norm = fn(string $t) => preg_split(
            '/\s+/', trim(preg_replace('/[^\p{L}\p{N}\s]/u',' ', mb_strtolower($t))) ?? '',
            -1, PREG_SPLIT_NO_EMPTY
        );
        $fa = array_values(array_unique(array_filter($norm($a), fn($w)=>mb_strlen($w)>2 && !in_array($w,self::STOP,true))));
        $fb = array_values(array_unique(array_filter($norm($b), fn($w)=>mb_strlen($w)>2 && !in_array($w,self::STOP,true))));
        if (!$fa || !$fb) return 0.0;
        return count(array_intersect($fa,$fb)) / max(count($fa),count($fb));
    }
}
