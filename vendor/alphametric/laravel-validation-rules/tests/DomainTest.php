<?php

// Namespace
namespace Alphametric\Validation\Rules\Tests;

// Using directives
use Alphametric\Validation\Rules\Domain;
use Orchestra\Testbench\TestCase as Orchestra;

// Domain test
class DomainTest extends Orchestra
{

	/** @test */
	public function the_domain_rule_can_be_validated()
	{
		// Define the validation rule
		$rule = ['domain' => [new Domain]];

		// Execute the tests
		$this->assertFalse(validator(['domain' => 'http://'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'https://'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'http://google.com'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'https://google.com'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'http://google'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'https://google'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'https://google.com/test'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'google.com/test'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'www.google.com/test'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'www.google.com/test/test'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 'google'], $rule)->passes());
		$this->assertFalse(validator(['domain' => 1], $rule)->passes());
		$this->assertTrue(validator(['domain' => 'google.com'], $rule)->passes());
		$this->assertTrue(validator(['domain' => 'www.google.com'], $rule)->passes());
	}

}
