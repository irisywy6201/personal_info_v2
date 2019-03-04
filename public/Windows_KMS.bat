@echo off
cls
@Echo:
echo ==========執行 NCU KMS 認證程序==========
@Echo:
cscript C:\windows\system32\slmgr.vbs -skms kms-v4.cc.ncu.edu.tw 
@Echo:
cscript C:\windows\system32\slmgr.vbs -ato 
@Echo:
echo ==========看到「產品已啟用成功」，表示認證已完成。==========
@Echo:
pause