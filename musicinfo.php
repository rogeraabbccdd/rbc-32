<?php

include('fixDownload.php');
header('Content-type: application/json; charset=utf-8');
$musicId = isset($_GET['music']) ? (int)$_GET['music'] : 100040001;
$list = json_decode(file_get_contents('config/packInfo_last.json'));
$output = '';
for ($i = 0; $i < count($list); $i++) {
    for ($j = 0; $j < count($list[$i]->MusicList); $j++) {
        if ($list[$i]->MusicList[$j]->ID === (int)$musicId) {
            $output = $list[$i]->MusicList[$j];
            break;
        }
    }
}
if ($output !== '') {
    $output->ItemURL = fixDL($output->ID, $output->ItemURL);
    echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
for ($i = 350; $i < 400; $i++) {
    if (file_exists('config/packinfo'.$i.'.json')) {
        $data = json_decode(file_get_contents('config/packinfo'.$i.'.json'));
        for ($j = 0; $j < count($data->MusicList); $j++) {
            if ($data->MusicList[$j]->ID === (int)$musicId) {
                $output = $data->MusicList[$j];
                break;
            }
        }
    }
}
if ($output) {
    $output->ItemURL = fixDL($output->ID, $output->ItemURL);
    echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
    echo '{}';
}