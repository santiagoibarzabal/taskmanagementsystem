<?php

declare(strict_types=1);

namespace App\Contexts\Task\Infrastructure\Repositories\Mappers;

use App\Contexts\Status\Domain\StatusAggregate;
use App\Contexts\Task\Domain\Exceptions\MappingException;
use App\Contexts\Task\Domain\TaskAggregate;
use App\Contexts\Task\Domain\ValueObjects\Description;
use App\Contexts\Task\Domain\ValueObjects\Priority;
use App\Contexts\Task\Domain\ValueObjects\Title;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use App\Contexts\Status\Domain\ValueObjects\Description as StatusDescription;

class TaskMapper
{
    /**
     * @throws MappingException
     */
    public function databaseToDomain(
        Object $databaseTask,
        Object $databaseStatus,
        Object $databaseUserId,
    ): TaskAggregate
    {
        if (!property_exists($databaseTask, 'id') || !Uuid::isValid($databaseTask->id)) {
            throw new MappingException('invalid_id');
        }
        $id = Uuid::fromString($databaseTask->id);

        if (!property_exists($databaseTask, 'title') || !is_string($databaseTask->title)) {
            throw new MappingException('invalid_title');
        }
        $title = Title::create($databaseTask->title);

        if (!property_exists($databaseTask, 'description')) {
            throw new MappingException('invalid_description');
        }
        $description = Description::create($databaseTask->description);

        if (!property_exists($databaseTask, 'priority')) {
            throw new MappingException('invalid_priority');
        }
        $priority = Priority::tryFrom($databaseTask->priority);
        if ($priority === null) {
            throw new MappingException('invalid_priority');
        }

        if (!property_exists($databaseTask, 'created_at')) {
            throw new MappingException('invalid_description');
        }
        try {
            $createdAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $databaseTask->created_at);
        } catch (MappingException) {
            throw new MappingException('invalid_created_at');
        }

        if (!property_exists($databaseTask, 'updated_at')) {
            throw new MappingException('invalid_updated_at');
        }
        try {
            $updatedAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $databaseTask->updated_at);
        } catch (MappingException) {
            throw new MappingException('invalid_updated_at');
        }

        $userId = null;
        if (!property_exists($databaseUserId, 'user_id')) {
            throw new MappingException('invalid_user_id');
        }
        if ($databaseUserId->user_id !== null && !Uuid::isValid($databaseUserId->user_id)) {
            throw new MappingException('invalid_user_id');
        }
        if ($databaseUserId->user_id !== null) {
            $userId = Uuid::fromString($databaseUserId->user_id);
        }


        if (!property_exists($databaseStatus, 'id') || !Uuid::isValid($databaseStatus->id)) {
            throw new MappingException('invalid_id');
        }
        $statusId = Uuid::fromString($databaseStatus->id);
        if (!property_exists($databaseStatus, 'description')) {
            throw new MappingException('invalid_status_description');
        }
        $statusDescription = StatusDescription::tryFrom($databaseStatus->description);
        if ($statusDescription === null) {
            throw new MappingException('invalid_status_description');
        }

        if (!property_exists($databaseStatus, 'created_at')) {
            throw new MappingException('invalid_status_created_at');
        }
        try {
            $statusCreatedAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $databaseStatus->created_at);
        } catch (MappingException) {
            throw new MappingException('invalid_status_created_at');
        }

        if (!property_exists($databaseStatus, 'updated_at')) {
            throw new MappingException('invalid_status_updated_at');
        }
        try {
            $statusUpdatedAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $databaseStatus->updated_at);
        } catch (MappingException) {
            throw new MappingException('invalid_status_updated_at');
        }

        $status = StatusAggregate::create(
            $statusDescription,
            $statusCreatedAt,
            $statusUpdatedAt,
            $statusId,
        );

        return new TaskAggregate(
            $id,
            $title,
            $description,
            $priority,
            $status,
            $createdAt,
            $updatedAt,
            $userId,
        );
    }

    public function domainToDatabase(
        TaskAggregate $taskAggregate,
    ): array {
        return [
            'id' => $taskAggregate->id()->toString(),
            'title' => (string) $taskAggregate->title(),
            'description' => (string) $taskAggregate->description(),
            'priority' => $taskAggregate->priority()->value,
            'created_at' => $taskAggregate->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $taskAggregate->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
