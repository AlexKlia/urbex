<?php
/**
 * Created by PhpStorm.
 * User: Big Boss
 * Date: 14/12/2016
 * Time: 10:13
 */

namespace Controller;

use \W\Controller\Controller;
use \Model\PicturesModel;
use W\Model\UsersModel;


class PicturesController extends Controller
{

    public function displayAccueil($page = 1)
    {
        $picturesModel =  new PicturesModel();
        $picture = $picturesModel->latestPictures($page-1,10);

        $picturesModel =  new PicturesModel();
        $countPicture = $picturesModel->CountPictures();
        $nbPages= ceil($countPicture/10);


        $this->show('pictures/lastPictures', ['allPictures' =>$picture, 'nbPages'=>$nbPages]);

    }


}