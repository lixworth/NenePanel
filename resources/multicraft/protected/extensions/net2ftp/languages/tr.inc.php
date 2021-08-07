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
//  |     $messages[...] = ["Le fichier %1\$s a été copié vers %2\$s "]             |
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
$net2ftp_messages["en"] = "tr";

// HTML dir attribute: left-to-right (LTR) or right-to-left (RTL)
$net2ftp_messages["ltr"] = "ltr";

// CSS style: align left or right (use in combination with LTR or RTL)
$net2ftp_messages["left"] = "left";
$net2ftp_messages["right"] = "right";

// Encoding
$net2ftp_messages["iso-8859-1"] = "iso-8859-9";


// -------------------------------------------------------------------------
// Status messages
// -------------------------------------------------------------------------

// When translating these messages, keep in mind that the text should not be too long
// It should fit in the status textbox

$net2ftp_messages["Connecting to the FTP server"] = "FTP sunucusuna baglaniyor";
$net2ftp_messages["Logging into the FTP server"] = "FTP sunucusuna giris yapiyor";
$net2ftp_messages["Setting the passive mode"] = "Pasif moda geciyor";                 //geçiyor: ayarlıyor
$net2ftp_messages["Getting the FTP system type"] = "FTP sistem türünü aliyor";
$net2ftp_messages["Changing the directory"] = "Dizini degistiriyor";                  //dizini: klasörü
$net2ftp_messages["Getting the current directory"] = "Güncel dizini aliyor";          //dizini: klasörü
$net2ftp_messages["Getting the list of directories and files"] = "Dosya ve dizinlerin listesini aliyor";           //dizinlerin: klasörlerin
$net2ftp_messages["Parsing the list of directories and files"] = "Dosya ve dizinlerin listesini cözümlüyor";       //parsing: ?
$net2ftp_messages["Logging out of the FTP server"] = "FTP sunucusundan cikis yapiyor";
$net2ftp_messages["Getting the list of directories and files"] = "Dosya ve dizinlerin listesini aliyor";           //dizinlerin: klasörlerin
$net2ftp_messages["Printing the list of directories and files"] = "Dosya ve dizinlerin listesini yazdiriyor";      //dizinlerin: klasörlerin
$net2ftp_messages["Processing the entries"] = "Girisi isleme aliyor";
$net2ftp_messages["Processing entry %1\$s"] = "Girisi isleme aliyor %1\$s";
$net2ftp_messages["Checking files"] = "Dosyalari denetliyor";
$net2ftp_messages["Transferring files to the FTP server"] = "FTP sunucusuna dosyalari aktariyor";
$net2ftp_messages["Decompressing archives and transferring files"] = "Arsiv paketini aciyor ve dosyalari aktariyor";
$net2ftp_messages["Searching the files..."] = "Dosyalari ariyor...";
$net2ftp_messages["Uploading new file"] = "Yeni dosya yüklüyor";
$net2ftp_messages["Reading the file"] = "Dosyayi okuyor";
$net2ftp_messages["Parsing the file"] = "Dosyayi çözümlüyor";
$net2ftp_messages["Reading the new file"] = "Yeni dosyayi okuyor";
$net2ftp_messages["Reading the old file"] = "Eski dosyayi okuyor";
$net2ftp_messages["Comparing the 2 files"] = "2 Dosyayi karsilastiriyor";
$net2ftp_messages["Printing the comparison"] = "Karsilastirmayi yazdiriyor";
$net2ftp_messages["Sending FTP command %1\$s of %2\$s"] = "FTP komutu gönderiyor %1\$s - %2\$s";
$net2ftp_messages["Getting archive %1\$s of %2\$s from the FTP server"] = "FTP sunucusundan arsiv paketini aliyor %1\$s - %2\$s";
$net2ftp_messages["Creating a temporary directory on the FTP server"] = "FTP sunucusunda gecici dizin oluşturuyor";           //dizin: klasör
$net2ftp_messages["Setting the permissions of the temporary directory"] = "Gecici diznin iznini ayarliyor";
$net2ftp_messages["Copying the net2ftp installer script to the FTP server"] = "FTP sunucusuna net2ftp yükleyici yazilimini kopyaliyor";
$net2ftp_messages["Script finished in %1\$s seconds"] = "Yazilim %1\$s saniyede bitti";
$net2ftp_messages["Script halted"] = "Yazılım durdu";

// Used on various screens
$net2ftp_messages["Please wait..."] = "Lütfen bekleyin...";


// -------------------------------------------------------------------------
// index.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unexpected state string: %1\$s. Exiting."] = "Beklenmeyen durum dizisi: %1\$s. Çıkıyor.";
$net2ftp_messages["This beta function is not activated on this server."] = "Bu beta işlevi, bu sunucuda açılmadı.";    //activated: ?
$net2ftp_messages["This function has been disabled by the Administrator of this website."] = "Bu işlev bu websitenin Yöneticisi tarafından kapatıldı.";    //disabled: ?


// -------------------------------------------------------------------------
// /includes/browse.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["The directory <b>%1\$s</b> does not exist or could not be selected, so the directory <b>%2\$s</b> is shown instead."] = "Dizin <b>%1\$s</b> yok veya seçilemiyor, bu yüzden yerine <b>%2\$s</b> dizini gösteriliyor.";
$net2ftp_messages["Your root directory <b>%1\$s</b> does not exist or could not be selected."] = "Ana dizininiz <b>%1\$s</b> yok veya seçilemiyor.";
$net2ftp_messages["The directory <b>%1\$s</b> could not be selected - you may not have sufficient rights to view this directory, or it may not exist."] = "Dizin <b>%1\$s</b> seçilemiyor - bu dizini görüntüleyebilmek için yeterli haklara sahip olmayabilirsiniz veya o, var değil.";
$net2ftp_messages["Entries which contain banned keywords can't be managed using net2ftp. This is to avoid Paypal or Ebay scams from being uploaded through net2ftp."] = "Yasaklı anahtar kelimeleri içeren girişler net2ftp kullanılarak yönetilemez. Bu, net2ftp yoluyla Paypal veya Ebay dolandırıcılığının yüklenmesini önlemek içindir.";
$net2ftp_messages["Files which are too big can't be downloaded, uploaded, copied, moved, searched, zipped, unzipped, viewed or edited; they can only be renamed, chmodded or deleted."] = "Çok büyük olan dosyalar, indirilemez, yüklenemez, kopyalanamaz, taşınamaz, aranamaz, arşiv paketine eklenemez, arşiv paketinden çıkartılamaz, görüntülemez veya düzenlemez; sadece yeniden adlandırılabilir, izinleri değiştirilebilir veya silinebilir.";
$net2ftp_messages["Execute %1\$s in a new window"] = "Yeni pencerede %1\$s gerçekleştir";


// -------------------------------------------------------------------------
// /includes/main.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Please select at least one directory or file!"] = "Lütfen en azından bir dizin veya dosya seçin!";


// -------------------------------------------------------------------------
// /includes/authorizations.inc.php
// -------------------------------------------------------------------------

// checkAuthorization()
$net2ftp_messages["The FTP server <b>%1\$s</b> is not in the list of allowed FTP servers."] = "FTP sunucusu <b>%1\$s</b> izin verilen FTP sunucuları listesinde değil.";
$net2ftp_messages["The FTP server <b>%1\$s</b> is in the list of banned FTP servers."] = "FTP sunucusu <b>%1\$s</b> yasaklı FTP sunucuları listesinde.";
$net2ftp_messages["The FTP server port %1\$s may not be used."] = "FTP sunucusu portu %1\$s kullanılmayabilir.";
$net2ftp_messages["Your IP address (%1\$s) is not in the list of allowed IP addresses."] = "Your IP address (%1\$s) is not in the list of allowed IP addresses.";
$net2ftp_messages["Your IP address (%1\$s) is in the list of banned IP addresses."] = "IP adresiniz (%1\$s) yasaklı IP adresleri listesinde.";

// isAuthorizedDirectory()
$net2ftp_messages["Table net2ftp_users contains duplicate rows."] = "net2ftp_users tablosu çift dizeler içeriyor.";     //dublicate: ?

// checkAdminUsernamePassword()
$net2ftp_messages["You did not enter your Administrator username or password."] = "Yönetici kullanıcı adınızı veya şifrenizi girmediniz.";
$net2ftp_messages["Wrong username or password. Please try again."] = "Yanlış kullanıcı adı veya şifre. Lütfen tekrar deneyin.";

// -------------------------------------------------------------------------
// /includes/consumption.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unable to determine your IP address."] = "IP adresinizi belirleyemiyor.";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress contains duplicate rows."] = "net2ftp_log_consumption_ipaddress tablosu çift dizeler içeriyor.";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver contains duplicate rows."] = "net2ftp_log_consumption_ftpserver tablosu çift dizeler içeriyor.";
$net2ftp_messages["The variable <b>consumption_ipaddress_datatransfer</b> is not numeric."] = "<b>consumption_ipaddress_datatransfer</b> değişkeni sayısal değil.";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress could not be updated."] = "net2ftp_log_consumption_ipaddress tablosu güncellenemiyor.";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress contains duplicate entries."] = "net2ftp_log_consumption_ipaddress tablosu contains çift girişler içeriyor.";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver could not be updated."] = "net2ftp_log_consumption_ftpserver tablosu güncellenemiyor.";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver contains duplicate entries."] = "net2ftp_log_consumption_ftpserver tablosu çift girişler içeriyor.";
$net2ftp_messages["Table net2ftp_log_access could not be updated."] = "Table net2ftp_log_access could not be updated.";
$net2ftp_messages["Table net2ftp_log_access contains duplicate entries."] = "Table net2ftp_log_access contains duplicate entries.";


// -------------------------------------------------------------------------
// /includes/database.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unable to connect to the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php."] = "MySQL veritabanına bağlanamıyor. Lütfen MySQL veritabanı ayarlarınızı net2ftp'nin ayar dosyası settings.inc.php de denetleyin.";
$net2ftp_messages["Unable to select the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php."] = "MySQL veritabanını seçemiyor. Lütfen MySQL veritabanı ayarlarınızı net2ftp'nin ayar dosyası settings.inc.php de denetleyin.";


// -------------------------------------------------------------------------
// /includes/errorhandling.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["An error has occured"] = "Bir hata oluştu";
$net2ftp_messages["Go back"] = "Geri dön";
$net2ftp_messages["Go to the login page"] = "Giriş sayfasına git";


// -------------------------------------------------------------------------
// /includes/filesystem.inc.php
// -------------------------------------------------------------------------

// ftp_openconnection()
$net2ftp_messages["The <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">FTP module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">php.net</a><br />"] = "The <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">FTP module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">php.net</a><br />";
$net2ftp_messages["The <a href=\"http://www.php.net/manual/en/function.ftp-ssl-connect.php\" target=\"_blank\">FTP and/or OpenSSL modules of PHP</a> is not installed.<br /><br /> The administrator of this website should install these modules. Installation instructions are given on php.net: <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">here for FTP</a>, and <a href=\"http://www.php.net/manual/en/openssl.installation.php\" target=\"_blank\">here for OpenSSL</a><br />"] = "The <a href=\"http://www.php.net/manual/en/function.ftp-ssl-connect.php\" target=\"_blank\">FTP and/or OpenSSL modules of PHP</a> is not installed.<br /><br /> The administrator of this website should install these modules. Installation instructions are given on php.net: <a href=\"http://www.php.net/manual/en/ftp.installation.php\" target=\"_blank\">here for FTP</a>, and <a href=\"http://www.php.net/manual/en/openssl.installation.php\" target=\"_blank\">here for OpenSSL</a><br />";
$net2ftp_messages["The <a href=\"http://www.php.net/manual/en/function.ssh2-sftp.php\" target=\"_blank\">SSH2 module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ssh2.installation.php\" target=\"_blank\">php.net</a><br />"] = "The <a href=\"http://www.php.net/manual/en/function.ssh2-sftp.php\" target=\"_blank\">SSH2 module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ssh2.installation.php\" target=\"_blank\">php.net</a><br />";
$net2ftp_messages["Unable to connect to FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />"] = "FTP sunucusuna <b>%1\$s</b> portunda <b>%2\$s</b> bağlanamıyor.<br /><br />FTP sunucusunun adresinin bu olduğundan emin misiniz? Bu sıklıkla HTTP (web) sunucusununkinden farklıdır. Lütfen yardım için ISS yardım masanızla ya da sistem yöneticinizle iletişim kurun.<br />";
$net2ftp_messages["Unable to login to FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />"] = "FTP sunucusuna <b>%1\$s</b> kullanıcı adıyla <b>%2\$s</b> giriş yapamıyor.<br /><br />Kullanıcı adınızın ve şifrenizin doğru olduğundan emin misiniz? Lütfen yardım için ISS yardım masanızla ya da sistem yöneticinizle iletişim kurun.<br />";
$net2ftp_messages["Unable to switch to the passive mode on FTP server <b>%1\$s</b>."] = "FTP sunucusunda <b>%1\$s</b> pasif moda geçemiyor.";    //switch: ?

