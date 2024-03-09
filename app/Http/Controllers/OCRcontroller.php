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

    return response()->json(['text' => $text]);
    // dd($text);
    // Process the extracted text
    // For example, you can return it or store it in a database
} catch (\Exception $e) {
    // Handle any exceptions or errors
    echo "Error: " . $e->getMessage();
    dd( $e->getMessage());

}

    }
}
