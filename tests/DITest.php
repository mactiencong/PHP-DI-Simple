<?php
namespace phpdisimple;
class DITest extends TestCase
{
	public function testDI()
	{   
		$maticoDeveloper = DI::get('Developer', array('name'=>'matico'));
		$maticoInfo = $maticoDeveloper->info();
		$congmtDeveloper = DI::get('Developer', array('name'=>'congmt'));
		$congmtInfo= $congmtDeveloper->info();
		$this->assertSame('matico-VN-PHP', $maticoInfo);
		$this->assertSame('congmt-VN-PHP', $congmtInfo);
	}
}