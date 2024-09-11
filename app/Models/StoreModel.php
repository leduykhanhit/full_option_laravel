<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Engines\Engine;
use Laravel\Scout\Searchable;

class StoreModel extends Model
{
    protected $table = 'stores';
    use Searchable;

    public function searchableAs(): string
    {
        return 'stores_index';
    }

    public function getScoutKey(): mixed
    {
        return $this->code;
    }

    public function getScoutKeyName(): mixed
    {
        return 'code';
    }

    public function searchableUsing(): Engine
    {
        return app(EngineManager::class)->engine('meilisearch');
    }

    public function toSearchableArray(): array
    {
//        $array = $this->toArray();

        // Customize the data array...
        return [
            'id' => (int) $this->getKey(),
            'id_record' => (int) $this->id,
            'name' => $this->name,
            'code' => (float) $this->price,
            'address' => $this->address,
            'full_search' => $this->name . $this->address,
        ];

        //return $array;
    }
}
