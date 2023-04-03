<?php
/**
 *
 * Nextcloud - GPTZero
 *
 * @copyright Copyright (c) 2023 Andrey Borysenko <andrey18106x@gmail.com>
 *
 * @copyright Copyright (c) 2023 Alexander Piskun <bigcat88@icloud.com>
 *
 * @author 2023 Andrey Borysenko <andrey18106x@gmail.com>
 *
 * @license AGPL-3.0-or-later
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\GPTZero\Controller;

use OCP\IConfig;
use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\GPTZero\AppInfo\Application;

class ConfigController extends Controller {
	/** @var IConfig */
	private $config;

	public function __construct(
		string $appName,
		IRequest $request,
		IConfig $config,
	) {
		parent::__construct($appName, $request);

		$this->config = $config;
	}

	/**
	 * @NoAdminRequired
	 *
	 * @return DataResponse
	 */
	public function isUserConnected(): DataResponse {
		$apiToken = $this->config->getAppValue(Application::APP_ID, 'api_token');

		return new DataResponse([
			'connected' => $apiToken !== '',
			'api_token' => $apiToken,
		]);
	}

	/**
	 * set admin config values
	 *
	 * @param array $values
	 * @return DataResponse
	 */
	public function setAdminConfig(array $values): DataResponse {
		foreach ($values as $key => $value) {
			$this->config->setAppValue(Application::APP_ID, $key, $value);
		}
		return new DataResponse(1);
	}
}
