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
use \Model\VotesModel;


class PicturesController extends Controller
{

    public function displayAccueil($page = 1)
    {
        $picturesModel =  new PicturesModel();
        $picture = $picturesModel->latestPictures($page-1,10);

        $picturesModel =  new PicturesModel();
        $countPicture = $picturesModel->CountPictures();
        $nbPages= ceil($countPicture/10);


        if($page < 1)
        {
            $page = 1;
        }

        $this->show('pictures/lastPictures', ['allPictures' =>$picture, 'nbPages'=>$nbPages, 'page' => $page]);

    }



    public function ajaxOperation()
    {
        $picturesModel = new PicturesModel() ;
        //$nbVotes = $picturesModel->latestPictures( 1 ,10);
        //print_r($nbVotes);

        if(isset($_POST['pictureId']) && ctype_digit($_POST['pictureId']))
        {
            $voteModel = new VotesModel();
            $vote = $voteModel->search(['id_user' => [$_SESSION]['user']['username'], 'id_picture' => $_POST['pictureId']], 'AND');

            if(empty($vote)){
                /*$id = $voteModel->insert([
                    'id_user' => 1,
                    'id_picture' => $_POST['pictureId']
                ]);*/
                $voteModel->insert([$_SESSION]['user']['username'],$_POST['pictureId']);
            }
            $nbVotes = $picturesModel->getNbVotes($_POST['pictureId']);
            $this->showJson(['success'=> true, 'nbVote'=>$nbVotes]);
        }

    }
}