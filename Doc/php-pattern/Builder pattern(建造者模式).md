
[TOC]

# 建造者模式
> 建造者模式是一种创建型模式，它可以让一个产品的内部表象和和产品的生产过程分离开，从而可以生成具有不同内部表象的产品。建造者模式又可以称为生成器模式

## Builder模式中主要角色:

- 抽象建造者（Builder）角色：定义抽象接口，规范产品各个部分的建造，必须包括建造方法和返回方法。
- 具体建造者（Concrete）角色：实现抽象建造者接口。应用程序最终根据此角色中实现的业务逻辑创造产品。
- 导演（Director）角色：调用具体的建造者角色创造产品。
- 产品（Product）角色：在导演者的指导下所创建的复杂对象。

```php
<?php

class Product { // 产品本身
    private $_parts;
    public function __construct() { $this->_parts = array(); }
    public function add($part) { return array_push($this->_parts, $part); }
}

abstract class Builder { // 建造者抽象类
    public abstract function buildPart1();
    public abstract function buildPart2();
    public abstract function getResult();
}

class ConcreteBuilder extends Builder { // 具体建造者
    private $_product;
    public function __construct() { $this->_product = new Product(); }
    public function buildPart1() { $this->_product->add("Part1"); }
    public function buildPart2() { $this->_product->add("Part2"); }
    public function getResult() { return $this->_product; }
}

class Director {
    public function __construct(Builder $builder) {
        $builder->buildPart1();
        $builder->buildPart2();
    }
}

// client
$buidler = new ConcreteBuilder();
$director = new Director($buidler);
$product = $buidler->getResult();
?>
```

以下情况应当使用建造者模式：
1. 需要生成的产品对象有复杂的内部结构。
2. 需要生成的产品对象的属性相互依赖，建造者模式可以强迫生成顺序。
3. 在对象创建过程中会使用到系统中的一些其它对象，这些对象在产品对象的创建过程中不易得到。

使用建造者模式主要有以下效果：
1. 建造者模式的使用使得产品的内部表象可以独立的变化。使用建造者模式可以使客户端不必知道产品内部组成的细节。
2. 每一个Builder都相对独立，而与其它的Builder无关。
3. 模式所建造的最终产品更易于控制。

## 优缺点
- 优点

建造者模式可以很好的将一个对象的实现与相关的“业务”逻辑分离开来，从而可以在不改变事件逻辑的前提下，使增加(或改变)实现变得非常容易。

- 缺点
建造者接口的修改会导致所有执行类的修改。

## 大话设计模式

```php
<?php 

//画小人

abstract class PersonBuilder
{
    abstract public function BuildHead();
    abstract public function BuildBody();
    abstract public function BuildArmLeft();
    abstract public function BuildArmRight();
    abstract public function BuildLegLeft();
    abstract public function BuildLegRight();
}

class PersonThinBuilder extends PersonBuilder
{
    public function BuildHead()
    {
        echo "小头\n";
    }

    public function BuildBody()
    {
        echo "小身子\n";
    }

    public function BuildArmRight()
    {
        echo "右臂\n";
    }

    public function BuildArmLeft()
    {
        echo "左臂\n";
    }

    public function BuildLegLeft()
    {
        echo "左腿\n";
    }

    public function BuildLegRight()
    {
        echo "右腿\n";
    }
}

class PersonFatBuilder extends PersonBuilder
{
    public function BuildHead()
    {
        echo "大头\n";
    }

    public function BuildBody()
    {
        echo "大身子\n";
    }

    public function BuildArmRight()
    {
        echo "右臂\n";
    }

    public function BuildArmLeft()
    {
        echo "左臂\n";
    }

    public function BuildLegLeft()
    {
        echo "左腿\n";
    }

    public function BuildLegRight()
    {
        echo "右腿\n";
    }
}

class PersonDirector
{
    private $personBuilder;
    function __construct($personBuilder)
    {
        $this->personBuilder = $personBuilder;
    }

    public function CreatePerson()
    {
        $this->personBuilder->BuildHead();
        $this->personBuilder->BuildBody();
        $this->personBuilder->BuildArmRight();
        $this->personBuilder->BuildArmLeft();
        $this->personBuilder->BuildLegLeft();
        $this->personBuilder->BuildLegRight();
    }
}


//客户端代码

echo "苗条的:\n";
$thinDirector = new PersonDirector(new PersonThinBuilder());
$thinDirector->CreatePerson();

echo "\n胖的:\n";
$fatDirector = new PersonDirector(new PersonFatBuilder());
$fatDirector->CreatePerson();
```
### 建造者模式与工厂模式的区别：