// ftp_openconnection2()
$net2ftp_messages["Unable to connect to the second (target) FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the second (target) FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />"] = "İkinci (hedef) FTP sunucusuna <b>%1\$s</b> portunda <b>%2\$s</b> bağlanamıyor.<br /><br />İkinci (hedef) FTP sunucusunun adresinin bu olduğundan emin misiniz? Bu sıklıkla HTTP (web) sunucusununkinden farklıdır. Lütfen yardım için ISS yardım masanızla ya da sistem yöneticinizle iletişim kurun.<br />";
$net2ftp_messages["Unable to login to the second (target) FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />"] = "İkinci (hedef) FTP sunucusuna <b>%1\$s</b> kullanıcı adıyla <b>%2\$s</b> giriş yapamıyor.<br /><br />Kullanıcı adınızın ve şifrenizin doğru olduğundan emin misiniz? Lütfen yardım için ISS yardım masanızla ya da sistem yöneticinizle iletişim kurun.<br />";
$net2ftp_messages["Unable to switch to the passive mode on the second (target) FTP server <b>%1\$s</b>."] = "İkinci (hedef) FTP sunucusunda <b>%1\$s</b> pasif moda geçemiyor.";   //switch: ?

// ftp_myrename()
$net2ftp_messages["Unable to rename directory or file <b>%1\$s</b> into <b>%2\$s</b>"] = "<b>%1\$s</b> dosya ya da dizinini <b>%2\$s</b>e yeniden adlandıramıyor";

// ftp_mychmod()
$net2ftp_messages["Unable to execute site command <b>%1\$s</b>. Note that the CHMOD command is only available on Unix FTP servers, not on Windows FTP servers."] = "Site komutunu <b>%1\$s</b> gerçekleştiremiyor. CHMOD komutunun, Windows FTP sunucularında değil de sadece Unix FTP sunucularında mümkün olduğuna dikkat edin.";    //note: ?
$net2ftp_messages["Directory <b>%1\$s</b> successfully chmodded to <b>%2\$s</b>"] = "Dizin <b>%1\$s</b> başarılı bir şekilde <b>%2\$s</b> e chmod yapıldı.";
$net2ftp_messages["Processing entries within directory <b>%1\$s</b>:"] = "<b>%1\$s</b> dizin içerisindeki girişleri işleme alıyor:";
$net2ftp_messages["File <b>%1\$s</b> was successfully chmodded to <b>%2\$s</b>"] = "<b>%1\$s</b> Dosya başarılı bir şekilde <b>%2\$s</b>e chmod yapıldı";
$net2ftp_messages["All the selected directories and files have been processed."] = "Tüm seçili dosya ve dizinler işleme alındı.";

// ftp_rmdir2()
$net2ftp_messages["Unable to delete the directory <b>%1\$s</b>"] = "<b>%1\$s</b> dizini silemiyor";

// ftp_delete2()
$net2ftp_messages["Unable to delete the file <b>%1\$s</b>"] = "<b>%1\$s</b> dosyayı silemiyor";

// ftp_newdirectory()
$net2ftp_messages["Unable to create the directory <b>%1\$s</b>"] = "<b>%1\$s</b> dizini oluşturamıyor";

// ftp_readfile()
$net2ftp_messages["Unable to create the temporary file"] = "Geçici dosya oluşturamıyor";
$net2ftp_messages["Unable to get the file <b>%1\$s</b> from the FTP server and to save it as temporary file <b>%2\$s</b>.<br />Check the permissions of the %3\$s directory.<br />"] = "FTP sunucusundan <b>%1\$s</b> dosyasını alamıyor ve <b>%2\$s</b> geçici dosya olarak kaydedemiyor.<br /> %3\$s dizininin izinlerini denetleyin.<br />";
$net2ftp_messages["Unable to open the temporary file. Check the permissions of the %1\$s directory."] = "Geçici dosyayı açamıyor. %1\$s dizininin izinlerini denetleyin.";
$net2ftp_messages["Unable to read the temporary file"] = "Geçici dosyayı okuyamıyor";
$net2ftp_messages["Unable to close the handle of the temporary file"] = "Geçici dosyanın idaresini kapatamıyor";    //handle: ?
$net2ftp_messages["Unable to delete the temporary file"] = "Geçici dosyayı silemiyor";

// ftp_writefile()
$net2ftp_messages["Unable to create the temporary file. Check the permissions of the %1\$s directory."] = "Geçici dosya oluşturamıyor. %1\$s dizininin izinlerini denetleyin.";
$net2ftp_messages["Unable to open the temporary file. Check the permissions of the %1\$s directory."] = "Geçici dosyayı açamıyor. %1\$s dizininin izinlerini denetleyin.";
$net2ftp_messages["Unable to write the string to the temporary file <b>%1\$s</b>.<br />Check the permissions of the %2\$s directory."] = "<b>%1\$s</b> geçici dosyaya diziyi yazamıyor.<br />%1\$s dizininin izinlerini denetleyin.";
$net2ftp_messages["Unable to close the handle of the temporary file"] = "Geçici dosyanın idaresini kapatamıyor";    //handle: ?
$net2ftp_messages["Unable to put the file <b>%1\$s</b> on the FTP server.<br />You may not have write permissions on the directory."] = "FTP sunucusuna <b>%1\$s</b> dosyasını yerleştiremiyor.<br />Dizinde yazma iznine sahip olamayabilirsiniz.";
$net2ftp_messages["Unable to delete the temporary file"] = "Geçici dosyayı silemiyor";

// ftp_copymovedelete()
$net2ftp_messages["Processing directory <b>%1\$s</b>"] = "<b>%1\$s</b> dizinini işleme alıyor";
$net2ftp_messages["The target directory <b>%1\$s</b> is the same as or a subdirectory of the source directory <b>%2\$s</b>, so this directory will be skipped"] = "<b>%1\$s</b> hedef dizini <b>%2\$s</b> kaynak dizininin aynısı veya bir alt dizini , bu yüzden bu dizin atlanılacak";
$net2ftp_messages["The directory <b>%1\$s</b> contains a banned keyword, so this directory will be skipped"] = "The directory <b>%1\$s</b> contains a banned keyword,bu yüzden bu dizin atlanılacak";
$net2ftp_messages["The directory <b>%1\$s</b> contains a banned keyword, aborting the move"] = "<b>%1\$s</b> dizini yasaklı bir anahtar kelime içeriyor, taşımayı iptal ediyor";
$net2ftp_messages["Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing the copy/move process..."] = "<b>%1\$s</b> alt dizini oluşturamıyor. Önceden var olabilir. Kopyalama/taşıma işlemine devam ediyor...";
$net2ftp_messages["Created target subdirectory <b>%1\$s</b>"] = "Hedef alt dizin <b>%1\$s</b> oluşturuldu";
$net2ftp_messages["The directory <b>%1\$s</b> could not be selected, so this directory will be skipped"] = "Dizin <b>%1\$s</b> seçilemiyor,bu yüzden bu dizin atlanılacak";
$net2ftp_messages["Unable to delete the subdirectory <b>%1\$s</b> - it may not be empty"] = "Alt dizini <b>%1\$s</b> silemiyor - boş olmayabilir";
$net2ftp_messages["Deleted subdirectory <b>%1\$s</b>"] = "Alt dizin <b>%1\$s</b> silindi";
$net2ftp_messages["Deleted subdirectory <b>%1\$s</b>"] = "Alt dizin <b>%1\$s</b> silindi";
$net2ftp_messages["Unable to move the directory <b>%1\$s</b>"] = "Unable to move the directory <b>%1\$s</b>";
$net2ftp_messages["Moved directory <b>%1\$s</b>"] = "Moved directory <b>%1\$s</b>";
$net2ftp_messages["Processing of directory <b>%1\$s</b> completed"] = "Dizinin <b>%1\$s</b> işleme alınması tamamlandı";
$net2ftp_messages["The target for file <b>%1\$s</b> is the same as the source, so this file will be skipped"] = "Dosya için hedef <b>%1\$s</b> kaynağın aynısı, bu yüzden bu dosya atlanılacak";
$net2ftp_messages["The file <b>%1\$s</b> contains a banned keyword, so this file will be skipped"] = "Dosya <b>%1\$s</b> yasaklı anahtar sözcük içeriyor, bu yüzden bu dosya atlanılacak";
$net2ftp_messages["The file <b>%1\$s</b> contains a banned keyword, aborting the move"] = "Dosya <b>%1\$s</b> yasaklı anahtar sözcük içeriyor, taşımayı iptal ediyor";
$net2ftp_messages["The file <b>%1\$s</b> is too big to be copied, so this file will be skipped"] = "Dosya <b>%1\$s</b> kopyalayabilmek için çok büyük, bu yüzden bu dosya atlanılacak";
$net2ftp_messages["The file <b>%1\$s</b> is too big to be moved, aborting the move"] = "Dosya <b>%1\$s</b> taşımak için çok büyük, taşımayı iptal ediyor";
$net2ftp_messages["Unable to copy the file <b>%1\$s</b>"] = "Dosyayı <b>%1\$s</b> kopyalayamıyor";
$net2ftp_messages["Copied file <b>%1\$s</b>"] = "Dosyayı <b>%1\$s</b> kopyaladı";
$net2ftp_messages["Unable to move the file <b>%1\$s</b>, aborting the move"] = "Dosyayı <b>%1\$s</b> taşıyamıyor, taşımayı iptal ediyor";
$net2ftp_messages["Unable to move the file <b>%1\$s</b>"] = "Unable to move the file <b>%1\$s</b>";
$net2ftp_messages["Moved file <b>%1\$s</b>"] = "Dosya <b>%1\$s</b> taşındı";
$net2ftp_messages["Unable to delete the file <b>%1\$s</b>"] = "<b>%1\$s</b> dosyayı silemiyor";
$net2ftp_messages["Deleted file <b>%1\$s</b>"] = "Dosyayı <b>%1\$s</b> sildi";
$net2ftp_messages["All the selected directories and files have been processed."] = "Tüm seçili dosya ve dizinler işleme alındı.";

// ftp_processfiles()

// ftp_getfile()
$net2ftp_messages["Unable to copy the remote file <b>%1\$s</b> to the local file using FTP mode <b>%2\$s</b>"] = "Uzaktaki dosyayı <b>%1\$s</b> yerel dosyaya  FTP <b>%2\$s</b> modunu kullanarak kopyalayamıyor";
$net2ftp_messages["Unable to delete file <b>%1\$s</b>"] = "Dosyayı <b>%1\$s</b> silemiyor";

// ftp_putfile()
$net2ftp_messages["The file is too big to be transferred"] = "Dosya aktarabilmek için çok büyük";
$net2ftp_messages["Daily limit reached: the file <b>%1\$s</b> will not be transferred"] = "Günlük sınıra ulaştı: dosya <b>%1\$s</b> aktarılamayacak";
$net2ftp_messages["Unable to copy the local file to the remote file <b>%1\$s</b> using FTP mode <b>%2\$s</b>"] = "Yerel dosyayı, uzaktaki dosyaya <b>%1\$s</b> FTP <b>%2\$s</b> modunu kullanarak kopyalayamıyor";
$net2ftp_messages["Unable to delete the local file"] = "Yerel dosyayı silemiyor";

// ftp_downloadfile()
$net2ftp_messages["Unable to delete the temporary file"] = "Geçici dosyayı silemiyor";
$net2ftp_messages["Unable to send the file to the browser"] = "Tarayıcıya dosyayı gönderemiyor";

// ftp_zip()
$net2ftp_messages["Unable to create the temporary file"] = "Geçici dosya oluşturamıyor";
$net2ftp_messages["The zip file has been saved on the FTP server as <b>%1\$s</b>"] = "Zip arşiv paketi dosyası, FTP sunucusuna <b>%1\$s</b> olarak kaydedildi";
$net2ftp_messages["Requested files"] = "İstenilen dosyalar";

