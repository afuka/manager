# RITSC 后台模板

## 安装
- 1.composer 安装第三方拓展
```
composer install
```

- 2.更新配置信息
```
修改 .env 文件中的相关配置
```

- 3.生成迁移的数据库
```
# 生成库
php artisan migrate
# 生成测试数据
php artisan db:seed
```

- 4.服务器指向，配置到 项目 /public 中
