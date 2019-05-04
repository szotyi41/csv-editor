<link rel="stylesheet" href="style.css">

<?php

require 'src/Query.php';
require 'src/Data.php';
require 'src/Replace.php';
require 'src/Remove.php';
require 'src/Duplicate.php';
require 'src/Explode.php';
require 'src/Math.php';
require 'src/DateFormat.php';


$data = new Data('adm_feed.csv');
$data->import();

echo 'Rows: ' . $data->getCount();

$rep1 = new Replace($data);
$rep1->getfield(2);
$rep1->setfield(2);
$rep1->replace('http', 'https');

$times = new Math($data);
$times->setfield(8);
$times->format(0, ',', ' ');
$times->suffix(' HUF');
$times->calc('%s*1.27', [7]);

/*
$rep1 = new Replace($data);
$rep1->where(4, 'i', 'SANS');
$rep1->getfield(4);
$rep1->setfield(4);
$rep1->replace('SANS', 'EXEC%s', [0]);

$rep2 = new Replace($data);
$rep2->setfield(9);
$rep2->set('%s Üres %s', [1, 'csicska']);

$remove = new Remove($data);
$remove->where(4, 'i', 'ARTENGO');
$remove->remove();

$duplicate = new Duplicate($data);
$duplicate->where(4, 'e', 'KIPSTA');
$duplicate->duplicate();

$explode = new Explode($data);
$explode->getfield(1);
$explode->setfields([10,11,12]);
$explode->explode(',');
$data->setColumn(10, 'Exploded 1');
$data->setColumn(11, 'Exploded 2');
$data->setColumn(12, 'Exploded 3');

$date = new DateFormat($data);
$date->getfield(8);
$date->setfield(13);
$date->format('Y. m. d.');
$date->date('+ 1 days');*/



echo 'Rows: ' . $data->getCount();


$data->table();
