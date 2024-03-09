<?php

namespace App\Http\Controllers;

use app\Services\OCRservice;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OCRcontroller extends Controller
{
    //
    public function extractText(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Perform OCR using TesseractOCR
        // $ocr = (new TesseractOCR($request->file('image')->store('images')))->run();
        // $ocr->image($request->file('image')->getPathname());
        // $ocr->run();
        // $imagePath = $request->file('image')->store('images');
        // $text = (new TesseractOCR($request->file('image')->store('images')))->run();
        // $text = (new TesseractOCR($request->file('image')->getPathname()))->run();
        

try {
    $imagePath = $request->file('image')->store('images');
    $text = (new TesseractOCR(storage_path('app/' . $imagePath)))->run();

    $lines = explode("\n", $text);
    $keyValuePairs = [];

    foreach ($lines as $line) {
        // Assuming key and value are separated by a colon
        $pair = explode(':', $line, 2);
        if (count($pair) == 2) {
            $key = trim($pair[0]);
            $value = trim($pair[1]);
            $keyValuePairs[$key] = $value;
        }
    }
    // dd($keyValuePairs);
    // return $keyValuePairs;
    return response()->json($keyValuePairs);
    // return compact($keyValuePairs);
    // dd($text);
    // return compact($keyValuePairs);

} catch (\Exception $e) {
    // Handle any exceptions or errors
    echo "Error: " . $e->getMessage();
    dd( $e->getMessage());

}

    }
}
