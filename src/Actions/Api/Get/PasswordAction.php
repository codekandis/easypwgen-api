<?php declare( strict_types = 1 );
namespace CodeKandis\EasyPwGenApi\Actions\Api\Get;

use CodeKandis\EasyPwGenApi\Configurations\ConfigurationRegistry;
use CodeKandis\EasyPwGenApi\Entities\PasswordEntity;
use CodeKandis\EasyPwGenApi\Entities\UriExtenders\PasswordApiUriExtender;
use CodeKandis\EasyPwGenApi\Generators\RandomizedPasswordGenerator;
use CodeKandis\EasyPwGenApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\EasyPwGenApi\Http\UriBuilders\ApiUriBuilderInterface;
use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use JsonException;
use function array_key_exists;

/**
 * Represents the HTTP `GET` password action.
 * @package codekandis/easypwgen-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class PasswordAction extends AbstractAction
{
	/**
	 * Represents the default password length.
	 * @var int
	 */
	private const DEFAULT_PASSWORD_LENGTH = 8;

	/**
	 * Stores the API URI builder.
	 * @var ApiUriBuilderInterface
	 */
	private ApiUriBuilderInterface $apiUriBuilder;

	/**
	 * Gets the API URI builder.
	 * @return ApiUriBuilder The API URI builder.
	 */
	private function getUriBuilder(): ApiUriBuilderInterface
	{
		return $this->apiUriBuilder ?? $this->apiUriBuilder = new ApiUriBuilder( ConfigurationRegistry::_()->getUriBuilderConfiguration() );
	}

	/**
	 * Executes the action.
	 * @throws JsonException An error occurred during the response encoding.
	 */
	public function execute(): void
	{
		$password = new PasswordEntity();
		$this->extendUris( $password );

		$password->value = ( new RandomizedPasswordGenerator() )
			->generate(
				$this->getPasswordLength()
			);

		$responseData = [
			'password' => $password,
		];
		$response     = new JsonResponder( StatusCodes::OK, $responseData );
		$response->respond();
	}

	/**
	 * Gets the length of the password.
	 * @return int The length of the password.
	 */
	private function getPasswordLength(): int
	{
		return false === array_key_exists( 'length', $_GET )
			? static::DEFAULT_PASSWORD_LENGTH
			: (int) $_GET[ 'length' ];
	}

	/**
	 * Extends the URIs of the password entity.
	 * @param PasswordEntity $password The password entity.
	 */
	private function extendUris( PasswordEntity $password ): void
	{
		$uriBuilder = $this->getUriBuilder();
		( new PasswordApiUriExtender( $uriBuilder, $password ) )
			->extend();
	}
}
