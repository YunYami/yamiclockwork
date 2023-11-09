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
	protected $requestData = [];

	/**
	 * 将属性中的值赋值到request中的属性，作为持久化所必须的
	 *
	 * @param  Request  $request
	 * @author Wumeng wumeng@gupo.onaliyun.com
	 * @since 2023-11-09 17:41
	 */
	public function resolve(Request $request)
	{
		if ($this->requestData) {
			$request->cloudLadderData = $this->requestData;
		}
	}

	/**
	 * 将日志记录在属性中
	 *
	 * @param $dataArr
	 * @param $requestId
	 * @author Wumeng wumeng@gupo.onaliyun.com
	 * @since 2023-11-09 17:41
	 */
	public function writeData($dataArr, $requestId)
	{
		$this->requestData[] = ['request_id' => $requestId, 'data' => $dataArr];
	}

	/**
	 * 获取总览所需要的数据格式
	 *
	 * @param  string  $type
	 * @param  string  $name
	 * @param  float  $timestamp
	 * @return array
	 * @author Wumeng wumeng@gupo.onaliyun.com
	 * @since 2023-11-09 17:40
	 */
	public function getData(string $type, string $name, float $timestamp = 0): array
	{
		return [
			$type   => $timestamp ?? microtime(true),
			"color" => "cyan",
			"name"  => $name,
		];
	}

	/**
	 * 在总览上进行记录
	 *
	 * @param  string  $fullUrl
	 * @param  string  $type
	 * @param  float  $timestamp
	 * @author Wumeng wumeng@gupo.onaliyun.com
	 * @since 2023-11-09 17:40
	 */
	public function performanceWrite(string $fullUrl, string $type, float $timestamp = 0): void
	{
		$data = $this->getData($type, $fullUrl, $timestamp);
		clock()->event($fullUrl, $data)->$type();
	}
}
