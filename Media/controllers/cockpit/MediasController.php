<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Session;
use Core\Router;

use Media\models\Media;
use Media\models\MediaCategory;

class MediasController extends CockpitController
{
    /*
     * @var Media\models\Media
     */
    public $media = null;

    public function indexAction()
    {
        $medias = Media::findAll();

        $typeOptions = Media::getTypeOptions();

        $this->render('media::medias::index', array(
            'medias' => $medias,
            'typeOptions' => $typeOptions,
            'titlePage'         => '<i class="fa fa-picture-o fa-brown"></i> Gestion des médias',
            'titleBox'          => 'Liste des médias'
        ));
    }

    public function newAction()
    {
        if ($this->media === null) {
            $this->media = new Media();
        }

        $typeOptions = Media::getTypeOptions();

        $mediacategoryOptions = MediaCategory::getOptions();

        $this->render('media::medias::edit', array(
            'id' => 0,
            'media' => $this->media,
            'typeOptions' => $typeOptions,
            'mediacategoryOptions' => $mediacategoryOptions,
            'titlePage'     => '<i class="fa fa-picture-o fa-brown"></i> Gestion des médias',
            'titleBox'      => 'Ajouter un Nouveau média',
            'formAction' => Router::url('cockpit_media_medias_create')
        ));
    }

    public function editAction($id)
    {
        if ($this->media === null) {
            $this->media = Media::findById($id);
        }

        $typeOptions = Media::getTypeOptions();

        $mediacategoryOptions = MediaCategory::getOptions();

        $this->render('media::medias::edit', array(
            'id'                    => $id,
            'media'                 => $this->media,
            'typeOptions'           => $typeOptions,
            'mediacategoryOptions'  => $mediacategoryOptions,
            'titlePage'             => '<i class="fa fa-picture-o fa-brown"></i> Gestion des médias',
            'titleBox'              => 'Modification du média n°'.$id,
            'formAction'            => Router::url('cockpit_media_medias_update_'.$id)
        ));
    }

    public function createAction()
    {
        $this->media = new Media();

        if ($this->media->save($this->request->post)) {
            $this->media->generateImages();
            Session::addFlash('Media ajouté', 'success');
            $this->redirect('cockpit_media_medias');
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->media = Media::findById($id);

        if ($this->media->save($this->request->post)) {
            $this->media->generateImages();
            Session::addFlash('Media modifié', 'success');
            $this->redirect('cockpit_media_medias');
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $media = Media::findById($id);
        $media->delete();
        Session::addFlash('Media supprimé', 'success');
        $this->redirect('cockpit_media_medias');
    }

    public function generateimagesAction()
    {
        $medias = Media::findAll();
        foreach ($medias as $media) {
            $media->generateImages();
        }
        Session::addFlash('Images regénérées', 'success');
        $this->redirect('cockpit_media_medias');
    }
}
