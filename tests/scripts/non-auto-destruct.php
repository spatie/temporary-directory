<?php

require '../../src/TemporaryDirectory';

use Spatie\TemporaryDirectory\TemporaryDirectory;

$path = $testingDirectory = __DIR__.DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR .'temp';

$temporaryDirectory = new TemporaryDirectory($path);

touch($temporaryDirectory->path('text.txt'));
