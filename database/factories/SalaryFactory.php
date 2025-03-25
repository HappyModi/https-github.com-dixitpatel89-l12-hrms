<?php

use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    protected $model = Salary::class;

    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'month' => $this->faker->monthName,
            'basic' => $this->faker->numberBetween(20000, 50000),
            'hra' => $this->faker->numberBetween(5000, 10000),
            'special_allowance' => $this->faker->numberBetween(2000, 5000),
            'lop_days' => $this->faker->numberBetween(0, 5),
            'net_salary' => $this->faker->numberBetween(30000, 60000),
        ];
    }
}

