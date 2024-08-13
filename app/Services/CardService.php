<?php

namespace App\Services;

use App\Models\Card;
use App\Services\Interfaces\CardServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CardService implements CardServiceInterface
{

    public function getAllCards(Request $request): Collection
    {
        $parameters = $request->query();
        $query = Card::query();
        foreach ($parameters as $key => $value) {
            if (Schema::hasColumn('cards', $key)) {
                $query->where($key, $value);
            }
        }
        return $query->get();
    }

    public function createCard(array $data): Card
    {
        return Card::create($data);
    }

    public function getCardById(int $id): Card
    {
        return Card::find($id);
    }

    public function updateCard(array $data, int $id): Card
    {
        $card = Card::findOrFail($id);
        $card->update($data);
        return $card;
    }

    public function deleteCard(int $id): bool
    {
        return Card::destroy($id) > 0;
    }
}
