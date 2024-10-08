<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

function compare($a, $b) {
    if ($a->codpcddsp == $b->codpcddsp) return 0;
    return ($a->codpcddsp < $b->codpcddsp) ? 1 : -1;
}

$codunddsp = filter_input(INPUT_GET, 'codunddsp', FILTER_VALIDATE_INT);
$url = "https://portalservicos.usp.br/wsinfo/api?name=compra&lq=codunddsp:$codunddsp&length=100";
$client = new Client();
$response = $client->get($url);
$json = json_decode(utf8_encode($response->getBody()));
$items = $json->items;

uasort($items, "compare");

echo "<pre>";
foreach ($items as $item) {
    echo "Contratação: $item->numcpr/$item->anocpr\n";
    echo "Modalidade: $item->nommdldsp\n";
    echo "Objeto: $item->objcpr\n";
    echo "<a href='https://portalservicos.usp.br/contratacoes/$item->codpcddsp'>Detalhes</a>\n";
    echo "<hr/>";
}
echo "</pre>";
