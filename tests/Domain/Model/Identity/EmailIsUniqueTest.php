<?php namespace Cribbb\Tests\Domain\Model\Identity;

use Mockery as m;
use Cribbb\Domain\Model\Identity\Email;
use Cribbb\Domain\Model\Identity\EmailIsUnique;

class EmailIsUniqueTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserRepository */
    private $repository;

    /** @var EmailIsUnique */
    private $spec;

    public function setUp()
    {
        $this->repository = m::mock('Cribbb\Domain\Model\Identity\UserRepository');
        $this->spec = new EmailIsUnique($this->repository);
    }

    /** @test */
    public function should_return_true_when_unique()
    {
        $this->repository->shouldReceive('userOfEmail')->andReturn(null);
        $this->assertTrue($this->spec->isSatisfiedBy(new Email('name@domain.com')));
    }

    /** @test */
    public function should_return_false_when_not_unique()
    {
        $this->repository->shouldReceive('userOfEmail')->andReturn(['id' => 1]);
        $this->assertFalse($this->spec->isSatisfiedBy(new Email('name@domain.com')));
    }
}
