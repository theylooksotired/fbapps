<?php
class Navigation_Controller extends Controller{

	public function __construct($GET, $POST, $FILES) {
		parent::__construct($GET, $POST, $FILES);
		$this->ui = new Navigation_Ui($this);
	}
	
	public function controlActions() {
		switch ($this->action) {
			default:
			case 'error':
				header("HTTP/1.1 301 Moved Permanently"); 
				header('Location: http://www.plasticwebs.com');
				exit();
			break;
			case 'intro':
				$this->layoutPage = 'intro';
				$this->content = $this->facebookActions().'
								<div class="pages">
									<div class="page pageIntro">
										<div class="pageIns">
											<div class="pageIntroLeft">
												<div class="logo">'.$this->getTitle().'</div>
											</div>
											<div class="pageIntroRight">
												'.Page::show('home').'
											</div>
										</div>
									</div>
									<div class="page pageApplications">
										<div class="pageIns">
											'.App_Ui::intro().'
										</div>
									</div>
								</div>';
				return $this->ui->render();
			break;
			case 'como-instalar':
			case 'costo':
				$this->layoutPage = 'intro';
				$page = ($this->action=='costo') ? 'cost' : 'howToUse';
				$this->content = '<div class="page pageCost">
									<a class="anchor" name="cost"></a>
									<div class="pageTitle">
										<h3><span>'.__('cost').'</span></h3>
									</div>
									<div class="pageIns">
										'.Page::show($page).'
									</div>
								</div>';
				return $this->ui->render();
			break;
			case 'aplicaciones':
				$info = explode('_', $this->id);
				$item = App::read($info[0]);
				if ($item->id()!='') {
					$this->titlePage = $item->getBasicInfo();
					$this->metaDescription = $item->get('description');
					$this->metaUrl = $item->url();
					$this->content = $this->facebookActions();
					$this->content .= $item->showUi('Complete');
				} else {
					$this->titlePage = __('apps');
					$this->metaUrl = url($this->action);
					$this->content = App_Ui::intro();
				}
				return $this->ui->render();
			break;
			/**
			*
			* Customer
			*
			**/
			case 'conectarse':
			case 'olvide-password':
			case 'crear-cuenta':
			case 'mi-cuenta':
			case 'salir':
				$customerController = new Customer_Controller($this->params, $this->values, $this->files);
				return $customerController->controlActions();
			break;
			/**
			*
			* Contact
			*
			**/
			case 'contact':
				$this->getClient('1245287298873865', '9ca16729f652e30763e5872fb2579a27', 'contact-admin', 'goToAdminContact');
				if (count($this->values) > 0 && isset($this->values['message'])) {
					$form = new Contact_Form($this->values);
					$errors = $form->isValid();
					if (count($errors) > 0) {
						$form = new Contact_Form($this->values, $errors);
						$formHtml = $form->createPublic($this->client);
					} else {					
						$contact = new Contact();
						$contact->insert($this->values);
						HtmlMail::send($this->client->get('emailContact'), 'fbContact', array('CONTENT'=>$contact->showUi('Mail')));
						$formHtml = '<div class="message">'.$client->get('messageThanks').'</div>';
					}
				} else {					
					$form = new Contact_Form();
					$formHtml = $form->createPublic($this->client);
				}
				$contentAdmin = (isset($this->contentAdmin)) ? $this->contentAdmin : '';
				$this->content = $contentAdmin.'
								'.$this->client->showUi('Contact', array('formHtml'=>$formHtml));
				return $this->ui->render();
			break;
			case 'contact-admin':
				$this->titlePage = __('configApplication');
				$client = Client::readSecret($this->id);
				if ($client->id()!='') {
					$form = Client_Form::newObject($client);
					if (count($this->values)>0) {
						$this->values['idClient'] = $client->id();
						$this->values['pageId'] = $client->get('pageId');
						$form = new Client_Form($this->values);
						$errors = $form->isValid();
						if (count($errors) > 0) {
							$form = new Client_Form($this->values, $errors);
						} else {					
							$client->modify($this->values);
							$this->message = __('changesSaved');
							$form = Client_Form::newObject($client);
						}
					}
					$formHtml = $form->createContact();
					$this->linkMobile = url('contact/'.$client->get('pageId'));
					$this->content = $formHtml;
				} else {
					$this->messageError = __('noAppConfigured');
				}
				return $this->ui->render();
			break;
			/**
			*
			* HTML Content
			*
			**/
			case 'html':
				$this->getClient('384427195223972', '5bf80b165879647d2db0f8f7528612b2', 'html-admin', 'goToAdminHtml');
				$htmlContent = HtmlContent::readFirst(array('where'=>'idClient="'.$this->client->id().'"'));
				$contentAdmin = (isset($this->contentAdmin)) ? $this->contentAdmin : '';
				if ($htmlContent->id()!='') {
					$this->content = $contentAdmin.'
									'.$htmlContent->showUi('Section');
					return $this->ui->render();
				} else {
					return $contentAdmin.'
							<div class="message">'.__('appNotConfigured').'</div>';
				}
			break;
			case 'html-admin':
				$this->header = '<script type="text/javascript" src="'.BASE_URL.'helpers/ckeditor/ckeditor.js"></script>';
				$this->titlePage = __('configApplication');
				$client = Client::readSecret($this->id);
				if ($client->id()!='') {
					$htmlContent = HtmlContent::readFirst(array('where'=>'idClient="'.$client->id().'"'));
					if ($htmlContent->id()=='') {
						$htmlContent = new HtmlContent();
						$htmlContent->insert(array('idClient'=>$client->id()));
					}
					$form = HtmlContent_Form::newObject($htmlContent);
					if (count($this->values)>0) {
						$this->values['idClient'] = $client->id();
						$this->values['pageId'] = $client->get('pageId');
						$form = new HtmlContent_Form($this->values);
						$errors = $form->isValid();
						if (count($errors) > 0) {
							$form = new HtmlContent_Form($this->values, $errors);
						} else {
							$htmlContent->modify($this->values);
							$this->message = __('changesSaved');
							$form = HtmlContent_Form::newObject($htmlContent);
						}
					}
					$this->linkMobile = url('html/'.$client->get('pageId'));
					$formHtml = $form->createHtml();
					$this->content = $formHtml;
				} else {
					$this->messageError = __('noAppConfigured');
				}
				return $this->ui->render();
			break;
			/**
			*
			* Poster
			*
			**/
			case 'poster':
				$this->getClient('1903121263252747', 'ee9bd08f464c99e337ef3d86ec9daa7b', 'poster-admin', 'goToAdminPoster');
				$poster = Poster::readFirst(array('where'=>'idClient="'.$this->client->id().'"'));
				$contentAdmin = (isset($this->contentAdmin)) ? $this->contentAdmin : '';
				if ($poster->id()!='') {
					$this->content = $contentAdmin.'
									'.$poster->showUi('Section');
					return $this->ui->render();
				} else {
					return $contentAdmin.'
							<div class="message">'.__('appNotConfigured').'</div>';
				}
			break;
			case 'poster-admin':
				$this->titlePage = __('configApplication');
				$client = Client::readSecret($this->id);
				if ($client->id()!='') {
					$poster = Poster::readFirst(array('where'=>'idClient="'.$client->id().'"'));
					if ($poster->id()=='') {
						$poster = new Poster();
						$poster->insert(array('idClient'=>$client->id()));
					}
					$form = Poster_Form::newObject($poster);
					if (count($this->values)>0) {
						$this->values['idClient'] = $client->id();
						$this->values['pageId'] = $client->get('pageId');
						$form = new Poster_Form($this->values);
						$errors = $form->isValid();
						if (count($errors) > 0) {
							$form = new Poster_Form($this->values, $errors);
						} else {
							$poster->modify($this->values);
							$this->message = __('changesSaved');
							$form = Poster_Form::newObject($poster);
						}
					}
					$this->linkMobile = url('poster/'.$client->get('pageId'));
					$formHtml = $form->createHtml();
					$this->content = $formHtml;
				} else {
					$this->messageError = __('noAppConfigured');
				}
				return $this->ui->render();
			break;
			/**
			*
			* Pdf
			*
			**/
			case 'pdf':
				$this->mode = 'pdf';
				$this->getClient('1202412853209906', '0beb5612756cf8cee4dcbf0524615914', 'pdf-admin', 'goToAdminPdf');
				$pdf = Pdf::readFirst(array('where'=>'idClient="'.$this->client->id().'"'));
				$contentAdmin = (isset($this->contentAdmin)) ? $this->contentAdmin : '';
				if ($pdf->id()!='') {
					$this->header = '
									<script type="text/javascript">
										var WORKER_SRC = \''.BASE_URL.'helpers/pdfjs/build/pdf.worker.js\';
										var CMAPURL = \''.BASE_URL.'helpers/pdfjs/cmaps\';
									</script>
									<link href="'.BASE_URL.'helpers/pdfjs/viewer.css" rel="stylesheet" type="text/css" />
									<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/compatibility.js"></script>
									<link rel="resource" type="application/l10n" href="locale/locale.properties">
									<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/l10n.js"></script>
									<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/build/pdf.js"></script>
									<script type="text/javascript" src="'.BASE_URL.'helpers/pdfjs/viewer.js"></script>

									';
					$this->content = $pdf->showUi('Section');
					return $contentAdmin.'
							'.$this->ui->render();
				} else {
					return $contentAdmin.'
							<div class="message">'.__('appNotConfigured').'</div>';
				}
			break;
			case 'pdf-admin':
				$this->titlePage = __('configApplication');
				$client = Client::readSecret($this->id);
				if ($client->id()!='') {
					$pdf = Pdf::readFirst(array('where'=>'idClient="'.$client->id().'"'));
					if ($pdf->id()=='') {
						$pdf = new Pdf();
						$pdf->insert(array('idClient'=>$client->id()));
					}
					$form = Pdf_Form::newObject($pdf);
					if (count($this->values)>0) {
						$this->values['idClient'] = $client->id();
						$this->values['pageId'] = $client->get('pageId');
						$form = new Pdf_Form($this->values);
						$errors = $form->isValid();
						if (count($errors) > 0) {
							$form = new Pdf_Form($this->values, $errors);
						} else {
							$pdf->modify($this->values);
							$this->message = __('changesSaved');
							$form = Pdf_Form::newObject($pdf);
						}
					}
					$this->linkMobile = url('pdf/'.$client->get('pageId'));
					$formHtml = $form->createHtml();
					$this->content = $formHtml;
				} else {
					$this->messageError = __('noAppConfigured');
				}
				return $this->ui->render();
			break;
			/**
			*
			* Videos
			*
			**/
			case 'videos':
				$this->getClient('412294832444296', '451899ec758ef10666024a9d0e552934', 'videos-admin', 'goToAdminVideos');
				$videos = Videos::readFirst(array('where'=>'idClient="'.$this->client->id().'"'));
				$contentAdmin = (isset($this->contentAdmin)) ? $this->contentAdmin : '';
				if ($videos->id()!='') {
					$this->content = $contentAdmin.'
									'.$videos->showUi('Section');
					return $this->ui->render();
				} else {
					return $contentAdmin.'
							<div class="message">'.__('appNotConfigured').'</div>';
				}
			break;
			case 'videos-admin':
				$this->titlePage = __('configApplication');
				$client = Client::readSecret($this->id);
				if ($client->id()!='') {
					$videos = Videos::readFirst(array('where'=>'idClient="'.$client->id().'"'));
					if ($videos->id()=='') {
						$videos = new Videos();
						$videos->insert(array('idClient'=>$client->id()));
					}
					$form = Videos_Form::newObject($videos);
					if (count($this->values)>0) {
						$this->values['idClient'] = $client->id();
						$this->values['pageId'] = $client->get('pageId');
						$form = new Videos_Form($this->values);
						$errors = $form->isValid();
						if (count($errors) > 0) {
							$form = new Videos_Form($this->values, $errors);
						} else {
							$videos->modify($this->values);
							$this->message = __('changesSaved');
							$form = Videos_Form::newObject($videos);
						}
					}
					$this->linkMobile = url('videos/'.$client->get('pageId'));
					$formHtml = $form->createHtml();
					$this->content = $formHtml;
				} else {
					$this->messageError = __('noAppConfigured');
				}
				return $this->ui->render();
			break;
		}
	}

