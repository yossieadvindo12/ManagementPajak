<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;

class OCRService
{
    public function recognizeText($imagePath)
    {
        return (new TesseractOCR($imagePath))
            ->lang(config('services.tesseract.options.lang'))
            ->run();
    }
}
