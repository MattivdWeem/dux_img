<?php

namespace Duxilio\ImageServer;

use Duxilio\ImageServer\imageServerSettings;

class imageServer{

    private $settings;
    private $index;

    public function __construct(imageServerSettings $serverSettings){
        $this->setSettings($serverSettings);
        $this->setIndex();
    }


    public function serve($image){

        if (!isset($this->getIndex()[$image])) {
            return json_encode(['fail' => 'nope']);
        }


        header ('Content-Type: image/png');
        return file_get_contents(__DIR__.'/../images/'.$this->getIndex()[$image]['image']);
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param mixed $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex()
    {
        $this->index = json_decode(file_get_contents(__DIR__.'/../imageIndex.json'), true);
    }

    public function validateRequest(){
        // checking for headers, times permissions and sessions here.
        if ($_SERVER['HTTP_USER_AGENT'] == 'SOMETHING BADDD') {
            return false;
        }
        return true;
    }
    public function response($message){
        die(json_encode($message));
    }


}


