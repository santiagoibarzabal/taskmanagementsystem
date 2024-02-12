<?php

declare(strict_types=1);

namespace Tests\User\Domain;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Status\Domain\ValueObjects\Description as StatusDescription;
use App\TaskManagementSystem\Task\Domain\Exceptions\InvalidTaskDescriptionException;
use App\TaskManagementSystem\Task\Domain\Exceptions\InvalidTaskTitleException;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Title;
use App\TaskManagementSystem\User\Domain\UserAggregate;
use Illuminate\Support\Str;
use Tests\UnitTestCase;

class UserAggregateTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_create_task_aggregate_throw_invalid_description_exception(): void
    {
        $this->expectException(InvalidTaskDescriptionException::class);
        TaskAggregate::create(
            Title::create('title'),
            Description::create(Str::random(290)),
            Priority::LOW,
            StatusAggregate::create(StatusDescription::PENDING),
        );
    }
}
