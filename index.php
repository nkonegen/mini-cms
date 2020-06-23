<?php
// get content of .json files and convert JSON objects to PHP objects #############################
$startPageJsonFileContent = file_get_contents("data/start_page.json");
$startPageJsonArray = json_decode($startPageJsonFileContent, true);

$subPage1JsonFileContent = file_get_contents("data/sub_page1.json");
$subPage1JsonArray = json_decode($subPage1JsonFileContent, true);

$subPage2JsonFileContent = file_get_contents("data/sub_page2.json");
$subPage2JsonArray = json_decode($subPage2JsonFileContent, true);

$pages = ['start_page' => $startPageJsonArray, 'sub_page1' => $subPage1JsonArray, 'sub_page2' => $subPage2JsonArray];

// get content of .tmpl files #####################################################################
$startPageTemplateFileContent = file_get_contents("templates/start_page.tmpl");

$subPageTemplateFileContent = file_get_contents("templates/sub_page.tmpl");

$contentElementTemplateFileContent = file_get_contents("templates/content_element.tmpl");

$templates = ['startpage' => $startPageTemplateFileContent, 'subpage' => $subPageTemplateFileContent];

// foreach loop ###################################################################################
foreach ($pages as $key => $page) {
    $filledContentElements = '';
    $templateName = $page['template'];

    foreach ($page['content_elements'] as $contentElement) {
        $title = $contentElement['title'];
        $subtitle = $contentElement['subtitle'];
        $content = $contentElement['content'];

        $search = ['{title}', '{subtitle}', '{content}'];
        $replace = $contentElement;
        $filledContentElements .= str_replace($search , $replace, $contentElementTemplateFileContent);
    }

    echo $filledContentElements;
    $filledPage = str_replace('{content}', $filledContentElements, $templates[$templateName]);

    file_put_contents("public/$key.html", $filledPage);

    echo "<hr>";
}
