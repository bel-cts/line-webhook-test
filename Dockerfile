FROM php:8.2-apache

# เปิด mod_rewrite สำหรับใช้กับ .htaccess (ถ้าต้องการ)
RUN a2enmod rewrite

# Copy ไฟล์ทั้งหมดไปไว้ที่ /var/www/html
COPY . /var/www/html/

# เปิดให้ PHP Log Error ออก Console (ไว้ Debug ตอน Deploy)
RUN echo "error_log=/dev/stderr" >> /usr/local/etc/php/php.ini

EXPOSE 80