$net2ftp_messages["Dear,"] = "Sayın,";
$net2ftp_messages["Someone has requested the files in attachment to be sent to this email account (%1\$s)."] = "Birisi bu e-posta hesabına (%1\$s) ekteki dosyanın gönderilemsini istedi.";
$net2ftp_messages["If you know nothing about this or if you don't trust that person, please delete this email without opening the Zip file in attachment."] = "Eğer bunun hakkında hiçbir şey bilmiyorsanız ya da bu kişiye güvenmiyorsanız, lütfen ekteki zip arşiv paketi dosyasını açmadan bu e-postayı silin.";
$net2ftp_messages["Note that if you don't open the Zip file, the files inside cannot harm your computer."] = "Zip arşiv paketi dosyasını açmazsanız, içerisindeki dosyaların bilgisayarınıza zarar veremeyeceğine dikkat edin.";   //note: ?
$net2ftp_messages["Information about the sender: "] = "Gönderen hakkında bilgiler: ";
$net2ftp_messages["IP address: "] = "IP adres: ";
$net2ftp_messages["Time of sending: "] = "Gönderme zamanı: ";
$net2ftp_messages["Sent via the net2ftp application installed on this website: "] = "Bu websitesine yüklenen net2ftp uygulaması yoluyla gönderildi: ";
$net2ftp_messages["Webmaster's email: "] = "Web sahibi'nin e-postası: ";
$net2ftp_messages["Message of the sender: "] = "Gönderenin iletisi: ";
$net2ftp_messages["net2ftp is free software, released under the GNU/GPL license. For more information, go to http://www.net2ftp.com."] = "net2ftp GNU/GPL lisansı altında piyasaya sürülen bedava bir yazılımdır. Daha fazla bilgi için, http://www.net2ftp.com ye gidin.";

$net2ftp_messages["The zip file has been sent to <b>%1\$s</b>."] = "Zip arşivi paketi, <b>%1\$s</b>e gönderildi.";

// acceptFiles()
$net2ftp_messages["File <b>%1\$s</b> is too big. This file will not be uploaded."] = "Dosya <b>%1\$s</b> çok büyük. Bu dosya yüklenilmeyecek.";
$net2ftp_messages["File <b>%1\$s</b> is contains a banned keyword. This file will not be uploaded."] = "Dosya <b>%1\$s</b> yasaklı anahtar sözcük içeriyor. Bu dosya yüklenilmeyecek.";
$net2ftp_messages["Could not generate a temporary file."] = "Geçici bir dosya oluşturamıyor.";
$net2ftp_messages["File <b>%1\$s</b> could not be moved"] = "Dosya <b>%1\$s</b> taşınamıyor";
$net2ftp_messages["File <b>%1\$s</b> is OK"] = "Dosya <b>%1\$s</b> TAMAM";
$net2ftp_messages["Unable to move the uploaded file to the temp directory.<br /><br />The administrator of this website has to <b>chmod 777</b> the /temp directory of net2ftp."] = "Yüklenen dosyayı temp dizinine taşıyamıyor.<br /><br />Bu websitesinin yöneticisi net2ftp nin temp dizinini <b>777 chmod</b> yapmalı.";
$net2ftp_messages["You did not provide any file to upload."] = "Yüklemek için herhangi bir dosya sağlamadınız.";

// ftp_transferfiles()
$net2ftp_messages["File <b>%1\$s</b> could not be transferred to the FTP server"] = "Dosya <b>%1\$s</b> FTP sunucusuna aktarılamıyor";
$net2ftp_messages["File <b>%1\$s</b> has been transferred to the FTP server using FTP mode <b>%2\$s</b>"] = "Dosya <b>%1\$s</b> FTP sunucusuna, FTP <b>%2\$s</b> modu kullanarak aktarıldı";
$net2ftp_messages["Transferring files to the FTP server"] = "FTP sunucusuna dosyalari aktariyor";

// ftp_unziptransferfiles()
$net2ftp_messages["Processing archive nr %1\$s: <b>%2\$s</b>"] = "Arşiv paketini %1\$s işleme alıyor: <b>%2\$s</b>";
$net2ftp_messages["Archive <b>%1\$s</b> was not processed because its filename extension was not recognized. Only zip, tar, tgz and gz archives are supported at the moment."] = "Arşiv paketi <b>%1\$s</b> işleme alınmadı çünkü dosya uzantısı tanınmadı. şu an sadece zip, tar, tgz ve gz arşiv paketleri destekleniyor.";
$net2ftp_messages["Unable to extract the files and directories from the archive"] = "Arşiv paketinden dosya ve dizinleri çıkartamıyor";
$net2ftp_messages["Archive contains filenames with ../ or ..\\ - aborting the extraction"] = "Archive contains filenames with ../ or ..\\ - aborting the extraction";
$net2ftp_messages["Could not unzip entry %1\$s (error code %2\$s)"] = "Could not unzip entry %1\$s (error code %2\$s)";
$net2ftp_messages["Created directory %1\$s"] = "Dizini %1\$s oluşturuldu";
$net2ftp_messages["Could not create directory %1\$s"] = "Dizini %1\$s oluşturamıyor";
$net2ftp_messages["Copied file %1\$s"] = "Dosyayı %1\$s kopyaladı";
$net2ftp_messages["Could not copy file %1\$s"] = "Dosyayı %1\$s kopyalayamıyor";
$net2ftp_messages["Unable to delete the temporary directory"] = "Geçici dizini silemiyor";
$net2ftp_messages["Unable to delete the temporary file %1\$s"] = "Geçici dosyayı %1\$s silemiyor";

// ftp_mysite()
$net2ftp_messages["Unable to execute site command <b>%1\$s</b>"] = "Site komutunu <b>%1\$s</b> gerçekleştiremiyor";

// shutdown()
$net2ftp_messages["Your task was stopped"] = "İşleminiz durduruldu";
$net2ftp_messages["The task you wanted to perform with net2ftp took more time than the allowed %1\$s seconds, and therefor that task was stopped."] = "Net2ftp ile gerçekleştirmek istediğiniz işlem izin verilen %1\$s saniyeden daha fazla sürdü ve bu nedenle işlem durduruldu.";
$net2ftp_messages["This time limit guarantees the fair use of the web server for everyone."] = "Bu süre sınırı, web sunucusunu herkes tarafından adil kullanımını garantiler.";
$net2ftp_messages["Try to split your task in smaller tasks: restrict your selection of files, and omit the biggest files."] = "İşleminizi daha küçük işlemlere bölmeye çalışın: dosyalarınızın seçimini kısıtlayın ve en büyük dosyaları atlayın.";
$net2ftp_messages["If you really need net2ftp to be able to handle big tasks which take a long time, consider installing net2ftp on your own server."] = "Eğer gerçekten net2ftp  nin daha uzun süre alan büyük işlemleri ele alabilmesi için, net2ftp yi kendi sunucunuza yüklemeyi düşünün.";

// SendMail()
$net2ftp_messages["You did not provide any text to send by email!"] = "E-postayla göndermek için herhangi bir metin sağlamadınız!";
$net2ftp_messages["You did not supply a From address."] = "Kimden adresi sağlamadınız.";
$net2ftp_messages["You did not supply a To address."] = "Kime adresi sağlamdınız.";
$net2ftp_messages["Due to technical problems the email to <b>%1\$s</b> could not be sent."] = "Teknik problemler yüzünden e-posta <b>%1\$s</b>a gönderilemiyor.";

// tempdir2()
$net2ftp_messages["Unable to create a temporary directory because (unvalid parent directory)"] = "Unable to create a temporary directory because (unvalid parent directory)";
$net2ftp_messages["Unable to create a temporary directory because (parent directory is not writeable)"] = "Unable to create a temporary directory because (parent directory is not writeable)";
$net2ftp_messages["Unable to create a temporary directory (too many tries)"] = "Unable to create a temporary directory (too many tries)";

// -------------------------------------------------------------------------
// /includes/logging.inc.php
// -------------------------------------------------------------------------
// logAccess(), logLogin(), logError()
$net2ftp_messages["Unable to execute the SQL query."] = "SQL sorgusunu gerçekleştiremiyor.";
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
$net2ftp_messages["Please enter your username and password for FTP server "] = "Lütfen FTP sunucusu için kullanıcı adınızı ve şifrenizi girin ";
$net2ftp_messages["You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below."] = "Pop açılan pencereye giriş bilginizi doldurmadınız.<br />Aşağıdaki \"Giriş sayfasına git\" üzerine tıklayın.";
$net2ftp_messages["Access to the net2ftp Admin panel is disabled, because no password has been set in the file settings.inc.php. Enter a password in that file, and reload this page."] = "Net2ftp Yönetici paneline giriş kapatıldı, çünkü settings.inc.php dosyasında şifre ayarlanmadı. O dosyaya şifre girin ve bu sayfayı tekrar yükleyin.";
$net2ftp_messages["Please enter your Admin username and password"] = "Lütfen Yönetici kullanıcı adınızı ve şifrenizi girin"; 
$net2ftp_messages["You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below."] = "Pop açılan pencereye giriş bilginizi doldurmadınız.<br />Aşağıdaki \"Giriş sayfasına git\" üzerine tıklayın.";
$net2ftp_messages["Wrong username or password for the net2ftp Admin panel. The username and password can be set in the file settings.inc.php."] = "Net2ftp Yönetici paneli için yanlış kullanıcı adı veya şifre. Kullancı adı veya şifre, settings.inc.php dosyasında ayarlanabilir.";


// -------------------------------------------------------------------------
// /skins/skins.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Blue"] = "Mavi";
$net2ftp_messages["Grey"] = "Gri";
$net2ftp_messages["Black"] = "Siyah";
$net2ftp_messages["Yellow"] = "Sarı";
$net2ftp_messages["Pastel"] = "Pastel";

// getMime()
$net2ftp_messages["Directory"] = "Dizin";
$net2ftp_messages["Symlink"] = "Symlink";
$net2ftp_messages["ASP script"] = "ASP yazılım";
$net2ftp_messages["Cascading Style Sheet"] = "Cascading Style Sheet";
$net2ftp_messages["HTML file"] = "HTML dosyası";
$net2ftp_messages["Java source file"] = "Java kaynak dosyası";
$net2ftp_messages["JavaScript file"] = "JavaScript dosyası";
$net2ftp_messages["PHP Source"] = "PHP Kaynak";
$net2ftp_messages["PHP script"] = "PHP yazılımı";
$net2ftp_messages["Text file"] = "Metin dosyası";
$net2ftp_messages["Bitmap file"] = "Bitmap dosyası";
$net2ftp_messages["GIF file"] = "GIF dosyası";
$net2ftp_messages["JPEG file"] = "JPEG dosyası";
$net2ftp_messages["PNG file"] = "PNG dosyası";
$net2ftp_messages["TIF file"] = "TIF dosyası";
$net2ftp_messages["GIMP file"] = "GIMP dosyası";
$net2ftp_messages["Executable"] = "Uygulama";
$net2ftp_messages["Shell script"] = "Shell yazılımı";
$net2ftp_messages["MS Office - Word document"] = "MS Ofis - Word belgesi";
$net2ftp_messages["MS Office - Excel spreadsheet"] = "MS Ofis - Excel çizelgesi";
$net2ftp_messages["MS Office - PowerPoint presentation"] = "MS Ofis - PowerPoint sunumu";
$net2ftp_messages["MS Office - Access database"] = "MS Ofis - Access veritabanı";
$net2ftp_messages["MS Office - Visio drawing"] = "MS Ofis - Visio çizimi";
$net2ftp_messages["MS Office - Project file"] = "MS Ofis - Project dosyası";
$net2ftp_messages["OpenOffice - Writer 6.0 document"] = "OpenOffice - Writer 6.0 belgesi";
$net2ftp_messages["OpenOffice - Writer 6.0 template"] = "OpenOffice - Writer 6.0 şablonu";
$net2ftp_messages["OpenOffice - Calc 6.0 spreadsheet"] = "OpenOffice - Calc 6.0 çizelgesi";
$net2ftp_messages["OpenOffice - Calc 6.0 template"] = "OpenOffice - Calc 6.0 şablonu";
$net2ftp_messages["OpenOffice - Draw 6.0 document"] = "OpenOffice - Draw 6.0 belgesi";
$net2ftp_messages["OpenOffice - Draw 6.0 template"] = "OpenOffice - Draw 6.0 şablonu";
$net2ftp_messages["OpenOffice - Impress 6.0 presentation"] = "OpenOffice - Impress 6.0 sunumu";
$net2ftp_messages["OpenOffice - Impress 6.0 template"] = "OpenOffice - Impress 6.0 şablonu";
$net2ftp_messages["OpenOffice - Writer 6.0 global document"] = "OpenOffice - Writer 6.0 evrensel belge";
$net2ftp_messages["OpenOffice - Math 6.0 document"] = "OpenOffice - Math 6.0 belgesi";
$net2ftp_messages["StarOffice - StarWriter 5.x document"] = "StarOffice - StarWriter 5.x belgesi";
$net2ftp_messages["StarOffice - StarWriter 5.x global document"] = "StarOffice - StarWriter 5.x evrensel belge";
$net2ftp_messages["StarOffice - StarCalc 5.x spreadsheet"] = "StarOffice - StarCalc 5.x çözümü";
$net2ftp_messages["StarOffice - StarDraw 5.x document"] = "StarOffice - StarDraw 5.x belgesi";
$net2ftp_messages["StarOffice - StarImpress 5.x presentation"] = "StarOffice - StarImpress 5.x sunumu";
$net2ftp_messages["StarOffice - StarImpress Packed 5.x file"] = "StarOffice - StarImpress Packed 5.x dosyası";
$net2ftp_messages["StarOffice - StarMath 5.x document"] = "StarOffice - StarMath 5.x belgesi";
$net2ftp_messages["StarOffice - StarChart 5.x document"] = "StarOffice - StarChart 5.x belgesi";
$net2ftp_messages["StarOffice - StarMail 5.x mail file"] = "StarOffice - StarMail 5.x posta dosyası";
$net2ftp_messages["Adobe Acrobat document"] = "Adobe Acrobat belgesi";
$net2ftp_messages["ARC archive"] = "ARC arşiv paketi";
$net2ftp_messages["ARJ archive"] = "ARJ arşiv paketi";
$net2ftp_messages["RPM"] = "RPM";
$net2ftp_messages["GZ archive"] = "GZ arşiv paketi";
$net2ftp_messages["TAR archive"] = "TAR arşiv paketi";
$net2ftp_messages["Zip archive"] = "Zip arşiv paketi";
$net2ftp_messages["MOV movie file"] = "MOV film dosyası";
$net2ftp_messages["MPEG movie file"] = "MPEG film dosyası";
$net2ftp_messages["Real movie file"] = "Real film dosyası";
$net2ftp_messages["Quicktime movie file"] = "Quicktime film dosyası";
$net2ftp_messages["Shockwave flash file"] = "Shockwave flaş dosyası";
$net2ftp_messages["Shockwave file"] = "Shockwave dosyası";
$net2ftp_messages["WAV sound file"] = "WAV ses dosyası";
$net2ftp_messages["Font file"] = "Font dosyası";
$net2ftp_messages["%1\$s File"] = "%1\$s Dosyası";
$net2ftp_messages["File"] = "Dosya";

