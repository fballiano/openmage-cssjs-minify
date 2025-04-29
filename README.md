CSS/JS Minify module for Maho, OpenMage and Magento1.
=====================================================

<table><tr><td align=center>
<strong>If you find my work valuable, please consider sponsoring</strong><br />
<a href="https://github.com/sponsors/fballiano" target=_blank title="Sponsor me on GitHub"><img src="https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=#white" alt="Sponsor me on GitHub" /></a>
<a href="https://www.buymeacoffee.com/fballiano" target=_blank title="Buy me a coffee"><img src="https://img.shields.io/badge/Buy_Me_A_Coffee-FFDD00?style=for-the-badge&logo=buy-me-a-coffee&logoColor=black" alt="Buy me a coffee" /></a>
<a href="https://www.paypal.com/paypalme/fabrizioballiano" target=_blank title="Donate via PayPal"><img src="https://img.shields.io/badge/PayPal-00457C?style=for-the-badge&logo=paypal&logoColor=white" alt="Donate via PayPal" /></a>
</td></tr></table>

Quick description
---------

A modern solution to minify CSS/JS in your OpenMage project.

Features
---------

- Uses the great matthiasmullie/minify library, with 26+M downloads is the most
  modern and supported minimization library for PHP
- Creates `media/fbminify` folder where the minified files are stored
- Changes to the original files are detected based on the modification timestamp
  of the files themselves
- A cron job will clean old copies of the minified files every night at 03:30

Warning
---------

This module is provided "as is" and I'll not be responsible for any problem or damage.

Installation
------------

Only composer installation is supported:
`composer require fballiano/openmage-cssjs-minify`

Make sure that CSS/JS merging (the one provided by OpenMage core) is disabled
(it's an old relic of the M1 era and it's not necessary anymore since HTTP2).

Technical documentation
-----------------------

Technical documentation is available on [https://deepwiki.com/fballiano/openmage-cssjs-minify](https://deepwiki.com/fballiano/openmage-cssjs-minify).

Support
-------
If you have any issues with this extension, open an issue on GitHub.

Contribution
------------
Any contributions are highly appreciated. The best way to contribute code is to open a
[pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Fabrizio Balliano  
[http://fabrizioballiano.com](http://fabrizioballiano.com)  
[@fballiano](https://twitter.com/fballiano)

Licence
-------
[OSL - Open Software Licence 3.0](https://opensource.org/license/osl-3)

Copyright
---------
(c) Fabrizio Balliano
