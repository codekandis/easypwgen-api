<?php declare( strict_types = 1 );
namespace CodeKandis\EasyPwGenApi\Renderers;

use CodeKandis\Tiphy\Renderers\RenderedContent;
use CodeKandis\Tiphy\Renderers\RenderedContentInterface;
use CodeKandis\Tiphy\Renderers\RendererInterface;

/**
 * Represents a text content renderer.
 * @package codekandis/easypwgen
 * @author Christian Ramelow <info@codekandis.net>
 */
class TextRenderer implements RendererInterface
{
	/**
	 * Stores the data to render.
	 * @var string
	 */
	private $data;

	/**
	 * Constructor method.
	 * @param mixed $data The data to render.
	 */
	public function __construct( string $data )
	{
		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function render(): RenderedContentInterface
	{
		return new RenderedContent( $this->data );
	}
}
