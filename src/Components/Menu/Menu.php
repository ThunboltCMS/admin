<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Components\Menu;

class Menu extends MenuChild {

	/** @var null|string */
	private $icon;

	/** @var null|string */
	private $color;

	public function __construct(string $name, array $url, ?string $icon = null, ?string $color = null, ?array $allows = null, array $children = []) {
		parent::__construct($name, $url, $allows, $children);
		$this->icon = $icon;
		$this->color = $color;
	}

	/**
	 * @return null|string
	 */
	public function getIcon(): ?string {
		return $this->icon;
	}

	/**
	 * @return null|string
	 */
	public function getColor(): ?string {
		return $this->color;
	}

}
