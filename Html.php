<?php

class Html
{
	/*
	* Creates the tag given
	*/
	public static function tag(string $tag, string $content = '', array $options = [])
	{
		$tagOptions = self::setTagOptions($options);
		return sprintf('<%s %s >%s</%s>', $tag, $tagOptions, $content, $tag);
	}

	/*
	* Creates the a tag
	*/
	public static function a(string $href, string $content = '', array $options = [])
	{
		$tagOptions = self::setTagOptions(array_merge($options, ['href' => $href]));
		return sprintf('<a %s >%s</a>', $tagOptions, $content);
	}

	/*
	* Creates an unordered list
	*/
	public static function ul(array $data, array $ulOptions = [], array $liOptions = []) : string
	{
		return self::createList('ul', $data, $ulOptions, $liOptions);
	}

	/*
	* Creates an ordered list
	*/
	public static function ol(array $data, array $olOptions = [], array $liOptions = []) : string
	{
		return self::createList('ol', $data, $olOptions, $liOptions);
	}

	/*
	* Loops through the data for the list creation. Multiple levels of the list are supported
	*/
	private static function createList(string $list, array $data, array $options = [], array $liOptions = []) : string
	{
		$liOptionsString = self::setTagOptions($liOptions);
		$listOptionsString = self::setTagOptions($options);
		$listString = sprintf('<%s %s >', $list, $listOptionsString);
		foreach($data as $key => $val)
		{
			if(is_array($val))
			{
				$listString .= '<li '.$liOptionsString.'>' .self::{$val[0]}($val[1], isset($val[2]) ? $val[2] : [], isset($val[3]) ? $val[3] : []) .'</li>';
			}
			else{
				$listString .= sprintf('<li %s>%s</li>', $liOptionsString, $val);
			}
		}
		return sprintf('%s </%s>', $listString, $list);
	}

	/*
	* Creates the options from the array
	*/
	protected static function setTagOptions(array $options) : string
	{
		$str = '';
		if(!empty($options))
		{
			foreach($options as $key => $val)
			{
				$str .= sprintf(' %s="%s"', $key, $val);
			}
		}
		return $str;
	}
}