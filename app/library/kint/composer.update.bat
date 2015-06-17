@ECHO OFF
CD /d %~dp0
composer update >update.log
PAUSE