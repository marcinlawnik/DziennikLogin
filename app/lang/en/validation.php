<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "The :attribute musi być zaakceptowany.",
	"active_url"           => "The :attribute to nie jest ważny URL.",
	"after"                => "The :attribute dane muszą być:date.",
	"alpha"                => "The :attribute może zawierać tylko litery.",
	"alpha_dash"           => "The :attribute może zawierać litery,cyfry i znaki.",
	"alpha_num"            => "The :attribute może zawierać tylko liczby i litery.",
	"array"                => "The :attribute musi być tablicą.",
	"before"               => "The :attribute musi być informacją przed :date.",
	"between"              => array(
		"numeric" => "The :attribute musi być pomiędzy :min and :max.",
		"file"    => "The :attribute musi być pomiędzy :min and :max kilobytes.",
		"string"  => "The :attribute musi być pomiędzy :min and :max characters.",
		"array"   => "The :attribute musi być pomiędzy:min and :max items.",
	),
	"confirmed"            => "The :attribute potwierdzenie się nie zgadza.",
	"date"                 => "The :attribute to nie są ważne dane.",
	"date_format"          => "The :attribute nie zgodny z formatem :format.",
	"different"            => "The :attribute and :other musi byc inny.",
	"digits"               => "The :attribute musi być :digits cyfry.",
	"digits_between"       => "The :attribute musi być pomiędzy :min and :max cyfry.",
	"email"                => "The :attribute musi byc poprawny adres email.",
	"exists"               => "The selected :attribute jest niepoprawny.",
	"image"                => "The :attribute musi być obraz.",
	"in"                   => "The selected :attribute jest niepoprawny.",
	"integer"              => "The :attribute musi być liczba całkowita.",
	"ip"                   => "The :attribute musi być poprawny adres email.",
	"max"                  => array(
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => "The :attribute may not be greater than :max characters.",
		"array"   => "The :attribute may not have more than :max items.",
	),
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
		"array"   => "The :attribute must have at least :min items.",
	),
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "The :attribute field is required.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => array(
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	),
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
