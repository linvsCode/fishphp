# 压力测试工具ab

## 命令

```php
$ ab -n1000 -c20 www.baidu.com

//命令详解

n : 请求数
c : 并发数

大话：20人同时搜索百度，并搜索了50次

```
## 重要参数

```php
Requests per second: 101.65[#/sec] //每秒接受请求数 ，接受数量越多，网站性能更好
Time per request:9.838[ms]  //请求耗时，页面响应时间，耗时越小，网站响应时间越短，用户体验更佳
```

# PHP代码运行流程

//待补充

# 禁用错误抑制符

- 会在代码执行开始前和结束后增加opcode,忽略报错

- 可使用 PHP vld 扩展 查看代码运行的opcode
```php
>> php -dvld.active=1 -dvld.execute=0 test.php
//参数说明
dvld.active=1 :开启vld扩展
dvld.execute=0 :只看执行过程
```

# 减少PHP魔法函数的使用

# 避免在循环内做运算

```php
<?php
    $str =  "hello world";
    for ($i = 0;$i<strlen($str)$i++) {
        //....
    }
```

# 减少计算密集型业务

# 减少文件类操作

# 减少PHP发起网络请求

- 设置超时时间
1. 连接超时 200ms
2. 读超时 800ms
3. 写超时 500ms
- 串行请求并行化
1.使用curl_multi_*()
2.swoole

# 压缩PHP输出


# xhprof工具分析PHP性能

