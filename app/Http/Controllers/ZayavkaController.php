<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zayavka;
use App\Models\Product;
use App\Mail\ZayavkaCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


/**
 * @OA\PathItem(path="/api/zayavkas")
 */
class ZayavkaController extends Controller
{

    /**
     * @OA\Post(
     *      path="/api/zayavkas",
     *      summary="Create a new zayavka",
     *      tags={"Zayavka"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Zayavka")
     *      ),
     *      @OA\Response(response="201", description="Created"),
     *  )
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
        ]);

        // Create the Zayavka entry
        $zayavka = Zayavka::create($request->all());

        // Prepare the basic message
        $message = "New Application Received:\n" .
                   "First Name: " . $request->first_name . "\n" .
                   "Email: " . $request->email . "\n" .
                   "Description: " . $request->descriptions . "\n";

        // Check if product_id is provided and not null
        if (!is_null($request->product_id)) {
            // Retrieve the product based on product_id
            $product = Product::find($request->product_id);

            if ($product) {
                $message .= "Product: " . $product->title['en'] . "\n"; // Append product title to the message
            }

        }

        // Send the message to Telegram
        $telegramToken = env('TELEGRAM_BOT_TOKEN'); // Store the token in the .env file
        $chatId = env('TELEGRAM_CHAT_ID'); // Store the chat ID in the .env file

        Http::post("https://api.telegram.org/bot{$telegramToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message
        ]);

        // Return the response
        return response()->json($zayavka, 201);
    }






    public function show($id)
    {
        return Zayavka::find($id);
    }

    public function update(Request $request, $id)
    {
        $zayavka = Zayavka::findOrFail($id);
        $zayavka->update($request->all());

        return $zayavka;
    }

    public function destroy($id)
    {
        Zayavka::destroy($id);

        return response()->noContent();
    }


//    public function show($id)
//    {
//        $team = Zayavka::find($id);
//
//        if (is_null($team)) {
//            return response()->json(['message' => 'Review not found'], 404);
//        }
//
//        return response()->json($team);
//    }


}
