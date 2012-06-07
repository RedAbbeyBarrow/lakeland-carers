<?php
class Application_Plugin_Auth_Acl extends Zend_Acl
{
	
	public function __construct()
    {
		$this->setResources();
        $this->setAccessRoles();
        $this->setAcccessRules();
    }
    
    private function setAccessRoles()
	{
		$this->addRole(new Zend_Acl_Role('guests'));
		$this->addRole(new Zend_Acl_Role('administrator'), 'guests');
		return $this;
	}

	private function setResources()
	{
		$this->add(new Zend_Acl_Resource('default'))
			 ->add(new Zend_Acl_Resource('default:index'), 'default')
			 ->add(new Zend_Acl_Resource('default:error'), 'default')
			 ->add(new Zend_Acl_Resource('default:about'), 'default')
			 ->add(new Zend_Acl_Resource('default:clients'), 'default')
			 ->add(new Zend_Acl_Resource('default:contact'), 'default')
			 ->add(new Zend_Acl_Resource('default:faq'), 'default')
			 ->add(new Zend_Acl_Resource('default:services'), 'default')
			 ->add(new Zend_Acl_Resource('default:news'), 'default');

		$this->add(new Zend_Acl_Resource('admin'))
			 ->add(new Zend_Acl_Resource('admin:index'), 'admin')
			 ->add(new Zend_Acl_Resource('admin:error'), 'admin')
			 ->add(new Zend_Acl_Resource('admin:security'), 'admin')
			 ->add(new Zend_Acl_Resource('admin:pages'), 'admin')
			 ->add(new Zend_Acl_Resource('admin:testimonials'), 'admin')
			 ->add(new Zend_Acl_Resource('admin:news'), 'admin');

		return $this;
    }
       
    private function setAcccessRules()
    {
    	/* Guests */
    	$this->allow('guests', 'default:index', array('index',));
    	$this->allow('guests', 'default:error', array('error','noaccess',));
    	$this->allow('guests', 'default:about', array('index','theteam'));
    	$this->allow('guests', 'default:clients', array('index','testimonials',));
    	$this->allow('guests', 'default:contact', array('index',));
    	$this->allow('guests', 'default:faq', array('index','careers',));
    	$this->allow('guests', 'default:services', array('index','homecare','physicaldisabilities','liveincare','learningdifficulties','endoflife','dementiacare',));
		$this->allow('guests', 'default:news', array('index','view',));
		$this->allow('guests', 'admin:security', array('login',));
		
		/* Admins */
		$this->deny('administrator', 'admin:security', array('index', 'login',));
		$this->allow('administrator', 'admin:security', array('logout',));
		$this->allow('administrator', 'admin:index', array('index',));
		$this->allow('administrator', 'admin:error', array('error','noaccess'));
		$this->allow('administrator', 'admin:pages', array('index','updateseo','updatecontent',));
		$this->allow('administrator', 'admin:testimonials', array('index','add','update','delete',));
		$this->allow('administrator', 'admin:news', array('index','add','update','delete',));
		
		return $this;
    }
}		
?>
