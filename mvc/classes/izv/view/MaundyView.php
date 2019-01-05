<?php

namespace izv\view;

use izv\model\Model;

class MaundyView extends View {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('template_folder', 'templates/maundy');
        $this->getModel()->set('template_file', '_main.html');
    }

    function render($accion) {
        $data = $this->getModel()->getViewData();
        $loader = new \Twig_Loader_Filesystem($data['template_folder']);
        $twig = new \Twig_Environment($loader);
        return $twig->render($data['template_file'], $data);
    }
}