<?php

namespace App\Helpers;

use App\Models\Visita;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class Visitas
{
	private $ignoreCrawlers = true;
	private $request = null;
	private $model = null;
	private $model_id = null;

	public function __construct(Request $request, $model = null, $model_id = 0)
	{
		$this->request = $request;
		$this->model = $model;
		$this->model_id = $model_id;
	}

	protected function isCrawler()
	{
		return $this->ignoreCrawlers && app(CrawlerDetect::class)->isCrawler();
	}

	public function record($force = false)
	{
		//  && !$this->recordedIp()
		// dd($this->recordedIp());
		$force = true;
		$ip = $this->getVisitorCountry()->ip ?? '127.0.0.1';
		if ((!$this->isCrawler() && !$this->recordedIp($ip)) || $force) {
			$campos = [
				'ip' => $ip,
				'iso_code' => $this->getVisitorCountry()->iso_code ?? 'zz',
				'country' => $this->getVisitorCountry()->country ?? 'unknown',
				'city' => $this->getVisitorCountry()->city ?? 'unknown',
				'state' => $this->getVisitorCountry()->state ?? 'unknown',
				'state_name' => $this->getVisitorCountry()->state_name ?? 'unknown',
				'lat' => $this->getVisitorCountry()->lat ?? 0,
				'lon' => $this->getVisitorCountry()->lon ?? 0,
				'timezone' => $this->getVisitorCountry()->timezone ?? 'unknown',
				'continent' => $this->getVisitorCountry()->continent ?? 'unknown',
				'so' => $this->getVisitorOperatingSystem(),
				'language' => $this->getVisitorLanguage(),
				'browser' => $this->getVisitorBrowserName(),
				'url' => $this->request->url(),
				'model' => $this->model,
				'model_id' => $this->model_id,
				'user_id' => auth()->id(),
			];
			// dd($campos);
			Visita::create($campos);
			return true;
		}
		return false;
	}

	protected function recordedIp($ip)
	{
		return Visita::where('ip', $ip)->where('model_id', $this->model_id)->where('model', $this->model)->where('created_at', '>=', now()->subHours(1))->exists();
	}

	/**
	 *  Gets visitor country code
	 * @return mixed|string
	 */
	public function getVisitorCountry()
	{
		// $this->request->ip() 187.189.155.7
		return geoip($this->request->ip());
	}

	/**
	 *  Gets visitor operating system
	 * @return mixed|string
	 */
	public function getVisitorOperatingSystem()
	{
		$osArray = [
			'/windows|win32|win16|win95/i' => 'Windows',
			'/iphone/i' => 'iPhone',
			'/ipad/i' => 'iPad',
			'/macintosh|mac os x|mac_powerpc/i' => 'MacOS',
			'/(?=.*mobile)android/i' => 'AndroidMobile',
			'/(?!.*mobile)android/i' => 'AndroidTablet',
			'/android/i' => 'Android',
			'/blackberry/i' => 'BlackBerry',
			'/linux/i' => 'Linux',
			'/ubuntu/i' => 'Ubuntu',
		];
		foreach ($osArray as $regex => $value) {
			if (preg_match($regex, $this->request->server('HTTP_USER_AGENT') ?? '')) {
				return $value;
			}
		}
		return 'unknown';
	}

	/**
	 *  Gets visitor browser name
	 * @return mixed|string
	 */
	public function getVisitorBrowserName()
	{
		$osArray = [
			'/msie/i' => 'Internet Explorer',
			'/edge/i' => 'Microsoft Edge',
			'/firefox/i' => 'Firefox',
			'/chrome/i' => 'Chrome',
			'/safari/i' => 'Safari',
			'/opera/i' => 'Opera',
			'/netscape/i' => 'Netscape',
			'/maxthon/i' => 'Maxthon',
			'/konqueror/i' => 'Konqueror',
			'/mobile/i' => 'Handheld Browse',
		];
		// dd($this->request->server('HTTP_USER_AGENT'));
		foreach ($osArray as $regex => $value) {
			if (preg_match($regex, $this->request->server('HTTP_USER_AGENT') ?? '')) {
				return $value;
			}
		}
		return 'unknown';
	}

	/**
	 *  Gets visitor language
	 * @return mixed|string
	 */
	public function getVisitorLanguage()
	{
		$language = $this->request->getPreferredLanguage();
		if (false !== $position = strpos($language, '_')) {
			$language = substr($language, 0, $position);
		}
		return $language;
	}
}
