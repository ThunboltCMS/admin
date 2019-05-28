<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Components\Navbar;

final class NavbarOptions {

	/** @var string|null */
	public $avatar;

	/** @var NavbarLink[] */
	protected $links = [];

	public function __construct(?string $avatar = null) {
		$this->avatar = $avatar;
	}

	public function addLink(NavbarLink $navbarLink): self {
		$this->links[] = $navbarLink;

		return $this;
	}

	/**
	 * @return NavbarLink[]
	 */
	public function getLinks(): array {
		return $this->links;
	}

}
