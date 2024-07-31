<?php

namespace App\Components;

class Recusive
{
    private $data;
    private $html = '';
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getCategoryRecusive($parentId, $id = 0, $text = '')
    {

        foreach ($this->data as $dataItem) {

            if ($dataItem['parent_id'] == $id) {
                if (!empty($parentId) && $parentId == $dataItem['id']) {
                    $this->html .= "<option selected value='" . $dataItem['id'] . "'>" . $text . $dataItem['name'] . "</option>";
                } else {
                    $this->html .= "<option value='" . $dataItem['id'] . "'>" . $text . $dataItem['name'] . "</option>";
                }
                $this->getCategoryRecusive($parentId, $dataItem['id'], $text . ' - ');
            }
        }

        return $this->html;
    }
}
