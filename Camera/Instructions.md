# Raspberry Pi Camera module setup : 

System: Mac OS X Yosemite, 16 GB SD card 

Unmout the SD card to overwrite the disk : 
diskutil unmountDisk /dev/disk<disk# from diskutil>

copy the image to the sd card :

sudo dd bs=1m if=2016-02-09-raspbian-jessie.img of=/dev/rdisk4

Step 2 : 
configure the Raspberry pi with edimax wireless adapter : 
sudo vi /etc/network/interfaces 
allow-hotplug wlan0 
iface wlan0 inet dhcp 
wpa-ssid "YOUR NETWORK SSID"
wpa-psk "WIFI PASSWORD"

sudo reboot 

Step 3 : 


