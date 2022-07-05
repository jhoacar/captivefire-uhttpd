FROM openwrtorg/rootfs:x86-64

USER root

# Install Server Dependencies 
RUN mkdir /var/lock && \
    opkg update && opkg install \
    uhttpd \
    php8 \
    php8-cgi
    
# Install PHP Extensions
RUN opkg install \
    php8-mod-iconv \
    php8-mod-phar




# using exec format so that /sbin/init is proc 1 (see procd docs)
CMD ["/sbin/init"]