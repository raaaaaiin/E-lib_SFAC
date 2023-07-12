<?php

namespace App\Installer;

//use Modules\Setting\Entities\Setting;

use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class Site
{
    public function setup($data)
    {
        $env = DotenvEditor::load();
        $env->setKey('APP_NAME', $data['site_name']);
        $env->setKey('APP_URL', $data['site_url']);
        $env->setKey('MAIL_FROM_ADDRESS', $data['site_email']);

        $env->save();

        $files = glob(base_path("bootstrap/cache")."/*");
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }
}
