<?php
// **************************************** get .json files ****************************************
$startPageJsonFileContent = file_get_contents("data/start_page.json"); // Get content of start_page.json file
$startPageJsonArray = json_decode($startPageJsonFileContent, true); //convert JSON object to PHP object

$subPage1JsonFileContent = file_get_contents("data/sub_page1.json"); // Get content of sub_page1.json file
$subPage1JsonArray = json_decode($subPage1JsonFileContent, true); //convert JSON object to PHP object

$subPage2JsonFileContent = file_get_contents("data/sub_page2.json"); // Get content of sub_page2.json file
$subPage2JsonArray = json_decode($subPage2JsonFileContent, true); //convert JSON object to PHP object

$pages = ['start_page' => $startPageJsonArray, 'sub_page1' => $subPage1JsonArray, 'sub_page2' => $subPage2JsonArray];

// **************************************** get .tmpl files ****************************************
$startPageTemplateFileContent = file_get_contents("templates/start_page.tmpl"); // Get content of start_page.tmpl file

$subPageTemplateFileContent = file_get_contents("templates/sub_page.tmpl"); // Get content of sub_page.tmpl file

$contentElementTemplateFileContent = file_get_contents("templates/content_element.tmpl"); // Get content of content_element.tmpl file

$templates = ['startpage' => $startPageTemplateFileContent, 'subpage' => $subPageTemplateFileContent];

// **************************************** foreach loop ****************************************
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

	// write .html pages in public folder
	file_put_contents("public/$key.html", $filledPage);

	echo "<hr>";
}
