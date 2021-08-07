<?php

//   -------------------------------------------------------------------------------
//  |                  net2ftp: a web based FTP client                              |
//  |              Copyright (c) 2003-2013 by David Gartner                         |
//  |                                                                               |
//  | This program is free software; you can redistribute it and/or                 |
//  | modify it under the terms of the GNU General Public License                   |
//  | as published by the Free Software Foundation; either version 2                |
//  | of the License, or (at your option) any later version.                        |
//  |                                                                               |
//   -------------------------------------------------------------------------------

//   -------------------------------------------------------------------------------
//  | For credits, see the credits.txt file                                         |
//   -------------------------------------------------------------------------------
//  |                                                                               |
//  |                              INSTRUCTIONS                                     |
//  |                                                                               |
//  |  The messages to translate are listed below.                                  |
//  |  The structure of each line is like this:                                     |
//  |     $message["Hello world!"] = "Hello world!";                                |
//  |                                                                               |
//  |  Keep the text between square brackets [] as it is.                           |
//  |  Translate the 2nd part, keeping the same punctuation and HTML tags.          |
//  |                                                                               |
//  |  The English message, for example                                             |
//  |     $message["net2ftp is written in PHP!"] = "net2ftp is written in PHP!";    |
//  |  should become after translation:                                             |
//  |     $message["net2ftp is written in PHP!"] = "net2ftp est ecrit en PHP!";     |
//  |     $message["net2ftp is written in PHP!"] = "net2ftp is geschreven in PHP!"; |
//  |                                                                               |
//  |  Note that the variable starts with a dollar sign $, that the value is        |
//  |  enclosed in double quotes " and that the line ends with a semi-colon ;       |
//  |  Be careful when editing this file, do not erase those special characters.    |
//  |                                                                               |
//  |  Some messages also contain one or more variables which start with a percent  |
//  |  sign, for example %1\$s or %2\$s. The English message, for example           |
//  |     $messages[...] = ["The file %1\$s was copied to %2\$s "]                  |
//  |  should becomes after translation:                                            |
//  |     $messages[...] = ["Le fichier %1\$s a t copi vers %2\$s "]             |
//  |                                                                               |
//  |  When a real percent sign % is needed in the text it is entered as %%         |
//  |  otherwise it is interpreted as a variable. So no, it's not a mistake.        |
//  |                                                                               |
//  |  Between the messages to translate there is additional PHP code, for example: |
//  |      if ($net2ftp_globals["state2"] == "rename") {           // <-- PHP code  |
//  |          $net2ftp_messages["Rename file"] = "Rename file";   // <-- message   |
//  |      }                                                       // <-- PHP code  |
//  |  This code is needed to load the messages only when they are actually needed. |
//  |  There is no need to change or delete any of that PHP code; translate only    |
//  |  the message.                                                                 |
//  |                                                                               |
//  |  Thanks in advance to all the translators!                                    |
//  |  David.                                                                       |
//  |                                                                               |
//   -------------------------------------------------------------------------------


// -------------------------------------------------------------------------
// Language settings
// -------------------------------------------------------------------------

// HTML lang attribute
$net2ftp_messages["en"] = "ja";

// HTML dir attribute: left-to-right (LTR) or right-to-left (RTL)
$net2ftp_messages["ltr"] = "ltr";

// CSS style: align left or right (use in combination with LTR or RTL)
$net2ftp_messages["left"] = "left";
$net2ftp_messages["right"] = "right";

// Encoding
$net2ftp_messages["iso-8859-1"] = "euc-jp";


// -------------------------------------------------------------------------
// Status messages
// -------------------------------------------------------------------------

// When translating these messages, keep in mind that the text should not be too long
// It should fit in the status textbox

$net2ftp_messages["Connecting to the FTP server"] = "FTPサーバに接続しています";
$net2ftp_messages["Logging into the FTP server"] = "FTPサーバにログインしています";
$net2ftp_messages["Setting the passive mode"] = "パッシブモードの設定をしています";
$net2ftp_messages["Getting the FTP system type"] = "FTPシステム種別を取得しています";
$net2ftp_messages["Changing the directory"] = "ディレクトリを変更しています";
$net2ftp_messages["Getting the current directory"] = "カレントディレクトリを取得しています";
$net2ftp_messages["Getting the list of directories and files"] = "ディレクトリとファイルのリストを取得しています";
$net2ftp_messages["Parsing the list of directories and files"] = "ディレクトリとファイルのリストを解析しています";
$net2ftp_messages["Logging out of the FTP server"] = "FTPサーバからログアウトしています";
$net2ftp_messages["Getting the list of directories and files"] = "ディレクトリとファイルのリストを取得しています";
$net2ftp_messages["Printing the list of directories and files"] = "ディレクトリとファイルのリストを表示しています";
$net2ftp_messages["Processing the entries"] = "エントリの処理をしています";
$net2ftp_messages["Processing entry %1\$s"] = "エントリ %1\$s を処理しています";
$net2ftp_messages["Checking files"] = "ファイルチェックをしています";
$net2ftp_messages["Transferring files to the FTP server"] = "ファイルを FTPサーバに転送しています";
$net2ftp_messages["Decompressing archives and transferring files"] = "アーカイブを解凍し、ファイルを転送しています";
$net2ftp_messages["Searching the files..."] = "ファイルの検索中...";
$net2ftp_messages["Uploading new file"] = "新しいファイルをアップロードしています";
$net2ftp_messages["Reading the file"] = "ファイルを読み込んでいます";
$net2ftp_messages["Parsing the file"] = "ファイルを解析しています";
$net2ftp_messages["Reading the new file"] = "新しいファイルの読み込んでいます";
$net2ftp_messages["Reading the old file"] = "古いファイルを読み込んでいます";
$net2ftp_messages["Comparing the 2 files"] = "2つのファイルを比較しています";
$net2ftp_messages["Printing the comparison"] = "差分を表示しています";
$net2ftp_messages["Sending FTP command %1\$s of %2\$s"] = "FTPコマンドを送信中 %2\$s の %1\$s";
$net2ftp_messages["Getting archive %1\$s of %2\$s from the FTP server"] = "Getting archive %1\$s of %2\$s from the FTP server";
$net2ftp_messages["Creating a temporary directory on the FTP server"] = "Creating a temporary directory on the FTP server";
$net2ftp_messages["Setting the permissions of the temporary directory"] = "Setting the permissions of the temporary directory";
$net2ftp_messages["Copying the net2ftp installer script to the FTP server"] = "Copying the net2ftp installer script to the FTP server";
$net2ftp_messages["Script finished in %1\$s seconds"] = "スクリプトは %1\$s 秒で終了しました";
$net2ftp_messages["Script halted"] = "スクリプトは停止しました";

// Used on various screens
$net2ftp_messages["Please wait..."] = "しばらくお待ち下さい...";


// -------------------------------------------------------------------------
// index.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unexpected state string: %1\$s. Exiting."] = "予期しないステート文字: %1\$s 終了します。";
$net2ftp_messages["This beta function is not activated on this server."] = "この仮機能はこのサーバでは稼動しません。";
$net2ftp_messages["This function has been disabled by the Administrator of this website."] = "この機能はサイトの管理者によって無効にされています。";


// -------------------------------------------------------------------------
// /includes/browse.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["The directory <b>%1\$s</b> does not exist or could not be selected, so the directory <b>%2\$s</b> is shown instead."] = "ディレクトリ <b>%1\$s</b> は存在しないか、選択することができません。ディレクトリ <b>%2\$s</b> が代わりに表示されました。";
$net2ftp_messages["Your root directory <b>%1\$s</b> does not exist or could not be selected."] = "あなたのルートディレクトリ <b>%1\$s</b> は存在しないか、選択することができません。";
$net2ftp_messages["The directory <b>%1\$s</b> could not be selected - you may not have sufficient rights to view this directory, or it may not exist."] = "ディレクトリ <b>%1\$s</b> を選択することができません - あなたにはこのディレクトリを閲覧する十分な資格がないか、またはディレクトリが存在しません。";
$net2ftp_messages["Entries which contain banned keywords can't be managed using net2ftp. This is to avoid Paypal or Ebay scams from being uploaded through net2ftp."] = "Entries which contain banned keywords can't be managed using net2ftp. This is to avoid Paypal or Ebay scams from being uploaded through net2ftp.";
$net2ftp_messages["Files which are too big can't be downloaded, uploaded, copied, moved, searched, zipped, unzipped, viewed or edited; they can only be renamed, chmodded or deleted."] = "Files which are too big can't be downloaded, uploaded, copied, moved, searched, zipped, unzipped, viewed or edited; they can only be renamed, chmodded or deleted.";
$net2ftp_messages["Execute %1\$s in a new window"] = "%1\$s を新しいウィンドウで実行";


// -------------------------------------------------------------------------
// /includes/main.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Please select at least one directory or file!"] = "最低1つ以上のディレクトリ又はファイルを選択して下さい!";


// -------------------------------------------------------------------------
// /includes/authorizations.inc.php
// -------------------------------------------------------------------------

// checkAuthorization()
$net2ftp_messages["The FTP server <b>%1\$s</b> is not in the list of allowed FTP servers."] = "FTPサーバ <b>%1\$s</b> は、許可されたFTPサーバのリストに入っていません。";
$net2ftp_messages["The FTP server <b>%1\$s</b> is in the list of banned FTP servers."] = "FTPサーバ<b>%1\$s</b>は、 禁止されたFTPサーバのリストに入っています。";
$net2ftp_messages["The FTP server port %1\$s may not be used."] = "FTPサーバポート %1\$s は使用できません。";
$net2ftp_messages["Your IP address (%1\$s) is not in the list of allowed IP addresses."] = "Your IP address (%1\$s) is not in the list of allowed IP addresses.";
$net2ftp_messages["Your IP address (%1\$s) is in the list of banned IP addresses."] = "あなたのIPアドレス(%1\$s)は、禁止されたIPアドレスのリストに入っています。";

// isAuthorizedDirectory()
$net2ftp_messages["Table net2ftp_users contains duplicate rows."] = "テーブル net2ftp_users に重複した行が含まれています。";

// checkAdminUsernamePassword()
$net2ftp_messages["You did not enter your Administrator username or password."] = "管理者のユーザ名かパスワードを入力してません。";
$net2ftp_messages["Wrong username or password. Please try again."] = "誤ったユーザ名かパスワードです。やり直してください。";

// -------------------------------------------------------------------------
// /includes/consumption.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unable to determine your IP address."] = "あなたの IPアドレスを判別することができません。";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress contains duplicate rows."] = "テーブル net2ftp_log_consumption_ipaddress に重複した行が含まれています。";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver contains duplicate rows."] = "テーブル net2ftp_log_consumption_ftpserver に重複した行が含まれています。";
$net2ftp_messages["The variable <b>consumption_ipaddress_datatransfer</b> is not numeric."] = "変数 <b>consumption_ipaddress_datatransfer</b> は数値ではありません。";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress could not be updated."] = "テーブル net2ftp_log_consumption_ipaddress は更新不可です。";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress contains duplicate entries."] = "テーブル net2ftp_log_consumption_ipaddress に重複したエントリが含まれています。";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver could not be updated."] = "テーブル net2ftp_log_consumption_ftpserver は更新不可です。";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver contains duplicate entries."] = "テーブル net2ftp_log_consumption_ftpserver に重複したエントリが含まれています。";
$net2ftp_messages["Table net2ftp_log_access could not be updated."] = "Table net2ftp_log_access could not be updated.";
$net2ftp_messages["Table net2ftp_log_access contains duplicate entries."] = "Table net2ftp_log_access contains duplicate entries.";


// -------------------------------------------------------------------------
// /includes/database.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unable to connect to the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php."] = "Unable to connect to the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php.";
$net2ftp_messages["Unable to select the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php."] = "Unable to select the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php.";


// -------------------------------------------------------------------------
// /includes/errorhandling.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["An error has occured"] = "エラーです";
$net2ftp_messages["Go back"] = "戻る";
$net2ftp_messages["Go to the login page"] = "ログインページに戻る";


// -------------------------------------------------------------------------
// /includes/filesystem.inc.php
// -------------------------------------------------------------------------

