<?php


namespace App\Parser\Parsers;


use App\Parser\IParse;

class ParserFit implements IParse
{

    /**
     * @var array
     */
    private array $lists = [];

    /**
     * ParserFit constructor.
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function __construct()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $excel = $reader->load('S:\newOpen\OpenServer\domains\schedule.loc\app\Parser\Parsers\testpars.xls');
        // Устанавливаем индекс активного листа
        $excel->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $excel->getActiveSheet();
        foreach ($excel->getWorksheetIterator() as $worksheet) {
            $this->lists[] = $worksheet->toArray();
        }
    }

    /**
     * @param array $groups
     * @param array $list
     * @param $range
     */
    private function createSchedule(array &$groups, array &$list, $range)
    {
        foreach ($list as $keyRow => $row) {
            $numberPara = null;
            foreach ($row as $keyColumn => $column){
                if(mb_stripos($column,"група") !== false || mb_stripos($column,"номер") !== false) {
                    break;
                }
                //записываем в массив день
                if($keyColumn == 1 && !is_null($column)){
                    //заполняем дни
                    foreach ($groups as $keyGroup => $group){
                        if (array_key_exists($column ,$groups[$keyGroup])){
                            $column = $column . " (2)";
                        }
                        $groups[$keyGroup][$column] = [];
                    }
                    //перемещяем указатель на сл день
                    if($keyRow != key($list)){
                        foreach ($groups as $keyGroup => $group){
                            end($groups[key($groups)]);
                            next($groups);
                        }
                    }
                    reset($groups);
                }
                if ($keyColumn == 2){
                    $numberPara = $column;
                }
                //диапазон где есть пары для групп
                if ($keyColumn >= $range['start'] && ($keyColumn <= $range['end'])){
                    $prevTitlePara = '';
                    if(is_null($numberPara)){
                        $existNumberPara = array_key_last($groups[key($groups)][key($groups[key($groups)])]);
                        if (!is_null($existNumberPara)){
                            $prevTitlePara = $groups[key($groups)][key($groups[key($groups)])][$existNumberPara];
                        }
                    }
                    //если пары нету удаляем массив
                    if($prevTitlePara == '' && $column == ''){
                        unset($groups[key($groups)][key($groups[key($groups)])][(is_null($numberPara)) ? $existNumberPara : $numberPara]);
                    }else{
                        $groups[key($groups)][key($groups[key($groups)])][(is_null($numberPara)) ? $existNumberPara : $numberPara] = $prevTitlePara . ' ' .  $column;
                    }
                    next($groups);
                }
            }
            //сброс указателя
            reset($groups);
        }
    }

    /**
     * @param array $lists
     * @return array
     */
    private function findRangeForGroup(array $lists) :array
    {
        $range = [
            'start' => 0,
            'end' => 0,
        ];
        foreach ($lists[key($lists)] as $keyColumn => $column){
            if(gettype($column) === "integer"){
                if ($range['start'] != 0){
                    $range['end'] = $keyColumn-1;
                }else{
                    $range['start'] = $keyColumn+1;
                }
            }
        }
        return $range;
    }

    /**
     * @param $list
     * @return array
     */
    //поиск групп и удаление лишней начальнойй информации
    private function searchGroup(array &$list) :array
    {
        $groups = [];
        foreach ($list as $keyRow => $row){
            foreach ($row as $keyColumn => $column){
                if(mb_stripos($column,"група") !== false){
                    $groups[$column] = [];
                }
            }
            unset($list[$keyRow]);
            if (!empty($groups)){
                break;
            }
        }

        return $groups;
    }

    /**
     * @return array
     */
    public function run(): array
    {
        $groups['course'] = 4;
        $groups['faculty'] = 'FIT';
        $groups['schedule'] = $this->searchGroup($this->lists[0]);
        $range = $this->findRangeForGroup($this->lists[0]);
        $this->createSchedule($groups['schedule'], $this->lists[0], $range);


//        $groups['schedule'] = $groups;
        return $groups;
    }
}
