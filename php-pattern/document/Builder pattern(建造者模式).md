# 建造者模式
> 建造者模式是一种创建型模式，它可以让一个产品的内部表象和和产品的生产过程分离开，从而可以生成具有不同内部表象的产品。

## Builder模式中主要角色:

- 抽象建造者（Builder）角色：定义抽象接口，规范产品各个部分的建造，必须包括建造方法和返回方法。
- 具体建造者（Concrete）角色：实现抽象建造者接口。应用程序最终根据此角色中实现的业务逻辑创造产品。
- 导演（Director）角色：调用具体的建造者角色创造产品。
- 产品（Product）角色：在导演者的指导下所创建的复杂对象。

```$xslt
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

```$xslt
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

#### 总结：

- 建造者模式，将一个复杂对象的构建与它的表示分离，使得同样的构建过程可以创建不同的表示。

- 如果我们用了建造者模式，那么用户只需要指定需要建造的类型就可以得到他们，而具体建造的过程和细节就不需要知道了。

- 主要用于创建一些复杂的对象，这些对象内部构建间的建造顺序通常是稳定的，但对象内部的构建通畅面临着复杂的变化。

- 建造者模式是在当创建复杂对象的算法应该独立于改对象的组成部分以及它们的装配方式时适用的模式。