
$app_class = 'thiagoalessio\TesseractOCR\TesseractOCR';
    $file = 'C:/Users/admin/Desktop/im2.jpg';
    
    $class = new ReflectionClass($app_class);
    $infoImg = $class->newInstanceArgs();
    $infoImg->lang('eng','jpn','spa','fr');
    $infoImg->image($file);
    $infoImg->withoutTempFiles();
    $resultat = $infoImg->run();
    var_dump($resultat);