<?php declare( strict_types = 1 );
namespace CodeKandis\EasyPwGenApi\Configurations\Plain;

use const E_ALL;

return [
	'dsn'           => '',
	'displayErrors' => false,
	'errorTypes'    => E_ALL,
	'environment'   => 'production',
	'release'       => '0.4.0',
	'serverName'    => 'api.easypwgen.codekandis'
];