我们可以看到，建造者模式与工厂模式是极为相似的，总体上，建造者模式仅仅只比工厂模式多了一个“导演类”的角色。在建造者模式的类图中，假如把这个导演类看做是最终调用的客户端，那么图中剩余的部分就可以看作是一个简单的工厂模式了。

与工厂模式相比，建造者模式一般用来创建更为复杂的对象，因为对象的创建过程更为复杂，因此将对象的创建过程独立出来组成一个新的类——导演类。也就是说，工厂模式是将对象的全部创建过程封装在工厂类中，由工厂类向客户端提供最终的产品；而建造者模式中，建造者类一般只提供产品类中各个组件的建造，而将具体建造过程交付给导演类。由导演类负责将各个组件按照特定的规则组建为产品，然后将组建好的产品交付给客户端。


## 模式应用

### 例子一
> 在很多游戏软件中，地图包括天空、地面、背景等组成部分，人物角色包括人体、服装、装备等组成部分，可以使用建造者模式对其进行设计，通过不同的具体建造者创建不同类型的地图或人物

如果我们想创造出有一个person类，我们通过实例化时设置的属性不同，让他们两人一个是速度快的小孩，一个是知识深的长者

```php
<?php
class person {
    public $age;
    public $speed;
    public $knowledge;
}
//抽象建造者类
abstract class Builder{
    public $_person;
    public abstract function setAge();
    public abstract function setSpeed();
    public abstract function setKnowledge();
    public function __construct(Person $person){
        $this->_person=$person;
    }
    public function getPerson(){
        return $this->_person;
    }
}
//长者建造者
class OlderBuider extends Builder{
    public function setAge(){
        $this->_person->age=70;
    }
    public function setSpeed(){
        $this->_person->speed="low";
    }
    public function setKnowledge(){
        $this->_person->knowledge='more';
    }
}
//小孩建造者
class ChildBuider extends Builder{
    public function setAge(){
        $this->_person->age=10;
    }
    public function setSpeed(){
        $this->_person->speed="fast";
    }
    public function setKnowledge(){
        $this->_person->knowledge='litte';
    }
}
//建造指挥者
class Director{
    private $_builder;
    public function __construct(Builder $builder){
        $this->_builder = $builder;
    }
    public function built(){
        $this->_builder->setAge();
        $this->_builder->setSpeed();
        $this->_builder->setKnowledge();
    }
}
//实例化一个长者建造者
$oldB = new OlderBuider(new Person);
//实例化一个建造指挥者
$director = new Director($oldB);
//指挥建造
$director->built();
//得到长者
$older = $oldB->getPerson();

var_dump($older);
```

### 例子二

我们接到了一个订单，是宝马公司和奔驰公司的，他们负责定义产品的零部件以及型号，我们负责生产，需求简单的描述就是这样。 我们需要为这个需求设计一个设计模式去更好的适应他们的需求。

首先我们需要一个车模型类，来定义好需要的所有零部件，这就叫做抽象类，之所以这样是因为我们还有可能接到更多公司的订单，比如劳斯莱斯，宾利。

然后由各自的车来继承这个抽象类，实现里面的方法。 

接下来就需要一个建造者抽象类，来定义建造各自的车需要的方法

然后由各自车建造者来继承这个抽象类。

