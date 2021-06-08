@echo off
@REM Create a http server at /jukebox-playlist/Server
cd .\Server\
echo %cd%
php -S 127.0.0.1:3000