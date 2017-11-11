<?php
namespace phpdisimple;
class DI {
	private static $injectedSingletonObjects=array();
	public static function get($className, $arguments=null){
		if (!self::isClassExist($className))
			throw new Exception("Missing class name: {$className}");
		$reflectionClass = new ReflectionClass($className);
		$isArgumentsNotEmpty = self::isArrayNotEmpty($arguments);
		$object = $isArgumentsNotEmpty?$reflectionClass->newInstanceArgs($arguments):new $className;
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
			$object->$injectClassName = $isInjectCommentSingleton?self::loadInjectedSingletonObject($injectClassName):self::get($injectClassName);
		}
	}
	
	private static function loadInjectedSingletonObject($injectClassName){
		if (!isset(self::$injectedSingletonObjects[$injectClassName]))
			self::$injectedSingletonObjects[$injectClassName] =  self::get($injectClassName);
		return self::$injectedSingletonObjects[$injectClassName];
	}
	
	private static function getInjectClassNameFromComment($comment){
		$injectClassName = str_replace('@InjectSingleton', '', $comment);
		$injectClassName = str_replace('@Inject', '', $injectClassName);
		$injectClassName = str_replace('*', '', $injectClassName);
		$injectClassName = preg_replace('/\s+/', '', $injectClassName);
		return $injectClassName;
	}
	
	private static function isClassExist($className){
		return class_exists($className);
	}
	
	private static function isArrayNotEmpty($array){
		return is_array($array)&&count($array)>0; 
	}
}