<?php

namespace Models\Companies;

use Faker\Factory;
use Interfaces\FileConvertible;


class Company implements FileConvertible {
    protected string $name;
    protected int $foundedYear;
    protected string $description;
    protected string $website;
    protected string $phone;
    protected string $industry;
    protected string $CEO;
    protected bool $isPubliclyTraded;
    protected string $country;
    protected string $founder;
    protected int $totalEmployees;

    public function __construct($name, $foundedYear, $description, $website, $phone, $industry, $CEO, $isPubliclyTraded, $country, $founder, $totalEmployees) {
        $this->name = $name;
        $this->foundedYear = $foundedYear;
        $this->description = $description;
        $this->website = $website;
        $this->phone = $phone;
        $this->industry = $industry;
        $this->CEO = $CEO;
        $this->isPubliclyTraded = $isPubliclyTraded;
        $this->country = $country;
        $this->founder = $founder;
        $this->totalEmployees = $totalEmployees;
    }

    public function toString(): string {
        return "Name: {$this->name}, Founded: {$this->foundedYear}, CEO: {$this->CEO}, Public: {$this->isPubliclyTradedToString()}";
    }

    public function toHTML(): string {
        return "<p><strong>Name:</strong> {$this->name}<br><strong>Founded:</strong> {$this->foundedYear}<br><strong>CEO:</strong> {$this->CEO}<br><strong>Public:</strong> {$this->isPubliclyTradedToString()}</p>";
    }

    public function toMarkdown(): string {
        return "**Name**: {$this->name}\n**Founded**: {$this->foundedYear}\n**CEO**: {$this->CEO}\n**Public**: {$this->isPubliclyTradedToString()}";
    }

    public function toArray(): array {
        return [
            'name' => $this->name,
            'foundedYear' => $this->foundedYear,
            'description' => $this->description,
            'website' => $this->website,
            'phone' => $this->phone,
            'industry' => $this->industry,
            'CEO' => $this->CEO,
            'isPubliclyTraded' => $this->isPubliclyTraded,
        ];
    }

    protected function isPubliclyTradedToString(): string {
        return $this->isPubliclyTraded ? 'Yes' : 'No';
    }

    public static function generateCompany(): Company {
        $faker = Factory::create('ja_JP');

         return new Company(
            $faker->company, // $name
            $faker->numberBetween(1800, 2020), // $foundedYear
            $faker->realText(), // $description
            $faker->domainName, // $website
            $faker->phoneNumber, // $phone
            $faker->word, // $industry
            $faker->name, // $CEO
            $faker->boolean, // $isPubliclyTraded
            $faker->country, // $country
            $faker->name, // $founder
            $faker->numberBetween(1, 10000) // $totalEmployees
        );
    }
}
