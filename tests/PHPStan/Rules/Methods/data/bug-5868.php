<?php // lint >= 8.0

namespace Bug5868;


class HelloWorld
{
	public function nullable1(): ?self
	{
		return $this->nullable1()?->nullable1()?->nullable2();
	}

	public function nullable2(): ?self
	{
		return $this;
	}

	function getAttributeInNode(?DOMNode $node, string $attributeName): ?DOMNode
	{
		return $node?->attributes?->getNamedItem($attributeName);
	}

}

