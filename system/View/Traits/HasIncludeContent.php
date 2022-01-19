<?php


namespace System\View\Traits;


trait HasIncludeContent
{
    private function checkIncludesContent()
    {
        while (1) {
            $includesNamesArray = $this->findIncludesNames();
            if ($includesNamesArray) {
                foreach ($includesNamesArray as $includeName) {
                    $this->initialIncludes($includeName);
                }
            } else {
                break;
            }
        }
    }

    private function findIncludesNames()
    {
        $fileIncludesNamesArray = [];
        preg_match_all("/@include+\('([^)]+)'\)/", $this->content, $fileIncludesNamesArray);
        return isset($fileIncludesNamesArray[1]) ? $fileIncludesNamesArray[1] : false;
    }

    private function initialIncludes($includeName)
    {
        $this->content = str_replace("@include('$includeName')", $this->viewLoader($includeName), $this->content);
    }
}