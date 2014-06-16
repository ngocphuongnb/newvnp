<?php

class VNP_Router {
	static $Rules = array(
		'i' => '[0-9]++',
		'a' => '[a-zA-Z0-9]++',
		'h' => '[a-fA-F0-9]++',
		'*'	=> '.+?',
		'**'=> '.++',
		''	=> '[^/\.]++'
	);
	static $MatchPattern;
	static $MatchRuleKey;
	static $CompiledRoutesPath;
	static $CompiledRoutesCachedFile;
	private $BasePath = '';
	private $Routes = array();
	static function Init() {
		self::$MatchPattern = '/\[[' . join('|', array_keys(self::$Rules)) . ']\:([a-zA-Z0-9_\-]++)\]/';
		self::$MatchRuleKey = '/\[([' . join('|', array_keys(self::$Rules)) . '])\:([a-zA-Z0-9_\-]++)\]/';
		self::$CompiledRoutesPath = dirname(__FILE__);
		self::$CompiledRoutesCachedFile = 'routes_' . md5('VNP_CachedRoutes') . '.cache';
		
	}
	public function SetBasePath($Path = '') {
		$this->BasePath = $Path;
	}
	static function AddRule($Name, $Rule) {
		self::$Rules[$Name] = $Rule;
	}
	public function Map($Name, $Route, $Target, $Method = 'GET', $Priority = 0) {
		if(isset($this->Routes[$Name])) trigger_error('Route ' . $Name . ' existed!');
		else $this->Routes[$Name] = array(	'name'		=> $Name,
											'route'		=> $Route,
											'target'	=> $Target,
											'method'	=> $Method,
											'priority'	=> $Priority);
	}
	public function UnMap($Name) {
		if(isset($this->Routes[$Name])) unset($this->Routes[$Name]);
	}
	public function Generate($RouteName, $Parameters) {
		if(isset($this->Routes[$RouteName])) {
			//if($Count = preg_match_all(self::$MatchPattern, $this->Routes[$RouteName]['route'], $Matches)) {
			if($Count = preg_match_all('`\[([a-zA-Z0-9_\-\|\*]*)\:([a-zA-Z0-9_\-]+)\]`', $this->Routes[$RouteName]['route'], $Matches)) {
				$Url = $this->Routes[$RouteName]['route'];
				for($i = 0; $i < $Count; $i++)
					$Url = str_replace($Matches[0][$i], $Parameters[$Matches[2][$i]], $Url);
				return $this->BasePath . $Url;
			}
			else return $this->BasePath . $this->Routes[$RouteName]['route'];
		}
		else return self::$BasePath;
	}
	private function ComplileRoutes($Recompile = false) {
		$RoutesCachedFile = self::$CompiledRoutesPath . self::$CompiledRoutesCachedFile;
		if(!file_exists($RoutesCachedFile) || $Recompile) {
			$CompiledRoutes = array();
			foreach($this->Routes as $Route) {
				if($Count = preg_match_all('`\[([a-zA-Z0-9_\-\|\*]*)\:([a-zA-Z0-9_\-]+)\]`', $Route['route'], $Matches)) {
					for($i = 0; $i < $Count; $i++) {
						if(!in_array($Matches[1][$i], array_keys(self::$Rules))) {
							$RuleKey = '*';
							$Route['var_format'][$Matches[2][$i]] = array_map('trim', explode('|', $Matches[1][$i]));
						}
						else $RuleKey = $Matches[1][$i];
						$Route['route'] =
						str_replace(
									$Matches[0][$i],
									'(?P<' . $Matches[2][$i] . '>' . self::$Rules[$RuleKey] . ')',
									$Route['route']
								);
					}
				}
				$CompiledRoutes[$Route['name']] = $Route;
			}
			File::Create($RoutesCachedFile, serialize($CompiledRoutes));
		}
		else $CompiledRoutes = unserialize(File::GetContent($RoutesCachedFile));
		return $CompiledRoutes;
	}
	public function Match($ThisUrl = NULL, $Method = NULL) {
		if($Method == NULL) $Method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD']: 'GET';
		$CompiledRoutes = $this->ComplileRoutes(true);
		if($ThisUrl == NULL) {
			//$ThisUrl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$ThisUrl = $_SERVER['REQUEST_URI'];
			if(($strpos = strpos($ThisUrl, '?')) !== false) {
				$ThisUrl = substr($ThisUrl, 0, $strpos);
			}
			$ThisUrl = substr($ThisUrl, strlen($this->BasePath));
		}
		$MatchedRoutes = array();
		foreach($CompiledRoutes as $Route) {
			$MethodMatch = false;
			$RouteMethods = array_map('trim', explode('|', $Route['method']));
			foreach($RouteMethods as $RM) {
				if(strcasecmp($Method, $RM) === 0) {
					$MethodMatch = true;
					break;
				}
			}
			if(!$MethodMatch)continue;
			
			if($Count = preg_match_all('`^' . $Route['route'] . '$`', $ThisUrl, $Matches, PREG_SET_ORDER)) {
				$MatchRoute = true;
				foreach($Matches[0] as $MatchKey => $MatchVar) {
					if(is_numeric($MatchKey)) {
						unset($Matches[0][$MatchKey]);
						continue;
					}
					if(isset($Route['var_format'][$MatchKey]) && !in_array($MatchVar, $Route['var_format'][$MatchKey])) {
						$MatchRoute = false;
						break;
					}
				}
				if($MatchRoute) {
					$MatchRoute = array('name'		=> $Route['name'],
										'target'	=> $Route['target'],
										'method'	=> $Route['method'],
										'priority'	=> $Route['priority'],
										'params'	=> $Matches[0]
									);
					$MatchedRoutes[] = 	$MatchRoute;
				}
			}
		}
		if(empty($MatchedRoutes)) $MatchedRoutes[] = array('name' => '', 'target' => '');
		usort($MatchedRoutes, 'Router_SortMatchedRules');
		return $MatchedRoutes;
	}
}

function Router_SortMatchedRules($Route1, $Route2) {
	return strcmp($Route1['priority'],$Route2['priority']);
}

?>