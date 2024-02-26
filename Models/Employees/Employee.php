<?php

namespace Models\Employees;

use Faker\Factory;
use Models\Users\User;
use DateTime;
use Interfaces\FileConvertible;

class Employee extends User implements FileConvertible {
    protected string $jobTitle;
    protected float $salary;
    protected DateTime $startDate;
    protected array $awards;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email,
        string $hashedPassword,
        string $phoneNumber,
        string $address,
        DateTime $birthDate,
        DateTime $membershipExpirationDate,
        string $role,
        string $jobTitle,
        float $salary,
        DateTime $startDate,
        array $awards = []
    ) {
        parent::__construct($id, $firstName, $lastName, $email, $hashedPassword, $phoneNumber, $address, $birthDate, $membershipExpirationDate, $role);
        
        $this->jobTitle = $jobTitle;
        $this->salary = $salary;
        $this->startDate = $startDate;
        $this->awards = $awards;
    }

    public function toString(): string {
        return parent::toString() . ", Job Title: {$this->jobTitle}, Salary: {$this->salary}, Start Date: {$this->startDate->format('Y-m-d')}, Awards: " . implode(', ', $this->awards);
    }

    public function toHTML(): string {

        // $awardsList = $this->awards ? '<ul><li>' . implode('</li><li>', $this->awards) . '</li></ul>' : 'None';
        $htmlString = <<<HTML
            <td>ID: {$this->id}, 
                Job Title: {$this->jobTitle}, 
                Name: {$this->lastName} {$this->firstName}, 
                Salary: {$this->salary}, 
                Start Date: {$this->startDate->format('Y-m-d')}, 
            </td>
        HTML;
        return $htmlString;
    }

    public function toMarkdown(): string {
        $awardsMarkdown = $this->awards ? "\n- " . implode("\n- ", $this->awards) : 'None';
        return parent::toMarkdown() . "\n**Job Title**: {$this->jobTitle}\n**Salary**: {$this->salary}\n**Start Date**: {$this->startDate->format('Y-m-d')}\n**Awards**: {$awardsMarkdown}";
    }

    public function toArray(): array {
        return array_merge(parent::toArray(), [
            'jobTitle' => $this->jobTitle,
            'salary' => $this->salary,
            'startDate' => $this->startDate->format('Y-m-d'),
            'awards' => $this->awards,
        ]);
    }

    public static function generateEmployee(): Employee {
        $faker = Factory::create('ja_JP');

        return new Employee(
            // Employee のコンストラクタに必要なパラメータを Faker で生成

            $faker->randomNumber(),
            $faker->firstName(),
            $faker->lastName(),
            $faker->email,
            $faker->password,
            $faker->phoneNumber,
            $faker->address,
            $faker->dateTimeThisCentury,
            $faker->dateTimeBetween('-10 years', '+20 years'),
            $faker->randomElement(['admin', 'user', 'editor']),
            $faker->jobTitle(),
            $faker->randomFloat(),
            $faker->dateTime(),
            $faker->words()
        );
    }
}
