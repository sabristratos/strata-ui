<?php

namespace App\Livewire;

use Livewire\Component;

class TableDemo extends Component
{
    public array $users = [];

    public string $sortBy = 'name';

    public string $sortDirection = 'asc';

    public array $selectedRows = [];

    public bool $selectAll = false;

    public function mount(): void
    {
        $this->users = [
            ['id' => 1, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'role' => 'Admin', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Bob Smith', 'email' => 'bob@example.com', 'role' => 'Editor', 'status' => 'Active'],
            ['id' => 3, 'name' => 'Carol Williams', 'email' => 'carol@example.com', 'role' => 'Viewer', 'status' => 'Inactive'],
            ['id' => 4, 'name' => 'David Brown', 'email' => 'david@example.com', 'role' => 'Editor', 'status' => 'Active'],
            ['id' => 5, 'name' => 'Eve Davis', 'email' => 'eve@example.com', 'role' => 'Admin', 'status' => 'Active'],
            ['id' => 6, 'name' => 'Frank Miller', 'email' => 'frank@example.com', 'role' => 'Viewer', 'status' => 'Inactive'],
            ['id' => 7, 'name' => 'Grace Wilson', 'email' => 'grace@example.com', 'role' => 'Editor', 'status' => 'Active'],
            ['id' => 8, 'name' => 'Henry Moore', 'email' => 'henry@example.com', 'role' => 'Admin', 'status' => 'Active'],
        ];
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll(bool $value): void
    {
        $this->selectedRows = $value
            ? array_column($this->getSortedUsers(), 'id')
            : [];
    }

    public function updatedSelectedRows(): void
    {
        $this->selectAll = count($this->selectedRows) === count($this->users);
    }

    public function getSortedUsers(): array
    {
        $users = $this->users;

        usort($users, function ($a, $b) {
            $comparison = $a[$this->sortBy] <=> $b[$this->sortBy];

            return $this->sortDirection === 'asc' ? $comparison : -$comparison;
        });

        return $users;
    }

    public function render()
    {
        return view('livewire.table-demo', [
            'sortedUsers' => $this->getSortedUsers(),
        ]);
    }
}
