<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Session;
use Core\Router;

use Media\models\MediaCategory;

class MediacategoriesController extends CockpitController
{
    /*
     * @var Media\models\MediaCategory
     */
    public $mediaCategory = null;

    public function indexAction()
    {
        $mediaCategories = MediaCategory::findAll();

        $this->render('media::mediacategories::index', array(
            'mediaCategories' => $mediaCategories,
            'pageTitle' => '<i class="fa fa-picture-o fa-brown"></i> Gestion des catégories de média',
            'boxTitle' => 'Liste des catégories de media'
        ));
    }

    public function newAction()
    {
        if ($this->mediaCategory === null) {
            $this->mediaCategory = new MediaCategory();
        }

        $this->render('media::mediacategories::edit', array(
            'mediaCategory' => $this->mediaCategory,
            'pageTitle' => '<i class="fa fa-picture-o fa-brown"></i> Gestion des catégories de média',
            'boxTitle' => 'Nouvelle catégorie de media',
            'formAction' => Router::url('cockpit_media_mediacategories_create')
        ));
    }

    public function editAction($id)
    {
        if ($this->mediaCategory === null) {
            $this->mediaCategory = MediaCategory::findById($id);
        }

        $this->render('media::mediacategories::edit', array(
            'mediaCategory' => $this->mediaCategory,
            'pageTitle' => '<i class="fa fa-picture-o fa-brown"></i> Gestion des catégories de média',
            'boxTitle' => 'Modification catégorie de media n°'.$id,
            'formAction' => Router::url('cockpit_media_mediacategories_update_'.$id)
        ));
    }

    public function createAction()
    {
        $this->mediaCategory = new MediaCategory();

        if ($this->mediaCategory->save($this->request->post)) {
            Session::addFlash('Catégorie de media ajoutée', 'success');
            $this->redirect('cockpit_media_mediacategories');
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->mediaCategory = MediaCategory::findById($id);

        if ($this->mediaCategory->save($this->request->post)) {
            Session::addFlash('Catégorie de media modifiée', 'success');
            $this->redirect('cockpit_media_mediacategories');
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $mediaCategory = MediaCategory::findById($id);
        $mediaCategory->delete();
        Session::addFlash('Catégorie de media supprimée', 'success');
        $this->redirect('cockpit_media_mediacategories');
    }
}
