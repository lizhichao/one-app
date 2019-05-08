
one框架项目实例化

[框架文档地址](https://www.kancloud.cn/vic-one/php-one/826876)

分布式列子

## 安装

```shell
composer create-project lizhichao/one-app:dev-cloud_demo
```

## 启动步骤

### 服务1：
    
1. 给服务1取个名字： 配置`Config/cloud.php` `self_key=>server1`
2. 启动服务1 `php swoole.php protocol`

### 服务2：
    
1. 给服务2取个名字： 配置`Config/cloud.php` `self_key=>server2`
2. 启动服务2 `php swoole.php protocol2`

## 测试

client-1   
telnet 127.0.0.1 8081  
client-3  
telnet 127.0.0.1 8081

client-2  
telnet 127.0.0.1 8082  
client-4  
telnet 127.0.0.1 8082

`client-1`和`client-3` 是同一个服务，`client-2`和`client-4` 是同一个服务，他们都可以相互通讯。

服务1 和 服务2 例子是监听不同的端口，你可以分布在不同的机器上。你修改`Config/client.php`各自对应的地址即可。