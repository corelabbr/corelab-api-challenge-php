<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Cards\StoreCardRequest;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface CardServiceInterface
{
    /**
     * Retrieve a list of cards based on query parameters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCards(Request $request): Collection;

    /**
     * Store a new card in the database.
     *
     * @param array $data
     * @return \App\Models\Card
     */
    public function createCard(array $data): Card;

    /**
     * Retrieve a card by its ID.
     *
     * @param int $id
     * @return \App\Models\Card|null
     */
    public function getCardById(int $id): ?Card;

    /**
     * Update an existing card in the database.
     *
     * @param array $data
     * @param int $id
     * @return \App\Models\Card
     */
    public function updateCard(array $data, int $id): Card;

    /**
     * Delete a card from the database.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCard(int $id): bool;
}