// ftp_openconnection()
$net2ftp_messages["The <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">FTP module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">php.net</a><br />"] = "The <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">FTP module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">php.net</a><br />";
$net2ftp_messages["The <a href=\"http://www.php.net/manual/en/function.ftp-ssl-connect.php\" target=\"_blank\">FTP and/or OpenSSL modules of PHP</a> is not installed.<br /><br /> The administrator of this website should install these modules. Installation instructions are given on php.net: <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">here for FTP</a>, and <a href=\"http://www.php.net/manual/en/openssl.installation.php\" target=\"_blank\">here for OpenSSL</a><br />"] = "The <a href=\"http://www.php.net/manual/en/function.ftp-ssl-connect.php\" target=\"_blank\">FTP and/or OpenSSL modules of PHP</a> is not installed.<br /><br /> The administrator of this website should install these modules. Installation instructions are given on php.net: <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">here for FTP</a>, and <a href=\"http://www.php.net/manual/en/openssl.installation.php\" target=\"_blank\">here for OpenSSL</a><br />";
$net2ftp_messages["The <a href=\"http://www.php.net/manual/en/function.ssh2-sftp.php\" target=\"_blank\">SSH2 module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ssh2.installation.php\" target=\"_blank\">php.net</a><br />"] = "The <a href=\"http://www.php.net/manual/en/function.ssh2-sftp.php\" target=\"_blank\">SSH2 module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ssh2.installation.php\" target=\"_blank\">php.net</a><br />";
$net2ftp_messages["Unable to connect to FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />"] = "FTPサーバ <b>%1\$s</b> のポート <b>%2\$s</b> に接続することができません。<br /><br />このアドレスは本当に FTPサーバ のものですか? これは大抵 HTTP (web) サーバのものとは異なっています。あなたの ISPのサポートデスク または システム管理者 に問い合わせてください。<br />";
$net2ftp_messages["Unable to login to FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />"] = "FTPサーバ <b>%1\$s</b> にユーザ名 <b>%2\$s</b> でログインすることができません。<br /><br />あなたのユーザ名とパスワードは本当に正しいですか? あなたの ISPのサポートデスク または システム管理者 に問い合わせてください。<br />";
$net2ftp_messages["Unable to switch to the passive mode on FTP server <b>%1\$s</b>."] = "FTPサーバ <b>%1\$s</b> のパッシブモードに切り替えることができません。";

// ftp_openconnection2()
$net2ftp_messages["Unable to connect to the second (target) FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the second (target) FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />"] = "第2 (対象) FTPサーバ <b>%1\$s</b> のポート <b>%2\$s</b> に接続することができません。<br /><br />このアドレスは本当に 第2 (対象) FTPサーバ のものですか? これは大抵 HTTP (web) サーバのものとは異なっています。あなたの ISPのサポートデスク または システム管理者 に問い合わせてください。<br />";
$net2ftp_messages["Unable to login to the second (target) FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />"] = "第2 (対象) FTPサーバ <b>%1\$s</b> にユーザ名 <b>%2\$s</b> でログインすることができません。<br /><br />あなたのユーザ名とパスワードは本当に正しいですか? あなたの ISPのサポートデスク または システム管理者 に問い合わせてください。<br />";
$net2ftp_messages["Unable to switch to the passive mode on the second (target) FTP server <b>%1\$s</b>."] = "第2 (対象) FTPサーバ <b>%1\$s</b> のパッシブモードに切り替えることができません。";

// ftp_myrename()
$net2ftp_messages["Unable to rename directory or file <b>%1\$s</b> into <b>%2\$s</b>"] = "ディレクトリ（またはファイル）の名前を <b>%1\$s</b> から <b>%2\$s</b> 変更できません";

// ftp_mychmod()
$net2ftp_messages["Unable to execute site command <b>%1\$s</b>. Note that the CHMOD command is only available on Unix FTP servers, not on Windows FTP servers."] = "サイトコマンド<b>%1\$s</b> は実行できません。CHMOD コマンドは Windows FTPサーバではなく Unix FTPサーバでのみ有効であることに注意してください。";
$net2ftp_messages["Directory <b>%1\$s</b> successfully chmodded to <b>%2\$s</b>"] = "ディレクトリ <b>%1\$s</b> の許可情報は <b>%2\$s</b> に変更されました";
$net2ftp_messages["Processing entries within directory <b>%1\$s</b>:"] = "ディレクトリ <b>%1\$s</b> 内のエントリを処理しています:";
$net2ftp_messages["File <b>%1\$s</b> was successfully chmodded to <b>%2\$s</b>"] = "ファイル <b>%1\$s</b> の許可情報は <b>%2\$s</b> に変更されました";
$net2ftp_messages["All the selected directories and files have been processed."] = "選択されたすべてのディレクトリ、ファイルの処理が完了しました。";

// ftp_rmdir2()
$net2ftp_messages["Unable to delete the directory <b>%1\$s</b>"] = "ディレクトリ <b>%1\$s</b> は削除できません";

