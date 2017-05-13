set day=%date:~0,2%
set mon=%date:~3,2%
set yea=%date:~8,2%
set h=%TIME:~0,2%
set m=%TIME:~3,2%
set s=%TIME:~6,2%
set ms=%TIME:~9,2%
set curtime=%h%.%m%.%s%.%ms%

rem log собирать за день
set nflog=beta_%yea%-%mon%-%day%.log
rem содержимое выводить каждый раз

set nfcontent1=beta_%yea%-%mon%-%day%_%curtime%_operation_attr.txt
set nfcontent2=beta_%yea%-%mon%-%day%_%curtime%_tracker_crm.txt
set nfcontent3=beta_%yea%-%mon%-%day%_%curtime%_get_tracking.txt
set nfcontent4=beta_%yea%-%mon%-%day%_%curtime%_status_crm.txt


"c:\Program Files (x86)\GnuWin32\bin\wget.exe" -O "wget_log\%nfcontent1%" -a "wget_log\%nflog%" "http://localsite/beta_post/update_operation_attr.php"

rem pause 5 sec
ping 127.0.0.1 -n 6 > nul

"c:\Program Files (x86)\GnuWin32\bin\wget.exe" -O "wget_log\%nfcontent2%" -a "wget_log\%nflog%" "http://localsite/beta_post/update_tracker_crm.php"

rem pause 5 sec
ping 127.0.0.1 -n 6 > nul

"c:\Program Files (x86)\GnuWin32\bin\wget.exe" -O "wget_log\%nfcontent3%" -a "wget_log\%nflog%" "http://localsite/beta_post/update_status_get_tracking.php"

rem pause 5 sec
ping 127.0.0.1 -n 6 > nul

"c:\Program Files (x86)\GnuWin32\bin\wget.exe" -O "wget_log\%nfcontent4%" -a "wget_log\%nflog%" "http://localsite/beta_post/update_status_crm.php"
