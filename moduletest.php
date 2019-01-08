<?php
if(!defined('_PS_VERSION_'))
exit;

class moduletest extends Module{
   public function __construct()
    {
        $this->name = 'moduletest'; //nombre del módulo el mismo que la carpeta y la clase.
        $this->tab = 'front_office_features'; // pestaña en la que se encuentra en el backoffice.
        $this->version = '1.0.0'; //versión del módulo
        $this->author ='Ing. Alejandro Villegas: https://koshucasweb.com.ve'; // autor del módulo
        $this->need_instance = 0; //si no necesita cargar la clase en la página módulos,1 si fuese necesario.
        $this->ps_versions_compliancy = array('min' => '1.7.x.x', 'max' => _PS_VERSION_); //las versiones con las que el módulo es compatible.
        $this->bootstrap = true; //si usa bootstrap plantilla responsive.

        parent::__construct(); //llamada al constructor padre.

        $this->displayName = $this->l('Mi primer módulo'); // Nombre del módulo
        $this->description = $this->l('Módulo de prueba.'); //Descripción del módulo
        $this->confirmUninstall = $this->l('¿Estás seguro de que quieres desinstalar el módulo?'); //mensaje de alerta al desinstalar el módulo.

        $this->templateFile = 'module:moduletest/views/templates/hook/moduletest.tpl';
    }

    public function install()
    {
        return (parent::install()
        && $this->registerHook('displayHeader') // Registramos el hook dentro de las cabeceras.
        && $this->registerHook('DisplayHome')
		&& $this->registerHook('DisplayFooterAfter')
        );

        $this->emptyTemplatesCache();

        return (bool) $return;
    }

    public function hookDisplayHeader($params)
    {
        $this->context->controller->registerStylesheet('modules-moduletest', 'modules/'.$this->name.'/views/css/moduletest.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules-moduletest', 'modules/'.$this->name.'/views/js/moduletest.js',[ 'position' => 'bottom','priority' => 150]);
    }

    public function uninstall()
    {
    $this->_clearCache('*');

    if(!parent::uninstall() || !$this->unregisterHook('displayHome'))
        return false;

    return true;
    }

    public function hookDisplayHome()
    {
        return $this->display(__FILE__, 'views/templates/hook/moduletest.tpl');
    }

	public function hookDisplayFooterAfter()
    {
        return $this->display(__FILE__, 'views/templates/hook/moduletest.tpl');
    }

    public function getContent()
    {
        return $this->display(__FILE__, 'getContent.tpl');
    }

}

?>