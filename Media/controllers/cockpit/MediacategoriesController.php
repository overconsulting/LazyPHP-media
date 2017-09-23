<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Session;
use Core\Router;

use Media\models\MediaCategory;
use Core\models\Site;

class MediacategoriesController extends CockpitController
{
    /**
     * @var Media\models\MediaCategory
     */
    private $mediaCategory = null;

    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-picture-o fa-brown"></i> Gestion des catégories de média';

    public function indexAction()
    {
        if ($this->site !== null) {
            $where = 'site_id = '.$this->site->id;
        } else {
            $where = '';
        }
        $mediaCategories = MediaCategory::findAll($where);

        $this->render(
            'media::mediacategories::index',
            array(
                'mediaCategories' => $mediaCategories,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Liste des catégories de media'
            )
        );
    }

    public function newAction()
    {
        if ($this->mediaCategory === null) {
            $this->mediaCategory = new MediaCategory();
        }

        $siteOptions = Site::getOptions();

        $this->render(
            'media::mediacategories::edit',
            array(
                'mediaCategory' => $this->mediaCategory,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Nouvelle catégorie de media',
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null,
                'formAction' => Router::url('cockpit_media_mediacategories_create')
            )
        );
    }

    public function editAction($id)
    {
        if ($this->mediaCategory === null) {
            $this->mediaCategory = MediaCategory::findById($id);
        }

        $siteOptions = Site::getOptions();

        $this->render('media::mediacategories::edit', array(
            'mediaCategory' => $this->mediaCategory,
            'pageTitle' => $this->pageTitle,
            'boxTitle' => 'Modification catégorie de media n°'.$id,
            'siteOptions' => $siteOptions,
            'selectSite' => $this->current_user->site_id === null,
            'formAction' => Router::url('cockpit_media_mediacategories_update_'.$id)
        ));
    }

    public function createAction()
    {
        $this->mediaCategory = new MediaCategory();

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->mediaCategory->save($this->request->post)) {
            $this->addFlash('Catégorie de media ajoutée', 'success');
            $this->redirect('cockpit_media_mediacategories');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->mediaCategory = MediaCategory::findById($id);

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->mediaCategory->save($this->request->post)) {
            $this->addFlash('Catégorie de media modifiée', 'success');
            $this->redirect('cockpit_media_mediacategories');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $mediaCategory = MediaCategory::findById($id);
        $mediaCategory->delete();
        $this->addFlash('Catégorie de media supprimée', 'success');
        $this->redirect('cockpit_media_mediacategories');
    }
}