// getAction()
$net2ftp_messages["Back"] = "Geri";
$net2ftp_messages["Submit"] = "Gönder";
$net2ftp_messages["Refresh"] = "Yenile";
$net2ftp_messages["Details"] = "Detaylar";
$net2ftp_messages["Icons"] = "Ikonlar";
$net2ftp_messages["List"] = "Liste";
$net2ftp_messages["Logout"] = "Çıkış";
$net2ftp_messages["Help"] = "Yardım";
$net2ftp_messages["Bookmark"] = "Sık Kullanılanlar";
$net2ftp_messages["Save"] = "Kaydet";
$net2ftp_messages["Default"] = "Varsayılan";


// -------------------------------------------------------------------------
// /skins/[skin]/header.template.php and footer.template.php
// -------------------------------------------------------------------------
$net2ftp_messages["Help Guide"] = "Yardım Rehberi";
$net2ftp_messages["Forums"] = "Forumlar";
$net2ftp_messages["License"] = "Lisans";
$net2ftp_messages["Powered by"] = "Katkılarıyla";
$net2ftp_messages["You are now taken to the net2ftp forums. These forums are for net2ftp related topics only - not for generic webhosting questions."] = "Şimdi net2ftp forumlarına götürülüyorsunuz. Bu forumlar, sadece net2ftp alakalı konular içindir - genel web barındırma soruları için değil.";
$net2ftp_messages["Standard"] = "Standard";
$net2ftp_messages["Mobile"] = "Mobile";

// -------------------------------------------------------------------------
// Admin module
if ($net2ftp_globals["state"] == "admin") {
// -------------------------------------------------------------------------

// /modules/admin/admin.inc.php
$net2ftp_messages["Admin functions"] = "Yönetici işlevleri";

// /skins/[skin]/admin1.template.php
$net2ftp_messages["Version information"] = "Sürüm bilgisi";
$net2ftp_messages["This version of net2ftp is up-to-date."] = "Net2ftp nin bu sürümü güncel.";
$net2ftp_messages["The latest version information could not be retrieved from the net2ftp.com server. Check the security settings of your browser, which may prevent the loading of a small file from the net2ftp.com server."] = "En son sürüm bilgisi, net2ftp.com sunucusundan alınamıyor. Tarayıcınızın net2ftp.com sunucusundan küçük bir dosya yüklemesini engelleyebilen güvenlik ayarlarını denetleyin.";   //retrieved: ?
$net2ftp_messages["Logging"] = "Giriyor";
$net2ftp_messages["Date from:"] = "Tarih den:";
$net2ftp_messages["to:"] = "e:";
$net2ftp_messages["Empty logs"] = "Boş kayıtlar";
$net2ftp_messages["View logs"] = "Kayıtları görüntüle";
$net2ftp_messages["Go"] = "Git";
$net2ftp_messages["Setup MySQL tables"] = "MySQL tablolarını kur";
$net2ftp_messages["Create the MySQL database tables"] = "MySQL veritabanı tabloları oluştur";

} // end admin

// -------------------------------------------------------------------------
// Admin_createtables module
if ($net2ftp_globals["state"] == "admin_createtables") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_createtables.inc.php
$net2ftp_messages["Admin functions"] = "Yönetici işlevleri";
$net2ftp_messages["The handle of file %1\$s could not be opened."] = "Dosyanın idaresi %1\$s açılamıyor.";   //handle: ?
$net2ftp_messages["The file %1\$s could not be opened."] = "Dosya %1\$s açılamıyor.";
$net2ftp_messages["The handle of file %1\$s could not be closed."] = "Dosyanın idaresi %1\$s kapatılamıyor."; //handle: ?
$net2ftp_messages["The connection to the server <b>%1\$s</b> could not be set up. Please check the database settings you've entered."] = "Sunucuya <b>%1\$s</b> bağlantı kurulamıyor. Lütfen girdiğiniz veritabanı ayarlarını denetleyin.";
$net2ftp_messages["Unable to select the database <b>%1\$s</b>."] = "Veritabanı <b>%1\$s</b> seçemiyor.";
$net2ftp_messages["The SQL query nr <b>%1\$s</b> could not be executed."] = "SQL sorgu sayısı <b>%1\$s</b> gerçekleştirilemiyor.";
$net2ftp_messages["The SQL query nr <b>%1\$s</b> was executed successfully."] = "SQL sorgu sayısı <b>%1\$s</b> başarılı bir şekilde gerçekleştirildi.";

// /skins/[skin]/admin_createtables1.template.php
$net2ftp_messages["Please enter your MySQL settings:"] = "Lütfen MySQL ayarlarınızı girin:";
$net2ftp_messages["MySQL username"] = "MySQL kullanıcı adı";
$net2ftp_messages["MySQL password"] = "MySQL şifresi";
$net2ftp_messages["MySQL database"] = "MySQL veritabanı";
$net2ftp_messages["MySQL server"] = "MySQL sunucusu";
$net2ftp_messages["This SQL query is going to be executed:"] = "Bu SQL sorgusu gerçekleştirilecek:";
$net2ftp_messages["Execute"] = "Gerçekleştir";

// /skins/[skin]/admin_createtables2.template.php
$net2ftp_messages["Settings used:"] = "Kullanılan ayarlar:";
$net2ftp_messages["MySQL password length"] = "MySQL şifre uzunluğu";
$net2ftp_messages["Results:"] = "Sonuçlar:";

} // end admin_createtables


// -------------------------------------------------------------------------
// Admin_viewlogs module
if ($net2ftp_globals["state"] == "admin_viewlogs") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_viewlogs.inc.php
$net2ftp_messages["Admin functions"] = "Yönetici işlevleri";
$net2ftp_messages["Unable to execute the SQL query <b>%1\$s</b>."] = "SQL sorgusunu <b>%1\$s</b> gerçekleştiremiyor.";
$net2ftp_messages["No data"] = "Bilgi yok";

} // end admin_viewlogs


// -------------------------------------------------------------------------
// Admin_emptylogs module
if ($net2ftp_globals["state"] == "admin_emptylogs") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_emptylogs.inc.php
$net2ftp_messages["Admin functions"] = "Yönetici işlevleri";
$net2ftp_messages["The table <b>%1\$s</b> was emptied successfully."] = "Tablo <b>%1\$s</b> başarılı bir şekilde boşaltıldı.";
$net2ftp_messages["The table <b>%1\$s</b> could not be emptied."] = "Tablo <b>%1\$s</b> boşaltılamıyor.";
$net2ftp_messages["The table <b>%1\$s</b> was optimized successfully."] = "Tablo <b>%1\$s</b> başarılı bir şekilde onarıldı.";
$net2ftp_messages["The table <b>%1\$s</b> could not be optimized."] = "Tablo <b>%1\$s</b> onarılamıyor.";

} // end admin_emptylogs


// -------------------------------------------------------------------------
// Advanced module
if ($net2ftp_globals["state"] == "advanced") {
// -------------------------------------------------------------------------

// /modules/advanced/advanced.inc.php
$net2ftp_messages["Advanced functions"] = "Gelişmiş işlevler";

// /skins/[skin]/advanced1.template.php
$net2ftp_messages["Go"] = "Git";
$net2ftp_messages["Disabled"] = "Kapatıldı";    //disabled: ?
$net2ftp_messages["Advanced FTP functions"] = "Gelişmiş FTP işlevleri";
$net2ftp_messages["Send arbitrary FTP commands to the FTP server"] = "FTP sunucusuna rastgele FTP komutları gönder";
$net2ftp_messages["This function is available on PHP 5 only"] = "Bu işlev sadece PHP 5 de mümkün";
$net2ftp_messages["Troubleshooting functions"] = "İşlevlerin sorunlarını gider";
$net2ftp_messages["Troubleshoot net2ftp on this webserver"] = "Bu websunucusunda net2ftp nin sorunlarını gider";
$net2ftp_messages["Troubleshoot an FTP server"] = "FTP sunucusunun sorunlarını gider";
$net2ftp_messages["Test the net2ftp list parsing rules"] = "Net2ftp liste çözümleme kurallarını test et";
$net2ftp_messages["Translation functions"] = "Çeviri işlevleri";
$net2ftp_messages["Introduction to the translation functions"] = "Çeviri işlevlerine giriş";
$net2ftp_messages["Extract messages to translate from code files"] = "Kod dosyalarından çevrilecek metin çıkart";
$net2ftp_messages["Check if there are new or obsolete messages"] = "Yeni ya da eskimiş ileti olup olmadığını denetle";

$net2ftp_messages["Beta functions"] = "Beta işlevleri";
$net2ftp_messages["Send a site command to the FTP server"] = "FTP sunucusuna bir site komutu gönder";
$net2ftp_messages["Apache: password-protect a directory, create custom error pages"] = "Apache: şifre-korumalı dizin, tasarlanmış hata sayfaları oluştur";   //custom: ?
$net2ftp_messages["MySQL: execute an SQL query"] = "MySQL: SQL sorgusu gerçekleştir";


// advanced()
$net2ftp_messages["The site command functions are not available on this webserver."] = "Site komut işlevleri bu web sunucusunda mümükün değil.";
$net2ftp_messages["The Apache functions are not available on this webserver."] = "Apache işlevleri bu web sunucusunda mümükün değil.";
$net2ftp_messages["The MySQL functions are not available on this webserver."] = "MySQL işlevleri bu web sunucusunda mümükün değil.";
$net2ftp_messages["Unexpected state2 string. Exiting."] = "Beklenmedik state2 dizisi. Çıkıyor.";

} // end advanced


// -------------------------------------------------------------------------
// Advanced_ftpserver module
if ($net2ftp_globals["state"] == "advanced_ftpserver") {
// -------------------------------------------------------------------------

// /modules/advanced_ftpserver/advanced_ftpserver.inc.php
$net2ftp_messages["Troubleshoot an FTP server"] = "FTP sunucusunun sorunlarını gider";

// /skins/[skin]/advanced_ftpserver1.template.php
$net2ftp_messages["Connection settings:"] = "Bağlantı ayarları:";
$net2ftp_messages["FTP server"] = "FTP sunucusu";
$net2ftp_messages["FTP server port"] = "FTP sunucu port";
$net2ftp_messages["Username"] = "Kullanıcı adı";
$net2ftp_messages["Password"] = "Şifre";
$net2ftp_messages["Password length"] = "Şifre uzunluğu";
$net2ftp_messages["Passive mode"] = "Pasif mod";
$net2ftp_messages["Directory"] = "Dizin";
$net2ftp_messages["Printing the result"] = "Sonuçları yazdırıyor";

// /skins/[skin]/advanced_ftpserver2.template.php
$net2ftp_messages["Connecting to the FTP server: "] = "FTP sunucusuna bağlanıyor: ";
$net2ftp_messages["Logging into the FTP server: "] = "FTP sunucusuna giriş yapıyor: ";
$net2ftp_messages["Setting the passive mode: "] = "Pasif moda geçiyor: ";
$net2ftp_messages["Getting the FTP server system type: "] = "FTP sunucusu sistem türünü alıyor: ";
$net2ftp_messages["Changing to the directory %1\$s: "] = "Dizini %1\$s değiştiriyor: ";
$net2ftp_messages["The directory from the FTP server is: %1\$s "] = "FTP sunucusundan dizin: %1\$s ";
$net2ftp_messages["Getting the raw list of directories and files: "] = "Dosya ve dizinlerin ham listesini alıyor: ";
$net2ftp_messages["Trying a second time to get the raw list of directories and files: "] = "Dosya ve dizinlerin ham listesini almak için ikince bir defa deniyor: ";
$net2ftp_messages["Closing the connection: "] = "Bağlantıyı kapatıyor: ";
$net2ftp_messages["Raw list of directories and files:"] = "Dosya ve dizinlerin ham listesi:";
$net2ftp_messages["Parsed list of directories and files:"] = "Dosya ve dizinlerin çözümlenmiş listesi:";   //parsed: ?

$net2ftp_messages["OK"] = "TAMAM";
$net2ftp_messages["not OK"] = "TAMAM değil";

} // end advanced_ftpserver


