{* $env string - Environment for JavaScript - constants for api urls, current language and other. User can add own in user.ini, [environment part] *}
{* $lang string - Current language shortname *}
{* $url base string - Url with subfolder if it *}
{* $urlLibs string - Url for libs public dir - for jquery, bootstrap etc /libs *}
{* $urlThemes string - Url for themes catalog in public folder /themes *}
{* $urlTheme string - Url for current theme catalog in public folder /themes/{theme} *}
{* $urlCss string - Url for current theme Css catalog in public folder /themes/{theme}/css *}
{* $urlJs string - Url for current theme Js catalog in public folder /themes/{theme}/js *}
{* $urlImages string - Url for current theme images catalog in public folder /themes/{theme}/images *}
{* $urlFonts string - Url for current theme fonts catalog in public folder /themes/{theme}/fonts *}
{* $route array - current route parametres as array *}
{* $otherLanguages array - links for current page in other languages *}
{* $styles string - styles for html header part. Can be link in controller $this->setStyle('mystyle.css') *}
{* $title string - page title, can be set in controller $this->setPageTitle('page title here'); *}
{* $header string - page header string, can be set in controller $this->setPageHeader('Page options'); *}
{* $scripts_header string - scripts for html header part. Can be link in controller $this->setScript('mystyle.js') *}
{* $scripts_footer string - scripts for html footer part. Can be link in controller $this->setScript('mystyle.js') *}
{* $microformat string - microformat settings *}
{* $keywords string - keywords. Can be set in controller in $this->setKeywords('one,two,three'); *}
{* $description string - description. Can be set in controller in $this->setDescription('desc here'); *}
{* $messages array - Array of system and user messages - alerts, info, errors etc *}
{* $projectName string - project name from config.ini *}
{* $content string - content part if it declared in controller *}
{* [url c="mycontroller" $a="myaction" p="?a=5" r="admin" l="ru"] - Generate url using site routing rules https://site.com/admin/ru/mycontroller/myaction?a=5 *}
