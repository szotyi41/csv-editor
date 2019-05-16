<link rel="stylesheet" href="style.css">

<?php

$start = microtime(true);

require_once 'vendor/autoload.php';


$data = (new Data('adm_feed.csv'))->import();

echo 'Started rows: ' . $data->getCount() . '<br>';

$rep1 = (new Replace($data))

    // Where the 4. column contains SANS text
    ->where(4, 'contains', 'SANS')

    // Or the 2. column contains SANS text
    ->orWhere(2, 'contains', 'SANS')

    // Get data from 2. column
    ->getColumn(2)

    // Set the 2. column
    ->setColumn(2)

    // Run the replace
    ->replace('http', 'https');


$times = (new Math($data))
    
    ->where(0, 'largerThan', 8383162)

    ->format(0, '.', '')
    ->round(2)
    ->suffix('.00 HUF')

    // Set the 8. column
    ->setColumn(8)

    // Get data from 7. column, and times it 1.27
    ->calc('%s*1.27', [7]);


$rep2 = (new Replace($data))
    ->getColumn(4)
    ->where(4, 'contains', 'SANS')
    ->setColumn(4)
    ->replace('SANS', 'EXEC %s', [0]);


$rep3 = (new Replace($data))
    ->setColumn(9)
    ->set('%s Üres %s', [1, 'csicska']);

$remove = (new Remove($data))
    ->where(4, 'equal', 'ARTENGO')
    ->orWhere(4, 'equal', 'KIPSTA')
    ->remove();


$duplicate = (new Duplicate($data))
    ->where(4, 'equal', 'WORKSHOP')
    ->duplicate();


$explode = (new Explode($data))
    ->getColumn(1)
    ->setColumns([10,11,12])
    ->explode(',');

$date = (new DateFormat($data))
    ->getColumn(8)
    ->setColumn(0)
    ->format('Y. m. d.')
    ->date('+ 1 days');


echo 'Ended rows: ' . $data->getCount() . '<br>';

$end = microtime(true);


echo 'Runtime in microseconds: ' . ($end - $start) . '<br>';

$data->table();
