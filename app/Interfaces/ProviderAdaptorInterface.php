<?php

namespace App\Interfaces;
interface ProviderAdaptorInterface
{
    public function getTodos();

    public function formatTodos($todos);
}
