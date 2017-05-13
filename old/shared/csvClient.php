<?php

class csvClient {
	public $header;
	public $rows;
	private $async;
        private $fileName;
        
	public function __construct($fileName, $async = true) {
		$this->header = array();
		$this->rows = array();
                $this->async = $async;
                $this->fileName = $fileName;
                
                //если запись асинхронная, создадим файл
                if ($this->async) {
                    $fp = fopen($this->fileName, 'a');
                    fclose($fp);
                }
	}
	
	public function addHeader($header) {
                //если заголовок уже устанавливали, выходим
                if (count($this->header) > 0)
                    return false;
                
		$inputenc = mb_convert_variables('windows-1251', 'utf-8', $header);
		$this->header = $header;
                if ($this->async) {
                    $this->saveRow($header);
                }
	}
	
	public function addRow($row) {
		$inputenc = mb_convert_variables('windows-1251', 'utf-8', $row);
		$this->rows[] = $row;
                if ($this->async) {
                    $this->saveRow($row);
                }
	}
	
	public function printCsv() {
		print_r($this->rows);
	}
	
        //если нужно записать в другой файл, передаем имя файла
	public function saveCsv($fileName = null) {
            //если передано имя файла, пишем в него, 
            //если нет, пишем в файл, который указали при создании объекта
            if ($fileName) {
                $fp = fopen($fileName, 'w');
            } else {
                $fp = fopen($this->fileName, 'w');
            }
            //если есть заголовок, сохраняем
            if($this->header) {
                fputcsv($fp, $this->header, ';');
            }
            //если есть строки, сохраняем
            if (count($this->rows) > 0)
            foreach ($this->rows as $row) {
                fputcsv($fp, $row, ';');
            }
            fclose($fp);
	}
        
        private function saveRow($row) {
            
            if ($this->fileName) {
                $fp = fopen($this->fileName, 'a');
                fputcsv($fp, $row, ';');
                fclose($fp);
            }
        }
        
        
}
	

?>