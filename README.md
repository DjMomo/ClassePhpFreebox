apifreebox
==========

Une classe PHP pour contrôler sa Freebox Révolution -Server- sous Freebox OS

https://github.com/DjMomo/ClassePhpFreebox

==========

2013-07-27 - V1.0 - Version initiale

==========
Configuration :

Aucune. Il vous suffit tout simplement d'autoriser l'application en appuyant suur la flèche droite de l'afficheur de votre Freebox Server la toute première fois que vous l'utilisez. 
A noter que par défaut, les applications autorisées n'ont pas accès à la partie Configuration de la Freebox Server. Cela ce donne dans le menu "Gestion des accès" de la partie "Paramètres de la Freebox".

==========
Quelques exemples d'utilisation :

Extraire toutes les iformations de la Freebox Server sous un format XML :
> http://IP/freebox.php

Arrêter le point d'accès Wifi :
> http://IP/freebox.php?do=wifi&val=off

Allumer le point d'accès WIfi :
> http://IP/freebox.php?do=wifi&val=on

Rebooter la box :
> http://IP/freebox.php?do=reboot

Changer la luminosité du LCD à XX% :
> http://IP/freebox.php?do=lcd_brightness&val=XX
