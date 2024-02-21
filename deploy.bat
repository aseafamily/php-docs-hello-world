@echo off
set "source_dir=C:\code\php-docs-hello-world"
set "destination_dir=Z:\WebStation\phpTest"

echo Copying .php files from %source_dir% to %destination_dir%...

xcopy /Y /S /I "%source_dir%\*.php" "%destination_dir%"

echo Copy completed.
