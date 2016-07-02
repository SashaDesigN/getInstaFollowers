<?php

$connection = new Mongo();
$connecting_conf = sprintf('mongodb://%s:%d/%s', 'localhost', '27017', 'instaDB');
$connection = new Mongo($connecting_conf, []);

$db = $connection->selectDB('instaDB');
