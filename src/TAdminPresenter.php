<?php declare(strict_types = 1);

namespace Thunbolt\Administration;

use Nette\Application\ForbiddenRequestException;
use Thunbolt\Administration\Components\Menu\MenuComponent;
use Thunbolt\Administration\Components\Navbar\NavbarOptionsFactory;
use Thunbolt\Composer\ComposerDirectories;

trait TAdminPresenter {

	/** @var MenuComponent */
	private $menuComponent;

	/** @var NavbarOptionsFactory */
	private $navbarOptionsFactory;

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

	final public function injectAdminBasePresenter(MenuComponent $menuComponent, NavbarOptionsFactory $navbarOptionsFactory): void {
		$this->menuComponent = $menuComponent;
		$this->navbarOptionsFactory = $navbarOptionsFactory;
	}

	final protected function createComponentMenu(): MenuComponent {
		return $this->menuComponent;
	}

	protected function beforeRender() {
		parent::beforeRender();

		$template = $this->getTemplate();

		$template->parentLayout = __DIR__ . '/AdminBundle/templates/@layout.latte';
		$template->navbarOptions = $this->navbarOptionsFactory->create();

		if (!AdministrationEnvironment::PRODUCTION) {
			$template->_stylesheet = $template->basePath . '/assets/admin.css';
			$template->_javascript = $template->basePath . '/assets/admin.js';
		} else {
			$version = AdministrationEnvironment::VERSION;
			$version = $version === false ? '' : '@' . $version;

			$basePath = "https://cdn.jsdelivr.net/gh/ThunboltModules/admin$version/assets/admin.";
			$template->_stylesheet = $basePath . 'css';
			$template->_javascript = $basePath . 'js';
		}
	}

}