// -------------------------------------------------------------------------
// Advanced_parsing module
if ($net2ftp_globals["state"] == "advanced_parsing") {
// -------------------------------------------------------------------------

$net2ftp_messages["Test the net2ftp list parsing rules"] = "Net2ftp liste çözümleme kurallarını test et";
$net2ftp_messages["Sample input"] = "Örnek girdi";
$net2ftp_messages["Parsed output"] = "Çözümlenmiş sonuç";   //parsed: ?

} // end advanced_parsing


// -------------------------------------------------------------------------
// Advanced_webserver module
if ($net2ftp_globals["state"] == "advanced_webserver") {
// -------------------------------------------------------------------------

$net2ftp_messages["Troubleshoot your net2ftp installation"] = "Net2ftp yüklemenizin sorunu çözün";
$net2ftp_messages["Printing the result"] = "Sonuçları yazdırıyor";

$net2ftp_messages["Checking if the FTP module of PHP is installed: "] = "Checking if the FTP module of PHP is installed: ";
$net2ftp_messages["yes"] = "evet";
$net2ftp_messages["no - please install it!"] = "hayır - lütfen onu yükle!";

$net2ftp_messages["Checking the permissions of the directory on the web server: a small file will be written to the /temp folder and then deleted."] = "Web sunucunuzdaki dizinin iznini denetliyor: küçük bir dosya /temp klasörüne yazılacak ve sonra silinecek.";
$net2ftp_messages["Creating filename: "] = "Dosya adı oluşturuyor: ";
$net2ftp_messages["OK. Filename: %1\$s"] = "TAMAM. Dosya adı: %1\$s";
$net2ftp_messages["not OK"] = "TAMAM değil";
$net2ftp_messages["OK"] = "TAMAM";
$net2ftp_messages["not OK. Check the permissions of the %1\$s directory"] = "TAMAM değil. %1\$s dizinin iznini denetliyor";
$net2ftp_messages["Opening the file in write mode: "] = "Dosyayı yazma modunda açıyor: ";
$net2ftp_messages["Writing some text to the file: "] = "Dosyaya herhangi bir metin yazıor : ";
$net2ftp_messages["Closing the file: "] = "Dosyayı kapatıor: ";
$net2ftp_messages["Deleting the file: "] = "Dosyayı siliyor: ";

$net2ftp_messages["Testing the FTP functions"] = "FTP işlevlerini test ediyor";
$net2ftp_messages["Connecting to a test FTP server: "] = "Test FTP sunucusuna bağlanıyor: ";
$net2ftp_messages["Connecting to the FTP server: "] = "FTP sunucusuna bağlanıyor: ";
$net2ftp_messages["Logging into the FTP server: "] = "FTP sunucusuna giriş yapıyor: ";
$net2ftp_messages["Setting the passive mode: "] = "Pasif moda geçiyor: ";
$net2ftp_messages["Getting the FTP server system type: "] = "FTP sunucusu sistem türünü alıyor: ";
$net2ftp_messages["Changing to the directory %1\$s: "] = "Dizini %1\$s değiştiriyor: ";
$net2ftp_messages["The directory from the FTP server is: %1\$s "] = "FTP sunucusundan dizin: %1\$s ";
$net2ftp_messages["Getting the raw list of directories and files: "] = "Dosya ve dizinlerin ham listesini alıyor: ";
$net2ftp_messages["Trying a second time to get the raw list of directories and files: "] = "Dosya ve dizinlerin ham listesini almak için ikince bir defa deniyor: ";
$net2ftp_messages["Closing the connection: "] = "Bağlantıyı kapatıyor: ";
$net2ftp_messages["Raw list of directories and files:"] = "Dosya ve dizinlerin ham listesi:";
$net2ftp_messages["Parsed list of directories and files:"] = "Dosya ve dizinlerin çözümlenmiş listesi:";   //parsed: ?
$net2ftp_messages["OK"] = "TAMAM";
$net2ftp_messages["not OK"] = "TAMAM değil";

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
$net2ftp_messages["Note: when you will use this bookmark, a popup window will ask you for your username and password."] = "Not: bu sık kullanılanları kullandığınız zaman, pop açılan pencere size kullanıcı adınızı ve şifrenizi soracak.";

} // end bookmark


// -------------------------------------------------------------------------
// Browse module
if ($net2ftp_globals["state"] == "browse") {
// -------------------------------------------------------------------------

// /modules/browse/browse.inc.php
$net2ftp_messages["Choose a directory"] = "Dizin seç";
$net2ftp_messages["Please wait..."] = "Lütfen bekleyin...";

// browse()
$net2ftp_messages["Directories with names containing \' cannot be displayed correctly. They can only be deleted. Please go back and select another subdirectory."] = " \' adını içeren dizinler doğru bir şekilde gösterilemez. sadece silinebilir. Lütfen geri dönün ve bir başka alt dizin seçin.";

$net2ftp_messages["Daily limit reached: you will not be able to transfer data"] = "Günlük sınırı aştı: bilgi aktaramayacaksınız";
$net2ftp_messages["In order to guarantee the fair use of the web server for everyone, the data transfer volume and script execution time are limited per user, and per day. Once this limit is reached, you can still browse the FTP server but not transfer data to/from it."] = "Herkesin web sunucusunu adil bir şekilde kullanımını garanti etmek için, bilgi aktarım hacmi ve yazılım uygulama süresi, kullanıcı başına ve günlük olarak sınırlandırılmıştır. Bir kez bu sınıra ulaşıldığında, FTP sunucusunu hala gezebilir fakat ondan/ona bilgi aktaramazsınız.";
$net2ftp_messages["If you need unlimited usage, please install net2ftp on your own web server."] = "Eğer sınırsız kullanıma ihtiyaç duyuyorsanız, lütfen net2ftpyi kendi web sunucunuza yükleyin.";

// printdirfilelist()
// Keep this short, it must fit in a small button!
$net2ftp_messages["New dir"] = "Yeni Dizin";
$net2ftp_messages["New file"] = "Yeni Dosya";
$net2ftp_messages["HTML templates"] = "HTML şablonları";
$net2ftp_messages["Upload"] = "Yükle";
$net2ftp_messages["Java Upload"] = "Java ile Yükle";
$net2ftp_messages["Flash Upload"] = "Flash ile Yükle";
$net2ftp_messages["Install"] = "Kur";
$net2ftp_messages["Advanced"] = "Gelişmiş";
$net2ftp_messages["Copy"] = "Kopyala";
$net2ftp_messages["Move"] = "Taşı";
$net2ftp_messages["Delete"] = "Sil";
$net2ftp_messages["Rename"] = "Yeniden Adlandır";
$net2ftp_messages["Chmod"] = "Chmod";
$net2ftp_messages["Download"] = "İndir";
$net2ftp_messages["Unzip"] = "Arşiv aç";
$net2ftp_messages["Zip"] = "Zip";
$net2ftp_messages["Size"] = "Boyut";
$net2ftp_messages["Search"] = "Arama";
$net2ftp_messages["Go to the parent directory"] = "Ana dizine git";
$net2ftp_messages["Go"] = "Git";
$net2ftp_messages["Transform selected entries: "] = "Seçili girişleri dönüştür: ";
$net2ftp_messages["Transform selected entry: "] = "Seçili girişi dönüştür: ";
$net2ftp_messages["Make a new subdirectory in directory %1\$s"] = "%1\$s dizininde yeni bir alt dizin yap";
$net2ftp_messages["Create a new file in directory %1\$s"] = "%1\$s dizininde yeni bir dosya oluştur";
$net2ftp_messages["Create a website easily using ready-made templates"] = "Hazır-yapılmış şablon kullanarak kolayca bir websitesi oluşturun";
$net2ftp_messages["Upload new files in directory %1\$s"] = "%1\$s dizinine yeni dosya yükle";
$net2ftp_messages["Upload directories and files using a Java applet"] = "Java aplet kullanarak dizin ve dosyaları yükle";
$net2ftp_messages["Upload files using a Flash applet"] = "Upload files using a Flash applet";
$net2ftp_messages["Install software packages (requires PHP on web server)"] = "Yazılım paketlerini yükle (web sunucusunda PHP gerektirir)";
$net2ftp_messages["Go to the advanced functions"] = "Gelişmiş işlevlere git";
$net2ftp_messages["Copy the selected entries"] = "Seçili girişleri kopyala";
$net2ftp_messages["Move the selected entries"] = "Seçili girişleri taşı";
$net2ftp_messages["Delete the selected entries"] = "Seçili girişleri sil";
$net2ftp_messages["Rename the selected entries"] = "Seçili girişleri yeniden adlandır";
$net2ftp_messages["Chmod the selected entries (only works on Unix/Linux/BSD servers)"] = "Seçili girişleri chmod (sadece Unix/Linux/BSD sunucularında çalışıyor)";
$net2ftp_messages["Download a zip file containing all selected entries"] = "Tüm seçili girişleri içeren bir zip dosyası indir";
$net2ftp_messages["Unzip the selected archives on the FTP server"] = "FTP sunucusundaki seçili arşiv paketlerini aç";
$net2ftp_messages["Zip the selected entries to save or email them"] = "Kaydedebilmek veya e-posta ile gönderebilmek için, seçili girişleri ziple";
$net2ftp_messages["Calculate the size of the selected entries"] = "Seçili girişlerin boyutunu hesapla";
$net2ftp_messages["Find files which contain a particular word"] = "Belirli bir sözcüğü içeren dosyaları bul";
$net2ftp_messages["Click to sort by %1\$s in descending order"] = "Alçalan sırada %1\$s ile sıralamak için tıklayın";
$net2ftp_messages["Click to sort by %1\$s in ascending order"] = "Yükselen sırada %1\$s ile sıralamak için tıklayın";
$net2ftp_messages["Ascending order"] = "Yükselen sıralama";
$net2ftp_messages["Descending order"] = "Alçalan sıralama";
$net2ftp_messages["Upload files"] = "Dosyaları yükle";
$net2ftp_messages["Up"] = "Yukarı";
$net2ftp_messages["Click to check or uncheck all rows"] = "Tüm dizileri işaretlemek ya da işareti kaldırmak için tıklayın";
$net2ftp_messages["All"] = "Tümü";
$net2ftp_messages["Name"] = "Ad";
$net2ftp_messages["Type"] = "Tür";
//$net2ftp_messages["Size"] = "Size";
$net2ftp_messages["Owner"] = "sahip";
$net2ftp_messages["Group"] = "Grup";
$net2ftp_messages["Perms"] = "İzinler";
$net2ftp_messages["Mod Time"] = "Mod Zamanı";
$net2ftp_messages["Actions"] = "Eylemler";
$net2ftp_messages["Select the directory %1\$s"] = "Dizini %1\$s seç";
$net2ftp_messages["Select the file %1\$s"] = "Dosyayı %1\$s seç";
$net2ftp_messages["Select the symlink %1\$s"] = "Symlink %1\$s seç";
$net2ftp_messages["Go to the subdirectory %1\$s"] = "Alt dizine %1\$s git";
$net2ftp_messages["Download the file %1\$s"] = "Dosyayı %1\$s indir";
$net2ftp_messages["Follow symlink %1\$s"] = "Symlink %1\$s takip et";
$net2ftp_messages["View"] = "Görüntüle";
$net2ftp_messages["Edit"] = "Düzenle";
$net2ftp_messages["Update"] = "Güncelle";
$net2ftp_messages["Open"] = "Aç";
$net2ftp_messages["View the highlighted source code of file %1\$s"] = "Dosyanın %1\$s vurgulanmış kaynak kodunu görüntüle";
$net2ftp_messages["Edit the source code of file %1\$s"] = "Dosyanın %1\$s kaynak kodunu düzenle";
$net2ftp_messages["Upload a new version of the file %1\$s and merge the changes"] = "Dosyanın %1\$s yeni sürümünü yükle ve değişiklikleri birleştir";   //mere: ?
$net2ftp_messages["View image %1\$s"] = "Resmi %1\$s görüntüle";
$net2ftp_messages["View the file %1\$s from your HTTP web server"] = "HTTP web sunucunuzdan %1\$s dosyayı görüntüle";
$net2ftp_messages["(Note: This link may not work if you don't have your own domain name.)"] = "(Not: Eğer kendi alan adınıza sahip değilseniz, bu bağlantı çalışmayabilir.)";
$net2ftp_messages["This folder is empty"] = "Bu klasör boş";

// printSeparatorRow()
$net2ftp_messages["Directories"] = "Dizinler";
$net2ftp_messages["Files"] = "Dosyalar";
$net2ftp_messages["Symlinks"] = "Symlinks";
$net2ftp_messages["Unrecognized FTP output"] = "Tanınmayan FTP sonucu";
$net2ftp_messages["Number"] = "Sayı";
$net2ftp_messages["Size"] = "Boyut";
$net2ftp_messages["Skipped"] = "Atlanılan";
$net2ftp_messages["Data transferred from this IP address today"] = "Data transferred from this IP address today";
$net2ftp_messages["Data transferred to this FTP server today"] = "Data transferred to this FTP server today";

// printLocationActions()
$net2ftp_messages["Language:"] = "Dil:";
$net2ftp_messages["Skin:"] = "Kaplama:";
$net2ftp_messages["View mode:"] = "Görüntüleme modu:";
$net2ftp_messages["Directory Tree"] = "Dizin ağacı";

// ftp2http()
$net2ftp_messages["Execute %1\$s in a new window"] = "Yeni pencerede %1\$s gerçekleştir";
$net2ftp_messages["This file is not accessible from the web"] = "Bu sayfaya webten ulaşılabilir değil";

// printDirectorySelect()
$net2ftp_messages["Double-click to go to a subdirectory:"] = "Alt dizine gitmek için çift tıklayın:";
$net2ftp_messages["Choose"] = "Seç";
$net2ftp_messages["Up"] = "Yukarı";

} // end browse


