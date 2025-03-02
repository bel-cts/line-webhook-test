FROM php:8.1-apache

# เปิดให้ php://input ใช้ได้
RUN docker-php-ext-install mysqli

# ก๊อปไฟล์ทุกอย่างไปที่ /var/www/html
COPY . /var/www/html/

# เปิดพอร์ต 80
EXPOSE 80
