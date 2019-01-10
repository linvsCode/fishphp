[toc]

# 单例模式

> 实现单例模式的思路：一个类能返回对象一个引用(永远是同一个)和一个获得该实例的方法（必须是静态方法，通常使用getInstance这个名称）；当我们调用这个方法时，如果类持有的引用不为空就返回这个引用，如果类保持的引用为空就创建该类的实例并将实例的引用赋予该类保持的引用；同时我们还将该类的构造函数定义为私有方法，这样其他处的代码就无法通过调用该类的构造函数来实例化该类的对象，只有通过该类提供的静态方法来得到该类的唯一实例。

**创造单例注意：**

　　1、一个类只能有一个类对象（只能实例化一个对象）

　　2、它必须自己创建这个实例

　　3、它必须自行向整个系统提供这个实例

　　4、构造函数和克隆函数必须声明为私有的,这是为了防止外部程序 new 类从而失去单例模式的意义

　　5、 getInstance()方法必须声明为公有的,必须调用此方法以返回唯一实例的一个引用

　　6、拥有一个保存类的实例的静态成员变量

　　7、PHP的单例模式是相对而言的,因为PHP的解释运行机制使得每个PHP页面被解释执行后，所有的相关资源都会被回收

　　8、拥有一个访问这个实例的公共的静态方法（常用getInstance()方法进行实例化单例类，通过instanceof操作符可以检测到类是否已经被实例化）

　　另外，需要创建__clone()方法防止对象被复制（克隆）
## 单例模式中主要角色
- Singleton定义一个getInstance操作，允许客户访问它唯一的实例。
   
这个例子也简单，就像我有6个老婆（快醒醒!），她们在喊”老公”的时候都是指我。不管什么时候，喊老公擦地，做饭，洗衣服都是指同一个人，多线程时候一定得考虑到抢占问题！老公是不可以边擦地边做饭的！（swoole之类的框架实现方法）

## 适用性

- 当类只能有一个实例而且客户可以从一个众所周知的访问点访问它时
- 当这个唯一实例应该是通过子类化可扩展的。并且用户应该无需更改代码就能使用一个扩展的实例时。

```php
<?php
class Singleton {
    private static $_instance = NULL;

    // 私有构造方法
    private function __construct() {}

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new Singleton();
        }
        return self::$_instance;
    }

    // 防止克隆实例
    public function __clone(){
        die('Clone is not allowed.' . E_USER_ERROR);
    }
}
?>
```
在此实例中，Singleton禁止了克隆及外部初始化，使得此类只可以通过getInstance()方法来获得实例，而这个实例只会在第一次使用时创建，以后每次都获得同一实例。

## 优缺点
### 优点
- 对唯一实例的受控访问
- 缩小命名空间 单例模式是对全局变量的一种改进。它避免了那些存储唯一实例的全局变量污染命名空间
- 允许对操作和表示的精华，单例类可以有子类。而且用这个扩展类的实例来配置一个应用是很容易的。你可以用你所需要的类的实例在运行时刻配置应用。
- 允许可变数目的实例（多例模式）
- 比类操作更灵活
### 缺点
- 单例模式在多线程的应用场合下必须小心使用。如果当唯一实例尚未创建时，有两个线程同时调用创建方法，那么它们同时没有检测到唯一实例的存在，从而同时各自创建了一个实例，这样就有两个实例被构造出来，从而违反了单例模式中实例唯一的原则。解决这个问题的办法是为指示类是否已经实例化的变量提供一个互斥锁(虽然这样会降低效率)。

## 大话设计模式

```php
<?php 

class Singleton
{
    private static $instance;

    private function __construct(){}

    public static function getInstance()
    {
        if (static::$instance == null) 
        {
            static::$instance == new Singleton();
        }
        return static::$instance;
    }
}


//客户端代码
$s1 = Singleton::getInstance();
$s2 = Singleton::getInstance();

if ($s1 == $s2) 
{
    echo "same class";
}
```

### 模式应用

1. php的应用主要在于数据库应用, 一个应用中会存在大量的数据库操作, 在使用面向对象的方式开发时, 如果使用单例模式,
则可以避免大量的new 操作消耗的资源,还可以减少数据库连接这样就不容易出现 too many connections情况。

2. 如果系统中需要有一个类来全局控制某些配置信息, 那么使用单例模式可以很方便的实现. 这个可以参看zend Framework的FrontController部分。

3. 在一次页面请求中, 便于进行调试, 因为所有的代码(例如数据库操作类db)都集中在一个类中, 我们可以在类中设置钩子, 输出日志，从而避免到处var_dump, echo

#### 使用Trait关键字实现类似于继承单例类的功能

```php
<?php
Trait Singleton{
        //存放实例
        private static $_instance = null;
        //私有化克隆方法
        private function __clone(){

        }

        //公有化获取实例方法
        public static function getInstance(){
            $class = __CLASS__;
            if (!(self::$_instance instanceof $class)){
                self::$_instance = new $class();
            }
            return self::$_instance;
        }
    }

class DB {
    private function __construct(){
        echo __CLASS__.PHP_EOL;
    }
}

class DBhandle extends DB {
    use Singleton;
    private function __construct(){
        echo "单例模式的实例被构造了";
    }
}
$handle=DBhandle::getInstance();

//注意若父类方法为public，则子类只能为pubic，若父类为private，子类为public ，protected，private都可以。

```
#### 建立数据库连接

```php
<?php
//参考 https://www.cnblogs.com/Steven-shi/p/5858229.html 
class DBHelper
{
    private $link;
    static private $_instance;

    // 连接数据库
    private function __construct($host, $username, $password)
    {
        $this->link = mysqli_connect($host, $username, $password);
        $this->query("SET NAMES 'utf8'", $this->link);
        //echo mysql_errno($this->link) . ": " . mysql_error($link). "n";
        //var_dump($this->link);
        return $this->link;
    }
    private function __clone()
    {
    }
    public static function get_class_nmdb($host, $username, $password)
    {
        //$connector = new nmdb($host, $username, $password);
        //return $connector;

        if (FALSE == (self::$_instance instanceof self)) {
            self::$_instance = new self($host, $username, $password);
        }
        return self::$_instance;
    }
    // 连接数据表
    public function select_db($database)
    {
        $this->result = mysql_select_db($database);
        return $this->result;
    }
    // 执行SQL语句
    public function query($query)
    {
        return $this->result = mysql_query($query, $this->link);
    }
    // 将结果集保存为数组
    public function fetch_array($fetch_array)
    {
        return $this->result = mysql_fetch_array($fetch_array, MYSQL_ASSOC);
    }
    // 获得记录数目
    public function num_rows($query)
    {
        return $this->result = mysql_num_rows($query);
    }
    // 关闭数据库连接
    public function close()
    {
        return $this->result = mysql_close($this->link);
    }
}
$connector = DBHelper::get_class_nmdb($host, $username, $password);
$connector -> select_db($database);
?>
```


## 总结：

- 单例模式，保证一个类仅有一个实例，并提供一个访问它的全局访问点。

- 单例模式因为Singleton类封装它的唯一实例，这样它可以严格地控制客户怎样访问以及何时访问它。简单地说就是对唯一实例的受控访问。

