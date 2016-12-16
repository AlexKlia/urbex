<?php

namespace Controller;

use Model\UsersModel;
use \W\Controller\Controller;
use \Model\PicturesModel;
use \Model\VotesModel;
use Service\ImageManagerService;



class PicturesController extends Controller
{


    public function displayAccueil($page = 1)
    {
        $picturesModel = new PicturesModel();

        if (isset($_POST['delete']))
        {
            $picturesModel->deletePics($_POST['pictureId']);
        }

        $picture = $picturesModel->latestPictures($page - 1, 10);

        $countPicture = $picturesModel->CountPictures();
        $nbPages = ceil($countPicture / 10);


        if ($page < 1) {
            $page = 1;
        }



        $this->show('pictures/lastPictures', ['allPictures' => $picture, 'nbPages' => $nbPages, 'page' => $page]);

    }


    public function ajaxOperation()
    {
        $picturesModel = new PicturesModel();
        //$nbVotes = $picturesModel->latestPictures( 1 ,10);
        //print_r($nbVotes);

        if (isset($_POST['pictureId']) && ctype_digit($_POST['pictureId'])) {
            $voteModel = new VotesModel();
            $vote = $voteModel->search(['id_user' => $_SESSION['user']['id'], 'id_picture' => $_POST['pictureId']], 'AND');

            if (empty($vote)) {
                /*$id = $voteModel->insert([
                    'id_user' => 1,
                    'id_picture' => $_POST['pictureId']
                ]);*/
                $voteModel->insert($_SESSION['user']['id'], $_POST['pictureId']);
            }
            $nbVotes = $picturesModel->getNbVotes($_POST['pictureId']);
            $this->showJson(['success' => true, 'nbVote' => $nbVotes]);
        }
    }

        public function add()
        {
            $this->allowTo(['User','Admin','Moderator']);

            $error;
            $add = '';
            if (isset($_POST['submit'])) {
                if (isset($_POST['title']) && strlen($_POST['title']) > 10) {
                    $title = strip_tags($_POST['title']);
                    $add['title'] = $title;
                } else $error['title'] = 'Le titre est obligatoire et doit être supérieur à 10 charactères';

                if (isset($_POST['description']) && strlen($_POST['description']) > 10) {
                    $descr = strip_tags($_POST['description'], '<br><b><i><strong>');
                    $add['descr'] = $descr;
                } else $error['description'] = 'La description est obligatoire et doit être supérieur à 10 charactères';

                if (isset($_FILES['url'])) {
//                $_FILES['url']=$_POST['url'];


                } else {
                    $error['pictures'] = 'Veuillez selectionner une image';
                };

                if (isset($_POST['geo'])) {
                    $geo = strip_tags($_POST['geo']);
                    $add['local'] = $geo;
                } else $add['local'] = '';

                if (empty($error)) {
                    /*                debug
                    $this->show('pictures/add', ['add'=>$add]);*/


                    // Vérifier si le téléchargement du fichier n'a pas été interrompu
                    if ($_FILES['url']['error'] != UPLOAD_ERR_OK) {
                        // A ne pas faire en-dehors du DOM, bien sur.. En réalité on utilisera une variable intermédiaire
                        echo 'Erreur lors du téléchargement.';
                    } else {
                        // Objet FileInfo
                        $finfo = new \finfo(FILEINFO_MIME_TYPE);

                        // Récupération du Mime
                        $mimeType = $finfo->file($_FILES['url']['tmp_name']);

                        $extFoundInArray = array_search(
                            $mimeType, array(
                                'jpg' => 'image/jpeg',
                                'png' => 'image/png',
                                'gif' => 'image/gif',
                            )
                        );
                        if ($extFoundInArray === false) {

                            echo 'Le fichier n\'est pas une image<br>';

                        } else {
                            // Renommer nom du fichier
                            $shaFile = sha1_file($_FILES['url']['tmp_name']);
                            $nbFiles = 0;
                            $fileName = ''; // Le nom du fichier, sans le dossier
                            do {
                                $fileName = $shaFile . $nbFiles . '.' . $extFoundInArray;

                                $fullPath = __DIR__ . '/../../public/assets/uploads/' . $fileName;
                                $nbFiles++;
                            } while (file_exists($fullPath));


                            $moved = move_uploaded_file($_FILES['url']['tmp_name'], $fullPath);
                            if (!$moved) {
                                echo 'Erreur lors de l\'enregistrement';
                            } else {

                                $imageResize = new ImageManagerService();
                                $resizeName = __DIR__ . '/../../public/assets/uploads/' . 'resize-' . $shaFile . (--$nbFiles) . '.' . $extFoundInArray;
                                $imageResize->resize($fullPath, null, 300, 300, false, $resizeName, false);

                                $add['url_original'] = $fileName;
                                $add['url_resize'] = 'resize-' . $fileName;
                                $add['id_user'] = $_SESSION['user']['id'];

                                $picturesModel = new PicturesModel();
                                $picturesModel->insert($add);

                                $this->show('pictures/add');

                            }
                        }
                    }

                } else {
                    /*                debug
                    $this->show('pictures/add', ['error'=>$error]);*/
                    print_r($error);
                }
            } else $this->show('pictures/add');
        }

        public function geo()
        {
            $picturesModel = new PicturesModel();
            $array = $picturesModel->disctinct();
            $arrayGeo = '';
            foreach ($array as $key => $value) {

                $arrayGeo[] = $value['local'];

                /*print_r($arrayGeo);*/
            }

            $this->showJson($arrayGeo);
            /*print_r($arrayGeo);*/

        }
    }
