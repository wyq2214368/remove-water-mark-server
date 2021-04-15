# 短视频去水印小帮手-服务端

短视频去水印系列教程服务端源码。php版

> 这里不过多介绍，我假设您有基本的编码基础，并熟悉php语言及laravel框架。

## 安装
请先确保 [composer](https://docs.phpcomposer.com/00-intro.html) 已安装。（如使用laravels，还需确认[swoole](https://wiki.swoole.com/wiki/page/6.html)扩展已安装）

>如未安装可根据链接中的官方文档进行安装

1. 克隆代码
    ```
    git clone https://github.com/wyq2214368/remove-water-mark-server.git
    ```

2. composer安装依赖
    ```
    composer install
    ```
    
   >以下的步骤是laravel及laravels的相关配置，您可以选择使用 `php artisan install` 指令一键完成。或根据相应文档完成设置
3. 创建.env文件
    ```
    cp .env.example .env
    ```
    
    编辑.env文件，设置你自己的微信小程序appi和secret
    
    ```
    WECHAT_MINI_PROGRAM_APPID=这里填你自己的appid
    WECHAT_MINI_PROGRAM_SECRET=这里填你自己的secret
    ```
    
4. 生成laravel的key
    ```
    php artisan key:generate
    ```

5. 文件夹权限设置
    ```
    chmod -R 777 storage/
    chmod -R 777 bootstrap/cache/
    ```
    >可视情况合理分配需要的权限
    
    或分配php-fpm进程用户为所有者
    ```bash
    choown -R apache:apache ./
    ```
6. 生成数据表
    请先到config/database.php文件修改数据库信息，之后执行
    ```
    php artisan migrate
    ```
    自动生成数据表    
7. 启动服务
    ```
    php artisan serve
    ```
    > 如果您不想启动laravel server而是使用laravel是服务，可以通过 `php artisan install` 指令启动laravels服务，或通过[laravels文档](https://github.com/hhxsv5/laravel-s/blob/master/README-CN.md#%E7%89%B9%E6%80%A7)自行启动
    
8. 访问并测试服务
   
   服务启动后可将小程序app.js中的globalData.apiDomain设置为： http://127.0.0.1:8000/api
    > 如您启动的laravels服务，则需要使用laravels配置的端口(默认是 5200)
    
以上，可以直接打开小程序访问了。

可扫码预览：

![在这里插入图片描述](https://img-blog.csdnimg.cn/20201221145928601.jpg)


<hr style=" border:solid; width:100px; height:1px;" color=#000000 size=1">

# 系列文章
- [手把手教你做短视频去水印微信小程序（0-概述）](https://editor.csdn.net/md/?articleId=111474557)
- [手把手教你做短视频去水印微信小程序（1-封装网络请求&登陆逻辑）](https://blog.csdn.net/qq_37788558/article/details/111500382)
- [手把手教你做短视频去水印微信小程序（2-首页）](https://blog.csdn.net/qq_37788558/article/details/111500382)
- [手把手教你做短视频去水印微信小程序（3-个人中心）](https://blog.csdn.net/qq_37788558/article/details/111478258)
- [手把手教你做短视频去水印微信小程序（4-转换结果页）](https://blog.csdn.net/qq_37788558/article/details/111588413)
- [手把手教你做短视频去水印微信小程序（5-服务端代码）](https://blog.csdn.net/qq_37788558/article/details/112204720)
- [手把手教你做短视频去水印微信小程序（6-广告代码）](https://blog.csdn.net/qq_37788558/article/details/112559472)
# github源码地址
欢迎star～
- [短视频去水印小程序源码-小程序端](https://github.com/wyq2214368/remove-water-mark-mp)
- [短视频去水印小程序源码-服务端（php）](https://github.com/wyq2214368/remove-water-mark-server)

## License

[MIT](https://github.com/wyq2214368/laravel-jieba/blob/master/LICENSE)
