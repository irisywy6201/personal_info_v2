@echo off
echo ���� Microsoft Office 2016 �w�˥ؿ�

if exist "C:\Program Files\Microsoft Office\Office16\OSPP.VBS" (goto pathProgramFiles) else goto pathProgramFiles86 

:pathProgramFiles
set officepath="C:\Program Files\Microsoft Office\Office16\"
@Echo:
echo �]�w KMS ���_�޲z���A��
cscript %officepath%OSPP.VBS /sethst:kms-v4.cc.ncu.edu.tw
@Echo:
echo �Ұ� Microsoft Office 2016
cscript %officepath%OSPP.VBS /act 
@Echo:
echo �Ұʵ{�ǰ��槹��
echo �p�G��ܡuProduct activation successful�v��ܻ{�ҨB�J���\�����F�I
goto commonexit

:pathProgramFiles86
if exist "C:\Program Files (x86)\Microsoft Office\Office16\OSPP.VBS" set officepath="C:\Program Files (x86)\Microsoft Office\Office16\"
if not exist "C:\Program Files (x86)\Microsoft Office\Office16\OSPP.VBS" goto pathNotFound
@Echo:
echo �]�w KMS ���_�޲z���A��
cscript %officepath%OSPP.VBS /sethst:kms-v4.cc.ncu.edu.tw
@Echo:
echo �Ұ� Microsoft Office 2016
cscript %officepath%OSPP.VBS /act 
@Echo:
echo �Ұʵ{�ǰ��槹��
echo �p�G��ܡuProduct activation successful�v��ܻ{�ҨB�J���\�����F�I
goto commonexit

:pathNotFound
@Echo:
echo �нT�{�A��Microsoft Office 2016 �w�˥ؿ����C:\Program Files\Microsoft Office\Office16\��C:\Program Files (x86)\Microsoft Office\Office16\���U
@Echo:
goto commonexit

:commonexit
pause
