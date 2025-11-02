<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class TableDemo extends Component
{
    public array $selected = [];

    public string $sortColumn = 'name';

    public string $sortDirection = 'asc';

    public bool $loading = false;

    public string $variant = 'bordered';

    public string $size = 'md';

    public bool $hoverable = true;

    public bool $striped = false;

    public bool $showEmpty = false;

    public function mount(): void
    {
        $this->selected = [];
    }

    #[Computed]
    public function users(): array
    {
        if ($this->showEmpty) {
            return [];
        }

        $users = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Admin', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'Editor', 'status' => 'Active'],
            ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com', 'role' => 'User', 'status' => 'Inactive'],
            ['id' => 4, 'name' => 'Alice Williams', 'email' => 'alice@example.com', 'role' => 'Admin', 'status' => 'Active'],
            ['id' => 5, 'name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'role' => 'User', 'status' => 'Active'],
            ['id' => 6, 'name' => 'Diana Prince', 'email' => 'diana@example.com', 'role' => 'Editor', 'status' => 'Active'],
            ['id' => 7, 'name' => 'Ethan Hunt', 'email' => 'ethan@example.com', 'role' => 'User', 'status' => 'Inactive'],
            ['id' => 8, 'name' => 'Fiona Green', 'email' => 'fiona@example.com', 'role' => 'Admin', 'status' => 'Active'],
        ];

        usort($users, function ($a, $b) {
            $result = strcmp($a[$this->sortColumn], $b[$this->sortColumn]);

            return $this->sortDirection === 'asc' ? $result : -$result;
        });

        return $users;
    }

    #[Computed]
    public function allSelected(): bool
    {
        $userCount = count($this->users);

        return $userCount > 0 && count($this->selected) === $userCount;
    }

    public function sortBy(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleSelection(int $id): void
    {
        if (in_array($id, $this->selected)) {
            $this->selected = array_values(array_diff($this->selected, [$id]));
        } else {
            $this->selected[] = $id;
        }
    }

    public function toggleSelectAll(): void
    {
        if (count($this->selected) === count($this->users)) {
            $this->selected = [];
        } else {
            $this->selected = array_column($this->users, 'id');
        }
    }

    public function simulateLoading(): void
    {
        $this->loading = true;
        $this->dispatch('refresh-table');
    }

    public function render()
    {
        return view('livewire.table-demo');
    }
}
