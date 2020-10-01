<?php
include('fixDownload.php');
$pack = isset($_GET['pack']) ? $_GET['pack'] : 1;
header('Content-type: application/json; charset=utf-8');
if (!file_exists('packlist/packinfo'.$pack.'.json')) {
    $list = json_decode(file_get_contents('packlist/packInfo_last.json'));
    for ($i = 0; $i < count($list); $i++) {
        if ((string)$list[$i]->ID === $pack) {
            $extCount = 0;
            for ($j = 0; $j < count($list[$i]->MusicList); $j++) {
				$list[$i]->MusicList[$j]->ItemURL = fixDL($list[$i]->MusicList[$j]->ID, $list[$i]->MusicList[$j]->ItemURL);
                $extCount += count($list[$i]->MusicList[$j]->PID);
            }
            $list[$i]->ExtNum = $extCount;
            echo json_encode($list[$i], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit();
        }
    }
    echo '{}';
    exit();
}
$data = json_decode(file_get_contents('packlist/packinfo'.$pack.'.json'));
$extCount = 0;
for ($i = 0; $i < count($data->MusicList); $i++) {
	$data->MusicList[$i]->ItemURL = fixDL($data->MusicList[$i]->ID, $data->MusicList[$i]->ItemURL);
    $extCount += count($data->MusicList[$i]->PID);
}
$data->ExtNum = $extCount;
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
exit();