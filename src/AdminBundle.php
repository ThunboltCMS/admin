<?php declare(strict_types = 1);

namespace Thunbolt\Administration;

use Thunbolt\Administration\DI\AdminExtension;
use Thunbolt\Bundles\Bundle;

class AdminBundle extends Bundle {

	public function getBaseFolder(): string {
		return __DIR__;
	}

	public function startup(): void {
		$this->helper->getCompiler()->addExtension(
			'admin', new AdminExtension()
		);
	}

}
