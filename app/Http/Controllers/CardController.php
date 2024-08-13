<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatus;
use App\Http\Requests\Cards\StoreCardRequest;
use App\Http\Requests\Cards\UpdateCardRequest;
use App\Services\Interfaces\CardServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CardController extends Controller
{
    protected $cardService;

    public function __construct(CardServiceInterface $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cards = $this->cardService->getAllCards($request);
        return response()->json($cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\StoreCardRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCardRequest $request): JsonResponse
    {
        try {
            $card = $this->cardService->createCard($request->validated());
            return response()->json($card, HttpStatus::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()],  HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $card = $this->cardService->getCardById($id);
        if ($card) {
            return response()->json($card);
        }
        return response()->json(['error' => 'Not Found'], HttpStatus::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\UpdateCardRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCardRequest $request, int $id): JsonResponse
    {
        try {
            $card = $this->cardService->updateCard($request->validated(), $id);
            return response()->json($card, HttpStatus::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->cardService->deleteCard($id);
        if ($deleted) {
            return response()->json(null,  HttpStatus::HTTP_NO_CONTENT);
        }
        return response()->json(['error' => 'Not Found'], HttpStatus::HTTP_NOT_FOUND);
    }
}
