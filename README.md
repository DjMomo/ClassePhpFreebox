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

==========
License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/.
