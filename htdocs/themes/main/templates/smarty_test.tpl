<!DOCTYPE html>
<html lang="{$lang}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="{$description}">
        <meta name="keywords" content="{$keywords}" />
        <title>{$title} - {$config->getProjectName()}</title>
        {$styles}
        {$env}
        {$scripts_header}
        {$snippets_top}
    </head>
    <body>
        {$snippets_middle}
        <h3>{_("Url operations")}</h3>
        <ul>
            <li>
                {url}
            </li>
            <li>
                {url c="mycontroller"}
            </li>
            <li>
                {url c="mycontroller" a="myaction" p="?param1=test"}
            </li>
            <li>
                {url c="mycontroller" r="admin"}
            </li>
            <li>
                {url c="mycontroller" r="admin" l="ru"}
            </li>
        </ul>
        <h3>{_("Print_r of route")}</h3>
        <pre>
        {print_r($route)}
        {$scripts_footer}
        {$snippets_middle}
</pre>
    </body>
</html>
