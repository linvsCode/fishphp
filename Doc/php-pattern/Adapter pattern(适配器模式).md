[toc]

# 适配器模式

> 适配器模式是一种结构型模式，它将一个类的接口转接成用户所期待的。一个适配使得因接口不兼容而不能在一起工作的类工作在一起，做法是将类别自己的接口包裹在一个已存在的类中。

## 适配器模式中主要角色
- 目标(Target)角色：定义客户端使用的与特定领域相关的接口，这也就是我们所期待得到的
- 源(Adaptee)角色：需要进行适配的接口
- 适配器(Adapter)角色：对Adaptee的接口与Target接口进行适配；适配器是本模式的核心，适配器把源接口转换成目标接口，此角色为具体类

## 适用性
1. 你想使用一个已经存在的类，而它的接口不符合你的需求
2. 你想创建一个可以复用的类，该类可以与其他不相关的类或不可预见的类协同工作 
3. 你想使用一个已经存在的子类，但是不可能对每一个都进行子类化以匹配它们的接口。对象适配器可以适配它的父类接口（仅限于对象适配器）

## 类适配器模式与对象适配器

> 其中类适配器模式使用继承方式，而对象适配器模式使用组合方式。由于类适配器模式包含双重继承，而PHP并不支持双重继承，所以一般都采取结合继承和实现的方式来模拟双重继承，即继承一个类，同时实现一个接口。类适配器模式很简单，但是与对象适配器模式相比，类适配器模式的灵活性稍弱。采用类适配器模式时，适配器继承被适配者并实现一个接口；采用对象适配器模式时，适配器使用被适配者，并实现一个接口。

### 类适配器：Adapter与Adaptee是继承关系

- 用一个具体的Adapter类和Target进行匹配。结果是当我们想要一个匹配一个类以及所有它的子类时，类Adapter将不能胜任工作
- 使得Adapter可以重定义Adaptee的部分行为，因为Adapter是Adaptee的一个子集
- 仅仅引入一个对象，并不需要额外的指针以间接取得adaptee

### 对象适配器：Adapter与Adaptee是委托关系

允许一个Adapter与多个Adaptee同时工作。Adapter也可以一次给所有的Adaptee添加功能
使用重定义Adaptee的行为比较困难

## 实例

**类适配器**

```php
<?php

interface Target {
    public function sampleMethod1();
    public function sampleMethod2();
}

class Adaptee { // 源角色
    public function sampleMethod1() {}
}

class Adapter extends Adaptee implements Target { // 适配后角色
    public function sampleMethod2() {}
}

// client
$adapter = new Adapter();
$adapter->sampleMethod1();
$adapter->sampleMethod2();

?>
```

**对象适配器**

```php
<?php

interface Target {
    public function sampleMethod1();
    public function sampleMethod2();
}

class Adaptee {
    public function sampleMethod1() {}
}

class Adapter implements Target {
    private $_adaptee;
    public function __construct(Adaptee $adaptee) {
        $this->_adaptee = $adaptee;
    }

    public function sampleMethod1() { $this->_adaptee->sampleMethod1(); }

    public function sampleMethod2() {}
}

$adaptee = new Adaptee();
$adapter = new Adapter($adaptee);
$adapter->sampleMethod1();
$adapter->sampleMethod2();
?>


```

## 大话设计模式

```php
<?php 

//篮球翻译适配器
abstract class Player
{
    protected $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    abstract public function Attack();
    abstract public function Defense();
}

//前锋
class Forwards extends Player
{
    function __construct()
    {
        parent::__construct();
    }

    
    public function Attack()
    {
        echo "前锋:".$this->name." 进攻\n";
    }
    public function Defense()
    {
        echo "前锋:".$this->name." 防守\n";
    }
}

//中锋
class Center extends Player
{
    function __construct()
    {
        parent::__construct();
    }

    public function Attack()
    {
        echo "中锋:".$this->name." 进攻\n";
    }
    public function Defense()
    {
        echo "中锋:".$this->name." 防守\n";
    }
}

//外籍中锋
class ForeignCenter
{
    private $name;
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function 进攻()
    {
        echo "外籍中锋:".$this->name." 进攻\n";
    }

    public function 防守()
    {
        echo "外籍中锋:".$this->name." 防守\n";
    }
}

//翻译者
class Translator extends Player
{
    private $foreignCenter;

    function __construct($name)
    {
        $this->foreignCenter = new ForeignCenter();
        $this->foreignCenter->setName($name);
    }

    public function Attack()
    {
        $this->foreignCenter->进攻();
    }
    public function Defense()
    {
        $this->foreignCenter->防守();
    }

}

// 客户端代码
$forwards = new Forwards("巴蒂尔");
$forwards->Attack();
$forwards->Defense();

$translator = new Translator("姚明");
$translator->Attack();
$translator->Defense();
```

总结：

> 适配器模式，将一个类的接口转化成客户希望的另外一个接口。适配器模式使得原本由于接口不兼容而不能一起工作的那些类可以一起工作。

> 系统的数据和行为都正确，但接口不符时，我们应该考虑用适配器，目的是使控制范围之外的一个原有对象与某个接口匹配。适配器模式主要应用于希望复用一些现存的类。但是接口又与复用环境要求不一致的情况。

> 两个类所做的事情相同或相似，但是具有不同的接口时要使用它。

> 在双方都不太容易修改的时候再使用适配器模式适配。