// -------------------------------------------------------------------------
// Calculate size module
if ($net2ftp_globals["state"] == "calculatesize") {
// -------------------------------------------------------------------------
$net2ftp_messages["Size of selected directories and files"] = "Seçili dizin ve dosyaların boyutu";
$net2ftp_messages["The total size taken by the selected directories and files is:"] = "Seçili dizin ve dosyaların aldığı toplam boyut:";
$net2ftp_messages["The number of files which were skipped is:"] = "Atlanılan dosyaların sayısı:";

} // end calculatesize


// -------------------------------------------------------------------------
// Chmod module
if ($net2ftp_globals["state"] == "chmod") {
// -------------------------------------------------------------------------
$net2ftp_messages["Chmod directories and files"] = "Dizin ve dosyaları chmod";
$net2ftp_messages["Set all permissions"] = "Tüm izinleri ayarla";
$net2ftp_messages["Read"] = "Oku";
$net2ftp_messages["Write"] = "Yaz";
$net2ftp_messages["Execute"] = "Gerçekleştir";
$net2ftp_messages["Owner"] = "sahip";
$net2ftp_messages["Group"] = "Grup";
$net2ftp_messages["Everyone"] = "Herkes";
$net2ftp_messages["To set all permissions to the same values, enter those permissions and click on the button \"Set all permissions\""] = "Tüm izinleri aynı değere ayarlamak için, yukarıdaki o izinleri girin ve \"Tüm izinleri ayarla\" düğmesine tıklayın";
$net2ftp_messages["Set the permissions of directory <b>%1\$s</b> to: "] = "Diznin <b>%1\$s</b> izinlerini şuna ayarla: ";
$net2ftp_messages["Set the permissions of file <b>%1\$s</b> to: "] = "Dosyanın <b>%1\$s</b> izinlerini şuna ayarla: ";
$net2ftp_messages["Set the permissions of symlink <b>%1\$s</b> to: "] = "symlink <b>%1\$s</b> izinlerini şuna ayarla: ";      //smlink: ?
$net2ftp_messages["Chmod value"] = "Chmod değeri";
$net2ftp_messages["Chmod also the subdirectories within this directory"] = "Bu dizin içerisindeki alt dizinleri de chmod";
$net2ftp_messages["Chmod also the files within this directory"] = "Bu dizin içerisindeki dosyaları da chmod";
$net2ftp_messages["The chmod nr <b>%1\$s</b> is out of the range 000-777. Please try again."] = "chmod sayısı <b>%1\$s</b> 000-777 aralığının dışındadır. Lütfen tekrar deneyin.";

} // end chmod


// -------------------------------------------------------------------------
// Clear cookies module
// -------------------------------------------------------------------------
// No messages


// -------------------------------------------------------------------------
// Copy/Move/Delete module
if ($net2ftp_globals["state"] == "copymovedelete") {
// -------------------------------------------------------------------------
$net2ftp_messages["Choose a directory"] = "Dizin seç";
$net2ftp_messages["Copy directories and files"] = "Dizin ve dosyaları kopyala";
$net2ftp_messages["Move directories and files"] = "Dizin ve dosyaları taşı";
$net2ftp_messages["Delete directories and files"] = "Dizin ve dosyaları sil";
$net2ftp_messages["Are you sure you want to delete these directories and files?"] = "Bu dizin ve dosyaları silmek istediğinizden emin misiniz?";
$net2ftp_messages["All the subdirectories and files of the selected directories will also be deleted!"] = "Seçili dizinlerin tüm dosyaları ve alt dizinleri ayrıca silinecek!";
$net2ftp_messages["Set all targetdirectories"] = "Tüm hedef dizinleri ayarla";
$net2ftp_messages["To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."] = "Sıradan bir hedef dizin ayarlamak için, yukarıdaki metin kutusuna hedef dizini girin ve \"Tüm hedef dizinleri ayarla\"düğmesine tıklayın.";
$net2ftp_messages["Note: the target directory must already exist before anything can be copied into it."] = "Not: içerisine herhangi bir şey kopyalanmadan önce, hedef dizin önceden var olmalı.";
$net2ftp_messages["Different target FTP server:"] = "Farklı hedef FTP sunucusu:";
$net2ftp_messages["Username"] = "Kullanıcı adı";
$net2ftp_messages["Password"] = "Şifre";
$net2ftp_messages["Leave empty if you want to copy the files to the same FTP server."] = "Eğer dosyaları, aynı FTP sunucusuna kopyalamak istiyorsanız, boş bırakın.";
$net2ftp_messages["If you want to copy the files to another FTP server, enter your login data."] = "Eğer dosyaları bir başka FTP sunucusuna kopyalamak istiyorsanız, giriş bilginizi girin.";
$net2ftp_messages["Leave empty if you want to move the files to the same FTP server."] = "Eğer dosyaları, aynı FTP sunucusuna taşımak istiyorsanız, boş bırakın.";
$net2ftp_messages["If you want to move the files to another FTP server, enter your login data."] = "Eğer dosyaları bir başka FTP sunucusuna taşımak istiyorsanız, giriş bilginizi girin.";
$net2ftp_messages["Copy directory <b>%1\$s</b> to:"] = "Dizini <b>%1\$s</b> şuna kopyala:";
$net2ftp_messages["Move directory <b>%1\$s</b> to:"] = "Dizini <b>%1\$s</b> şuna taşı:";
$net2ftp_messages["Directory <b>%1\$s</b>"] = "Dizin <b>%1\$s</b>";
$net2ftp_messages["Copy file <b>%1\$s</b> to:"] = "Dosyayı <b>%1\$s</b> şuna kopyala:";
$net2ftp_messages["Move file <b>%1\$s</b> to:"] = "Dosyayı <b>%1\$s</b> şuna taşı:";
$net2ftp_messages["File <b>%1\$s</b>"] = "Dosya <b>%1\$s</b>";
$net2ftp_messages["Copy symlink <b>%1\$s</b> to:"] = "symlink <b>%1\$s</b> şuna kopyala:";    //symlink: ?
$net2ftp_messages["Move symlink <b>%1\$s</b> to:"] = "symlink <b>%1\$s</b> şuna taşı:";       //symlink: ?
$net2ftp_messages["Symlink <b>%1\$s</b>"] = "Symlink <b>%1\$s</b>";
$net2ftp_messages["Target directory:"] = "Hedef dizin:";
$net2ftp_messages["Target name:"] = "Hedef adı:";
$net2ftp_messages["Processing the entries:"] = "Girişi işleme alıyor:";

} // end copymovedelete


// -------------------------------------------------------------------------
// Download file module
// -------------------------------------------------------------------------
// No messages


// -------------------------------------------------------------------------
// EasyWebsite module
if ($net2ftp_globals["state"] == "easyWebsite") {
// -------------------------------------------------------------------------
$net2ftp_messages["Create a website in 4 easy steps"] = "4 kolay adımda bir websitesi oluştur";
$net2ftp_messages["Template overview"] = "Şablon önizleme";
$net2ftp_messages["Template details"] = "Şablon detayları";
$net2ftp_messages["Files are copied"] = "Dosyalar kopyalandı";
$net2ftp_messages["Edit your pages"] = "Sayfalarını düzenle";

// Screen 1 - printTemplateOverview
$net2ftp_messages["Click on the image to view the details of a template."] = "Bir şablonun detaylarını görüntülemek için resme tıklayın.";
$net2ftp_messages["Back to the Browse screen"] = "Tarama ekranına geri dön";
$net2ftp_messages["Template"] = "Şablon";
$net2ftp_messages["Copyright"] = "Telif hakkı";
$net2ftp_messages["Click on the image to view the details of this template"] = "Bu şablonun detaylarını görüntülemek için resme tıklayın";

// Screen 2 - printTemplateDetails
$net2ftp_messages["The template files will be copied to your FTP server. Existing files with the same filename will be overwritten. Do you want to continue?"] = "Şablon dosyaları, FTP sunucunuza kopyalanacak. Aynı isimle var olan dosyalar üzerine yazılacak. Devam etmek istiyor musunuz?";
$net2ftp_messages["Install template to directory: "] = "Şablonu dizine yükle: ";
$net2ftp_messages["Install"] = "Kur";
$net2ftp_messages["Size"] = "Boyut";
$net2ftp_messages["Preview page"] = "Önizleme sayfası";
$net2ftp_messages["opens in a new window"] = "yeni pencerede açar";

// Screen 3
$net2ftp_messages["Please wait while the template files are being transferred to your server: "] = "Şablon dosyaları sunucunuza aktarılırken lütfen bekleyin: ";
$net2ftp_messages["Done."] = "Bitti.";
$net2ftp_messages["Continue"] = "Devam";

// Screen 4 - printEasyAdminPanel
$net2ftp_messages["Edit page"] = "Sayfayı düzenle";
$net2ftp_messages["Browse the FTP server"] = "FTP sunucusunu gez";
$net2ftp_messages["Add this link to your favorites to return to this page later on!"] = "Daha sonra bu sayfaya geri dönebilmek için bu bağlantıyı sık kullanılanlarınıza ekleyin!";
$net2ftp_messages["Edit website at %1\$s"] = "%1\$s de websiteni düzenle";
$net2ftp_messages["Internet Explorer: right-click on the link and choose \"Add to Favorites...\""] = "Internet Explorer: bağlantıa sağ tıklayın ve \"Sık Kullanılanlara Ekle...\"seçin ";
$net2ftp_messages["Netscape, Mozilla, Firefox: right-click on the link and choose \"Bookmark This Link...\""] = "Netscape, Mozilla, Firefox: bağlantıya sağ tıklayın ve \"Yer imlerine ekle...\"seçin";

// ftp_copy_local2ftp
$net2ftp_messages["WARNING: Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing..."] = "UYARI: <b>%1\$s</b> alt dizinini oluşturamıyor. Önceden var olabilir. Devam ediyor...";
$net2ftp_messages["Created target subdirectory <b>%1\$s</b>"] = "Hedef alt dizin <b>%1\$s</b> oluşturuldu";
$net2ftp_messages["WARNING: Unable to copy the file <b>%1\$s</b>. Continuing..."] = "UYARI: <b>%1\$s</b> dosyasını kopyalayamıyor. Devam ediyor...";
$net2ftp_messages["Copied file <b>%1\$s</b>"] = "Dosyayı <b>%1\$s</b> kopyaladı";
}


