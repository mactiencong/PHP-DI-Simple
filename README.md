# The simple Dependency Injection lib for PHP (5.3.x ~)
# How to work

1. Inject annotations
- @Inject
Inject a object instance normaly

```
/**
 * 
 * @author matico
 * @Inject Address
 * @Inject Skill
 *
 */
class Developer {
}
```

- @InjectSingleton
Inject a singleton object

```
/**
 * 
 * @author matico
 * @InjectSingleton Country
 */
class Address {
}
```

```
$maticoDeveloper = DI::get('Developer', array('name'=>'matico'));
$maticoInfo = $maticoDeveloper->info();
$congmtDeveloper = DI::get('Developer', array('name'=>'congmt'));
$congmtInfo= $congmtDeveloper->info();
$this->assertSame('matico-VN-PHP', $maticoInfo);
$this->assertSame('congmt-VN-PHP', $congmtInfo);
```
View example detail in testcases