	public function facebookActions() {
		return '<script>
			        window.fbAsyncInit = function() {
			        	document.querySelectorAll(".fbDialogButton").forEach(function(button){
			        		var buttonAppId = button.getAttribute("data-id");
			        		var buttonAppRedirect = button.getAttribute("data-redirect");
							button.addEventListener("click", function(evt){
					        	FB.init({
					                \'appId\': buttonAppId,
					                \'version\': \'v2.8\'
					            });
								var btn = document.getElementById(\'dsa\');
					        	FB.ui({
									\'method\': \'pagetab\',
									\'redirect_uri\': buttonAppRedirect
								}, function(response){
									if (response!=null && response.tabs_added!=null) {
										window.location = "https://www.facebook.com/" + Object.keys(response.tabs_added)[0] + "/app/" + buttonAppId + "/?ref=page_internal";
									}
								});
							});
			        	});
			        };
			        (function(d, s, id){
			            var js, fjs = d.getElementsByTagName(s)[0];
			            if (d.getElementById(id)) {return;}
			            js = d.createElement(s); js.id = id;
			            js.src = "//connect.facebook.net/en_US/sdk.js";
			            fjs.parentNode.insertBefore(js, fjs);
			        }(document, \'script\', \'facebook-jssdk\'));
			    </script>';
	}

	public function getClient($fbAppId, $fbAppSecret, $urlAdmin, $urlAdminLabel) {
		$this->layoutPage = 'clean';
		$this->client = Client::readFirst(array('where'=>'pageId="'.$this->id.'"'));
		if (DEBUG) {
			$page['id'] = '204274846254538';
			$page['admin'] = '1';
		} else {
			require_once BASE_FILE.'helpers/php/src/Facebook/autoload.php';
			$fb = new Facebook\Facebook(array(
				'app_id' => $fbAppId,
				'app_secret' => $fbAppSecret,
				'default_graph_version' => 'v2.8',
			));
			$canvasHelper = $fb->getCanvasHelper();
			$signedRequest = $canvasHelper->getSignedRequest();
			if (is_object($signedRequest)) {
				$page = $signedRequest->get('page');
				$user = $signedRequest->get('user');
				$userId = $signedRequest->get('user_id');
			}
		}
		if ($this->client->id()!='' || isset($page['id'])) {
			if ($this->client->id()=='') {
				$this->client = Client::readFirst(array('where'=>'pageId="'.$page['id'].'"'));
				if ($this->client->id()=='') {
					$this->client->insert(array('pageId'=>$page['id']));
					$linkFacebook = 'http://www.facebook.com/'.$page['id'];
					$htmlMail = '<p>Hay un nuevo cliente en las aplicaciones Facebook con el id <strong>'.$this->client->id().'</strong></p>
								<p>Acaba de instalar una aplicacion en la pagina <a href="'.$linkFacebook.'" target="_blank">'.$linkFacebook.'</a></p>';
					HtmlMail::send('info@plasticwebs.com', 'notification', array('CONTENT'=>$htmlMail));
				}
			}
		}
		$this->contentAdmin = '';
		if (isset($page['admin']) && $page['admin']==1) {
			$this->contentAdmin = '<div class="contentAdmin">
									<div class="contentAdminIns">
										<a href="'.url($urlAdmin.'/'.$this->client->secret()).'" target="_blank">'.__($urlAdminLabel).'</a>
									</div>
								</div>';
		}
	}

}
?>