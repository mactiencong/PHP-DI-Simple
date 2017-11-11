<?php
namespace phpdisimple;
/**
 * 
 * @author matico
 * @Inject Address
 * @Inject Skill
 *
 */
class Developer {
	private $name;
	public function __construct($name){
		echo 'Create Developer instance'.PHP_EOL;
		$this->name = $name;
	}
	public function info(){
		return $this->name.'-'.$this->Address->getAddress().'-'.$this->Skill->getSkill();
	}
}

/**
 * 
 * @author matico
 * @InjectSingleton Country
 */
class Address {
	public function __construct(){
		echo 'Create Address instance'.PHP_EOL;
	}
	public function getAddress(){
		return $this->Country->getCountry();
	}
}

class Country {
	public function __construct(){
		echo 'Create Country instance'.PHP_EOL;
	}
	public function getCountry(){
		return 'VN';
	}
}

class Skill {
	public function __construct(){
		echo 'Create Skill instance'.PHP_EOL;
	}
	public function getSkill(){
		return 'PHP';
	}
}