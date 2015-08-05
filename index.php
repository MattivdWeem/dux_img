<?php


if (isset($_POST['image'])) {$_POST['image'] = file_get_contents($_POST['image']);}


include(__DIR__.'/vendor/autoload.php');

$serverSettings = new \Duxilio\imageServer\imageServerSettings();
$serverSettings->setUrl('http://192.168.99.100:32770');
$server = new \Duxilio\imageServer\imageServer($serverSettings);



if (isset($_GET['image']) && $_GET['image'] != '') {

    echo $server->serve($_GET['image']);
    exit;

} else if (isset($_POST['image']) && $_POST['image'] != '') {

    if (!$server->validateRequest()) { $server->response('Bad Request'); }

    $data       = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['image']));
    $fileName   = time().'_'.md5(rand(1,250)).'-dux';
    file_put_contents('images/'.$fileName.'.jpg', $data);


    $key        = md5('serve.-'.time().rand(0,201).'-dux');

    $contents   = json_decode(file_get_contents('imageIndex.json'),true);
    $output     = [$key => ['image' => $fileName.'.jpg']];
    $contents   = array_merge($contents, $output);


    file_put_contents('imageIndex.json', json_encode($contents));

    header ('Content-Type: application/json');

    echo json_encode([
        'status' => 'success',
        'path' => $serverSettings->getUrl().'?image='.$key
    ]);


}












