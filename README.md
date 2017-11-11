# The simple Dependency Injection lib for PHP (5.3.x ~)
# How to work
View example in testcases

```
$maticoDeveloper = DI::get('Developer', array('name'=>'matico'));
$maticoInfo = $maticoDeveloper->info();
$congmtDeveloper = DI::get('Developer', array('name'=>'congmt'));
$congmtInfo= $congmtDeveloper->info();
$this->assertSame('matico-VN-PHP', $maticoInfo);
$this->assertSame('congmt-VN-PHP', $congmtInfo);
```