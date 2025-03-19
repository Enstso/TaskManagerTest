<?php

namespace Vendor\UnitTesting\tests;

use OutOfBoundsException;
use Vendor\UnitTesting\TaskManager;
use PHPUnit\Framework\TestCase;

class TaskManagerTest extends TestCase
{
    // Test if the TaskManager is correctly initialized with an empty task list
    public function test_Construct()
    {
        $taskManager = new TaskManager();
        $this->assertCount(0, $taskManager->getTasks());
    }

    // Test if a task can be successfully added and retrieved
    public function test_addTask()
    {
        $taskManager = new TaskManager();
        $task = "task1";
        $taskManager->addTask($task);
        $this->assertEquals($task, $taskManager->getTask(0));
    }

    // Test if removing a task with an invalid index throws an OutOfBoundsException
    public function test_removeTaskFailed()
    {
        $taskManager = new TaskManager();
        $task = "task1";
        $index = -1;
        $taskManager->addTask($task);

        // Expect an OutOfBoundsException before calling removeTask
        $this->expectException(OutOfBoundsException::class);
        $errorMessage = sprintf("Index de tâche invalide: %d", $index);
        $this->expectExceptionMessage($errorMessage);

        $taskManager->removeTask($index);
    }

    // Test if a task can be successfully removed
    public function test_removeTaskSuccess()
    {
        $taskManager = new TaskManager();
        $task = "task1";
        $taskManager->addTask($task);
        $taskManager->removeTask(0);
        
        // Ensure the task list is empty after removal
        $this->assertCount(0, $taskManager->getTasks());
    }

    // Test if retrieving a task from an empty task list throws an OutOfBoundsException
    public function test_getTaskFailed()
    {
        $taskManager = new TaskManager();
        $index = 0;

        // Expect an OutOfBoundsException before calling getTask
        $this->expectException(OutOfBoundsException::class);
        $errorMessage = sprintf("Index de tâche invalide: %d", $index);
        $this->expectExceptionMessage($errorMessage);

        $taskManager->getTask($index);
    }
}
