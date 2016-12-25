<?php
trait Tools {
	
	// стандартизированная обработка данных из форм (POST-параметров из форм и GET-параметров из адресной строки)
	public static function clearData($data, $type="s")
	{
		switch ($type)
		{
			case 's':	return trim(htmlspecialchars($data));	// если тип переменной - строка (по умолчанию)
			case 'i':	return abs( (int) $data);							// если тип переменной - целое число
		}
	}

	// отладочный вывод информации
	public static function showDev($value = '')
	{
		echo '<pre>';
		print_r($value);
		echo '</pre>';
	}

	//  раскодирование символов Unicode в PHP 
	public static function decodeUnicode($value)
	{
		if(!$value) {
			throw new Exception('ERROR! '.__FILE__. ':'.__LINE__.'&lt;br />В метод decodeUnicode() не поступил параметр');
		}
		if(getType($value) !== 'string') {
			throw new Exception('ERROR! '.__FILE__. ':'.__LINE__.'&lt;br />В метод decodeUnicode() поступила не строка');
		}

		$s = preg_replace('/\\\u0([0-9a-fA-F]{3})/','&#x\1;', $value);
		$s = html_entity_decode($s, ENT_NOQUOTES,'UTF-8');
		
		return $s;
	}
}