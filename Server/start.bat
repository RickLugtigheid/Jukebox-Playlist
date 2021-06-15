@echo off
@REM Create a http server at /jukebox-playlist/Server
cd .\Server\
echo %cd%
@REM Use 0.0.0.0 to make the port accessible to any interface
php -S 0.0.0.0:3000