```php
<?php

abstract class carModel{

    //这里存储所有组装车需要的零件
    public $spareParts = array();

    //车的名字
    public $carName = "";

    //增加轮子部件
    public abstract function addLunzi($xinghao);

    //增加外壳部件
    public abstract function addWaike($xinghao);

    //增加发动机部件
    public abstract function addFadongji($xinghao);

    //获取车，并给车取名字
    final public function getCar($carName){
        if($this->spareParts){
            $this->carName = $carName;
            //$k 代表部件名字
            //$v 代表型号
            foreach($this->spareParts as $k=>$v){
                $actionName = "add" . $k;
                $this->$actionName($v); 
            }
        }else{
            throw new Exception("没有汽车部件");
            
        }
    }
}


//定义具体的产品
class bmwCarModel extends carModel{

    public $spareParts = array();
    public $carName = "";

    public function addLunzi($xinghao){
        echo "宝马".$this->carName."的轮子，型号是" . $xinghao . "\n";
    }

    public function addWaike($xinghao){
        echo "宝马".$this->carName."的外壳，型号是" . $xinghao . "\n";
    }

    public function addFadongji($xinghao){
        echo "宝马".$this->carName."的发动机,型号是 " . $xinghao . "\n";
    }
}


//定义具体的产品
class benziCarModel extends carModel{

    public $spareParts = array();
    public $carName = "";

    public function addLunzi($xinghao){
        echo "奔驰".$this->carName."的轮子，型号是" . $xinghao . "\n";
    }

    public function addWaike($xinghao){
        echo "奔驰".$this->carName."的外壳，型号是" . $xinghao . "\n";
    }

    public function addFadongji($xinghao){
        echo "奔驰".$this->carName."的发动机,型号是 " . $xinghao . "\n";
    }
}



//定义建造者
abstract class carBuilder{
    public abstract function setSpareParts($partsName , $xinghao);

    public abstract function getCarModel($name);
}


class bmwBuilder extends carBuilder{
    private $bmwModel;

    public function __construct(){
        $this->bmwModel = new bmwCarModel();
    }

    public function setSpareParts($partsName , $xinghao){
        $this->bmwModel->spareParts[$partsName] = $xinghao;
    }

    public function getCarModel($name){
        $this->bmwModel->getCar($name);
    }
}


class benziBuilder extends carBuilder{
    private $benziModel;

    public function __construct(){
        $this->benziModel = new benziCarModel();
    }

    public function setSpareParts($partsName , $xinghao){
        $this->benziModel->spareParts[$partsName] = $xinghao;
    }

    public function getCarModel($name){
        $this->benziModel->getCar($name);
    }
}

//模拟客户端调用

//创建一辆宝马车，取名字为宝马x1

$bmwBuilder = new bmwBuilder();
$bmwBuilder->setSpareParts('Lunzi' , '牛逼轮子1号');
$bmwBuilder->setSpareParts('Waike' , '牛逼外壳1号');
$bmwBuilder->setSpareParts('Fadongji' , '牛逼发动机1号');
$bmwBuilder->getCarModel("宝马x1"); 
$bmwBuilder->getCarModel("宝马x1");  //连续创建两个宝马x1

//再创建一个宝马 没有外壳 取名为 宝马s5
$bmwBuilder = new bmwBuilder();
$bmwBuilder->setSpareParts('Lunzi' , '牛逼轮子2号');
$bmwBuilder->setSpareParts('Fadongji' , '牛逼发动机2号');
$bmwBuilder->getCarModel("宝马s5"); 
$bmwBuilder->getCarModel("宝马s5");  //连续创建两个宝马x1
```


## 总结：

- 建造者模式，将一个复杂对象的构建与它的表示分离，使得同样的构建过程可以创建不同的表示。

- 如果我们用了建造者模式，那么用户只需要指定需要建造的类型就可以得到他们，而具体建造的过程和细节就不需要知道了。

- 主要用于创建一些复杂的对象，这些对象内部构建间的建造顺序通常是稳定的，但对象内部的构建通畅面临着复杂的变化。

- 建造者模式是在当创建复杂对象的算法应该独立于改对象的组成部分以及它们的装配方式时适用的模式。