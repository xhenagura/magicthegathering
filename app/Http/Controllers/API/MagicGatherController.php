<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MagicGatherController extends Controller
{
    public function getAllCards(Request $request)
    {
        try {
            $page = $request->input('page', 1); // Get the page number from the request, default to 1 if not provided

            // Make a request to the Magic: The Gathering API to fetch cards
            $response = Http::get('https://api.magicthegathering.io/v1/cards', [
                'page' => $page
                // Add any other query parameters as needed, based on the API documentation
            ]);

            return $response->json(); // Return the JSON response from the API
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch cards'], 500); // Return an error response if an exception occurs
        }
    }


    public function getSets()
    {
        try {
            // Make a request to the Magic: The Gathering API to fetch sets
            $response = Http::get('https://api.magicthegathering.io/v1/sets');

            return $response->json(); // Return the JSON response from the API
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch sets'], 500); // Return an error response if an exception occurs
        }
    }

    public function getTypes()
    {
        try {
            // Make a request to the Magic: The Gathering API to fetch types
            $response = Http::get('https://api.magicthegathering.io/v1/types');

            return $response->json(); // Return the JSON response from the API
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch types'], 500); // Return an error response if an exception occurs
        }
    }

    public function getSupertypes()
    {
        try {
            // Make a request to the Magic: The Gathering API to fetch supertypes
            $response = Http::get('https://api.magicthegathering.io/v1/supertypes');

            return $response->json(); // Return the JSON response from the API
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch supertypes'], 500); // Return an error response if an exception occurs
        }
    }

    public function getFormats()
    {
        try {
            // Make a request to the Magic: The Gathering API to fetch formats
            $response = Http::get('https://api.magicthegathering.io/v1/formats');

            return $response->json(); // Return the JSON response from the API
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch formats'], 500); // Return an error response if an exception occurs
        }
    }
    public function addCardToDeck(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'mana_cost' => 'required|string',
            // Add any other validation rules for the card data
        ]);
    
        // Fetch the current deck from the request data or initialize an empty array
        $deck = $request->input('deck', []);
    
        // Check if adding this card would exceed the maximum deck size
        if (count($deck) >= 30) {
            return response()->json(['error' => 'Deck size cannot exceed 30 cards'], 400);
        }
    
        // Add the card to the deck
        $card = [
            'name' => $validatedData['name'],
            'mana_cost' => $validatedData['mana_cost'],
            // Add any other card data you need to store
        ];
    
        $deck[] = $card;
        dd($deck);
    
        // Calculate and return the average mana cost of the deck
        $averageManaCost = $this->calculateAverageManaCost($deck);
    
        // Return a success response with the added card and average mana cost
        return response()->json([
            'message' => 'Card added to deck successfully',
            'card' => $card,
            'average_mana_cost' => $averageManaCost
        ]);
    }
    

    private function calculateAverageManaCost($deck)
    {
        $totalManaCost = 0;
        $nonLandCardCount = 0;

        foreach ($deck as $card) {
            // Check if the card is a land card (assuming land cards have no mana cost)
            if (!isset($card['mana_cost'])) {
                continue; // Skip land cards
            }

            $totalManaCost += $this->parseManaCost($card['mana_cost']);
            $nonLandCardCount++;
        }

        // Calculate the average mana cost, handle the case where there are no non-land cards
        $averageManaCost = $nonLandCardCount > 0 ? $totalManaCost / $nonLandCardCount : 0;

        return $averageManaCost;
    }

    private function parseManaCost($manaCost)
    {
        // Implement logic to parse mana cost string and calculate its value
        // For simplicity, let's assume mana cost is represented by the number of characters in the string
        return strlen($manaCost);
    }

}
