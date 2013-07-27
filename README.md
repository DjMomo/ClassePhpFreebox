apifreebox
==========

An API to control Freebox Revolution

https://github.com/DjMomo/apifreebox

==========

2013-05-23 - V1.0 - Initial version

==========
Configuration :

Insert your freebox password into mafreebox.cfg file

==========
How to use :

Extract all informations about Server into XML format :
> http://IP/freebox.php

Switch Wifi AP OFF :
> http://IP/freebox.php?do=wifi_off

Switch Wifi AP ON :
> http://IP/freebox.php?do=wifi_on

Reboot box :
> http://IP/freebox.php?do=reboot

Reboot box after XX seconds :
> http://IP/freebox.php?do=reboot&val=XX

Change LCD luminosity to XX% :
> http://IP/freebox.php?do=lcd&val=XX
