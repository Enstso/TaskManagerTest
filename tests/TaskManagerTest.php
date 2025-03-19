<?php

namespace Vendor\UnitTesting\tests;

use OutOfBoundsException;
use Vendor\UnitTesting\TaskManager;
use PHPUnit\Framework\TestCase;

class TaskManagerTest extends TestCase
{
    // Test if a task can be successfully added and retrieved
    public function testAddTask()
    {
        $taskManager = new TaskManager();
        $task = "task1";
        $taskManager->addTask($task);

        // Verify that the added task can be retrieved correctly
        $this->assertEquals($task, $taskManager->getTask(0));
    }

    // Test if a task can be successfully removed
    public function testRemoveTask()
    {
        $taskManager = new TaskManager();
        $task = "task1";
        $taskManager->addTask($task);
        $taskManager->removeTask(0);

        // Ensure the task list is empty after removal
        $this->assertCount(0, $taskManager->getTasks());
    }

    // Test retrieving tasks when no tasks have been added and when multiple tasks have been added
    public function testGetTasks()
    {
        $taskManager = new TaskManager();
        $tasks = $taskManager->getTasks();

        // Verify that the tasks list is an empty array
        $this->assertIsArray($tasks);
        $this->assertCount(0, $tasks);
        $this->assertEquals([], $tasks);

        $task1 = "task1";
        $task2 = "task2";
        $task3 = "task3";

        // Add multiple tasks to the task manager
        $taskManager->addTask($task1);
        $taskManager->addTask($task2);
        $taskManager->addTask($task3);

        // Verify that all tasks were added and can be retrieved correctly
        $tasks = $taskManager->getTasks();

        $this->assertCount(3, $tasks);
        $this->assertEquals([$task1, $task2, $task3], $tasks);
    }

    // Test if retrieving a specific task works correctly
    public function testGetTask()
    {
        $taskManager = new TaskManager();
        $task = "task1";
        $index = 0;
        $taskManager->addTask($task);

        // Verify that the task can be retrieved correctly
        $this->assertEquals($task, $taskManager->getTask($index));
    }

    // Test if removing a task with an invalid index throws an OutOfBoundsException
    public function testRemoveInvalidIndexThrowsException()
    {
        $taskManager = new TaskManager();
        $task = "task1";
        $index = -1;
        $taskManager->addTask($task);

        // Expect an OutOfBoundsException before calling removeTask
        $this->expectException(OutOfBoundsException::class);

        // Define the expected exception message
        $errorMessage = sprintf("Index de tâche invalide: %d", $index);
        $this->expectExceptionMessage($errorMessage);

        // Attempt to remove a task with an invalid index
        $taskManager->removeTask($index);
    }


    // Test if retrieving a task from an empty task list throws an OutOfBoundsException
    public function testGetInvalidIndexThrowsException()
    {
        $taskManager = new TaskManager();
        $index = 0;

        // Expect an OutOfBoundsException before calling getTask
        $this->expectException(OutOfBoundsException::class);

        // Define the expected exception message
        $errorMessage = sprintf("Index de tâche invalide: %d", $index);
        $this->expectExceptionMessage($errorMessage);

        // Attempt to retrieve a task from an empty list
        $taskManager->getTask($index);
    }

    // Test if the order of tasks remains correct after removing a task
    public function testTaskOrderAfterRemoval()
    {
        $taskManager = new TaskManager();
        $task1 = "task1";
        $task2 = "task2";
        $task3 = "task3";
        $indexToRemove = 1;

        // Add multiple tasks to the task manager
        $taskManager->addTask($task1);
        $taskManager->addTask($task2);
        $taskManager->addTask($task3);

        // Verify that all tasks were added in the correct order
        $this->assertCount(3, $taskManager->getTasks());
        $this->assertEquals($task1, $taskManager->getTasks()[0]);
        $this->assertEquals($task2, $taskManager->getTasks()[1]);
        $this->assertEquals($task3, $taskManager->getTasks()[2]);

        // Remove the second task (index 1)
        $taskManager->removeTask($indexToRemove);

        // Verify that the remaining tasks are in the correct order
        $this->assertCount(2, $taskManager->getTasks());
        $this->assertEquals($task1, $taskManager->getTasks()[0]);
        $this->assertEquals($task3, $taskManager->getTasks()[1]);
    }
}