// ftp_delete2()
$net2ftp_messages["Unable to delete the file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> は削除できません";

// ftp_newdirectory()
$net2ftp_messages["Unable to create the directory <b>%1\$s</b>"] = "ディレクトリ <b>%1\$s</b> の作成はできません";

// ftp_readfile()
$net2ftp_messages["Unable to create the temporary file"] = "テンポラリファイルの作成が行えません";
$net2ftp_messages["Unable to get the file <b>%1\$s</b> from the FTP server and to save it as temporary file <b>%2\$s</b>.<br />Check the permissions of the %3\$s directory.<br />"] = "FTPサーバ からファイル <b>%1\$s</b> を取得し 一時ファイル <b>%2\$s</b> として保存することができません。<br />ディレクトリ %3\$s の許可情報を確認してください。<br />";
$net2ftp_messages["Unable to open the temporary file. Check the permissions of the %1\$s directory."] = "テンポラリファイルを開くことができません。ディレクトリ %1\$s の許可情報を確認してください。";
$net2ftp_messages["Unable to read the temporary file"] = "テンポラリファイルを読み込むことができません";
$net2ftp_messages["Unable to close the handle of the temporary file"] = "テンポラリファイルを閉じることができません";
$net2ftp_messages["Unable to delete the temporary file"] = "テンポラリファイルを削除することができません";

// ftp_writefile()
$net2ftp_messages["Unable to create the temporary file. Check the permissions of the %1\$s directory."] = "テンポラリファイルの作成が行えません。ディレクトリ %1\$s の許可情報を確認してください。";
$net2ftp_messages["Unable to open the temporary file. Check the permissions of the %1\$s directory."] = "テンポラリファイルを開くことができません。ディレクトリ %1\$s の許可情報を確認してください。";
$net2ftp_messages["Unable to write the string to the temporary file <b>%1\$s</b>.<br />Check the permissions of the %2\$s directory."] = "テンポラリファイル <b>%1\$s</b> に書き込むことができません。<br />ディレクトリ %2\$s の許可情報を確認してください。";
$net2ftp_messages["Unable to close the handle of the temporary file"] = "テンポラリファイルを閉じることができません";
$net2ftp_messages["Unable to put the file <b>%1\$s</b> on the FTP server.<br />You may not have write permissions on the directory."] = "FTPサーバ上にファイル <b>%1\$s</b> を置くことができません。<br />ディレクトリへの書き込み許可がありません。";
$net2ftp_messages["Unable to delete the temporary file"] = "テンポラリファイルを削除することができません";

// ftp_copymovedelete()
$net2ftp_messages["Processing directory <b>%1\$s</b>"] = "ディレクトリ <b>%1\$s</b> の処理中";
$net2ftp_messages["The target directory <b>%1\$s</b> is the same as or a subdirectory of the source directory <b>%2\$s</b>, so this directory will be skipped"] = "対象のディレクトリ <b>%1\$s</b> は元のディレクトリ <b>%2\$s</b> のサブディレクトリか、または同じディレクトリです。このディレクトリの処理をスキップします。";
$net2ftp_messages["The directory <b>%1\$s</b> contains a banned keyword, so this directory will be skipped"] = "The directory <b>%1\$s</b> contains a banned keyword, so this directory will be skipped";
$net2ftp_messages["The directory <b>%1\$s</b> contains a banned keyword, aborting the move"] = "The directory <b>%1\$s</b> contains a banned keyword, aborting the move";
$net2ftp_messages["Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing the copy/move process..."] = "サブディレクトリ <b>%1\$s</b> はすでに存在するため、作成することができません。コピー／移動処理を継続します...";
$net2ftp_messages["Created target subdirectory <b>%1\$s</b>"] = "対象のサブディレクトリ <b>%1\$s</b> を作成";
$net2ftp_messages["The directory <b>%1\$s</b> could not be selected, so this directory will be skipped"] = "ディレクトリ <b>%1\$s</b> を選択することができません。このディレクトリはスキップされます。";
$net2ftp_messages["Unable to delete the subdirectory <b>%1\$s</b> - it may not be empty"] = "サブディレクトリ <b>%1\$s</b> を削除することができません - このディレクトリは空ではありません";
$net2ftp_messages["Deleted subdirectory <b>%1\$s</b>"] = "サブディレクトリ <b>%1\$s</b> を削除";
$net2ftp_messages["Deleted subdirectory <b>%1\$s</b>"] = "サブディレクトリ <b>%1\$s</b> を削除";
$net2ftp_messages["Unable to move the directory <b>%1\$s</b>"] = "Unable to move the directory <b>%1\$s</b>";
$net2ftp_messages["Moved directory <b>%1\$s</b>"] = "Moved directory <b>%1\$s</b>";
$net2ftp_messages["Processing of directory <b>%1\$s</b> completed"] = "ディレクトリ <b>%1\$s</b> の処理が完了";
$net2ftp_messages["The target for file <b>%1\$s</b> is the same as the source, so this file will be skipped"] = "対象のファイル <b>%1\$s</b> は元のファイルと同名です。このファイルの処理をスキップします。";
$net2ftp_messages["The file <b>%1\$s</b> contains a banned keyword, so this file will be skipped"] = "The file <b>%1\$s</b> contains a banned keyword, so this file will be skipped";
$net2ftp_messages["The file <b>%1\$s</b> contains a banned keyword, aborting the move"] = "The file <b>%1\$s</b> contains a banned keyword, aborting the move";
$net2ftp_messages["The file <b>%1\$s</b> is too big to be copied, so this file will be skipped"] = "The file <b>%1\$s</b> is too big to be copied, so this file will be skipped";
$net2ftp_messages["The file <b>%1\$s</b> is too big to be moved, aborting the move"] = "The file <b>%1\$s</b> is too big to be moved, aborting the move";
$net2ftp_messages["Unable to copy the file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> をコピーすることができません";
$net2ftp_messages["Copied file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> をコピー";
$net2ftp_messages["Unable to move the file <b>%1\$s</b>, aborting the move"] = "Unable to move the file <b>%1\$s</b>, aborting the move";
$net2ftp_messages["Unable to move the file <b>%1\$s</b>"] = "Unable to move the file <b>%1\$s</b>";
$net2ftp_messages["Moved file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> を移動";
$net2ftp_messages["Unable to delete the file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> は削除できません";
$net2ftp_messages["Deleted file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> を削除";
$net2ftp_messages["All the selected directories and files have been processed."] = "選択されたすべてのディレクトリ、ファイルの処理が完了しました。";

// ftp_processfiles()

// ftp_getfile()
$net2ftp_messages["Unable to copy the remote file <b>%1\$s</b> to the local file using FTP mode <b>%2\$s</b>"] = "FTPモード <b>%2\$s</b> を使用してリモートファイル <b>%1\$s</b> をローカルファイルにコピーすることができません";
$net2ftp_messages["Unable to delete file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> を削除することができません";

// ftp_putfile()
$net2ftp_messages["The file is too big to be transferred"] = "The file is too big to be transferred";
$net2ftp_messages["Daily limit reached: the file <b>%1\$s</b> will not be transferred"] = "1日の制限に到達: ファイル <b>%1\$s</b> は転送されません";
$net2ftp_messages["Unable to copy the local file to the remote file <b>%1\$s</b> using FTP mode <b>%2\$s</b>"] = "FTPモード <b>%2\$s</b> を使用してローカルファイルをリモートファイル <b>%1\$s</b> にコピーすることができません";
$net2ftp_messages["Unable to delete the local file"] = "ローカルファイルを削除することができません";

// ftp_downloadfile()
$net2ftp_messages["Unable to delete the temporary file"] = "テンポラリファイルを削除することができません";
$net2ftp_messages["Unable to send the file to the browser"] = "ファイルをブラウザに送ることができません";

// ftp_zip()
$net2ftp_messages["Unable to create the temporary file"] = "テンポラリファイルの作成が行えません";
$net2ftp_messages["The zip file has been saved on the FTP server as <b>%1\$s</b>"] = "圧縮ファイルはすでにFTPサーバ上で <b>%1\$s</b> として保存されています";
$net2ftp_messages["Requested files"] = "Requested files";

$net2ftp_messages["Dear,"] = "Dear,";
$net2ftp_messages["Someone has requested the files in attachment to be sent to this email account (%1\$s)."] = "Someone has requested the files in attachment to be sent to this email account (%1\$s).";
$net2ftp_messages["If you know nothing about this or if you don't trust that person, please delete this email without opening the Zip file in attachment."] = "If you know nothing about this or if you don't trust that person, please delete this email without opening the Zip file in attachment.";
$net2ftp_messages["Note that if you don't open the Zip file, the files inside cannot harm your computer."] = "Note that if you don't open the Zip file, the files inside cannot harm your computer.";
$net2ftp_messages["Information about the sender: "] = "Information about the sender: ";
$net2ftp_messages["IP address: "] = "IP address: ";
$net2ftp_messages["Time of sending: "] = "Time of sending: ";
$net2ftp_messages["Sent via the net2ftp application installed on this website: "] = "Sent via the net2ftp application installed on this website: ";
$net2ftp_messages["Webmaster's email: "] = "Webmaster's email: ";
$net2ftp_messages["Message of the sender: "] = "Message of the sender: ";
$net2ftp_messages["net2ftp is free software, released under the GNU/GPL license. For more information, go to http://www.net2ftp.com."] = "net2ftp is free software, released under the GNU/GPL license. For more information, go to http://www.net2ftp.com.";

$net2ftp_messages["The zip file has been sent to <b>%1\$s</b>."] = "圧縮ファイルは <b>%1\$s</b> へ送信されました。";

// acceptFiles()
$net2ftp_messages["File <b>%1\$s</b> is too big. This file will not be uploaded."] = "ファイル <b>%1\$s</b> は大きすぎます。このファイルはアップロードされません。";
$net2ftp_messages["File <b>%1\$s</b> is contains a banned keyword. This file will not be uploaded."] = "File <b>%1\$s</b> is contains a banned keyword. This file will not be uploaded.";
$net2ftp_messages["Could not generate a temporary file."] = "一時ファイルを生成することができません。";
$net2ftp_messages["File <b>%1\$s</b> could not be moved"] = "ファイル <b>%1\$s</b> は移動できません";
$net2ftp_messages["File <b>%1\$s</b> is OK"] = "ファイル <b>%1\$s</b> は OK";
$net2ftp_messages["Unable to move the uploaded file to the temp directory.<br /><br />The administrator of this website has to <b>chmod 777</b> the /temp directory of net2ftp."] = "アップロードしたファイルをテンポラリディレクトリへ移動することができません。<br /><br />このサイトの管理者が net2ftp の /temp ディレクトリの許可情報を <b>777</b> に設定する必要があります。";
$net2ftp_messages["You did not provide any file to upload."] = "アップロードするファイルが設定されていません。";

// ftp_transferfiles()
$net2ftp_messages["File <b>%1\$s</b> could not be transferred to the FTP server"] = "ファイル <b>%1\$s</b> を FTPサーバに転送することができませんでした";
$net2ftp_messages["File <b>%1\$s</b> has been transferred to the FTP server using FTP mode <b>%2\$s</b>"] = "ファイル <b>%1\$s</b> は FTPモード <b>%2\$s</b> を使用して FTPサーバに転送されました";
$net2ftp_messages["Transferring files to the FTP server"] = "ファイルを FTPサーバに転送しています";

// ftp_unziptransferfiles()
$net2ftp_messages["Processing archive nr %1\$s: <b>%2\$s</b>"] = "圧縮ファイルの処理エラー %1\$s: <b>%2\$s</b>";
$net2ftp_messages["Archive <b>%1\$s</b> was not processed because its filename extension was not recognized. Only zip, tar, tgz and gz archives are supported at the moment."] = "ファイル拡張子が判別不能なため、圧縮ファイル <b>%1\$s</b> は処理されませんでした。現在サポートされている圧縮ファイルは zip, tar, tgz, gz だけです。";
$net2ftp_messages["Unable to extract the files and directories from the archive"] = "Unable to extract the files and directories from the archive";
$net2ftp_messages["Archive contains filenames with ../ or ..\\ - aborting the extraction"] = "Archive contains filenames with ../ or ..\\ - aborting the extraction";
$net2ftp_messages["Could not unzip entry %1\$s (error code %2\$s)"] = "Could not unzip entry %1\$s (error code %2\$s)";
$net2ftp_messages["Created directory %1\$s"] = "Created directory %1\$s";
$net2ftp_messages["Could not create directory %1\$s"] = "Could not create directory %1\$s";
$net2ftp_messages["Copied file %1\$s"] = "Copied file %1\$s";
$net2ftp_messages["Could not copy file %1\$s"] = "Could not copy file %1\$s";
$net2ftp_messages["Unable to delete the temporary directory"] = "Unable to delete the temporary directory";
$net2ftp_messages["Unable to delete the temporary file %1\$s"] = "Unable to delete the temporary file %1\$s";

// ftp_mysite()
$net2ftp_messages["Unable to execute site command <b>%1\$s</b>"] = "サイトコマンド <b>%1\$s</b> を実行することができません";

// shutdown()
$net2ftp_messages["Your task was stopped"] = "作業は中止しました";
$net2ftp_messages["The task you wanted to perform with net2ftp took more time than the allowed %1\$s seconds, and therefor that task was stopped."] = "あなたが net2ftpで実行しようとした作業は、許容時間の %1\$s 秒よりも長い時間が必要です。したがって、作業は中止しました。";
$net2ftp_messages["This time limit guarantees the fair use of the web server for everyone."] = "この時間制限は、皆様が公平に webサーバを利用できるよう保障するものです。";
$net2ftp_messages["Try to split your task in smaller tasks: restrict your selection of files, and omit the biggest files."] = "作業をより小さな作業に分割してみて下さい: ファイルの選択を制限し、大きなファイルを省いてください。";
$net2ftp_messages["If you really need net2ftp to be able to handle big tasks which take a long time, consider installing net2ftp on your own server."] = "もしどうしても net2ftpを使って長時間大きな作業をする必要がある場合は、ご自分のサーバに net2ftpを導入することを検討して下さい。";

// SendMail()
$net2ftp_messages["You did not provide any text to send by email!"] = "電子メールで送信するメッセージがありません!";
$net2ftp_messages["You did not supply a From address."] = "差出人アドレスが未入力です。";
$net2ftp_messages["You did not supply a To address."] = "宛先アドレスが未入力です。";
$net2ftp_messages["Due to technical problems the email to <b>%1\$s</b> could not be sent."] = "技術的な問題で <b>%1\$s</b> への 電子メールは送信されませんでした。";

// tempdir2()
$net2ftp_messages["Unable to create a temporary directory because (unvalid parent directory)"] = "Unable to create a temporary directory because (unvalid parent directory)";
$net2ftp_messages["Unable to create a temporary directory because (parent directory is not writeable)"] = "Unable to create a temporary directory because (parent directory is not writeable)";
$net2ftp_messages["Unable to create a temporary directory (too many tries)"] = "Unable to create a temporary directory (too many tries)";

// -------------------------------------------------------------------------
// /includes/logging.inc.php
// -------------------------------------------------------------------------
// logAccess(), logLogin(), logError()
$net2ftp_messages["Unable to execute the SQL query."] = "SQLクエリを実行することができません。";
$net2ftp_messages["Unable to open the system log."] = "Unable to open the system log.";
$net2ftp_messages["Unable to write a message to the system log."] = "Unable to write a message to the system log.";

// getLogStatus(), putLogStatus()
$net2ftp_messages["Table net2ftp_log_status contains duplicate entries."] = "Table net2ftp_log_status contains duplicate entries.";
$net2ftp_messages["Table net2ftp_log_status could not be updated."] = "Table net2ftp_log_status could not be updated.";

// rotateLogs()
$net2ftp_messages["The log tables were renamed successfully."] = "The log tables were renamed successfully.";
$net2ftp_messages["The log tables could not be renamed."] = "The log tables could not be renamed.";
$net2ftp_messages["The log tables were copied successfully."] = "The log tables were copied successfully.";
$net2ftp_messages["The log tables could not be copied."] = "The log tables could not be copied.";
$net2ftp_messages["The oldest log table was dropped successfully."] = "The oldest log table was dropped successfully.";
$net2ftp_messages["The oldest log table could not be dropped."] = "The oldest log table could not be dropped.";


// -------------------------------------------------------------------------
// /includes/registerglobals.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Please enter your username and password for FTP server "] = "FTPサーバ上のあなたのユーザ名とパスワードを入力して下さい";
$net2ftp_messages["You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below."] = "ポップアップウィンドウにあなたのログイン情報が入力されていません。<br />下の \"ログインページへ移動\" をクリックしてください。";
$net2ftp_messages["Access to the net2ftp Admin panel is disabled, because no password has been set in the file settings.inc.php. Enter a password in that file, and reload this page."] = "ファイル settings.inc.php にパスワードが設定されていないため、net2ftp 管理用パネルへのアクセスは無効です。ファイルにパスワードを入力し、このページをリロードして下さい。";
$net2ftp_messages["Please enter your Admin username and password"] = "管理者のユーザ名とパスワードを入力して下さい"; 
$net2ftp_messages["You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below."] = "ポップアップウィンドウにあなたのログイン情報が入力されていません。<br />下の \"ログインページへ移動\" をクリックしてください。";
$net2ftp_messages["Wrong username or password for the net2ftp Admin panel. The username and password can be set in the file settings.inc.php."] = "net2ftp 管理用パネルのユーザ名かパスワードが間違っています。ユーザ名とパスワードはファイル settings.inc.php で設定することができます。";


// -------------------------------------------------------------------------
// /skins/skins.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Blue"] = "青色";
$net2ftp_messages["Grey"] = "灰色";
$net2ftp_messages["Black"] = "黒色";
$net2ftp_messages["Yellow"] = "黄色";
$net2ftp_messages["Pastel"] = "淡色";

// getMime()
$net2ftp_messages["Directory"] = "フォルダ";
$net2ftp_messages["Symlink"] = "シンボリックリンク";
$net2ftp_messages["ASP script"] = "ASP スクリプト";
$net2ftp_messages["Cascading Style Sheet"] = "CSS スタイルシート";
$net2ftp_messages["HTML file"] = "HTML ドキュメント";
$net2ftp_messages["Java source file"] = "Java ソースファイル";
$net2ftp_messages["JavaScript file"] = "JavaScript ファイル";
$net2ftp_messages["PHP Source"] = "PHP ソース";
$net2ftp_messages["PHP script"] = "PHP スクリプト";
$net2ftp_messages["Text file"] = "プレーンテキスト ドキュメント";
$net2ftp_messages["Bitmap file"] = "BMP イメージ";
$net2ftp_messages["GIF file"] = "GIF イメージ";
$net2ftp_messages["JPEG file"] = "JPEG イメージ";
$net2ftp_messages["PNG file"] = "PNG イメージ";
$net2ftp_messages["TIF file"] = "TIFF イメージ";
$net2ftp_messages["GIMP file"] = "GIMP ネイティブイメージフォーマット";
$net2ftp_messages["Executable"] = "実行可能ファイル";
$net2ftp_messages["Shell script"] = "シェルスクリプト";
$net2ftp_messages["MS Office - Word document"] = "MS Office - Word ドキュメント";
$net2ftp_messages["MS Office - Excel spreadsheet"] = "MS Office - Excel ワークシート";
$net2ftp_messages["MS Office - PowerPoint presentation"] = "MS Office - PowerPoint プレゼンテーション";
$net2ftp_messages["MS Office - Access database"] = "MS Office - Access データベース";
$net2ftp_messages["MS Office - Visio drawing"] = "MS Office - Visio ドローイング";
$net2ftp_messages["MS Office - Project file"] = "MS Office - Project ファイル";
$net2ftp_messages["OpenOffice - Writer 6.0 document"] = "OpenOffice - Writer 6.0 テキストドキュメント";
$net2ftp_messages["OpenOffice - Writer 6.0 template"] = "OpenOffice - Writer 6.0 テンプレート";
$net2ftp_messages["OpenOffice - Calc 6.0 spreadsheet"] = "OpenOffice - Calc 6.0 スプレッドシート";
$net2ftp_messages["OpenOffice - Calc 6.0 template"] = "OpenOffice - Calc 6.0 テンプレート";
$net2ftp_messages["OpenOffice - Draw 6.0 document"] = "OpenOffice - Draw 6.0 ドローイング";
$net2ftp_messages["OpenOffice - Draw 6.0 template"] = "OpenOffice - Draw 6.0 テンプレート";
$net2ftp_messages["OpenOffice - Impress 6.0 presentation"] = "OpenOffice - Impress 6.0 プレゼンテーション";
$net2ftp_messages["OpenOffice - Impress 6.0 template"] = "OpenOffice - Impress 6.0 テンプレート";
$net2ftp_messages["OpenOffice - Writer 6.0 global document"] = "OpenOffice - Writer 6.0 マスタードキュメント";
$net2ftp_messages["OpenOffice - Math 6.0 document"] = "OpenOffice - Math 6.0 数式";
$net2ftp_messages["StarOffice - StarWriter 5.x document"] = "StarOffice - StarWriter 5.x テキストドキュメント";
$net2ftp_messages["StarOffice - StarWriter 5.x global document"] = "StarOffice - StarWriter 5.x マスタードキュメント";
$net2ftp_messages["StarOffice - StarCalc 5.x spreadsheet"] = "StarOffice - StarCalc 5.x スプレッドシート";
$net2ftp_messages["StarOffice - StarDraw 5.x document"] = "StarOffice - StarDraw 5.x ドローイング";
$net2ftp_messages["StarOffice - StarImpress 5.x presentation"] = "StarOffice - StarImpress 5.x プレゼンテーション";
$net2ftp_messages["StarOffice - StarImpress Packed 5.x file"] = "StarOffice - StarImpress Packed 5.x ファイル";
$net2ftp_messages["StarOffice - StarMath 5.x document"] = "StarOffice - StarMath 5.x 数式";
$net2ftp_messages["StarOffice - StarChart 5.x document"] = "StarOffice - StarChart 5.x ドキュメント";
$net2ftp_messages["StarOffice - StarMail 5.x mail file"] = "StarOffice - StarMail 5.x mail ファイル";
$net2ftp_messages["Adobe Acrobat document"] = "Adobe Acrobat ドキュメント";
$net2ftp_messages["ARC archive"] = "ARC アーカイブ";
$net2ftp_messages["ARJ archive"] = "ARJ アーカイブ";
$net2ftp_messages["RPM"] = "RPM パッケージファイル";
$net2ftp_messages["GZ archive"] = "Gzip ファイル";
$net2ftp_messages["TAR archive"] = "TAR アーカイブ";
$net2ftp_messages["Zip archive"] = "Zip アーカイブ";
$net2ftp_messages["MOV movie file"] = "MOV ビデオ";
$net2ftp_messages["MPEG movie file"] = "MPEG ビデオ";
$net2ftp_messages["Real movie file"] = "リアルビデオ ファイル";
$net2ftp_messages["Quicktime movie file"] = "Quicktime ビデオ";
$net2ftp_messages["Shockwave flash file"] = "Shockwave flash メディア";
$net2ftp_messages["Shockwave file"] = "Shockwave ファイル";
$net2ftp_messages["WAV sound file"] = "WAV オーディオ";
$net2ftp_messages["Font file"] = "フォントファイル";
$net2ftp_messages["%1\$s File"] = "%1\$s ファイル";
$net2ftp_messages["File"] = "ファイル";

// getAction()
$net2ftp_messages["Back"] = "戻る";
$net2ftp_messages["Submit"] = "送信";
$net2ftp_messages["Refresh"] = "更新";
$net2ftp_messages["Details"] = "詳細";
$net2ftp_messages["Icons"] = "アイコン";
$net2ftp_messages["List"] = "リスト";
$net2ftp_messages["Logout"] = "ログアウト";
$net2ftp_messages["Help"] = "ヘルプ";
$net2ftp_messages["Bookmark"] = "ブックマーク";
$net2ftp_messages["Save"] = "保存";
$net2ftp_messages["Default"] = "デフォルト";


// -------------------------------------------------------------------------
// /skins/[skin]/header.template.php and footer.template.php
// -------------------------------------------------------------------------
$net2ftp_messages["Help Guide"] = "ヘルプガイド";
$net2ftp_messages["Forums"] = "フォーラム";
$net2ftp_messages["License"] = "ライセンス";
$net2ftp_messages["Powered by"] = "供給元";
$net2ftp_messages["You are now taken to the net2ftp forums. These forums are for net2ftp related topics only - not for generic webhosting questions."] = "あなたは net2ftp フォーラムへ行こうとしています。このフォーラムは net2ftp に関連する話題だけのものです - 一般的なウェブホスティングについての質問はやめて下さい。";
$net2ftp_messages["Standard"] = "Standard";
$net2ftp_messages["Mobile"] = "Mobile";

// -------------------------------------------------------------------------
// Admin module
if ($net2ftp_globals["state"] == "admin") {
// -------------------------------------------------------------------------

// /modules/admin/admin.inc.php
$net2ftp_messages["Admin functions"] = "管理用機能";

// /skins/[skin]/admin1.template.php
$net2ftp_messages["Version information"] = "バージョン情報";
$net2ftp_messages["This version of net2ftp is up-to-date."] = "このバージョンの net2ftp は最新のものです。";
$net2ftp_messages["The latest version information could not be retrieved from the net2ftp.com server. Check the security settings of your browser, which may prevent the loading of a small file from the net2ftp.com server."] = "最新バージョン情報は net2ftp.com サーバから検索されませんでした。ご使用のブラウザが、 net2ftp.com サーバから小ファイルが読み込まれるのを防止している恐れがあります。ブラウザのセキュリティ設定を確認して下さい。";
$net2ftp_messages["Logging"] = "記録中";
$net2ftp_messages["Date from:"] = "起点日時:";
$net2ftp_messages["to:"] = "終点日時:";
$net2ftp_messages["Empty logs"] = "ログの消去";
$net2ftp_messages["View logs"] = "ログの表示";
$net2ftp_messages["Go"] = "移動";
$net2ftp_messages["Setup MySQL tables"] = "MySQL テーブルの設定";
$net2ftp_messages["Create the MySQL database tables"] = "MySQL データベーステーブルの作成";

} // end admin

// -------------------------------------------------------------------------
// Admin_createtables module
if ($net2ftp_globals["state"] == "admin_createtables") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_createtables.inc.php
$net2ftp_messages["Admin functions"] = "管理用機能";
$net2ftp_messages["The handle of file %1\$s could not be opened."] = "ファイル %1\$s のハンドルを開くことができませんでした。";
$net2ftp_messages["The file %1\$s could not be opened."] = "ファイル %1\$s を開くことができませんでした。";
$net2ftp_messages["The handle of file %1\$s could not be closed."] = "ファイル %1\$s のハンドルを閉じることができませんでした。";
$net2ftp_messages["The connection to the server <b>%1\$s</b> could not be set up. Please check the database settings you've entered."] = "サーバ <b>%1\$s</b> への接続は設定されませんでした。あなたが入力したデータベースの設定値を確認してください。";
$net2ftp_messages["Unable to select the database <b>%1\$s</b>."] = "データベース <b>%1\$s</b> を選択することができません。";
$net2ftp_messages["The SQL query nr <b>%1\$s</b> could not be executed."] = "SQLクエリエラー <b>%1\$s</b> を実行することができませんでした。";
$net2ftp_messages["The SQL query nr <b>%1\$s</b> was executed successfully."] = "SQLクエリ <b>%1\$s</b> は正常に実行されました。";

// /skins/[skin]/admin_createtables1.template.php
$net2ftp_messages["Please enter your MySQL settings:"] = "あなたの MySQL の設定値を入力してください:";
$net2ftp_messages["MySQL username"] = "MySQL ユーザ名";
$net2ftp_messages["MySQL password"] = "MySQL パスワード";
$net2ftp_messages["MySQL database"] = "MySQL データベース";
$net2ftp_messages["MySQL server"] = "MySQL サーバ";
$net2ftp_messages["This SQL query is going to be executed:"] = "この SQLクエリが実行されようとしています:";
$net2ftp_messages["Execute"] = "実行";

// /skins/[skin]/admin_createtables2.template.php
$net2ftp_messages["Settings used:"] = "使用される設定:";
$net2ftp_messages["MySQL password length"] = "MySQL パスワード長";
$net2ftp_messages["Results:"] = "結果:";

} // end admin_createtables


// -------------------------------------------------------------------------
// Admin_viewlogs module
if ($net2ftp_globals["state"] == "admin_viewlogs") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_viewlogs.inc.php
$net2ftp_messages["Admin functions"] = "管理用機能";
$net2ftp_messages["Unable to execute the SQL query <b>%1\$s</b>."] = "SQLクエリ <b>%1\$s</b> を実行することができません。";
$net2ftp_messages["No data"] = "データ無し";

} // end admin_viewlogs


// -------------------------------------------------------------------------
// Admin_emptylogs module
if ($net2ftp_globals["state"] == "admin_emptylogs") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_emptylogs.inc.php
$net2ftp_messages["Admin functions"] = "管理用機能";
$net2ftp_messages["The table <b>%1\$s</b> was emptied successfully."] = "テーブル <b>%1\$s</b> は正常に空になりました。";
$net2ftp_messages["The table <b>%1\$s</b> could not be emptied."] = "テーブル <b>%1\$s</b> を空にすることができませんでした。";
$net2ftp_messages["The table <b>%1\$s</b> was optimized successfully."] = "テーブル <b>%1\$s</b> は正常に最適化されました。";
$net2ftp_messages["The table <b>%1\$s</b> could not be optimized."] = "テーブル <b>%1\$s</b> を最適化することができませんでした。";

} // end admin_emptylogs


// -------------------------------------------------------------------------
// Advanced module
if ($net2ftp_globals["state"] == "advanced") {
// -------------------------------------------------------------------------

// /modules/advanced/advanced.inc.php
$net2ftp_messages["Advanced functions"] = "拡張機能";

// /skins/[skin]/advanced1.template.php
$net2ftp_messages["Go"] = "移動";
$net2ftp_messages["Disabled"] = "無効";
$net2ftp_messages["Advanced FTP functions"] = "拡張 FTP 機能";
$net2ftp_messages["Send arbitrary FTP commands to the FTP server"] = "FTPサーバへ任意の FTPコマンドを送信する";
$net2ftp_messages["This function is available on PHP 5 only"] = "この機能は PHP 5 でのみ有効です";
$net2ftp_messages["Troubleshooting functions"] = "トラブルシューティング機能";
$net2ftp_messages["Troubleshoot net2ftp on this webserver"] = "このwebサーバの net2ftp のトラブルシュート";
$net2ftp_messages["Troubleshoot an FTP server"] = "FTPサーバのトラブルシュート";
$net2ftp_messages["Test the net2ftp list parsing rules"] = "net2ftp のリスト解析ルールをテスト";
$net2ftp_messages["Translation functions"] = "翻訳機能";
$net2ftp_messages["Introduction to the translation functions"] = "翻訳機能の手引き";
$net2ftp_messages["Extract messages to translate from code files"] = "コードファイルを翻訳するためメッセージを取り出す";
$net2ftp_messages["Check if there are new or obsolete messages"] = "メッセージが新しいものか旧式のものかを調べる";

$net2ftp_messages["Beta functions"] = "開発中の機能";
$net2ftp_messages["Send a site command to the FTP server"] = "FTPサーバへサイトコマンドを送る";
$net2ftp_messages["Apache: password-protect a directory, create custom error pages"] = "Apache: ディレクトリのパスワード保護、カスタムエラーページの作成";
$net2ftp_messages["MySQL: execute an SQL query"] = "MySQL: SQLクエリを実行";


// advanced()
$net2ftp_messages["The site command functions are not available on this webserver."] = "このwebサーバでは、サイトコマンド機能は利用できません。";
$net2ftp_messages["The Apache functions are not available on this webserver."] = "このwebサーバでは、 Apache機能は利用できません。";
$net2ftp_messages["The MySQL functions are not available on this webserver."] = "このwebサーバでは、 MySQL機能は利用できません。";
$net2ftp_messages["Unexpected state2 string. Exiting."] = "予期しない state2 ストリングです。終了しています。";

} // end advanced


// -------------------------------------------------------------------------
// Advanced_ftpserver module
if ($net2ftp_globals["state"] == "advanced_ftpserver") {
// -------------------------------------------------------------------------

// /modules/advanced_ftpserver/advanced_ftpserver.inc.php
$net2ftp_messages["Troubleshoot an FTP server"] = "FTPサーバのトラブルシュート";

// /skins/[skin]/advanced_ftpserver1.template.php
$net2ftp_messages["Connection settings:"] = "接続設定:";
$net2ftp_messages["FTP server"] = "FTP サーバ";
$net2ftp_messages["FTP server port"] = "FTPサーバポート";
$net2ftp_messages["Username"] = "ユーザ名";
$net2ftp_messages["Password"] = "パスワード";
$net2ftp_messages["Password length"] = "パスワード長";
$net2ftp_messages["Passive mode"] = "Passive モード";
$net2ftp_messages["Directory"] = "フォルダ";
$net2ftp_messages["Printing the result"] = "結果を出力しています";

// /skins/[skin]/advanced_ftpserver2.template.php
$net2ftp_messages["Connecting to the FTP server: "] = "FTPサーバに接続中: ";
$net2ftp_messages["Logging into the FTP server: "] = "FTPサーバにログイン中: ";
$net2ftp_messages["Setting the passive mode: "] = "パッシブモードの設定中: ";
$net2ftp_messages["Getting the FTP server system type: "] = "FTPサーバのシステム種別を取得中: ";
$net2ftp_messages["Changing to the directory %1\$s: "] = "ディレクトリ %1\$s へ変更中: ";
$net2ftp_messages["The directory from the FTP server is: %1\$s "] = "FTPサーバからのディレクトリ: %1\$s ";
$net2ftp_messages["Getting the raw list of directories and files: "] = "ディレクトリとファイルの生リストを取得中: ";
$net2ftp_messages["Trying a second time to get the raw list of directories and files: "] = "ディレクトリとファイルの生リストを再取得中: ";
$net2ftp_messages["Closing the connection: "] = "接続を切断中: ";
$net2ftp_messages["Raw list of directories and files:"] = "ディレクトリとファイルの生リスト:";
$net2ftp_messages["Parsed list of directories and files:"] = "ディレクトリとファイルの解析済みリスト:";

$net2ftp_messages["OK"] = "OK";
$net2ftp_messages["not OK"] = "失敗";

} // end advanced_ftpserver


// -------------------------------------------------------------------------
// Advanced_parsing module
if ($net2ftp_globals["state"] == "advanced_parsing") {
// -------------------------------------------------------------------------

$net2ftp_messages["Test the net2ftp list parsing rules"] = "net2ftp のリスト解析ルールをテスト";
$net2ftp_messages["Sample input"] = "サンプル入力";
$net2ftp_messages["Parsed output"] = "解析後の出力";

} // end advanced_parsing


// -------------------------------------------------------------------------
// Advanced_webserver module
if ($net2ftp_globals["state"] == "advanced_webserver") {
// -------------------------------------------------------------------------

$net2ftp_messages["Troubleshoot your net2ftp installation"] = "あなたの net2ftp 導入をトラブルシュート";
$net2ftp_messages["Printing the result"] = "結果を出力しています";

$net2ftp_messages["Checking if the FTP module of PHP is installed: "] = "PHP の FTPモジュールがインストールされているか調べています: ";
$net2ftp_messages["yes"] = "はい";
$net2ftp_messages["no - please install it!"] = "いいえ - インストールしてください!";

$net2ftp_messages["Checking the permissions of the directory on the web server: a small file will be written to the /temp folder and then deleted."] = "webサーバ上のディレクトリの許可情報を調べています: /temp フォルダに小さなファイルが作成されますが、後で削除されます。";
$net2ftp_messages["Creating filename: "] = "ファイル名を作成中: ";
$net2ftp_messages["OK. Filename: %1\$s"] = "OK. ファイル名: %1\$s";
$net2ftp_messages["not OK"] = "失敗";
$net2ftp_messages["OK"] = "OK";
$net2ftp_messages["not OK. Check the permissions of the %1\$s directory"] = "失敗。ディレクトリ %1\$s の許可情報を確認してください";
$net2ftp_messages["Opening the file in write mode: "] = "ファイルを書き込みモードで開いています: ";
$net2ftp_messages["Writing some text to the file: "] = "ファイルにテキストを書き込んでいます: ";
$net2ftp_messages["Closing the file: "] = "ファイルを閉じています: ";
$net2ftp_messages["Deleting the file: "] = "ファイルを削除しています: ";

$net2ftp_messages["Testing the FTP functions"] = "FTP機能をテストしています";
$net2ftp_messages["Connecting to a test FTP server: "] = "テスト用FTPサーバに接続中: ";
$net2ftp_messages["Connecting to the FTP server: "] = "FTPサーバに接続中: ";
$net2ftp_messages["Logging into the FTP server: "] = "FTPサーバにログイン中: ";
$net2ftp_messages["Setting the passive mode: "] = "パッシブモードの設定中: ";
$net2ftp_messages["Getting the FTP server system type: "] = "FTPサーバのシステム種別を取得中: ";
$net2ftp_messages["Changing to the directory %1\$s: "] = "ディレクトリ %1\$s へ変更中: ";
$net2ftp_messages["The directory from the FTP server is: %1\$s "] = "FTPサーバからのディレクトリ: %1\$s ";
$net2ftp_messages["Getting the raw list of directories and files: "] = "ディレクトリとファイルの生リストを取得中: ";
$net2ftp_messages["Trying a second time to get the raw list of directories and files: "] = "ディレクトリとファイルの生リストを再取得中: ";
$net2ftp_messages["Closing the connection: "] = "接続を切断中: ";
$net2ftp_messages["Raw list of directories and files:"] = "ディレクトリとファイルの生リスト:";
$net2ftp_messages["Parsed list of directories and files:"] = "ディレクトリとファイルの解析済みリスト:";
$net2ftp_messages["OK"] = "OK";
$net2ftp_messages["not OK"] = "失敗";

} // end advanced_webserver


// -------------------------------------------------------------------------
// Bookmark module
if ($net2ftp_globals["state"] == "bookmark") {
// -------------------------------------------------------------------------

$net2ftp_messages["Drag and drop one of the links below to the bookmarks bar"] = "Drag and drop one of the links below to the bookmarks bar";
$net2ftp_messages["Right-click on one of the links below and choose \"Add to Favorites...\""] = "Right-click on one of the links below and choose \"Add to Favorites...\"";
$net2ftp_messages["Right-click on one the links below and choose \"Add Link to Bookmarks...\""] = "Right-click on one the links below and choose \"Add Link to Bookmarks...\"";
$net2ftp_messages["Right-click on one of the links below and choose \"Bookmark link...\""] = "Right-click on one of the links below and choose \"Bookmark link...\"";
$net2ftp_messages["Right-click on one of the links below and choose \"Bookmark This Link...\""] = "Right-click on one of the links below and choose \"Bookmark This Link...\"";
$net2ftp_messages["One click access (net2ftp won't ask for a password - less safe)"] = "One click access (net2ftp won't ask for a password - less safe)";
$net2ftp_messages["Two click access (net2ftp will ask for a password - safer)"] = "Two click access (net2ftp will ask for a password - safer)";
$net2ftp_messages["Note: when you will use this bookmark, a popup window will ask you for your username and password."] = "注釈: このブックマークを利用すると、ポップアップウィンドウでユーザ名とパスワードを入力します。";

} // end bookmark


// -------------------------------------------------------------------------
// Browse module
if ($net2ftp_globals["state"] == "browse") {
// -------------------------------------------------------------------------

// /modules/browse/browse.inc.php
$net2ftp_messages["Choose a directory"] = "ディレクトリを選択";
$net2ftp_messages["Please wait..."] = "しばらくお待ち下さい...";

// browse()
$net2ftp_messages["Directories with names containing \' cannot be displayed correctly. They can only be deleted. Please go back and select another subdirectory."] = "名前に \' を含むディレクトリは正しく表示されません。削除されてしまいます。戻って別のサブディレクトリを選択してください。";

$net2ftp_messages["Daily limit reached: you will not be able to transfer data"] = "1日の転送制限に到達: データを転送することはできません";
$net2ftp_messages["In order to guarantee the fair use of the web server for everyone, the data transfer volume and script execution time are limited per user, and per day. Once this limit is reached, you can still browse the FTP server but not transfer data to/from it."] = "webサーバを皆様で公平に利用することを保障するため、データの転送量とスクリプトの実行時間はユーザごとに1日単位で制限されています。上限に到達した場合も FTPサーバを表示することはできますが、データの送受信はできません。";
$net2ftp_messages["If you need unlimited usage, please install net2ftp on your own web server."] = "無制限に使用したい方は、ご自分の webサーバに net2ftp をインストールして下さい。";

// printdirfilelist()
// Keep this short, it must fit in a small button!
$net2ftp_messages["New dir"] = "新規ディレクトリ";
$net2ftp_messages["New file"] = "新規ファイル";
$net2ftp_messages["HTML templates"] = "HTML テンプレート";
$net2ftp_messages["Upload"] = "アップロード";
$net2ftp_messages["Java Upload"] = "Java アップロード";
$net2ftp_messages["Flash Upload"] = "Flash Upload";
$net2ftp_messages["Install"] = "Install";
$net2ftp_messages["Advanced"] = "拡張機能";
$net2ftp_messages["Copy"] = "コピー";
$net2ftp_messages["Move"] = "移動";
$net2ftp_messages["Delete"] = "削除";
$net2ftp_messages["Rename"] = "名前の変更";
$net2ftp_messages["Chmod"] = "許可情報の変更";
$net2ftp_messages["Download"] = "ダウンロード";
$net2ftp_messages["Unzip"] = "Unzip";
$net2ftp_messages["Zip"] = "圧縮";
$net2ftp_messages["Size"] = "サイズ";
$net2ftp_messages["Search"] = "検索";
$net2ftp_messages["Go to the parent directory"] = "ひとつ上へ移動";
$net2ftp_messages["Go"] = "移動";
$net2ftp_messages["Transform selected entries: "] = "選択されたエントリの: ";
$net2ftp_messages["Transform selected entry: "] = "Transform selected entry: ";
$net2ftp_messages["Make a new subdirectory in directory %1\$s"] = "ディレクトリ %1\$s の下にサブディレクトリを作成";
$net2ftp_messages["Create a new file in directory %1\$s"] = "ディレクトリ %1\$s に新しいファイルを作成";
$net2ftp_messages["Create a website easily using ready-made templates"] = "既成のテンプレートを利用して簡単に webサイトを作成";
$net2ftp_messages["Upload new files in directory %1\$s"] = "ディレクトリ %1\$s 内に新しいファイルをアップロード";
$net2ftp_messages["Upload directories and files using a Java applet"] = "Javaアプレットを利用してディレクトリとファイルをアップロード";
$net2ftp_messages["Upload files using a Flash applet"] = "Upload files using a Flash applet";
$net2ftp_messages["Install software packages (requires PHP on web server)"] = "Install software packages (requires PHP on web server)";
$net2ftp_messages["Go to the advanced functions"] = "拡張機能の画面を開く";
$net2ftp_messages["Copy the selected entries"] = "選択されたエントリをコピー";
$net2ftp_messages["Move the selected entries"] = "選択されたエントリを移動";
$net2ftp_messages["Delete the selected entries"] = "選択されたエントリを削除";
$net2ftp_messages["Rename the selected entries"] = "選択されたエントリの名前を変更";
$net2ftp_messages["Chmod the selected entries (only works on Unix/Linux/BSD servers)"] = "選択されたエントリの許可情報を変更（Unix/Linux/BSD サーバのみ有効）";
$net2ftp_messages["Download a zip file containing all selected entries"] = "選択されたエントリをすべて含む圧縮ファイルをダウンロード";
$net2ftp_messages["Unzip the selected archives on the FTP server"] = "Unzip the selected archives on the FTP server";
$net2ftp_messages["Zip the selected entries to save or email them"] = "選択されたエントリを圧縮";
$net2ftp_messages["Calculate the size of the selected entries"] = "選択されたエントリのファイルサイズを計算";
$net2ftp_messages["Find files which contain a particular word"] = "特定の文字列を含むファイルを検索";
$net2ftp_messages["Click to sort by %1\$s in descending order"] = "クリックすると %1\$s で降順ソート";
$net2ftp_messages["Click to sort by %1\$s in ascending order"] = "クリックすると %1\$s で昇順ソート";
$net2ftp_messages["Ascending order"] = "昇順";
$net2ftp_messages["Descending order"] = "降順";
$net2ftp_messages["Upload files"] = "ファイルのアップロード";
$net2ftp_messages["Up"] = "上へ";
$net2ftp_messages["Click to check or uncheck all rows"] = "クリックすると全項目の選択／非選択を切り替え";
$net2ftp_messages["All"] = "全て";
$net2ftp_messages["Name"] = "名前";
$net2ftp_messages["Type"] = "タイプ";
//$net2ftp_messages["Size"] = "Size";
$net2ftp_messages["Owner"] = "所有者";
$net2ftp_messages["Group"] = "グループ";
$net2ftp_messages["Perms"] = "許可情報";
$net2ftp_messages["Mod Time"] = "更新日時";
$net2ftp_messages["Actions"] = "操作";
$net2ftp_messages["Select the directory %1\$s"] = "ディレクトリ %1\$s を選択";
$net2ftp_messages["Select the file %1\$s"] = "ファイル %1\$s を選択";
$net2ftp_messages["Select the symlink %1\$s"] = "シンボリックリンク %1\$s を選択";
$net2ftp_messages["Go to the subdirectory %1\$s"] = "サブディレクトリ %1\$s へ移動";
$net2ftp_messages["Download the file %1\$s"] = "ファイル %1\$s のダウンロード";
$net2ftp_messages["Follow symlink %1\$s"] = "Follow symlink %1\$s";
$net2ftp_messages["View"] = "閲覧";
$net2ftp_messages["Edit"] = "編集";
$net2ftp_messages["Update"] = "更新";
$net2ftp_messages["Open"] = "開く";
$net2ftp_messages["View the highlighted source code of file %1\$s"] = "ファイル %1\$s のソースコードを色付きで表示";
$net2ftp_messages["Edit the source code of file %1\$s"] = "ファイル %1\$s のソースコードを編集";
$net2ftp_messages["Upload a new version of the file %1\$s and merge the changes"] = "新しいバージョンのファイル %1\$s をアップロードし変更部分を併合";
$net2ftp_messages["View image %1\$s"] = "画像 %1\$s の表示";
$net2ftp_messages["View the file %1\$s from your HTTP web server"] = "ファイル %1\$s をあなたの HTTP webサーバで表示";
$net2ftp_messages["(Note: This link may not work if you don't have your own domain name.)"] = "(注釈: ご自分のドメインを所有しておられない方には、このリンクは機能しません。)";
$net2ftp_messages["This folder is empty"] = "このフォルダは空です";

// printSeparatorRow()
$net2ftp_messages["Directories"] = "ディレクトリ";
$net2ftp_messages["Files"] = "ファイル";
$net2ftp_messages["Symlinks"] = "シンボリックリンク";
$net2ftp_messages["Unrecognized FTP output"] = "不明な FTP 出力";
$net2ftp_messages["Number"] = "数";
$net2ftp_messages["Size"] = "サイズ";
$net2ftp_messages["Skipped"] = "省略";
$net2ftp_messages["Data transferred from this IP address today"] = "Data transferred from this IP address today";
$net2ftp_messages["Data transferred to this FTP server today"] = "Data transferred to this FTP server today";

// printLocationActions()
$net2ftp_messages["Language:"] = "言語:";
$net2ftp_messages["Skin:"] = "テーマ:";
$net2ftp_messages["View mode:"] = "表示モード:";
$net2ftp_messages["Directory Tree"] = "ツリー表示";

// ftp2http()
$net2ftp_messages["Execute %1\$s in a new window"] = "%1\$s を新しいウィンドウで実行";
$net2ftp_messages["This file is not accessible from the web"] = "このファイルは web上からアクセスできません";

// printDirectorySelect()
$net2ftp_messages["Double-click to go to a subdirectory:"] = "ダブルクリックでサブディレクトリへ移動:";
$net2ftp_messages["Choose"] = "選択";
$net2ftp_messages["Up"] = "上へ";

} // end browse


// -------------------------------------------------------------------------
// Calculate size module
if ($net2ftp_globals["state"] == "calculatesize") {
// -------------------------------------------------------------------------
$net2ftp_messages["Size of selected directories and files"] = "選択されたディレクトリとファイルのサイズ";
$net2ftp_messages["The total size taken by the selected directories and files is:"] = "選択されたディレクトリとファイルの合計サイズ:";
$net2ftp_messages["The number of files which were skipped is:"] = "省略されたファイルの個数:";

} // end calculatesize


// -------------------------------------------------------------------------
// Chmod module
if ($net2ftp_globals["state"] == "chmod") {
// -------------------------------------------------------------------------
$net2ftp_messages["Chmod directories and files"] = "ディレクトリとファイルの許可情報の変更";
$net2ftp_messages["Set all permissions"] = "全て設定";
$net2ftp_messages["Read"] = "読み取り";
$net2ftp_messages["Write"] = "書き込み";
$net2ftp_messages["Execute"] = "実行";
$net2ftp_messages["Owner"] = "所有者";
$net2ftp_messages["Group"] = "グループ";
$net2ftp_messages["Everyone"] = "全員";
$net2ftp_messages["To set all permissions to the same values, enter those permissions and click on the button \"Set all permissions\""] = "全ての許可情報を同じ値にするには、上の欄で許可情報を入力し \"全て設定\" ボタンをクリックしてください";
$net2ftp_messages["Set the permissions of directory <b>%1\$s</b> to: "] = "ディレクトリ <b>%1\$s</b> の許可情報の変更: ";
$net2ftp_messages["Set the permissions of file <b>%1\$s</b> to: "] = "ファイル <b>%1\$s</b> の許可情報の変更: ";
$net2ftp_messages["Set the permissions of symlink <b>%1\$s</b> to: "] = "シンボリックリンク <b>%1\$s</b> の許可情報の変更: ";
$net2ftp_messages["Chmod value"] = "設定値";
$net2ftp_messages["Chmod also the subdirectories within this directory"] = "このディレクトリの中のサブディレクトリも変更";
$net2ftp_messages["Chmod also the files within this directory"] = "このディレクトリの中のファイルも変更";
$net2ftp_messages["The chmod nr <b>%1\$s</b> is out of the range 000-777. Please try again."] = "設定値エラー: <b>%1\$s</b> は 000 〜 777 の値ではありません。再設定して下さい。";

} // end chmod


// -------------------------------------------------------------------------
// Clear cookies module
// -------------------------------------------------------------------------
// No messages


// -------------------------------------------------------------------------
// Copy/Move/Delete module
if ($net2ftp_globals["state"] == "copymovedelete") {
// -------------------------------------------------------------------------
$net2ftp_messages["Choose a directory"] = "ディレクトリを選択";
$net2ftp_messages["Copy directories and files"] = "ディレクトリとファイルのコピー";
$net2ftp_messages["Move directories and files"] = "ディレクトリとファイルの移動";
$net2ftp_messages["Delete directories and files"] = "ディレクトリとファイルの削除";
$net2ftp_messages["Are you sure you want to delete these directories and files?"] = "これらのファイルを削除してもよろしいですか?";
$net2ftp_messages["All the subdirectories and files of the selected directories will also be deleted!"] = "選択されたディレクトリ内のサブディレクトリとファイルも削除されます!";
$net2ftp_messages["Set all targetdirectories"] = "全ての対象ディレクトリを選択";
$net2ftp_messages["To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."] = "共通の対象ディレクトリを設定するには、上のテキストボックスに対象ディレクトリを入力し \"全ての対象ディレクトリを選択\" ボタンをクリックして下さい。";
$net2ftp_messages["Note: the target directory must already exist before anything can be copied into it."] = "注釈: コピーする前に、対象ディレクトリが既に存在していなければなりません。";
$net2ftp_messages["Different target FTP server:"] = "別の対象 FTP サーバ:";
$net2ftp_messages["Username"] = "ユーザ名";
$net2ftp_messages["Password"] = "パスワード";
$net2ftp_messages["Leave empty if you want to copy the files to the same FTP server."] = "同じ FTP サーバにファイルをコピーするときは、何も入力しないで下さい。";
$net2ftp_messages["If you want to copy the files to another FTP server, enter your login data."] = "別の FTP サーバにファイルをコピーするときは、あなたのログイン情報を入力して下さい。";
$net2ftp_messages["Leave empty if you want to move the files to the same FTP server."] = "同じ FTP サーバにファイルを移動するときは、何も入力しないで下さい。";
$net2ftp_messages["If you want to move the files to another FTP server, enter your login data."] = "別の FTP サーバにファイルを移動するときは、あなたのログイン情報を入力して下さい。";
$net2ftp_messages["Copy directory <b>%1\$s</b> to:"] = "ディレクトリ <b>%1\$s</b> のコピー先:";
$net2ftp_messages["Move directory <b>%1\$s</b> to:"] = "ディレクトリ <b>%1\$s</b> の移動先:";
$net2ftp_messages["Directory <b>%1\$s</b>"] = "ディレクトリ <b>%1\$s</b>";
$net2ftp_messages["Copy file <b>%1\$s</b> to:"] = "ファイル <b>%1\$s</b> のコピー先:";
$net2ftp_messages["Move file <b>%1\$s</b> to:"] = "ファイル <b>%1\$s</b> の移動先:";
$net2ftp_messages["File <b>%1\$s</b>"] = "ファイル <b>%1\$s</b>";
$net2ftp_messages["Copy symlink <b>%1\$s</b> to:"] = "シンボリックリンク <b>%1\$s</b> のコピー先:";
$net2ftp_messages["Move symlink <b>%1\$s</b> to:"] = "シンボリックリンク <b>%1\$s</b> の移動先:";
$net2ftp_messages["Symlink <b>%1\$s</b>"] = "シンボリックリンク <b>%1\$s</b>";
$net2ftp_messages["Target directory:"] = "対象ディレクトリ:";
$net2ftp_messages["Target name:"] = "対象名:";
$net2ftp_messages["Processing the entries:"] = "エントリを処理しています:";

} // end copymovedelete


// -------------------------------------------------------------------------
// Download file module
// -------------------------------------------------------------------------
// No messages


// -------------------------------------------------------------------------
// EasyWebsite module
if ($net2ftp_globals["state"] == "easyWebsite") {
// -------------------------------------------------------------------------
$net2ftp_messages["Create a website in 4 easy steps"] = "webサイトを簡単な4つのステップで作成";
$net2ftp_messages["Template overview"] = "テンプレート一覧";
$net2ftp_messages["Template details"] = "テンプレート詳細";
$net2ftp_messages["Files are copied"] = "コピーしたファイル";
$net2ftp_messages["Edit your pages"] = "ページを編集する";

// Screen 1 - printTemplateOverview
$net2ftp_messages["Click on the image to view the details of a template."] = "画像をクリックするとテンプレートの詳細を表示します。";
$net2ftp_messages["Back to the Browse screen"] = "ブラウザ画面に戻る";
$net2ftp_messages["Template"] = "テンプレート";
$net2ftp_messages["Copyright"] = "Copyright";
$net2ftp_messages["Click on the image to view the details of this template"] = "画像をクリックするとこのテンプレートの詳細を表示します";

// Screen 2 - printTemplateDetails
$net2ftp_messages["The template files will be copied to your FTP server. Existing files with the same filename will be overwritten. Do you want to continue?"] = "テンプレートファイルがあなたの FTPサーバにコピーされます。同名のファイルが存在すると上書きします。続けますか？";
$net2ftp_messages["Install template to directory: "] = "テンプレートをディレクトリにインストール: ";
$net2ftp_messages["Install"] = "Install";
$net2ftp_messages["Size"] = "サイズ";
$net2ftp_messages["Preview page"] = "プレビュー";
$net2ftp_messages["opens in a new window"] = "新しいウィンドウで開く";

// Screen 3
$net2ftp_messages["Please wait while the template files are being transferred to your server: "] = "テンプレートファイルがあなたのサーバへ転送されます。しばらくお待ち下さい: ";
$net2ftp_messages["Done."] = "完了。";
$net2ftp_messages["Continue"] = "続ける";

// Screen 4 - printEasyAdminPanel
$net2ftp_messages["Edit page"] = "ページの編集";
$net2ftp_messages["Browse the FTP server"] = "FTPサーバを閲覧";
$net2ftp_messages["Add this link to your favorites to return to this page later on!"] = "リンクをお気に入りに追加して、後でまたこのページに戻れるようにする!";
$net2ftp_messages["Edit website at %1\$s"] = "webサイト %1\$s を編集";
$net2ftp_messages["Internet Explorer: right-click on the link and choose \"Add to Favorites...\""] = "Internet Explorer: リンクを右クリックし\"お気に入りに追加...\"を選択";
$net2ftp_messages["Netscape, Mozilla, Firefox: right-click on the link and choose \"Bookmark This Link...\""] = "Netscape, Mozilla, Firefox: リンクを右クリックし\"Bookmark This Link...\"を選択";

// ftp_copy_local2ftp
$net2ftp_messages["WARNING: Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing..."] = "警告: サブディレクトリ <b>%1\$s</b> を作成することができません。もうすでに存在しています。続行します...";
$net2ftp_messages["Created target subdirectory <b>%1\$s</b>"] = "対象のサブディレクトリ <b>%1\$s</b> を作成";
$net2ftp_messages["WARNING: Unable to copy the file <b>%1\$s</b>. Continuing..."] = "警告: ファイル <b>%1\$s</b> をコピーすることができません。続行します...";
$net2ftp_messages["Copied file <b>%1\$s</b>"] = "ファイル <b>%1\$s</b> をコピー";
}


// -------------------------------------------------------------------------
// Edit module
if ($net2ftp_globals["state"] == "edit") {
// -------------------------------------------------------------------------

// /modules/edit/edit.inc.php
$net2ftp_messages["Unable to open the template file"] = "テンプレートファイルが開けません";
$net2ftp_messages["Unable to read the template file"] = "テンプレートファイルが読み込めません";
$net2ftp_messages["Please specify a filename"] = "ファイル名を指定してください";
$net2ftp_messages["Status: This file has not yet been saved"] = "ステータス: このファイルはまだ保存されていません";
$net2ftp_messages["Status: Saved on <b>%1\$s</b> using mode %2\$s"] = "ステータス: %2\$s モードで <b>%1\$s</b> 上に保存されました";
$net2ftp_messages["Status: <b>This file could not be saved</b>"] = "ステータス: <b>このファイルは保存できません</b>";
$net2ftp_messages["Not yet saved"] = "Not yet saved";
$net2ftp_messages["Could not be saved"] = "Could not be saved";
$net2ftp_messages["Saved at %1\$s"] = "Saved at %1\$s";

// /skins/[skin]/edit.template.php
$net2ftp_messages["Directory: "] = "ディレクトリ: ";
$net2ftp_messages["File: "] = "ファイル: ";
$net2ftp_messages["New file name: "] = "新しいファイル名: ";
$net2ftp_messages["Character encoding: "] = "Character encoding: ";
$net2ftp_messages["Note: changing the textarea type will save the changes"] = "注釈: テキストエリアタイプを変更すると、変更箇所は保存されることになります";
$net2ftp_messages["Copy up"] = "上にコピー";
$net2ftp_messages["Copy down"] = "下にコピー";

} // end if edit


// -------------------------------------------------------------------------
// Find string module
if ($net2ftp_globals["state"] == "findstring") {
// -------------------------------------------------------------------------

// /modules/findstring/findstring.inc.php 
$net2ftp_messages["Search directories and files"] = "ファイルとディレクトリを検索";
$net2ftp_messages["Search again"] = "再検索";
$net2ftp_messages["Search results"] = "検索結果";
$net2ftp_messages["Please enter a valid search word or phrase."] = "有効な単語または語句を入力してください。";
$net2ftp_messages["Please enter a valid filename."] = "有効なファイル名を入力してください。";
$net2ftp_messages["Please enter a valid file size in the \"from\" textbox, for example 0."] = "有効なファイルサイズを \"from\" テキストボックスに入力して下さい。(例: 0)";
$net2ftp_messages["Please enter a valid file size in the \"to\" textbox, for example 500000."] = "有効なファイルサイズを \"to\" テキストボックスに入力して下さい。(例: 500000)";
$net2ftp_messages["Please enter a valid date in Y-m-d format in the \"from\" textbox."] = "Y-m-d 形式の有効な日付を \"from\" テキストボックスに入力して下さい。";
$net2ftp_messages["Please enter a valid date in Y-m-d format in the \"to\" textbox."] = "Y-m-d 形式の有効な日付を \"to\" テキストボックスに入力して下さい。";
$net2ftp_messages["The word <b>%1\$s</b> was not found in the selected directories and files."] = "文字列 <b>%1\$s</b> は選択されたディレクトリとファイル中には見つかりませんでした。";
$net2ftp_messages["The word <b>%1\$s</b> was found in the following files:"] = "文字列 <b>%1\$s</b> は次のファイル中に見つかりました:";

// /skins/[skin]/findstring1.template.php
$net2ftp_messages["Search for a word or phrase"] = "文字列の検索";
$net2ftp_messages["Case sensitive search"] = "詳細検索";
$net2ftp_messages["Restrict the search to:"] = "検索制限:";
$net2ftp_messages["files with a filename like"] = "ファイル名指定";
$net2ftp_messages["(wildcard character is *)"] = "(ワイルドカード: *)";
$net2ftp_messages["files with a size"] = "ファイルサイズ指定";
$net2ftp_messages["files which were last modified"] = "ファイルの最終更新日時で指定";
$net2ftp_messages["from"] = "from";
$net2ftp_messages["to"] = "to";

$net2ftp_messages["Directory"] = "フォルダ";
$net2ftp_messages["File"] = "ファイル";
$net2ftp_messages["Line"] = "行";
$net2ftp_messages["Action"] = "アクション";
$net2ftp_messages["View"] = "閲覧";
$net2ftp_messages["Edit"] = "編集";
$net2ftp_messages["View the highlighted source code of file %1\$s"] = "ファイル %1\$s のソースコードを色付きで表示";
$net2ftp_messages["Edit the source code of file %1\$s"] = "ファイル %1\$s のソースコードを編集";

} // end findstring


// -------------------------------------------------------------------------
// Help module
// -------------------------------------------------------------------------
// No messages yet


// -------------------------------------------------------------------------
// Install size module
if ($net2ftp_globals["state"] == "install") {
// -------------------------------------------------------------------------

// /modules/install/install.inc.php
$net2ftp_messages["Install software packages"] = "Install software packages";
$net2ftp_messages["Unable to open the template file"] = "テンプレートファイルが開けません";
$net2ftp_messages["Unable to read the template file"] = "テンプレートファイルが読み込めません";
$net2ftp_messages["Unable to get the list of packages"] = "Unable to get the list of packages";

// /skins/blue/install1.template.php
$net2ftp_messages["The net2ftp installer script has been copied to the FTP server."] = "The net2ftp installer script has been copied to the FTP server.";
$net2ftp_messages["This script runs on your web server and requires PHP to be installed."] = "This script runs on your web server and requires PHP to be installed.";
$net2ftp_messages["In order to run it, click on the link below."] = "In order to run it, click on the link below.";
$net2ftp_messages["net2ftp has tried to determine the directory mapping between the FTP server and the web server."] = "net2ftp has tried to determine the directory mapping between the FTP server and the web server.";
$net2ftp_messages["Should this link not be correct, enter the URL manually in your web browser."] = "Should this link not be correct, enter the URL manually in your web browser.";

} // end install


// -------------------------------------------------------------------------
// Java upload module
if ($net2ftp_globals["state"] == "jupload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Upload directories and files using a Java applet"] = "Javaアプレットを利用してディレクトリとファイルをアップロード";
$net2ftp_messages["Your browser does not support applets, or you have disabled applets in your browser settings."] = "Your browser does not support applets, or you have disabled applets in your browser settings.";
$net2ftp_messages["To use this applet, please install the newest version of Sun's java. You can get it from <a href=\"http://www.java.com/\">java.com</a>. Click on Get It Now."] = "To use this applet, please install the newest version of Sun's java. You can get it from <a href=\"http://www.java.com/\">java.com</a>. Click on Get It Now.";
$net2ftp_messages["The online installation is about 1-2 MB and the offline installation is about 13 MB. This 'end-user' java is called JRE (Java Runtime Environment)."] = "The online installation is about 1-2 MB and the offline installation is about 13 MB. This 'end-user' java is called JRE (Java Runtime Environment).";
$net2ftp_messages["Alternatively, use net2ftp's normal upload or upload-and-unzip functionality."] = "Alternatively, use net2ftp's normal upload or upload-and-unzip functionality.";

} // end jupload



// -------------------------------------------------------------------------
// Login module
if ($net2ftp_globals["state"] == "login") {
// -------------------------------------------------------------------------
$net2ftp_messages["Login!"] = "ログインしよう!";
$net2ftp_messages["Once you are logged in, you will be able to:"] = "Once you are logged in, you will be able to:";
$net2ftp_messages["Navigate the FTP server"] = "FTP サーバの操作";
$net2ftp_messages["Once you have logged in, you can browse from directory to directory and see all the subdirectories and files."] = "一度ログインすれば、ディレクトリとディレクトリ中のサブディレクトリ、ファイル全てを閲覧することができます。";
$net2ftp_messages["Upload files"] = "ファイルのアップロード";
$net2ftp_messages["There are 3 different ways to upload files: the standard upload form, the upload-and-unzip functionality, and the Java Applet."] = "3種類の方法でファイルをアップロードできます: 標準のアップロード、アップロード後自動解凍機能、Javaアプレットによるアップロード。";
$net2ftp_messages["Download files"] = "ファイルのダウンロード";
$net2ftp_messages["Click on a filename to quickly download one file.<br />Select multiple files and click on Download; the selected files will be downloaded in a zip archive."] = "ファイル名をクリックしてそのファイルを即座にダウンロードすることができます。<br />複数のファイルをクリックしてダウンロードすると、1つの圧縮ファイルにしてダウンロードされます。";
$net2ftp_messages["Zip files"] = "ファイルの圧縮";
$net2ftp_messages["... and save the zip archive on the FTP server, or email it to someone."] = "ファイルを圧縮して FTPサーバ上に保存したり、電子メールで送信することができます。";
$net2ftp_messages["Unzip files"] = "Unzip files";
$net2ftp_messages["Different formats are supported: .zip, .tar, .tgz and .gz."] = "Different formats are supported: .zip, .tar, .tgz and .gz.";
$net2ftp_messages["Install software"] = "Install software";
$net2ftp_messages["Choose from a list of popular applications (PHP required)."] = "Choose from a list of popular applications (PHP required).";
$net2ftp_messages["Copy, move and delete"] = "コピー、移動、削除";
$net2ftp_messages["Directories are handled recursively, meaning that their content (subdirectories and files) will also be copied, moved or deleted."] = "ディレクトリを繰り返し操作できます。その中のコンテンツ（サブディレクトリとファイル）もコピー、移動、削除できます。";
$net2ftp_messages["Copy or move to a 2nd FTP server"] = "別のFTPサーバへのコピー、移動";
$net2ftp_messages["Handy to import files to your FTP server, or to export files from your FTP server to another FTP server."] = "簡単にあなたの FTPサーバにファイルをインポートしたり、あなたの FTPサーバから別の FTPサーバへファイルをエキスポートすることができます。";
$net2ftp_messages["Rename and chmod"] = "ファイル名の変更と許可情報の変更";
$net2ftp_messages["Chmod handles directories recursively."] = "ディレクトリの許可情報の変更を繰り返し操作できます。";
$net2ftp_messages["View code with syntax highlighting"] = "色付きでコード表示";
$net2ftp_messages["PHP functions are linked to the documentation on php.net."] = "PHP機能は php.net のドキュメントとリンクしています。";
$net2ftp_messages["Plain text editor"] = "プレーンテキストエディタ";
$net2ftp_messages["Edit text right from your browser; every time you save the changes the new file is transferred to the FTP server."] = "ブラウザ上でテキストを正確に編集できます。変更して保存した新しいファイルは毎回 FTPサーバへ転送されます。";
$net2ftp_messages["HTML editors"] = "HTMLエディタ";
$net2ftp_messages["Edit HTML a What-You-See-Is-What-You-Get (WYSIWYG) form; there are 2 different editors to choose from."] = "Edit HTML a What-You-See-Is-What-You-Get (WYSIWYG) form; there are 2 different editors to choose from.";
$net2ftp_messages["Code editor"] = "コードエディタ";
$net2ftp_messages["Edit HTML and PHP in an editor with syntax highlighting."] = "HTML と PHP を色付き表示で編集できます。";
$net2ftp_messages["Search for words or phrases"] = "文字列の検索";
$net2ftp_messages["Filter out files based on the filename, last modification time and filesize."] = "表示するファイルをファイル名、最終変更日時、ファイルサイズでフィルタリングできます。";
$net2ftp_messages["Calculate size"] = "サイズの計算";
$net2ftp_messages["Calculate the size of directories and files."] = "ディレクトリとファイルのサイズを計算できます。";

$net2ftp_messages["FTP server"] = "FTP サーバ";
$net2ftp_messages["Example"] = "例";
$net2ftp_messages["Port"] = "ポート";
$net2ftp_messages["Protocol"] = "Protocol";
$net2ftp_messages["Username"] = "ユーザ名";
$net2ftp_messages["Password"] = "パスワード";
$net2ftp_messages["Anonymous"] = "匿名";
$net2ftp_messages["Passive mode"] = "Passive モード";
$net2ftp_messages["Initial directory"] = "初期ディレクトリ";
$net2ftp_messages["Language"] = "言語";
$net2ftp_messages["Skin"] = "テーマ";
$net2ftp_messages["FTP mode"] = "FTPモード";
$net2ftp_messages["Automatic"] = "自動";
$net2ftp_messages["Login"] = "ログイン";
$net2ftp_messages["Clear cookies"] = "クッキーの削除";
$net2ftp_messages["Admin"] = "Admin";
$net2ftp_messages["Please enter an FTP server."] = "FTPサーバを入力して下さい。";
$net2ftp_messages["Please enter a username."] = "ユーザ名を入力して下さい。";
$net2ftp_messages["Please enter a password."] = "パスワードを入力して下さい。";

} // end login


// -------------------------------------------------------------------------
// Login module
if ($net2ftp_globals["state"] == "login_small") {
// -------------------------------------------------------------------------

$net2ftp_messages["Please enter your Administrator username and password."] = "管理者のユーザ名とパスワードを入力して下さい。";
$net2ftp_messages["Please enter your username and password for FTP server <b>%1\$s</b>."] = "Please enter your username and password for FTP server <b>%1\$s</b>.";
$net2ftp_messages["Username"] = "ユーザ名";
$net2ftp_messages["Your session has expired; please enter your password for FTP server <b>%1\$s</b> to continue."] = "Your session has expired; please enter your password for FTP server <b>%1\$s</b> to continue.";
$net2ftp_messages["Your IP address has changed; please enter your password for FTP server <b>%1\$s</b> to continue."] = "Your IP address has changed; please enter your password for FTP server <b>%1\$s</b> to continue.";
$net2ftp_messages["Password"] = "パスワード";
$net2ftp_messages["Login"] = "ログイン";
$net2ftp_messages["Continue"] = "続ける";

} // end login_small


// -------------------------------------------------------------------------
// Logout module
if ($net2ftp_globals["state"] == "logout") {
// -------------------------------------------------------------------------

// logout.inc.php
$net2ftp_messages["Login page"] = "ログインページ";

// logout.template.php
$net2ftp_messages["You have logged out from the FTP server. To log back in, <a href=\"%1\$s\" title=\"Login page (accesskey l)\" accesskey=\"l\">follow this link</a>."] = "You have logged out from the FTP server. To log back in, <a href=\"%1\$s\" title=\"Login page (accesskey l)\" accesskey=\"l\">follow this link</a>.";
$net2ftp_messages["Note: other users of this computer could click on the browser's Back button and access the FTP server."] = "注釈: ブラウザの戻るボタンをクリックすると、このコンピュータの他のユーザが FTPサーバにアクセスすることができてしまいます。";
$net2ftp_messages["To prevent this, you must close all browser windows."] = "これを防ぐためには、全てのブラウザのウィンドウを閉じる必要があります。";
$net2ftp_messages["Close"] = "閉じる";
$net2ftp_messages["Click here to close this window"] = "ここをクリックするとこのウィンドウを閉じます";

} // end logout


// -------------------------------------------------------------------------
// New directory module
if ($net2ftp_globals["state"] == "newdir") {
// -------------------------------------------------------------------------
$net2ftp_messages["Create new directories"] = "新規ディレクトリの作成";
$net2ftp_messages["The new directories will be created in <b>%1\$s</b>."] = "新規ディレクトリは <b>%1\$s</b> に作成されます。";
$net2ftp_messages["New directory name:"] = "新規ディレクトリ名:";
$net2ftp_messages["Directory <b>%1\$s</b> was successfully created."] = "ディレクトリ <b>%1\$s</b> が作成されました。";
$net2ftp_messages["Directory <b>%1\$s</b> could not be created."] = "ディレクトリ <b>%1\$s</b> を作成することができませんでした。";

} // end newdir


// -------------------------------------------------------------------------
// Raw module
if ($net2ftp_globals["state"] == "raw") {
// -------------------------------------------------------------------------

// /modules/raw/raw.inc.php
$net2ftp_messages["Send arbitrary FTP commands"] = "任意の FTPコマンドを送信";


// /skins/[skin]/raw1.template.php
$net2ftp_messages["List of commands:"] = "コマンドのリスト:";
$net2ftp_messages["FTP server response:"] = "FTPサーバの応答:";

} // end raw


// -------------------------------------------------------------------------
// Rename module
if ($net2ftp_globals["state"] == "rename") {
// -------------------------------------------------------------------------
$net2ftp_messages["Rename directories and files"] = "ディレクトリ名とファイル名の変更";
$net2ftp_messages["Old name: "] = "以前の名前: ";
$net2ftp_messages["New name: "] = "新しい名前: ";
$net2ftp_messages["The new name may not contain any dots. This entry was not renamed to <b>%1\$s</b>"] = "新しいファイル名にドット(.)を含むことはできません。このエントリは <b>%1\$s</b> に改名されませんでした。";
$net2ftp_messages["The new name may not contain any banned keywords. This entry was not renamed to <b>%1\$s</b>"] = "The new name may not contain any banned keywords. This entry was not renamed to <b>%1\$s</b>";
$net2ftp_messages["<b>%1\$s</b> was successfully renamed to <b>%2\$s</b>"] = "<b>%1\$s</b> は <b>%2\$s</b> に改名されました";
$net2ftp_messages["<b>%1\$s</b> could not be renamed to <b>%2\$s</b>"] = "<b>%1\$s</b> を <b>%2\$s</b> に改名することはできません";

} // end rename


// -------------------------------------------------------------------------
// Unzip module
if ($net2ftp_globals["state"] == "unzip") {
// -------------------------------------------------------------------------

// /modules/unzip/unzip.inc.php
$net2ftp_messages["Unzip archives"] = "Unzip archives";
$net2ftp_messages["Getting archive %1\$s of %2\$s from the FTP server"] = "Getting archive %1\$s of %2\$s from the FTP server";
$net2ftp_messages["Unable to get the archive <b>%1\$s</b> from the FTP server"] = "Unable to get the archive <b>%1\$s</b> from the FTP server";

// /skins/[skin]/unzip1.template.php
$net2ftp_messages["Set all targetdirectories"] = "全ての対象ディレクトリを選択";
$net2ftp_messages["To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."] = "共通の対象ディレクトリを設定するには、上のテキストボックスに対象ディレクトリを入力し \"全ての対象ディレクトリを選択\" ボタンをクリックして下さい。";
$net2ftp_messages["Note: the target directory must already exist before anything can be copied into it."] = "注釈: コピーする前に、対象ディレクトリが既に存在していなければなりません。";
$net2ftp_messages["Unzip archive <b>%1\$s</b> to:"] = "Unzip archive <b>%1\$s</b> to:";
$net2ftp_messages["Target directory:"] = "対象ディレクトリ:";
$net2ftp_messages["Use folder names (creates subdirectories automatically)"] = "フォルダ名を使用 (サブディレクトリの自動作成)";

} // end unzip


// -------------------------------------------------------------------------
// Upload module
if ($net2ftp_globals["state"] == "upload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Upload to directory:"] = "アップロード先のディレクトリ:";
$net2ftp_messages["Files"] = "ファイル";
$net2ftp_messages["Archives"] = "圧縮ファイル";
$net2ftp_messages["Files entered here will be transferred to the FTP server."] = "ここに入力したファイルが FTP サーバへ転送されます。";
$net2ftp_messages["Archives entered here will be decompressed, and the files inside will be transferred to the FTP server."] = "ここに入力した圧縮ファイルが解凍され、中のファイルが FTP サーバへ転送されます。";
$net2ftp_messages["Add another"] = "追加";
$net2ftp_messages["Use folder names (creates subdirectories automatically)"] = "フォルダ名を使用 (サブディレクトリの自動作成)";

$net2ftp_messages["Choose a directory"] = "ディレクトリを選択";
$net2ftp_messages["Please wait..."] = "しばらくお待ち下さい...";
$net2ftp_messages["Uploading... please wait..."] = "アップロード中... しばらくお待ち下さい...";
$net2ftp_messages["If the upload takes more than the allowed <b>%1\$s seconds<\/b>, you will have to try again with less/smaller files."] = "アップロードが許容時間 <b>%1\$s 秒<\/b>を超えるようならば、より小さい/少ないファイルでやり直す必要があります。";
$net2ftp_messages["This window will close automatically in a few seconds."] = "このウィンドウは数秒後に自動で閉じられます。";
$net2ftp_messages["Close window now"] = "今すぐ閉じる";

$net2ftp_messages["Upload files and archives"] = "ファイルと圧縮ファイルのアップロード";
$net2ftp_messages["Upload results"] = "アップロード結果";
$net2ftp_messages["Checking files:"] = "ファイルのチェック中:";
$net2ftp_messages["Transferring files to the FTP server:"] = "ファイルを FTP サーバへ転送中:";
$net2ftp_messages["Decompressing archives and transferring files to the FTP server:"] = "圧縮ファイルを解凍しファイルを FTP サーバへ転送中:";
$net2ftp_messages["Upload more files and archives"] = "他のファイルと圧縮ファイルもアップロードする";

} // end upload


// -------------------------------------------------------------------------
// Messages which are shared by upload and jupload
if ($net2ftp_globals["state"] == "upload" || $net2ftp_globals["state"] == "jupload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Restrictions:"] = "サイズ制限:";
$net2ftp_messages["The maximum size of one file is restricted by net2ftp to <b>%1\$s</b> and by PHP to <b>%2\$s</b>"] = "1つのファイルの上限サイズは net2ftp で <b>%1\$s</b> まで、 PHP で <b>%2\$s</b> までに制限されています";
$net2ftp_messages["The maximum execution time is <b>%1\$s seconds</b>"] = "処理時間の上限は <b>%1\$s 秒</b> です";
$net2ftp_messages["The FTP transfer mode (ASCII or BINARY) will be automatically determined, based on the filename extension"] = "FTP 転送モード (ASCII または バイナリ) はファイル名の拡張子によって自動的に決定されます";
$net2ftp_messages["If the destination file already exists, it will be overwritten"] = "転送先に同名のファイルがすでに存在する場合は上書きされます";

} // end upload or jupload


// -------------------------------------------------------------------------
// View module
if ($net2ftp_globals["state"] == "view") {
// -------------------------------------------------------------------------

// /modules/view/view.inc.php
$net2ftp_messages["View file %1\$s"] = "ファイル %1\$s の表示";
$net2ftp_messages["View image %1\$s"] = "画像 %1\$s の表示";
$net2ftp_messages["View Macromedia ShockWave Flash movie %1\$s"] = "Macromedia ShockWave Flash ムービー %1\$s の表示";
$net2ftp_messages["Image"] = "画像";

// /skins/[skin]/view1.template.php
$net2ftp_messages["Syntax highlighting powered by <a href=\"http://luminous.asgaard.co.uk\">Luminous</a>"] = "色付き表示は <a href=\"http://luminous.asgaard.co.uk\">Luminous</a> から供給されています";
$net2ftp_messages["To save the image, right-click on it and choose 'Save picture as...'"] = "画像を保存するには、画像の上で右クリックし '名前を付けて画像を保存...' を選択してください";

} // end view


// -------------------------------------------------------------------------
// Zip module
if ($net2ftp_globals["state"] == "zip") {
// -------------------------------------------------------------------------

// /modules/zip/zip.inc.php
$net2ftp_messages["Zip entries"] = "圧縮ファイルエントリ";

// /skins/[skin]/zip1.template.php
$net2ftp_messages["Save the zip file on the FTP server as:"] = "FTP サーバ上で次のファイルを圧縮:";
$net2ftp_messages["Email the zip file in attachment to:"] = "Email に圧縮ファイルを添付:";
$net2ftp_messages["Note that sending files is not anonymous: your IP address as well as the time of the sending will be added to the email."] = "注釈: ファイルは匿名では送信されません。あなたの IP アドレスが送信時に email に追加されます。";
$net2ftp_messages["Some additional comments to add in the email:"] = "email に追加するコメント:";

$net2ftp_messages["You did not enter a filename for the zipfile. Go back and enter a filename."] = "圧縮ファイルのファイル名が入力されていません。戻るをクリックしてファイル名を入力して下さい。";
$net2ftp_messages["The email address you have entered (%1\$s) does not seem to be valid.<br />Please enter an address in the format <b>username@domain.com</b>"] = "入力された email アドレス (%1\$s) は有効ではありません。<br />次の書式に則ったアドレスを入力して下さい <b>username@domain.com</b>";

} // end zip

?>