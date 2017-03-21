<?php
class Post_Ui extends Ui{

	public function renderPublic() {
		return '<div class="itemPublic itemPublicPost">
					<a href="'.$this->object->url().'">
						<div class="itemPublicRight">
							<h2>'.$this->object->getBasicInfo().'</h2>
							<p>'.$this->object->get('shortDescription').'</p>
						</div>
						<div class="itemPublicLeft">
							<div class="itemPublicImage">
								'.$this->object->getImageIcon('image').'
							</div>
						</div>
					</a>
				</div>';
	}

	public function renderSide() {
		return '<div class="itemSimpleLink">
					<a href="'.$this->object->url().'">
						<p>'.$this->object->getBasicInfo().'</p>
						<p><em>'.Date::sqlText($this->object->get('publishDate')).'</em></p>
					</a>
				</div>';
	}

	/**
	* @cache
	*/
	public function renderComplete() {
		$breadCrumbs = array(url('noticias')=>'Noticias', $this->object->url()=>$this->object->getBasicInfo());
		return Navigation_Ui::renderMenu($this->object->id()).'
				<div class="contentFormatIns">
					'.Navigation_Ui::renderBreadCrumbs($breadCrumbs).'
					<div itemscope itemtype="http://schema.org/Article">
						<h1 itemprop="name">Listado de recetas de '.strtolower($this->object->getBasicInfo()).'</h1>
						<span style="display:none;" itemprop="author" itemscope itemtype="http://schema.org/Person">
							<span itemprop="name">'.Params::param('titlePage').'</span>
						</span>
						<div class="contentLeft">
							'.Adsense::top().'
							<div class="contentSimple">
								<div class="itemComplete itemCompletePost">
									<div class="postTop">
										<div class="postTopLeft">
											'.$this->object->getImage('image', 'web').'
										</div>
										<div class="postTopRight">
											<p><em>'.Date::sqlText($this->object->get('publishDate')).'</em></p>
											<p><strong>'.$this->object->get('shortDescription').'</strong></p>
										</div>
									</div>
									'.Adsense::top().'
									<div class="postContent pageComplete">
										'.$this->object->get('description').'
									</div>
								</div>
								'.$this->related().'
							</div>
						</div>
						<div class="contentRight">
							<aside>
								'.Recipe_Ui::side().'
								'.Adsense::inline().'
								'.Post_Ui::side().'
							</aside>
						</div>
					</div>
				</div>';
	}

	public function related() {
		$items = new ListObjects('Post', array('where'=>'idPost!="'.$this->object->id().'"', 'order'=>'RAND()', 'limit'=>'10'));
		return '<div class="related relatedPost">
					<h2>Otras noticias</h2>
					<div class="relatedIns">
						'.$items->showList().'
					</div>
				</div>';
	}

	static public function intro() {
		$items = new ListObjects('Post', array('results'=>'5'));
		return '<div class="listPublic listPublicIntro">
					'.$items->showListPager().'
				</div>';
	}

	static public function side() {
		$items = new ListObjects('Post', array('order'=>'publishDate DESC', 'limit'=>'10'));
		return '<div class="newsSide">
					<div class="newsSideIns">
						<h2 class="titleNewsSide">
							<a href="'.url('noticias').'">'.Params::param('title-news').'</a>
						</h2>
						<div class="newsSideList">
							'.$items->showList(array('function'=>'Side')).'
							<div class="clearer"></div>
						</div>
					</div>
				</div>';
	}

	/**
	* @cache
	*/
	static public function renderCompletePosts() {
		$items = new ListObjects('Post', array('order'=>'publishDate DESC'));
		return '<div class="listAllSimple">
					'.$items->showList(array('function'=>'Side')).'
				</div>';
	}

}
?>