<?php


namespace App\Repositories;


use App\Models\Task;

interface TaskRepositoryInterface
{
    public function create(array $data);
    public function update(Task $task,array $data);
    public function delete(Task $task);
}
