<?php
header('Content-type: application/json; charset=utf-8');
$jsonData = json_decode(file_get_contents('extlist.json', 'UTF-8'));
$from = (isset($_GET['head']) ? (int)$_GET['head'] : 1) - 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
include('fixDownload.php');
for ($i = 0; $i < count($jsonData->NoteList); $i++) {
	$jsonData->NoteList[$i]->ExtURL2 = fixDL($jsonData->NoteList[$i]->ExtID, $jsonData->NoteList[$i]->ExtURL2);
}
$result = [
    'Version' => '4.5.5',
    'NoteList' => $jsonData->NoteList,
    'HasNext' => false,
    'Date' => '202009',
];
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);