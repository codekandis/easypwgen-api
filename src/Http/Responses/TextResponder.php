<?php declare( strict_types = 1 );
namespace CodeKandis\EasyPwGenApi\Http\Responses;

use CodeKandis\EasyPwGenApi\Renderers\TextRenderer;
use CodeKandis\Tiphy\Http\ContentTypes;
use CodeKandis\Tiphy\Http\Responses\AbstractResponder;
use CodeKandis\Tiphy\Http\Responses\Headers;

/**
 * Represents a JSON HTTP responder.
 * @package codekandis/easypwgen
 * @author Christian Ramelow <info@codekandis.net>
 */
class TextResponder extends AbstractResponder
{
	/**
	 * {@inheritDoc}
	 */
	public function respond(): void
	{
		$this->sendStatusCode();

		$this->addHeader( Headers::ACCESS_CONTROL_ALLOW_ORIGIN, '*' );
		$this->addHeader( Headers::CACHE_CONTROL, 'no-store, no-cache, must-revalidate' );
		$this->addHeader( Headers::CONTENT_TYPE, ContentTypes::TEXT_PLAIN );

		$renderer        = new TextRenderer( $this->data );
		$renderedContent = $renderer->render();
		$contentLength   = $renderedContent->getContentLength();

		$this->addHeader( Headers::CONTENT_LENGTH, (string) $contentLength );
		$this->sendHeaders();

		echo $renderedContent->getContent();
	}
}
