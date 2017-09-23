<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Session;
use Core\Router;

use Media\models\Media;
use Media\models\MediaCategory;
use Core\models\Site;

class MediasController extends CockpitController
{
    /**
     * @var Media\models\Media
     */
    private $media = null;

    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-picture-o fa-brown"></i> Gestion des médias';

    public function indexAction()
    {
        if ($this->site !== null) {
            $where = 'site_id = '.$this->site->id;
        } else {
            $where = '';
        }
        $medias = Media::findAll($where);

        $typeOptions = Media::getTypeOptions();

        $this->render(
            'media::medias::index',
            array(
                'medias' => $medias,
                'typeOptions' => $typeOptions,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Liste des médias'
            )
        );
    }

    public function newAction()
    {
        if ($this->media === null) {
            $this->media = new Media();
        }

        $typeOptions = Media::getTypeOptions();

        $mediacategoryOptions = MediaCategory::getOptions();

        $siteOptions = Site::getOptions();

        $this->render(
            'media::medias::edit',
            array(
                'id' => 0,
                'media' => $this->media,
                'typeOptions' => $typeOptions,
                'mediacategoryOptions' => $mediacategoryOptions,
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Ajouter un Nouveau média',
                'formAction' => Router::url('cockpit_media_medias_create')
            )
        );
    }

    public function editAction($id)
    {
        if ($this->media === null) {
            $this->media = Media::findById($id);
        }

        $typeOptions = Media::getTypeOptions();

        $mediacategoryOptions = MediaCategory::getOptions();

        $siteOptions = Site::getOptions();

        $this->render(
            'media::medias::edit',
            array(
                'id' => $id,
                'media' => $this->media,
                'typeOptions' => $typeOptions,
                'mediacategoryOptions' => $mediacategoryOptions,
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Modification du média n°'.$id,
                'formAction' => Router::url('cockpit_media_medias_update_'.$id)
            )
        );
    }

    public function createAction()
    {
        $this->media = new Media();

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->media->save($this->request->post)) {
            $this->media->generateImages();
            $this->addFlash('Media ajouté', 'success');
            $this->redirect('cockpit_media_medias');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->media = Media::findById($id);

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->media->save($this->request->post)) {
            $this->media->generateImages();
            $this->addFlash('Media modifié', 'success');
            $this->redirect('cockpit_media_medias');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $media = Media::findById($id);
        $media->delete();
        $this->addFlash('Media supprimé', 'success');
        $this->redirect('cockpit_media_medias');
    }

    public function generateimagesAction()
    {
        $medias = Media::findAll();
        foreach ($medias as $media) {
            $media->generateImages();
        }
        $this->addFlash('Images regénérées', 'success');
        $this->redirect('cockpit_media_medias');
    }
}
