<?php
namespace phpdisimple;
class DI {
	private static $injectedSingletonObjects=array();
	public static function get($className, $arguments=null){
		if (!self::isClassExist($className))
			throw new Exception("Missing class name: {$className}");
		$reflectionClass = new ReflectionClass($className);
		$isArgumentsNotBlank = self::isArrayNotBlank($arguments);
		$object = $isArgumentsNotBlank?$reflectionClass->newInstanceArgs($arguments):new $className;
		self::inject($object, $reflectionClass);
		return $object;
	}
	
	private static function inject(&$object, &$reflectionClass){
		$docComment = $reflectionClass->getDocComment();
		if (!$docComment) return;
		$commentLines = explode("\n", $docComment);
		foreach ($commentLines as $comment){
			$isInjectComment = strpos($comment, '@Inject')!==false;
			if (!$isInjectComment) continue;
			$isInjectCommentSingleton = strpos($comment, '@InjectSingleton')!==false;
			$injectClassName = self::getInjectClassNameFromComment($comment);
			if (!$injectClassName) 
				continue;
			if ($isInjectCommentSingleton){
				if(self::loadInjectedSingletonObject($injectClassName)){
					$object->$injectClassName = self::$injectedSingletonObjects[$injectClassName];
				}
			} else {
				$injectedObject = self::get($injectClassName);
				if ($injectedObject)
					$object->$injectClassName = $injectedObject;
			}
		}
	}
	
	private static function loadInjectedSingletonObject($injectClassName){
		if (!isset(self::$injectedSingletonObjects[$injectClassName])) {
			$injectedSingletonObject = self::get($injectClassName);
			if ($injectedSingletonObject) {
				self::$injectedSingletonObjects[$injectClassName] =  $injectedSingletonObject;
				return true;
			}
			return false;
		}
	}
	
	private static function getInjectClassNameFromComment($comment){
		$injectClassName = str_replace('@InjectSingleton', '', $comment);
		$injectClassName = str_replace('*', '', $injectClassName);
		$injectClassName = str_replace('@Inject', '', $injectClassName);
		$injectClassName = preg_replace('/\s+/', '', $injectClassName);
		return $injectClassName;
	}
	
	private static function isClassExist($className){
		return class_exists($className);
	}
	
	private static function isArrayNotBlank($array){
		return is_array($array)&&count($array)>0; 
	}
}