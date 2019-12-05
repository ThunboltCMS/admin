<?php declare(strict_types = 1);

namespace Thunbolt\Administration\AdminBundle\Presenters;

use Thunbolt\User\Interfaces\ISignInForm;

trait TSignPresenter {

	/** @var ISignInForm @inject */
	public $signInForm;

	public function actionIn(?string $backlink): void {
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect('Homepage:');
		}

		$template = $this->getTemplate();

		$template->setFile($parentFile = __DIR__ . '/templates/Sign/in.latte');
		$template->parentFile = $parentFile;
	}

	public function actionOut(): void {
		if ($this->getUser()->isLoggedIn()) {
			$this->getUser()->logout();
		}

		$this->redirect('in');
	}

	protected function createComponentSignIn() {
		$form = $this->signInForm->createSignIn();

		$form->onSuccess[] = function () {
			if (method_exists($this, 'redirectRestore')) {
				$this->redirectRestore('Homepage:');
			} else {
				$this->redirect('Homepage:');
			}
		};

		return $form;
	}
	
}
