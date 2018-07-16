<?php declare(strict_types = 1);

namespace Thunbolt\Administration;

use Nette\Application\ForbiddenRequestException;
use Thunbolt\Administration\Components\Menu\MenuComponent;
use Thunbolt\Application\Presenter;
use Thunbolt\Composer\ComposerDirectories;

class AdminPresenter extends Presenter {

	/** @var MenuComponent */
	private $menuComponent;

	protected function startup() {
		parent::startup();

		if (!$this->getUser()->isLoggedIn() && $this->getNames()['presenter'] !== 'Sign') {
			$this->redirectStore('Sign:in');
		}
		if ($this->getUser()->isLoggedIn() && !$this->getUser()->isAdmin()) {
			throw new ForbiddenRequestException('User is not admin.');
		}
	}

	public function formatLayoutTemplateFiles(): array {
		$list = parent::formatLayoutTemplateFiles();
		$list[] = __DIR__ . '/AdminBundle/templates/@layout.latte';

		return $list;
	}

	public function injectAdminBasePresenter(MenuComponent $menuComponent): void {
		$this->menuComponent = $menuComponent;
	}

	protected function createComponentMenu(): MenuComponent {
		return $this->menuComponent;
	}

	protected function beforeRender() {
		parent::beforeRender();

		$template = $this->getTemplate();

		$template->assetsPath = $template->basePath . '/' . ComposerDirectories::PLUGIN_ASSETS_DIR . '/thunbolt-module/admin/assets';
	}

}
