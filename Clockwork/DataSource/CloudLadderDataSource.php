<?php

namespace Clockwork\DataSource;

use Clockwork\Request\Request;

/**
 * Class CloudLadderDataSource
 *
 * @package Clockwork\DataSource
 * @author wm
 */
class CloudLadderDataSource extends DataSource
{
	protected $data = [];

	protected $requestId = '';

	public function resolve(Request $request)
	{
		if ($this->requestId && $this->data) {
			$request->cloudLadderData = array_merge($request->cloudLadderData, [['request_id' => $this->requestId, 'data' => $this->data]]);
			$this->data = [];
			$this->requestId = '';
		}
	}

	public function writeData($data, $requestId)
	{
		if (!is_array($data) || !is_string($requestId)) {
			return;
		}
		$this->data = $data;
		$this->requestId = $requestId;
	}
}
