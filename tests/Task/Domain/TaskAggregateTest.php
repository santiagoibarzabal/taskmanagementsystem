<?php

declare(strict_types=1);

namespace Tests\Task\Domain;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Status\Domain\ValueObjects\Description as StatusDescription;
use App\TaskManagementSystem\Task\Domain\Exceptions\InvalidTaskDescriptionException;
use App\TaskManagementSystem\Task\Domain\Exceptions\InvalidTaskTitleException;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Title;
use Illuminate\Support\Str;
use Tests\UnitTestCase;

class TaskAggregateTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_create_task_aggregate(): void
    {
        $task = TaskAggregate::create(
            Title::create('title'),
            Description::create('description'),
            Priority::LOW,
            StatusAggregate::create(StatusDescription::PENDING),
        );
        $this->assertTrue($task instanceof TaskAggregate);
    }

    public function test_create_task_aggregate_throw_invalid_title_exception(): void
    {
        $this->expectException(InvalidTaskTitleException::class);
        TaskAggregate::create(
            Title::create(Str::random(120)),
            Description::create('desc'),
            Priority::LOW,
            StatusAggregate::create(StatusDescription::PENDING),
        );
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
