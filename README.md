# Tika

Master: [![Build Status](https://travis-ci.org/Funstaff/Tika.png?branch=master)](https://travis-ci.org/Funstaff/Tika)

A wrapper php for [Tika binary](http://tika.apache.org)

Usage
-----

```php
<?php

use Funstaff\Tika\Configuration;
use Funstaff\Tika\Document;
use Funstaff\Tika\Wrapper;

$config = new Configuration('/path/to/tika.jar');
$config
    ->setOutputFormat('html')
    ->setOutputEncoding('UTF8');

$wrapper = new Wrapper($config);
$wrapper
    ->addDocument(new Document('doc.pdf','/path/to/document.pdf'))
    ->addDocument(new Document('doc2.pdf','/path/to/document2.pdf'))
    ->execute();

/* Get All documents */
$documents = $wrapper->getDocument();

/* or only one document */
$document = $wrapper->getDocument('doc.pdf');

/* Get Document content */
$content = $document->getContent();

/* or raw content (output of Tika) */
$content = $document->getRawContent();

/* Get All Metadata for document (only on xml and html output format) */
$metadata = $document->getMetadata();

/* Get Value for metadata */
$author = $metadata->get('author');

```

Credits
-------
To all users that gave feedback and committed code [https://github.com/Funstaff/Tika](https://github.com/Funstaff/Tika).

© 2013 Bertrand Zuchuat - Funstaff