@echo off
echo 偵測 Microsoft Office 2016 安裝目錄

if exist "C:\Program Files\Microsoft Office\Office16\OSPP.VBS" (goto pathProgramFiles) else goto pathProgramFiles86 

:pathProgramFiles
set officepath="C:\Program Files\Microsoft Office\Office16\"
@Echo:
echo 設定 KMS 金鑰管理伺服器
cscript %officepath%OSPP.VBS /sethst:kms-v4.cc.ncu.edu.tw
@Echo:
echo 啟動 Microsoft Office 2016
cscript %officepath%OSPP.VBS /act 
@Echo:
echo 啟動程序執行完成
echo 如果顯示「Product activation successful」表示認證步驟成功完成了！
goto commonexit

:pathProgramFiles86
if exist "C:\Program Files (x86)\Microsoft Office\Office16\OSPP.VBS" set officepath="C:\Program Files (x86)\Microsoft Office\Office16\"
if not exist "C:\Program Files (x86)\Microsoft Office\Office16\OSPP.VBS" goto pathNotFound
@Echo:
echo 設定 KMS 金鑰管理伺服器
cscript %officepath%OSPP.VBS /sethst:kms-v4.cc.ncu.edu.tw
@Echo:
echo 啟動 Microsoft Office 2016
cscript %officepath%OSPP.VBS /act 
@Echo:
echo 啟動程序執行完成
echo 如果顯示「Product activation successful」表示認證步驟成功完成了！
goto commonexit

:pathNotFound
@Echo:
echo 請確認你的Microsoft Office 2016 安裝目錄位於C:\Program Files\Microsoft Office\Office16\或C:\Program Files (x86)\Microsoft Office\Office16\底下
@Echo:
goto commonexit

:commonexit
pause
