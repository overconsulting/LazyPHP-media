<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Session;
use Core\Router;

use Media\models\File;
use Core\models\Site;

class FilesController extends CockpitController
{
    /**
     * @var Media\models\File
     */
    private $file = null;

    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-picture-o fa-brown"></i> Gestion des Fichiers';

    public function indexAction()
    {
        if ($this->site !== null) {
            $where = 'site_id = '.$this->site->id;
        } else {
            $where = '';
        }
        $files = File::findAll($where);

        $this->render(
            'media::files::index',
            array(
                'files' => $files,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Liste des fichiers'
            )
        );
    }

    public function newAction()
    {
        if ($this->file === null) {
            $this->file = new File();
        }

        $siteOptions = Site::getOptions();

        $this->render(
            'media::files::edit',
            array(
                'id' => 0,
                'media' => $this->file,
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Ajouter un nouveau fichier',
                'formAction' => Router::url('cockpit_media_files_create')
            )
        );
    }

    public function createAction()
    {
        $this->file = new File();

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if (isset($this->request->post['name']) && $this->request->post['name'] != "") {
            $this->file->site_id = $this->request->post['site_id'];
            $this->file->name = $this->request->post['name'];
        }
        
        $this->file->generate();
        if ($this->file->save($this->request->post)) {
            $this->addFlash('Fichier ajouté', 'success');
            $this->redirect('cockpit_media_files');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }
}