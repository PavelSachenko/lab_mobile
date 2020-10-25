<?php


namespace App\Graber;


use App\Models\Graber\Src;
use PHPHtmlParser\Dom;

class Grab
{

    private $dom;

    public function __construct($url = "https://knute.edu.ua/blog/read/?pid=1038&uk")
    {
        $this->dom = new Dom();
        $this->dom->loadFromUrl($url);
        $this->initial();
    }

    public function getSrc()
    {
        $faculties = [];
        $arrSrc = [];

        foreach ($this->dom->find('td') as $faculty){
            $faculties[$faculty->firstChild()->innerHtml] = [];
        }

        for ($i = 0; $i<4; $i++){
            $this->dom = $this->dom->nextSibling();
            $this->dom = $this->dom->nextSibling();
            foreach ($this->dom->find('a') as $src){
                $arrSrc[] = [mb_substr($src->firstChild()->innerHtml, 0, 6) => $src->getAttribute('href')];
            }
        }

        return $this->transformSrcArray($faculties, $arrSrc);
    }

    private function transformSrcArray(array $faculties, array $src): array
    {
        $srcArray = [];
        $reff = 0;
        foreach ($faculties as $key => $faculty){
            for ($i = 0 + $reff; $i <24; $i = $i + 6){
                $srcArray[$key][key($src[$i])] = $src[$i][key($src[$i])];
                if (($i+6) >= 24){
                    break;
                }

            }
            $reff++;
        }

        $this->saveRefs($srcArray);
        return $srcArray;
    }

    private function initial()
    {
        $this->dom = $this->dom->find("table[@class='table table-striped']/tbody");
        $this->dom = $this->dom[0]->firstChild();
        $this->dom = $this->dom->nextSibling();
    }

    private function saveRefs(array $refs)
    {
        foreach ($refs as $facultyTitle => $faculty){
            foreach ($faculty as $course => $ref){
                $src = new Src();
                $src->course = $course;
                $src->faculty = $facultyTitle;
                $src->src = $ref;
                $src->save();
            }
        }
    }

}
