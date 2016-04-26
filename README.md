# Raspberry Pi Camera module setup : 

System: Mac OS X Yosemite, 16 GB SD card 

A. diskutil list 

1. Unmout the SD card to overwrite the disk : 
 
   `diskutil unmountDisk /dev/disk<disk# from diskutil>`

2. Start fdisk to partition the SD card: 
   `fdisk /dev/<#>`

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

## For the Streaming : 

- A pi 2 is necessary, camera module
- Install python 2.7 or higher (apt-get install python)
- Install OpenCV (apt-get install python-opencv)
- In raspbian config enable the pi camera module
- Enable driver for camera module (sudo modprobe bcm2835-v4l2)
- Uninstall all python dependencies
- Install flask, flask socketio, peewee, flask login, flask bcrypt, flask wtf, flask request
- Start webserver and application
- Go to localhost. (default admin user)



