# ONNX PHP

Library for use onnxruntime with php

## Installation

Run:

```sh
composer require veka-server/onnx-php
```

## Config

Run:

```php
/** Set the directory where the library will be downloaded, if it not set then it will be stored inside vendor directory */
Onnx\Library::setFolder(__DIR__.'/lib');

/** Download the library if not found */
Onnx\Library::install();

```
