<?php

namespace App\Models\Melisearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;
class Province extends Model
{
    use Searchable;
    public $timestamps = false;
    /**
     * Get the value used to index the model.
     */
    public function getScoutKey(): mixed
    {
        return $this->code;
    }

    /**
     * Get the key name used to index the model.
     */
    public function getScoutKeyName(): mixed
    {
        return 'code';
    }
}