// -------------------------------------------------------------------------
// Edit module
if ($net2ftp_globals["state"] == "edit") {
// -------------------------------------------------------------------------

// /modules/edit/edit.inc.php
$net2ftp_messages["Unable to open the template file"] = "Şablon dosyasını açamıyor";
$net2ftp_messages["Unable to read the template file"] = "Şablon dosyasını okuyamıyor";
$net2ftp_messages["Please specify a filename"] = "Lütfen bir dosya adı belirtin";
$net2ftp_messages["Status: This file has not yet been saved"] = "Durum: Bu sayfa henüz kaydedilmedi";
$net2ftp_messages["Status: Saved on <b>%1\$s</b> using mode %2\$s"] = "Durum: <b>%1\$s</b>de %2\$s modu kullanılarak kaydedildi";
$net2ftp_messages["Status: <b>This file could not be saved</b>"] = "Durum: <b>Bu sayfa kaydedilemiyor</b>";
$net2ftp_messages["Not yet saved"] = "Not yet saved";
$net2ftp_messages["Could not be saved"] = "Could not be saved";
$net2ftp_messages["Saved at %1\$s"] = "Saved at %1\$s";

// /skins/[skin]/edit.template.php
$net2ftp_messages["Directory: "] = "Dizin: ";
$net2ftp_messages["File: "] = "Dosya: ";
$net2ftp_messages["New file name: "] = "Yeni dosya adı: ";
$net2ftp_messages["Character encoding: "] = "Karakter kodlaması: ";
$net2ftp_messages["Note: changing the textarea type will save the changes"] = "Not: metin alanı türünü değiştirmek, değişiklikleri kaydedecektir";
$net2ftp_messages["Copy up"] = "Yukarıyı kopyala";     //copy up: ?
$net2ftp_messages["Copy down"] = "Aşağıyı kopyala";    //copy down: ?

} // end if edit


// -------------------------------------------------------------------------
// Find string module
if ($net2ftp_globals["state"] == "findstring") {
// -------------------------------------------------------------------------

// /modules/findstring/findstring.inc.php 
$net2ftp_messages["Search directories and files"] = "Dosya ve dizinleri ara";
$net2ftp_messages["Search again"] = "Tekrar ara";
$net2ftp_messages["Search results"] = "Arama sonuçları";
$net2ftp_messages["Please enter a valid search word or phrase."] = "Lütfen geçerli bir arama szcüğü ya da sz öbeği girin.";
$net2ftp_messages["Please enter a valid filename."] = "Lütfen geçerli bir dosya adı girin.";
$net2ftp_messages["Please enter a valid file size in the \"from\" textbox, for example 0."] = "Lütfen \"kimden\" metin kutusuna geçerli bir dosya boyutu girin, örneğin 0.";      //from: ?
$net2ftp_messages["Please enter a valid file size in the \"to\" textbox, for example 500000."] = "Lütfen \"kime\" metin kutusuna geçerli bir dosya boyutu girin, örneğin 500000.";
$net2ftp_messages["Please enter a valid date in Y-m-d format in the \"from\" textbox."] = "Lütfen \"kimden\" metin kutusuna yıl-ay-gün biçiminde geçerli bir tarih girin.";
$net2ftp_messages["Please enter a valid date in Y-m-d format in the \"to\" textbox."] = "Lütfen \"kime\" metin kutusuna yıl-ay-gün biçiminde geçerli bir tarih girin.";
$net2ftp_messages["The word <b>%1\$s</b> was not found in the selected directories and files."] = "Sözcük <b>%1\$s</b>, seçili alt dizinlerde ve dosyalarda bulunamadı.";
$net2ftp_messages["The word <b>%1\$s</b> was found in the following files:"] = "Sözcük <b>%1\$s</b>, aşağıdaki dosyalarda bulundu:";

// /skins/[skin]/findstring1.template.php
$net2ftp_messages["Search for a word or phrase"] = "Kelime ya da söz öbeği ara";
$net2ftp_messages["Case sensitive search"] = "Büyük/küçük harf hassas arama";
$net2ftp_messages["Restrict the search to:"] = "Aramayı şuna kısıtla:";
$net2ftp_messages["files with a filename like"] = "Benzer adlı dosyalar";
$net2ftp_messages["(wildcard character is *)"] = "(joker karakter: *)";              //wildcard: ?
$net2ftp_messages["files with a size"] = "boyutlu dosyalar";
$net2ftp_messages["files which were last modified"] = "son değiştirilen dosyalar";
$net2ftp_messages["from"] = "kimden";
$net2ftp_messages["to"] = "kime";

$net2ftp_messages["Directory"] = "Dizin";
$net2ftp_messages["File"] = "Dosya";
$net2ftp_messages["Line"] = "Satır";
$net2ftp_messages["Action"] = "Eylem";
$net2ftp_messages["View"] = "Görüntüle";
$net2ftp_messages["Edit"] = "Düzenle";
$net2ftp_messages["View the highlighted source code of file %1\$s"] = "Dosyanın %1\$s vurgulanmış kaynak kodunu görüntüle";
$net2ftp_messages["Edit the source code of file %1\$s"] = "Dosyanın %1\$s kaynak kodunu düzenle";

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
$net2ftp_messages["Install software packages"] = "Yazılım paketlerini yükle";
$net2ftp_messages["Unable to open the template file"] = "Şablon dosyasını açamıyor";
$net2ftp_messages["Unable to read the template file"] = "Şablon dosyasını okuyamıyor";
$net2ftp_messages["Unable to get the list of packages"] = "Paketlerin listesini alamıyor";

// /skins/blue/install1.template.php
$net2ftp_messages["The net2ftp installer script has been copied to the FTP server."] = "Net2ftp yükleyici yazılımı FTP sunucusuna kopyalandı.";
$net2ftp_messages["This script runs on your web server and requires PHP to be installed."] = "Bu yazılım, web sunucunuzda çalışır ve yüklenebilmesi için PHP gerektirir.";
$net2ftp_messages["In order to run it, click on the link below."] = "Çalıştırmak için, aşağıdaki bağlantıya tıklayın.";
$net2ftp_messages["net2ftp has tried to determine the directory mapping between the FTP server and the web server."] = "net2ftp, FTP sunucusu ile web sunucusu arasında dizin haritası belirlemeyi denedi .";    //mapping: ?
$net2ftp_messages["Should this link not be correct, enter the URL manually in your web browser."] = "Eğer bu bağlantı doğru değilse, URL yi web tarayıcınıza elinizle girin.";

} // end install


// -------------------------------------------------------------------------
// Java upload module
if ($net2ftp_globals["state"] == "jupload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Upload directories and files using a Java applet"] = "Java aplet kullanarak dizin ve dosyaları yükle";
$net2ftp_messages["Your browser does not support applets, or you have disabled applets in your browser settings."] = "Your browser does not support applets, or you have disabled applets in your browser settings.";
$net2ftp_messages["To use this applet, please install the newest version of Sun's java. You can get it from <a href=\"http://www.java.com/\">java.com</a>. Click on Get It Now."] = "To use this applet, please install the newest version of Sun's java. You can get it from <a href=\"http://www.java.com/\">java.com</a>. Click on Get It Now.";
$net2ftp_messages["The online installation is about 1-2 MB and the offline installation is about 13 MB. This 'end-user' java is called JRE (Java Runtime Environment)."] = "The online installation is about 1-2 MB and the offline installation is about 13 MB. This 'end-user' java is called JRE (Java Runtime Environment).";
$net2ftp_messages["Alternatively, use net2ftp's normal upload or upload-and-unzip functionality."] = "Alternatively, use net2ftp's normal upload or upload-and-unzip functionality.";

} // end jupload



// -------------------------------------------------------------------------
// Login module
if ($net2ftp_globals["state"] == "login") {
// -------------------------------------------------------------------------
$net2ftp_messages["Login!"] = "Giriş!";
$net2ftp_messages["Once you are logged in, you will be able to:"] = "Bir kez giriş yaptığınız zaman, şunu yapabileceksiniz:";
$net2ftp_messages["Navigate the FTP server"] = "FTP sunucusunu yönlendirme";
$net2ftp_messages["Once you have logged in, you can browse from directory to directory and see all the subdirectories and files."] = "Bir kez giriş yaptığınız zaman, dizinden dizine tarama yapabilir ve tüm alt dizinleri ve dosyaları görebilirsiniz.";
$net2ftp_messages["Upload files"] = "Dosyaları yükle";
$net2ftp_messages["There are 3 different ways to upload files: the standard upload form, the upload-and-unzip functionality, and the Java Applet."] = "Dosyaları yüklemek için 3 farklı yol var: standard yükleme formu, yükle-ve-aç işlevselliği, ve Java Apleti.";          //Applet: ?
$net2ftp_messages["Download files"] = "Dosyaları indir";
$net2ftp_messages["Click on a filename to quickly download one file.<br />Select multiple files and click on Download; the selected files will be downloaded in a zip archive."] = "Bir dosyayı hızlıca indirmek için dosya adına tıklayın.<br />Çoklu dosya seçin ve İndir e tıklayın; seçili dosyalar, zip arşiv paketi olarak indirilecektir.";
$net2ftp_messages["Zip files"] = "Zip dosyaları";
$net2ftp_messages["... and save the zip archive on the FTP server, or email it to someone."] = "... ve zip arşiv paketini FTP sunucusunda kaydet, veya birisine e-posta ile gönder.";
$net2ftp_messages["Unzip files"] = "Dosyaları çıkart";
$net2ftp_messages["Different formats are supported: .zip, .tar, .tgz and .gz."] = "Farklı biçimler destekleniyor: .zip, .tar, .tgz ve .gz.";
$net2ftp_messages["Install software"] = "Yazılım yükle";
$net2ftp_messages["Choose from a list of popular applications (PHP required)."] = "Sevilen uygulamaların listesinden seçin(PHP gerekli).";
$net2ftp_messages["Copy, move and delete"] = "Kopyala, taşı ve sil";
$net2ftp_messages["Directories are handled recursively, meaning that their content (subdirectories and files) will also be copied, moved or deleted."] = "Dizinler akıcı bir şekilde ele alınır, yani içeriği (alt dizinler ve dosyalar) ayrıca kopyalancak, taşıncak veya silinecek.";            //recursively: ?
$net2ftp_messages["Copy or move to a 2nd FTP server"] = "2. FTP sunucusuna kopyala veya taşı";
$net2ftp_messages["Handy to import files to your FTP server, or to export files from your FTP server to another FTP server."] = "FTP sunucunuza dosya aktarmak veya FTP sunucunuzdan bir başka FTP sunucusuna dosya aktarmak için kullanışlıdır.";
$net2ftp_messages["Rename and chmod"] = "Yenidenn adlandır ve chmod";
$net2ftp_messages["Chmod handles directories recursively."] = "Chmod dizinleri akıcı bir şekilde ele alır.";              //recursively: ?
$net2ftp_messages["View code with syntax highlighting"] = "Sözdizim vurgulaması ile kodu görüntüle";
$net2ftp_messages["PHP functions are linked to the documentation on php.net."] = "PHP işlevleri, php.net deki destek belgelerine bağlıdır.";
$net2ftp_messages["Plain text editor"] = "Basit metin editörü";
$net2ftp_messages["Edit text right from your browser; every time you save the changes the new file is transferred to the FTP server."] = "Tarayıcınızdan metni düzenleyin; her ne zaman değişiklikleri kaydederseniz, yeni dosya FTP sunucusuna aktarılacaktır.";
$net2ftp_messages["HTML editors"] = "HTML editörleri";
$net2ftp_messages["Edit HTML a What-You-See-Is-What-You-Get (WYSIWYG) form; there are 2 different editors to choose from."] = "Ne-Gördüğün-Ne-Elde-Ettiğindir (WYSIWYG) formunda HTML yi düzenle; seçebileceğiniz 2 farklı editör var.";
$net2ftp_messages["Code editor"] = "Kod editörü";
$net2ftp_messages["Edit HTML and PHP in an editor with syntax highlighting."] = "Sözdizim vurgulamalı bir editörde HTML ve PHP düzenle.";
$net2ftp_messages["Search for words or phrases"] = "Sözcük ya da söz öbeği arayın";
$net2ftp_messages["Filter out files based on the filename, last modification time and filesize."] = "Dosyaları adına,son değiştirme zamanına ve boyutuna dayalı olarak filtrele.";
$net2ftp_messages["Calculate size"] = "Boyutu hesapla";
$net2ftp_messages["Calculate the size of directories and files."] = "Dosya ve dizinlerin boyutunu hesapla.";

$net2ftp_messages["FTP server"] = "FTP sunucusu";
$net2ftp_messages["Example"] = "Örnek";
$net2ftp_messages["Port"] = "Port";
$net2ftp_messages["Protocol"] = "Protocol";
$net2ftp_messages["Username"] = "Kullanıcı adı";
$net2ftp_messages["Password"] = "Şifre";
$net2ftp_messages["Anonymous"] = "Anonim";
$net2ftp_messages["Passive mode"] = "Pasif mod";
$net2ftp_messages["Initial directory"] = "İlk dizin";
$net2ftp_messages["Language"] = "Dil";
$net2ftp_messages["Skin"] = "Kaplama";
$net2ftp_messages["FTP mode"] = "FTP modu";
$net2ftp_messages["Automatic"] = "Otomatik";
$net2ftp_messages["Login"] = "Giriş";
$net2ftp_messages["Clear cookies"] = "Çerezleri temizle";
$net2ftp_messages["Admin"] = "Yönetici";
$net2ftp_messages["Please enter an FTP server."] = "Lütfen bir FTP sunucusu girin.";
$net2ftp_messages["Please enter a username."] = "Lütfen bir kullanıcı adı girin.";
$net2ftp_messages["Please enter a password."] = "Lütfen bir şifre girin.";

} // end login


