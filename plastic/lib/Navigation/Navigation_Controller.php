<?php
class Navigation_Controller extends Controller{

	public function __construct($GET, $POST, $FILES) {
		parent::__construct($GET, $POST, $FILES);
		$this->ui = new Navigation_Ui($this);
	}
	
	public function controlActions() {
		$this->login = Customer_Login::getInstance();
		$this->metaImage = BASE_URL.'visual/img/cover.png';
		switch ($this->action) {
			default:
			case 'intro':
				$this->layoutPage = 'intro';
				$banner = Banner::readFirst();
				$this->content = '<div class="bannerIntro">
										<a class="anchor" name="intro"></a>
										<div class="bannerIntroIns">
											'.$banner->showUi('Public').'
										</div>
									</div>';
				return $this->ui->render();
			break;
			case 'servicios':
				$page = Page::code($this->action);
				$this->titlePage = $page->getBasicInfo();
				$this->metaDescription = $page->get('metaDescription');
				$this->metaKeywords = $page->get('metaKeywords');
				$this->content = $page->showUi('Complete');
				return $this->ui->render();
			break;
			case 'equipo':
				$page = Page::code($this->action);
				$this->titlePage = $page->getBasicInfo();
				$this->metaDescription = $page->get('metaDescription');
				$this->metaKeywords = $page->get('metaKeywords');
				$this->content = $page->showUi('Complete');
				return $this->ui->render();
			break;
			case 'portafolio':
				$page = Page::code($this->action);
				$this->titlePage = $page->getBasicInfo();
				$this->metaDescription = $page->get('metaDescription');
				$this->metaKeywords = $page->get('metaKeywords');
				$this->content = $page->showUi('Complete').'
								'.Site_Ui::showList();
				return $this->ui->render();
			break;
			case 'contacto':
				$page = Page::code('contacto');
				$this->titlePage = $page->getBasicInfo();
				$this->metaDescription = $page->get('metaDescription');
				$this->metaKeywords = $page->get('metaKeywords');
				$contactForm = new Contact_Form();
				$this->content = '<div class="contactPublic">
									<div class="contactLeft">
										'.$page->showUi('Complete').'
									</div>
									<div class="contactRight">
										'.$contactForm->createPublic().'
									</div>
								</div>';
				return $this->ui->render();
			break;
			case 'aplicaciones':
				$this->layoutPage = 'intro';
				$link = (!$this->login->isConnected()) ? '<a class="btnBig" href="'.url('cuenta/crear-cuenta').'">'.__('createAccount').'</a>' : '<a class="btnBig" href="'.url('cuenta/mi-cuenta').'">'.__('myAccount').'</a>';
				$this->content = '<div class="pages">
									<div class="page pageIntro">
										<div class="pageIns">
											<div class="pageIntroLeft">
												<div class="logo">'.$this->getTitle().'</div>
											</div>
											<div class="pageIntroRight">
												'.Page::show('home').'
												<p>'.$link.'</p>
											</div>
										</div>
									</div>
									<div class="page pageApplications">
										<div class="pageIns">
											'.App_Ui::apps().'
										</div>
									</div>
								</div>';
				return $this->ui->render();
			break;
			case 'como-instalar':
			case 'costo':
				$this->layoutPage = 'intro';
				$page = Page::code($this->action);
				$this->titlePage = $page->getBasicInfo();
				$this->metaDescription = $page->get('metaDescription');
				$this->content = '<div class="pageSimple pageSimple-'.$page->get('code').'">
									<div class="pageTitle">
										<h3><span>'.$page->getBasicInfo().'</span></h3>
									</div>
									<div class="pageIns">
										'.$page->showUi('Complete').'
									</div>
								</div>';
				return $this->ui->render();
			break;
			case 'aplicaciones':
				$info = explode('_', $this->id);
				$item = App::read($info[0]);
				$this->login = Customer_Login::getInstance();
				$this->layoutPage = ($this->login->isConnected()) ? 'account' : '';
				if ($item->id()!='') {
					$this->titlePage = $item->getBasicInfo();
					$this->metaDescription = $item->get('description');
					$this->metaUrl = $item->url();
					$this->content = $item->showUi('Complete');
				} else {
					$this->titlePage = __('apps');
					$this->metaUrl = url($this->action);
					$this->content = App_Ui::apps();
				}
				return $this->ui->render();
			break;
			case 'instalar-aplicacion':
				$customer = Customer::loggedCustomer();
				$app = App::read($this->id);
				$linkNext = url('');
				if ($app->id()!='' && isset($this->params['tabs_added']) && count($this->params['tabs_added'])>0) {
					foreach ($this->params['tabs_added'] as $pageId=>$value) {
						if ($value=='1') {
							$pageName = '';
							try {
								$fb = Navigation_Controller::getFacebookObject();
								$accessToken = $fb->getApp()->getAccessToken()->getValue();
								$page = $fb->get('/'.$pageId, $accessToken);
								$pageInfo = $page->getDecodedBody();
								$pageName = $pageInfo['name'];
							} catch(Exception $error){}
							// Create or load the Fan Page
							$customerPage = CustomerPage::readFirst(array('where'=>'idCustomer="'.$customer->id().'"
																					AND pageId="'.$pageId.'"'));
							if ($customerPage->id()=='') {
								$customerPage = new CustomerPage();
								$customerPage->insert(array('idCustomer'=>$customer->id(),
															'pageId'=>$pageId,
															'name'=>$pageName,
															'active'=>1));
								$linkFacebook = 'http://www.facebook.com/'.$pageId;
								$htmlMail = '<p>Hay un nueva pagina del cliente <strong>'.$customer->getBasicInfo().'</strong></p>
											<p>Acaba de instalar una aplicacion en <a href="'.$linkFacebook.'" target="_blank">'.$linkFacebook.'</a></p>';
								HtmlMail::send('info@plasticwebs.com', 'notification', array('CONTENT'=>$htmlMail));
							}
							// Create or load the App in the Fan Page
							$objectName = $app->get('objectName');
							$appInstall = new $objectName();
							$appInstall->readFirstObject(array('where'=>'pageId="'.$customerPage->get('pageId').'"'));
							if ($appInstall->id()=='') {
								$appInstall->insert(array('pageId'=>$customerPage->get('pageId')));
							}
							$linkNext = 'http://www.facebook.com/'.$customerPage->get('pageId');
						}
					}
				}
				header('Location: '.$linkNext);
				exit();
			break;
			case 'aplicacion-iframe':
			case 'aplicacion-movil':
				$this->layoutPage = 'clean';
				$app = App::readFirst(array('where'=>'code="'.$this->id.'"'));
				if ($app->id()!='') {
					$this->content = '';
					if ($this->action == 'aplicacion-movil') {
						//Mobile app
						$objectName = $app->get('objectName');
						$appInstall = new $objectName();
						$appInstall = $appInstall->readFirstObject(array('where'=>'pageId="'.$this->extraId.'"'));

					} else {
						//Get Facebook information and find the app installed
						$fb = Navigation_Controller::getFacebookObject($app->get('appId'), $app->get('appSecret'));
						$canvasHelper = $fb->getCanvasHelper();
						$signedRequest = $canvasHelper->getSignedRequest();
						if (is_object($signedRequest)) {
							$page = $signedRequest->get('page');
							$pageId = (isset($page['id'])) ? $page['id'] : '';
							$user = $signedRequest->get('user');
							$objectName = $app->get('objectName');
							$appInstall = new $objectName();
							$appInstall = $appInstall->readFirstObject(array('where'=>'pageId="'.$pageId.'"'));
						}
					}
					//Check if the customer is logged
					$this->login = Customer_Login::getInstance();
					if ($this->login->isConnected()) {
						$customerPage = CustomerPage::readFirst(array('where'=>'idCustomer="'.$this->login->id().'" AND pageId="'.$pageId.'"'));
						$this->content = ($customerPage->id()!='') ? '<div class="contentAdmin">
																		<div class="contentAdminIns">
																			<a href="'.url('aplicacion-configuracion/'.$app->get('code').'/'.md5('plasticwebs'.$customerPage->id())).'" target="_blank">'.__('goToAdmin').'</a>
																		</div>
																	</div>' : '';

					}
					// Show the app
					switch($app->get('code')) {
						case 'contacto':
							$this->header = '<script type="text/javascript" src="'.BASE_URL.'libjs/jquery/jquery-1.10.2.min.js"></script>
											<script type="text/javascript" src="'.BASE_URL.'libjs/public.js?v='.md5(rand()).'"></script>';
						break;
						case 'pdf':
							$this->header = '<script type="text/javascript">
												var WORKER_SRC = \''.BASE_URL.'helpers/pdfjs/build/pdf.worker.js\';
												var CMAPURL = \''.BASE_URL.'helpers/pdfjs/cmaps\';
											</script>
											<link href="'.BASE_URL.'helpers/pdfjs/viewer.css" rel="stylesheet" type="text/css" />
											<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/compatibility.js"></script>
											<link rel="resource" type="application/l10n" href="locale/locale.properties"/>
											<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/l10n.js"></script>
											<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/build/pdf.js"></script>
											<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/viewer.js"></script>';
						break;
					}
					$this->content .= ($appInstall->id()!='') ? $appInstall->showUi('Frame') : '<div class="message">'.__('appNotConfigured').'</div>';
					return $this->ui->render();
				}
				$this->content = '<div class="message">'.__('appNotConfigured').'</div>';
				return $this->ui->render();
			break;
			case 'aplicacion-configuracion':
				$customer = Customer::loggedCustomer();
				$customerPage = CustomerPage::readFirst(array('where'=>'MD5(CONCAT("plasticwebs",idCustomerPage))="'.$this->extraId.'" AND idCustomer="'.$customer->id().'"'));
				if ($customerPage->id()!='') {
					$app = App::readFirst(array('where'=>'code="'.$this->id.'"'));
					if ($app->id()!='') {
						$this->layoutPage = 'account';
						$this->titlePage = $app->getBasicInfo();
						$objectName = $app->get('objectName');
						$appInstall = new $objectName();
						$appInstall = $appInstall->readFirstObject(array('where'=>'pageId="'.$customerPage->get('pageId').'"'));
						if ($appInstall->id()!='') {
							$objectNameForm = $objectName.'_Form';
							$appInstallForm = new $objectNameForm($appInstall->valuesArray());
							if (count($this->values)>0) {
								$appInstallForm = new $objectNameForm($this->values);
								$errors = $appInstallForm->isValid();
								if (count($errors)>0) {
									$appInstallForm = new $objectNameForm($this->values, $errors);
								} else {
									$this->message = __('changesSaved');
									$this->values['id'.$objectName] = $appInstall->id();
									$appInstall->modify($this->values);
									$appInstallForm = new $objectNameForm($appInstall->valuesArray());
								}
							}
							$this->content = $customerPage->showUi('Info', array('app'=>$app)).'
											'.$appInstallForm->createHtml();
							return $this->ui->render();
						}
					}
				}
				header('Location: '.url(''));
				exit();
			break;
			case 'modal':
				switch ($this->id) {
					case 'contacto':
						$pageId = (isset($this->values['code'])) ? $this->values['code'] : '';
						$appContactForm = AppContactForm::readFirst(array('where'=>'pageId=:pageId'), array('pageId'=>$pageId));
						if (count($this->values)>0 && $appContactForm->id()!='') {
							$formPost = new AppContactFormMessage_Form($this->values);
							$errors = $formPost->isValid();
							if (count($errors) > 0) {
								$formPost = new AppContactFormMessage_Form($this->values, $errors);
								return $formPost->createPublic($appContactForm);
							} else {
								$appContactFormMessage = new AppContactFormMessage();
								$appContactFormMessage->insert($this->values);
								HtmlMail::send($appContactForm->get('emailContact'), 'notification-facebook', array('CONTENT'=>$appContactFormMessage->showUi('Mail')));
								return '<div class="message">'.$appContactForm->get('messageThanks').'</div>';
							}
						}
						return '<div class="message">'.__('thanksMessage').'</div>';
					break;
				}
			break;
			/**
			* Customer
			**/
			case 'cuenta':
				$customerController = new Customer_Controller($this->params, $this->values, $this->files);
				return $customerController->controlActions();
			break;
			case 'pagos':
				$customerPaymentController = new CustomerPayment_Controller($this->params, $this->values, $this->files);
				return $customerPaymentController->controlActions();
			break;
		}
	}

	static public function getFacebookObject($appId=FACEBOOK_LOGIN_APP_ID, $appSecret=FACEBOOK_LOGIN_APP_SECRET) {
        require_once BASE_FILE.'helpers/facebook/src/Facebook/autoload.php';
        return new Facebook\Facebook(array(
                    'app_id' => $appId,
                    'app_secret' => $appSecret,
                    'default_graph_version' => 'v2.8',
                ));
    }

}
?>