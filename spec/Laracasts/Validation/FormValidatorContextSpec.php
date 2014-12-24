<?php

namespace spec\Laracasts\Validation;

use Laracasts\Validation\FactoryInterface;
use Laracasts\Validation\ValidatorInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormValidatorContextSpec extends ObjectBehavior
{
	function let(FactoryInterface $validatorFactory)
	{
		$this->beAnInstanceOf('spec\Laracasts\Validation\AnotherExampleValidator');
		$this->beConstructedWith($validatorFactory);
	}

	function it_allows_setting_of_a_context()
	{
		$this->setContext('store');

		$this->getContext()->shouldReturn('store');
	}

	function it_returns_correct_validation_rules()
	{
		$this->setContext('store');

		$this->getValidationRules()->shouldReturn(array('username' => 'required'));
	}

}

class AnotherExampleValidator extends \Laracasts\Validation\FormValidator {
	protected $rules = [
		'store' => ['username' => 'required']
	];
}