// -------------------------------------------------------------------------
// Login module
if ($net2ftp_globals["state"] == "login_small") {
// -------------------------------------------------------------------------

$net2ftp_messages["Please enter your Administrator username and password."] = "Lütfen yönetici kullanıcı adınızı ve şifrenizi girin.";
$net2ftp_messages["Please enter your username and password for FTP server <b>%1\$s</b>."] = "Lütfen FTP sunucusu için kullanıcı adınızı ve şifrenizi girin<b>%1\$s</b>.";
$net2ftp_messages["Username"] = "Kullanıcı adı";
$net2ftp_messages["Your session has expired; please enter your password for FTP server <b>%1\$s</b> to continue."] = "Oturumunuz sona erdi; lütfen <b>%1\$s</b> devam etmek için,FTP sunucusu için şifrenizi girin.";
$net2ftp_messages["Your IP address has changed; please enter your password for FTP server <b>%1\$s</b> to continue."] = "IP adresiniz değişti; lütfen <b>%1\$s</b> devam etmek için,FTP sunucusu için şifrenizi girin.";
$net2ftp_messages["Password"] = "Şifre";
$net2ftp_messages["Login"] = "Giriş";
$net2ftp_messages["Continue"] = "Devam";

} // end login_small


// -------------------------------------------------------------------------
// Logout module
if ($net2ftp_globals["state"] == "logout") {
// -------------------------------------------------------------------------

// logout.inc.php
$net2ftp_messages["Login page"] = "Giriş sayfası";

// logout.template.php
$net2ftp_messages["You have logged out from the FTP server. To log back in, <a href=\"%1\$s\" title=\"Login page (accesskey l)\" accesskey=\"l\">follow this link</a>."] = "FTP sunucusundan çıkış yaptınız. Geri giriş yapmak için, <a href=\"%1\$s\" title=\"Giriş sayfası (accesskey l)\" accesskey=\"l\">bu bağlantıyı takip edin</a>.";
$net2ftp_messages["Note: other users of this computer could click on the browser's Back button and access the FTP server."] = "Not: bu bilgisayarın diğer kullanıcıları,tarayıcının Geri düğmesine tıklayabilir ve FTP sunucusuna ulaşabilir.";
$net2ftp_messages["To prevent this, you must close all browser windows."] = "Bunu önlemek için, tüm tarayıcı pencerelerini kapatmalısınız.";
$net2ftp_messages["Close"] = "Kapat";
$net2ftp_messages["Click here to close this window"] = "Bu pencereyi kapatmak için buraya tıklayınız";

} // end logout


// -------------------------------------------------------------------------
// New directory module
if ($net2ftp_globals["state"] == "newdir") {
// -------------------------------------------------------------------------
$net2ftp_messages["Create new directories"] = "Yeni dizinler oluştur";
$net2ftp_messages["The new directories will be created in <b>%1\$s</b>."] = "Yeni dizinler, <b>%1\$s</b>de oluşturulacaktır.";
$net2ftp_messages["New directory name:"] = "Yeni dizin adı:";
$net2ftp_messages["Directory <b>%1\$s</b> was successfully created."] = "Dizin <b>%1\$s</b> başarılı bir şekilde oluşturuldu.";
$net2ftp_messages["Directory <b>%1\$s</b> could not be created."] = "Dizin <b>%1\$s</b> oluşturamıyor.";

} // end newdir


// -------------------------------------------------------------------------
// Raw module
if ($net2ftp_globals["state"] == "raw") {
// -------------------------------------------------------------------------

// /modules/raw/raw.inc.php
$net2ftp_messages["Send arbitrary FTP commands"] = "Rastgele FTP komutları gönder";


// /skins/[skin]/raw1.template.php
$net2ftp_messages["List of commands:"] = "Komutların listesi:";
$net2ftp_messages["FTP server response:"] = "FTP sunucusu cevabı:";

} // end raw


// -------------------------------------------------------------------------
// Rename module
if ($net2ftp_globals["state"] == "rename") {
// -------------------------------------------------------------------------
$net2ftp_messages["Rename directories and files"] = "Dosya ve dizileri yeniden adlandır";
$net2ftp_messages["Old name: "] = "Eski ad: ";
$net2ftp_messages["New name: "] = "Yeni ad: ";
$net2ftp_messages["The new name may not contain any dots. This entry was not renamed to <b>%1\$s</b>"] = "Yeni ad nokta içeremez. Bu giriş, <b>%1\$s</b>e yeniden adlandırılmadı";
$net2ftp_messages["The new name may not contain any banned keywords. This entry was not renamed to <b>%1\$s</b>"] = "Yeni ad yasaklı anahtar kelime içeremez. Bu giriş, <b>%1\$s</b>e yeniden adlandırılmadı";
$net2ftp_messages["<b>%1\$s</b> was successfully renamed to <b>%2\$s</b>"] = "<b>%1\$s</b> başarılı bir şekilde <b>%2\$s</b>e yeniden adlandırıldı";
$net2ftp_messages["<b>%1\$s</b> could not be renamed to <b>%2\$s</b>"] = "<b>%1\$s</b> ,<b>%2\$s</b>e yeniden adlandırılamıyor";

} // end rename


// -------------------------------------------------------------------------
// Unzip module
if ($net2ftp_globals["state"] == "unzip") {
// -------------------------------------------------------------------------

// /modules/unzip/unzip.inc.php
$net2ftp_messages["Unzip archives"] = "Arşiv paketlerini aç";
$net2ftp_messages["Getting archive %1\$s of %2\$s from the FTP server"] = "FTP sunucusundan arsiv paketini aliyor %1\$s - %2\$s";
$net2ftp_messages["Unable to get the archive <b>%1\$s</b> from the FTP server"] = "FTP sunucusundan arşiv paketini alamıyor <b>%1\$s</b>";

// /skins/[skin]/unzip1.template.php
$net2ftp_messages["Set all targetdirectories"] = "Tüm hedef dizinleri ayarla";
$net2ftp_messages["To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."] = "Sıradan bir hedef dizin ayarlamak için, yukarıdaki metin kutusuna hedef dizini girin ve \"Tüm hedef dizinleri ayarla\"düğmesine tıklayın.";
$net2ftp_messages["Note: the target directory must already exist before anything can be copied into it."] = "Not: içerisine herhangi bir şey kopyalanmadan önce, hedef dizin önceden var olmalı.";
$net2ftp_messages["Unzip archive <b>%1\$s</b> to:"] = "Arşiv paketlerini <b>%1\$s</b> şuna aç:";
$net2ftp_messages["Target directory:"] = "Hedef dizin:";
$net2ftp_messages["Use folder names (creates subdirectories automatically)"] = "Klasör adlarını kullan (otomatik alt dizinler oluşturur)";

} // end unzip


// -------------------------------------------------------------------------
// Upload module
if ($net2ftp_globals["state"] == "upload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Upload to directory:"] = "Dizine yükle:";    //dizine: klasöre
$net2ftp_messages["Files"] = "Dosyalar";
$net2ftp_messages["Archives"] = "Arşiv paketleri";
$net2ftp_messages["Files entered here will be transferred to the FTP server."] = "Buraya girilen dosyalar FTP sunucusuna aktarılacaktır.";
$net2ftp_messages["Archives entered here will be decompressed, and the files inside will be transferred to the FTP server."] = "Buraya girilen arşiv paketleri açılacaktır ve içerisindeki dosyalar FTP sunucusuna aktarılacaktır.";
$net2ftp_messages["Add another"] = "Bir başkasını ekle";
$net2ftp_messages["Use folder names (creates subdirectories automatically)"] = "Klasör adlarını kullan (otomatik alt dizinler oluşturur)";

$net2ftp_messages["Choose a directory"] = "Dizin seç";
$net2ftp_messages["Please wait..."] = "Lütfen bekleyin...";
$net2ftp_messages["Uploading... please wait..."] = "Yüklüyor... lütfen bekleyin...";
$net2ftp_messages["If the upload takes more than the allowed <b>%1\$s seconds<\/b>, you will have to try again with less/smaller files."] = "Eğer yükleme izin verilen <b>%1\$s saniye<\/b>den daha fazla sürerse, daha az/daha küçük dosyalar ile tekrar denemek zorunda kalacaksınız.";
$net2ftp_messages["This window will close automatically in a few seconds."] = "Bu pencere birkaç saniye içinde otomatik olarak kapancaktır.";
$net2ftp_messages["Close window now"] = "Pencereyi şimdi kapat";

$net2ftp_messages["Upload files and archives"] = "Dosyaları ve arşiv paketlerini yükle";
$net2ftp_messages["Upload results"] = "Yükleme sonuçları";
$net2ftp_messages["Checking files:"] = "Dosyaları denetliyor:";
$net2ftp_messages["Transferring files to the FTP server:"] = "Dosyaları FTP sunucusuna aktarıyor:";
$net2ftp_messages["Decompressing archives and transferring files to the FTP server:"] = "Arşiv paketlerini açıyor ve FTP sunucusuna aktarıyor:";
$net2ftp_messages["Upload more files and archives"] = "Daha fazla arşiv paketi ve dosya yükle";

} // end upload


// -------------------------------------------------------------------------
// Messages which are shared by upload and jupload
if ($net2ftp_globals["state"] == "upload" || $net2ftp_globals["state"] == "jupload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Restrictions:"] = "Kısıtlamalar:";
$net2ftp_messages["The maximum size of one file is restricted by net2ftp to <b>%1\$s</b> and by PHP to <b>%2\$s</b>"] = "The maximum size of one file is restricted by net2ftp to <b>%1\$s</b> and by PHP to <b>%2\$s</b>";
$net2ftp_messages["The maximum execution time is <b>%1\$s seconds</b>"] = "Maksimum uygulama süresi <b>%1\$s saniye</b>dir";
$net2ftp_messages["The FTP transfer mode (ASCII or BINARY) will be automatically determined, based on the filename extension"] = "FTP aktarım modu (ASCII veya BINARY) dosya uzantısına bağlı olarak ,otomatik belirlenecektir";
$net2ftp_messages["If the destination file already exists, it will be overwritten"] = "Eğer hedef dosya zaten varsa, üzerine yazılacaktır";

} // end upload or jupload


// -------------------------------------------------------------------------
// View module
if ($net2ftp_globals["state"] == "view") {
// -------------------------------------------------------------------------

// /modules/view/view.inc.php
$net2ftp_messages["View file %1\$s"] = "Dosyayı göster %1\$s";
$net2ftp_messages["View image %1\$s"] = "Resmi %1\$s görüntüle";
$net2ftp_messages["View Macromedia ShockWave Flash movie %1\$s"] = "Macromedia ShockWave Flaş filmini göster %1\$s";
$net2ftp_messages["Image"] = "Resim";

// /skins/[skin]/view1.template.php
$net2ftp_messages["Syntax highlighting powered by <a href=\"http://luminous.asgaard.co.uk\">Luminous</a>"] = "Sözdizim vurgulama <a href=\"http://luminous.asgaard.co.uk\">Luminous</a> ile güçlendirilmiştir";
$net2ftp_messages["To save the image, right-click on it and choose 'Save picture as...'"] = "Resmi kaydetmek için, üzerine sağ tıklayın ve 'Resmi Farklı Kaydet...'i seçin";

} // end view


// -------------------------------------------------------------------------
// Zip module
if ($net2ftp_globals["state"] == "zip") {
// -------------------------------------------------------------------------

// /modules/zip/zip.inc.php
$net2ftp_messages["Zip entries"] = "Zip girişleri";

// /skins/[skin]/zip1.template.php
$net2ftp_messages["Save the zip file on the FTP server as:"] = "FTP sunucusunda zip dosyası olarak kaydet:";
$net2ftp_messages["Email the zip file in attachment to:"] = "Zip dosyasını ek şeklinde birisine, e-posta ile gönder:";
$net2ftp_messages["Note that sending files is not anonymous: your IP address as well as the time of the sending will be added to the email."] = "Dosya göndermenin anonim olmadığına dikkat edin: Gönderme zamanınıza ek olarak, IP adresiniz e-postaya eklenecek.";
$net2ftp_messages["Some additional comments to add in the email:"] = "E-postaya eklenecek bazı ek yorumlar:";

$net2ftp_messages["You did not enter a filename for the zipfile. Go back and enter a filename."] = "Zip dosyası için bir dosya adı girmediniz. Geri dönün ve bir dosya adı girin.";
$net2ftp_messages["The email address you have entered (%1\$s) does not seem to be valid.<br />Please enter an address in the format <b>username@domain.com</b>"] = "Girdiğiniz e-posta adresi (%1\$s) geçerli gözükmüyor.<br />Lütfen <b>kullanıcıadı@alanadı.com</b> biçiminde bir adres girin";

} // end zip

?>