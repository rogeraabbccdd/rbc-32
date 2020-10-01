<?php
header('Content-type: application/json; charset=utf-8');
$jsonData = json_decode(file_get_contents('packlist.json', 'UTF-8'));
$from = (isset($_GET['head']) ? (int)$_GET['head'] : 1) - 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$list = [];
for ($i = 0; $i < $limit; $i++) {
    if (isset($jsonData->PackList[$from + $i])) {
        array_push($list, $jsonData->PackList[$from + $i]);
    }
}
if ($from === 0) {
    $result = [
        'Version' => '4.5.5',
        'Promotion' => $jsonData->Promotion,
        'Genre' =>  $jsonData->Genre,
        'HasNext' => isset($jsonData->PackList[$limit + $from + 1]),
        'Date' => '202009',
        'PackList' => $list
    ];
} else {
    $result = [
        'Version' => '4.5.5',
        'HasNext' => isset($jsonData->PackList[$limit + $from + 1]),
        'Date' => '202009',
        'PackList' => $list
    ];
}
for ($i = 0; $i < count($result['PackList']); $i++) {
    if ($result['PackList'][$i]->ID >= 350) {
        $data = json_decode(file_get_contents('packinfo'.$result['PackList'][$i]->ID.'.json'));
        $count = 0;
        for ($j = 0; $j < count($data->MusicList); $j++) {
            $count += count($data->MusicList[$j]->PID);
        }
        $result['PackList'][$i]->ExtNum = $count;
        $result['PackList'][$i]->MusicNum = count($data->MusicList);
    } else {
        $list = json_decode(file_get_contents('packInfo_last.json'));
        for ($j = 0; $j < count($list); $j++) {
            if ($list[$j]->ID === $result['PackList'][$i]->ID) {
                $count = 0;
                for ($k = 0; $k < count($list[$j]->MusicList); $k++) {
                    $count += count($list[$j]->MusicList[$k]->PID);
                }
                $result['PackList'][$i]->ExtNum = $count;
                $result['PackList'][$i]->MusicNum = count($list[$j]->MusicList);
                break;
            }
        }
    }
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);