# Raspberry Pi Camera module setup : 

System: Mac OS X Yosemite, 16 GB SD card 

1. Unmout the SD card to overwrite the disk : 
 
   `diskutil unmountDisk /dev/disk<disk# from diskutil>`

2. copy the image to the sd card :

  `sudo dd bs=1m if=2016-02-09-raspbian-jessie.img of=/dev/rdisk#`

3. configure the Raspberry pi with edimax wireless adapter. Add this to your interfaces file.

  `sudo vi /etc/network/interfaces`
  
   `allow-hotplug wlan0 `
   
   `iface wlan0 inet dhcp`
   
   `wpa-ssid "YOUR NETWORK SSID"`
   
   `wpa-psk "WIFI PASSWORD"`
   
4. Reboot

    `sudo reboot`

5. [Connect the camera module to raspberry pi.](https://www.youtube.com/watch?v=DosQ0V39WAA)
6. Test the camera : 

  `Raspistill -o  -v cam.jpg`


