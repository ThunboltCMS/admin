<?php declare(strict_types = 1);

namespace Thunbolt\Administration\AdminBundle\Presenters;

use Thunbolt\Administration\AdminPresenter;

class HomepagePresenter extends AdminPresenter {

	public function formatLayoutTemplateFiles(): array {
		$list = parent::formatLayoutTemplateFiles();
		$list[] = __DIR__ . '/../templates/@layout.latte';

		return $list;
	}

	public function renderDefault(): void {
		$template = $this->getTemplate();

		$template->setFile($parentFile = __DIR__ . '/templates/Homepage/default.latte');
		$template->parentFile = $parentFile;
	}

}
